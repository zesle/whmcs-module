<?php

use WHMCS\Database\Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}
require_once dirname(dirname(__DIR__)) . '/addons/zeslecp/API/ZesleCPAPI.php';

/**
 * Define module related meta data.
 *
 * @return array
 */
function zeslecp_MetaData() {
    return array(
        'DisplayName' => 'ZesleCP',
        'APIVersion' => '1.0',
        'RequiresServer' => true,
        'DefaultNonSSLPort' => '2086',
        'DefaultSSLPort' => '2087',
        'ServiceSingleSignOnLabel' => 'Login to Panel as User',
        'AdminSingleSignOnLabel' => 'Login to Panel as Admin',
    );
}

/**
 * Define product configuration options.
 *
 * @return array
 */
function zeslecp_ConfigOptions() {
    $apiKey = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Key")->first()->value;
    $apiSecret = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Secret")->first()->value;
    $serverURL = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "Server_URL")->first()->value;
    $zeslecp = new ZesleCPAPI($apiKey, $apiSecret, $serverURL);
    $response = $zeslecp->getPackagesList();
    $data = json_decode($response, true);
    $packages = $data["data"];
    $options = array();
    foreach ($packages as $package) {
        $options[$package["id"]] = $package["name"];
    }
    return array(
        'Choose ZesleCP Package ' => array(
            'Type' => 'dropdown',
            'Options' => $options,
            'Description' => '',
        ),
    );
}

/**
 * Provision a new instance of a product/service.
 *
 * @return string "success" or an error message
 */
function zeslecp_CreateAccount(array $params) {
    try {
        $apiKey = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Key")->first()->value;
        $apiSecret = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Secret")->first()->value;
        $serverURL = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "Server_URL")->first()->value;
        $zeslecp = new ZesleCPAPI($apiKey, $apiSecret, $serverURL);
        $zeslePackage = $params["configoption1"];
        $accountType = $params["type"];
        if ($accountType == "reselleraccount") {
            $reseller = true;
        } else {
            $reseller = false;
        }
        $username = $params["username"];
        $password = generatePassword(2, 2, 2, 2, 14);
        $name = $params["clientsdetails"]["fullname"];
        //$email = $params["clientsdetails"]["email"];
        $domain = $params["domain"];
        $email = $username . "@" . $domain;
        $pid = $params["packageid"];
        $sid = $params["serviceid"];
        $postParams = array(
            "name" => $name,
            "username" => $username,
            "primary_domain" => $domain,
            "email" => $email,
            "password" => $password,
            "password2" => $password,
            "package_id" => $zeslePackage,
            "reseller" => $reseller,
        );
        $json = json_encode($postParams);
        $response = $zeslecp->createUser($json);
        $data = json_decode($response, true);
        if (preg_match("/Error:/", $response)) {
            throw new Exception($response);
        } elseif (!$data["success"]) {
            $errors = $data["errors"];
            $field = "";
            $error = "";
            foreach ($errors as $key => $value) {
                $field = $key;
                $error = $value[0];
                break;
            }
            $finalError = str_replace("&nbsp;", " ", $error);
            $finalError = str_replace("<br>", "", $finalError);
            throw new Exception($key . ":" . $finalError);
        } else {
            $users = $data["data"];
            $fid = Capsule::table('tblcustomfields')->where('fieldname', 'ZesleCP UserID')->where('type', 'product')->where('relid', $pid)->first()->id;
            $fieldid = Capsule::table('tblcustomfieldsvalues')->where('fieldid', $fid)->where('relid', $sid)->first()->fieldid;
            if (empty($fieldid)) {
                Capsule::table('tblcustomfieldsvalues')->insert(
                        [
                            "fieldid" => $fid,
                            "relid" => $sid,
                            "value" => $users["id"],
                        ]
                );
            } else {
                Capsule::table('tblcustomfieldsvalues')->where('fieldid', $fid)->where('relid', $sid)->update(
                        [
                            "value" => $users["id"],
                        ]
                );
            }
            Capsule::table('tblhosting')->where("id", $sid)->update(
                    [
                        "password" => encrypt($password),
                    ]
            );
            $user = $data["data"];
            $reseller = 0;
            if ($user["reseller"]) {
                $reseller = 1;
            }
            $impersonator = $user["impersonator"];
            if ($user["impersonator"] == null) {
                $impersonator = "";
            }
            $authToken = $user["auth_token"];
            if ($user["auth_token"] == null) {
                $authToken = "";
            }
            $cDateTime = explode("T", $user["created_at"]);
            $date = $cDateTime[0];
            $cTime = explode(".", $cDateTime[1]);
            $time = $cTime[0];
            $createdAt = $date . " " . $time;

            $uDateTime = explode("T", $user["updated_at"]);
            $date = $uDateTime[0];
            $uTime = explode(".", $uDateTime[1]);
            $time = $uTime[0];
            $updatedAt = $date . " " . $time;

            Capsule::table('mod_zeslecp_users')->insert(
                    [
                        'user_id' => $user["id"],
                        'package_id' => $user["package_id"],
                        'name' => $user["name"],
                        'username' => $user["username"],
                        'password' => $password,
                        'email' => $user["email"],
                        'owner' => $user["owner"],
                        'role' => $user["role"],
                        'status' => $user["status"],
                        'primary_domain' => $user["primary_domain"],
                        'reseller' => $reseller,
                        'usersc' => $user["usersc"],
                        'impersonator' => $impersonator,
                        'auth_token' => $authToken,
                        'created_at' => $createdAt,
                        'updated_at' => $updatedAt
                    ]
            );
        }
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
                'zeslecp',
                __FUNCTION__,
                $params,
                $e->getMessage(),
                $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}

/**
 * Suspend an instance of a product/service.
 * @return string "success" or an error message
 */
function zeslecp_SuspendAccount(array $params) {
    try {
        $apiKey = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Key")->first()->value;
        $apiSecret = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Secret")->first()->value;
        $serverURL = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "Server_URL")->first()->value;
        $zeslecp = new ZesleCPAPI($apiKey, $apiSecret, $serverURL);
        $id = isset($params["customfields"]["ZesleCP UserID"]) ? trim($params["customfields"]["ZesleCP UserID"]) : 0;
        $postParams = array(
            "id" => $id,
            "action" => "suspendUser",
        );
        $json = json_encode($postParams);
        $response = $zeslecp->suspendUser($json);
        $data = json_decode($response, true);
        if (preg_match("/Error:/", $response)) {
            throw new Exception($response);
        } elseif (!$data["success"]) {
            throw new Exception("Error: " . $data["message"]);
        } else {
            $updatedAt = date("Y-m-d H:i:s");
            Capsule::table('mod_zeslecp_users')->where("user_id", $id)->update(
                    [
                        'status' => 2,
                        'updated_at' => $updatedAt
                    ]
            );
        }
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
                'zeslecp',
                __FUNCTION__,
                $params,
                $e->getMessage(),
                $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}

/**
 * Un-suspend instance of a product/service.
 * @return string "success" or an error message
 */
function zeslecp_UnsuspendAccount(array $params) {
    try {
        $apiKey = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Key")->first()->value;
        $apiSecret = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Secret")->first()->value;
        $serverURL = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "Server_URL")->first()->value;
        $zeslecp = new ZesleCPAPI($apiKey, $apiSecret, $serverURL);
        $id = isset($params["customfields"]["ZesleCP UserID"]) ? trim($params["customfields"]["ZesleCP UserID"]) : 0;
        $postParams = array(
            "id" => $id,
            "action" => "suspendUser",
        );
        $json = json_encode($postParams);
        $response = $zeslecp->suspendUser($json);
        $data = json_decode($response, true);
        if (preg_match("/Error:/", $response)) {
            throw new Exception($response);
        } elseif (!$data["success"]) {
            throw new Exception("Error: " . $data["message"]);
        } else {
            $updatedAt = date("Y-m-d H:i:s");
            Capsule::table('mod_zeslecp_users')->where("user_id", $id)->update(
                    [
                        'status' => 1,
                        'updated_at' => $updatedAt
                    ]
            );
        }
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
                'zeslecp',
                __FUNCTION__,
                $params,
                $e->getMessage(),
                $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}

/**
 * Terminate instance of a product/service.
 *
 * @return string "success" or an error message
 */
function zeslecp_TerminateAccount(array $params) {
    try {
        $apiKey = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Key")->first()->value;
        $apiSecret = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Secret")->first()->value;
        $serverURL = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "Server_URL")->first()->value;
        $zeslecp = new ZesleCPAPI($apiKey, $apiSecret, $serverURL);
        $id = isset($params["customfields"]["ZesleCP UserID"]) ? trim($params["customfields"]["ZesleCP UserID"]) : 0;
        $postParams = array(
            "id" => $id,
        );
        $json = json_encode($postParams);
        $response = $zeslecp->terminateUser($json);
        $data = json_decode($response, true);
        if (preg_match("/Error:/", $response)) {
            throw new Exception($response);
        } elseif (!$data["success"]) {
            throw new Exception("Error: " . $data["message"]);
        } else {
            Capsule::table('mod_zeslecp_users')->where("user_id", $id)->delete();
        }
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
                'zeslecp',
                __FUNCTION__,
                $params,
                $e->getMessage(),
                $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}

/**
 * Change the password for an instance of a product/service.
 *
 * @return string "success" or an error message
 */
function zeslecp_ChangePassword(array $params) {
    try {
        $apiKey = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Key")->first()->value;
        $apiSecret = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Secret")->first()->value;
        $serverURL = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "Server_URL")->first()->value;
        $zeslecp = new ZesleCPAPI($apiKey, $apiSecret, $serverURL);
        $id = isset($params["customfields"]["ZesleCP UserID"]) ? trim($params["customfields"]["ZesleCP UserID"]) : 0;
        $zeslePackage = $params["configoption1"];
        $accountType = $params["type"];
        if ($accountType == "reselleraccount") {
            $reseller = true;
        } else {
            $reseller = false;
        }
        $username = $params["username"];
        $password = $params["password"];
        $name = $params["clientsdetails"]["fullname"];
        $email = $params["clientsdetails"]["email"];
        $domain = $params["domain"];
        $postParams = array(
            "name" => $name,
            "username" => $username,
            "primary_domain" => $domain,
            "email" => $email,
            "password" => $password,
            "password2" => $password,
            "package_id" => $zeslePackage,
            "reseller" => $reseller,
        );
        $json = json_encode($postParams);
        $response = $zeslecp->updateUser($json, $id);
        $data = json_decode($response, true);
        if (preg_match("/Error:/", $response)) {
            throw new Exception($response);
        } elseif (!$data["success"]) {
            $errors = $data["errors"];
            $field = "";
            $error = "";
            foreach ($errors as $key => $value) {
                $field = $key;
                $error = $value[0];
                break;
            }
            $finalError = str_replace("&nbsp;", " ", $error);
            $finalError = str_replace("<br>", "", $finalError);
            throw new Exception($key . ":" . $finalError);
        } else {
            $updatedAt = date("Y-m-d H:i:s");
            Capsule::table('mod_zeslecp_users')->where("user_id", $id)->update(
                    [
                        'password' => $password,
                        'updated_at' => $updatedAt
                    ]
            );
        }
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
                'zeslecp',
                __FUNCTION__,
                $params,
                $e->getMessage(),
                $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}

/**
 * Upgrade or downgrade an instance of a product/service.
 *
 * @return string "success" or an error message
 */
function zeslecp_ChangePackage(array $params) {
    try {
        $apiKey = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Key")->first()->value;
        $apiSecret = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Secret")->first()->value;
        $serverURL = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "Server_URL")->first()->value;
        $zeslecp = new ZesleCPAPI($apiKey, $apiSecret, $serverURL);
        $id = isset($params["customfields"]["ZesleCP UserID"]) ? trim($params["customfields"]["ZesleCP UserID"]) : 0;
        $zeslePackage = $params["configoption1"];
        $accountType = $params["type"];
        if ($accountType == "reselleraccount") {
            $reseller = true;
        } else {
            $reseller = false;
        }
        $username = $params["username"];
        $password = $params["password"];
        $name = $params["clientsdetails"]["fullname"];
        $email = $params["clientsdetails"]["email"];
        $domain = $params["domain"];
        $postParams = array(
            "name" => $name,
            "username" => $username,
            "primary_domain" => $domain,
            "email" => $email,
            "password" => $password,
            "password2" => $password,
            "package_id" => $zeslePackage,
            "reseller" => $reseller,
        );
        $json = json_encode($postParams);
        $response = $zeslecp->updateUser($json, $id);
        $data = json_decode($response, true);
        if (preg_match("/Error:/", $response)) {
            throw new Exception($response);
        } elseif (!$data["success"]) {
            $errors = $data["errors"];
            $field = "";
            $error = "";
            foreach ($errors as $key => $value) {
                $field = $key;
                $error = $value[0];
                break;
            }
            $finalError = str_replace("&nbsp;", " ", $error);
            $finalError = str_replace("<br>", "", $finalError);
            throw new Exception($key . ":" . $finalError);
        } else {
            
        }
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
                'zeslecp',
                __FUNCTION__,
                $params,
                $e->getMessage(),
                $e->getTraceAsString()
        );

        return $e->getMessage();
    }

    return 'success';
}

/**
 * Admin services tab additional fields.
 *
 * @return array
 */
function zeslecp_AdminServicesTabFields(array $params) {
    try {

        $response = array();
        // Return an array based on the function's response.
        return array(
            'Package Details' => (int) $response['numApples'],
        );
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
                'zeslecp',
                __FUNCTION__,
                $params,
                $e->getMessage(),
                $e->getTraceAsString()
        );
    }

    return array();
}

/**
 * Perform single sign-on for a given instance of a product/service.
 * @return array
 */
function zeslecp_ServiceSingleSignOn(array $params) {
    try {
        $serverHost = $params["serverhostname"];
        if (empty($serverHost)) {
            $serverHost = $params["serverip"];
        }
        $loginUrl = $params["serverhttpprefix"] . "://" . $serverHost . ":" . $params["serverport"];

        return array(
            'success' => true,
            'redirectTo' => $loginUrl,
        );
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
                'zeslecp',
                __FUNCTION__,
                $params,
                $e->getMessage(),
                $e->getTraceAsString()
        );

        return array(
            'success' => false,
            'errorMsg' => $e->getMessage(),
        );
    }
}

/**
 * Perform single sign-on for a server.
 *
 * @see https://developers.whmcs.com/provisioning-modules/module-parameters/
 *
 * @return array
 */
function zeslecp_AdminSingleSignOn(array $params) {
    try {

        $response = array();
        $serverHost = $params["serverhostname"];
        if (empty($serverHost)) {
            $serverHost = $params["serverip"];
        }
        $loginUrl = $params["serverhttpprefix"] . "://" . $serverHost . ":" . $params["serverport"];
        return array(
            'success' => true,
            'redirectTo' => $loginUrl,
        );
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
                'zeslecp',
                __FUNCTION__,
                $params,
                $e->getMessage(),
                $e->getTraceAsString()
        );

        return array(
            'success' => false,
            'errorMsg' => $e->getMessage(),
        );
    }
}

/**
 * Client area output logic handling.
 * @return array
 */
function zeslecp_ClientArea(array $params) {
    $requestedAction = isset($_REQUEST['customAction']) ? $_REQUEST['customAction'] : '';
    if ($requestedAction == 'manage') {
        $serviceAction = 'get_usage';
        $templateFile = 'templates/manage.tpl';
    } else {
        $serviceAction = 'get_stats';
        $templateFile = 'templates/overview.tpl';
    }

    try {
        $serverHost = $params["serverhostname"];
        if (empty($serverHost)) {
            $serverHost = $params["serverip"];
        }
        $loginUrl = $params["serverhttpprefix"] . "://" . $serverHost . ":" . $params["serverport"];
        $response = array();
        return array(
            'tabOverviewReplacementTemplate' => $templateFile,
            'templateVariables' => array(
                'password' => $params["password"],
                'panelLoginURL' => $loginUrl,
            ),
        );
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
                'zeslecp',
                __FUNCTION__,
                $params,
                $e->getMessage(),
                $e->getTraceAsString()
        );

        // In an error condition, display an error page.
        return array(
            'tabOverviewReplacementTemplate' => 'error.tpl',
            'templateVariables' => array(
                'usefulErrorHelper' => $e->getMessage(),
            ),
        );
    }
}

function generatePassword($u, $l, $n, $s, $passwordLength) {
    // Required at least 2 upper case
    $chars = "ABCDEFGHJKLMNPQRSTUVWXYZ";
    $uppercase = substr(str_shuffle($chars), 0, $u);

    // Required at least 2 lower case
    $chars = "abcdefghjkmnpqrstuvwxyz";
    $lowercase = substr(str_shuffle($chars), 0, $l);

    // Required at least 2 numeric
    $chars = "0123456789";
    $number = substr(str_shuffle($chars), 0, $n);

    // Required at least 2 specialist characters
    $chars = ",@)%_]>!}$<(*={#[";
    $specialsharaters = substr(str_shuffle($chars), 0, $s);
    $required = $uppercase . $lowercase . $number . $specialsharaters;

    // Other optional password characters
    $length = $passwordLength - ($u + $l + $n + $s) - 2;
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789,@)%_]>!}$<(*={#[";
    $optional = substr(str_shuffle($chars), 0, $length);
    return str_shuffle($required . $optional . "^.");
}
