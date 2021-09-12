<?php

use WHMCS\Database\Capsule;

require_once dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/init.php';
require_once dirname(dirname(__DIR__)) . '/API/ZesleCPAPI.php';
if (isset($_POST["data"])) {
    $data = json_decode(htmlspecialchars_decode($_POST["data"]), true);
    $postData = array(
        "name" => $data["pkgName"],
        "monthly_bw_limit" => $data["mbl"],
        "disk_quota" => $data["diskQ"],
        "max_addon_domains" => $data["maDomains"],
        "max_subdomains" => $data["msDomains"],
        "max_parked_domains" => $data["mpDomains"],
        "max_email_accounts" => $data["meAccount"],
        "max_quota_per_email_account" => $data["mqpeAccount"],
        "max_email_forwarders" => $data["meForwarders"],
        "max_mailing_lists" => $data["mmLists"],
        "max_autoresponders" => $data["mAutoresponders"],
        "max_mysql_databases" => $data["mmDatabases"],
        "max_ftp_accounts" => $data["mfAccounts"],
        "max_user_accounts" => $data["muAccounts"],
        "max_email_per_hour" => $data["mhebdRelayed"],
        "max_defer_fail_percentage" => $data["mpofodmadmspHour"],
        "dedicated_ip" => $data["dedicatedIP"],
        "shell_access" => $data["shellAccess"],
        "cgi_access" => $data["cgiAccess"],
        "theme_id" => $data["themeId"],
        "locale_id" => $data["locale"],
    );
    $json = json_encode($postData);
    $apiKey = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Key")->first()->value;
    $apiSecret = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Secret")->first()->value;
    $serverURL = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "Server_URL")->first()->value;
    $zeslecp = new ZesleCPAPI($apiKey, $apiSecret, $serverURL);
    $response = $zeslecp->addAPackage($json);
    $data = json_decode($response, true);
    if (preg_match("/Error:/", $response)) {
        echo $response;
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
        echo $key . ":" . $finalError;
    } else {
       echo "ok";
    }
}
