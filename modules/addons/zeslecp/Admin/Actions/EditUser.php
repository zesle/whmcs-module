<?php

use WHMCS\Database\Capsule;

require_once dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/init.php';
require_once dirname(dirname(__DIR__)) . '/API/ZesleCPAPI.php';
if (isset($_POST["data"])) {
    $postData = json_decode(htmlspecialchars_decode($_POST["data"]), true);
    $userId = $_POST["userId"];
    $json = json_encode($postData);
    $apiKey = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Key")->first()->value;
    $apiSecret = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Secret")->first()->value;
    $serverURL = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "Server_URL")->first()->value;
    $zeslecp = new ZesleCPAPI($apiKey, $apiSecret, $serverURL);
    $response = $zeslecp->editUser($json, $userId);
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
        $updatedAt = date("Y-m-d H:i:s");
        $password = '';
        if($postData["password"]) {
            $password = $postData["password"];
        }
        Capsule::table('mod_zeslecp_users')->where("user_id", $userId)->update(
                [
                    'package_id' => $postData["package_id"],
                    'name' => $postData["name"],
                    'username' => $postData["username"],
                    'password' => $password,
                    'email' => $postData["email"],
                    'primary_domain' => $postData["primary_domain"],
                    'updated_at' => $updatedAt
                ]
        );
        echo "ok";
    }
}

