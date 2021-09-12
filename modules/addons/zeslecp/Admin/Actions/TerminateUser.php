<?php

use WHMCS\Database\Capsule;

require_once dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/init.php';
require_once dirname(dirname(__DIR__)) . '/API/ZesleCPAPI.php';
if ($_POST["action"] == "terminateUser") {
    $useId = $_POST["useId"];    
    $apiKey = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Key")->first()->value;
    $apiSecret = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Secret")->first()->value;
    $serverURL = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "Server_URL")->first()->value;
    $zeslecp = new ZesleCPAPI($apiKey, $apiSecret, $serverURL);
    $postData = array(
        "id" => $useId,
    );
    $json = json_encode($postData);
    $response = $zeslecp->terminateUser($json);
    $data = json_decode($response, true);
    if (preg_match("/Error:/", $response)) {
        echo $response;
    } elseif (!$data["success"]) {
        echo "Error: ". $data["message"];
    } else {
        Capsule::table('mod_zeslecp_users')->where("user_id", $useId)->delete();
       echo "Success: ". $data["message"];
    }
}
