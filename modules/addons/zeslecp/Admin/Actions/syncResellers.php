<?php

use WHMCS\Database\Capsule;

require_once dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/init.php';
require_once dirname(dirname(__DIR__)) . '/API/ZesleCPAPI.php';
if ($_POST["action"] == "fhdkfh89uyidfholaqpk") {
    $apiKey = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Key")->first()->value;
    $apiSecret = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "API_Secret")->first()->value;
    $serverURL = Capsule::table('tbladdonmodules')->where("module", "zeslecp")->where("setting", "Server_URL")->first()->value;
    $zeslecp = new ZesleCPAPI($apiKey, $apiSecret, $serverURL);
    $response = $zeslecp->getResellerAccountsList();
    if (preg_match("/Error:/", $response)) {
        echo $response;
    } else {
        $data = json_decode($response, true);
        $perPage = $data["per_page"];
        $total = $data["total"];
        $to = $data["to"];
        $noOfPages = ceil($total / $perPage);
        for ($i = 1; $i <= $noOfPages; $i++) {
            $response = $zeslecp->getResellerAccountsListByNextPage($i);
            $data = json_decode($response, true);
            if (preg_match("/Error:/", $response)) {
                echo $response;
                die;
            } else {
                $users = $data["data"];
                foreach ($users as $user) {
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
                    $userId = Capsule::table('mod_zeslecp_users')->where('user_id', $user["id"])->first()->user_id;
                    if (empty($userId)) {
                        Capsule::table('mod_zeslecp_users')->insert(
                                [
                                    'user_id' => $user["id"],
                                    'package_id' => $user["package_id"],
                                    'name' => $user["name"],
                                    'username' => $user["username"],
                                    'password' => "",
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
                    } else {
                        Capsule::table('mod_zeslecp_users')->where("user_id", $user["id"])->update(
                                [
                                    'package_id' => $user["package_id"],
                                    'name' => $user["name"],
                                    'username' => $user["username"],
                                    'password' => "",
                                    'email' => $user["email"],
                                    'owner' => $user["owner"],
                                    'role' => $user["role"],
                                    'status' => $user["status"],
                                    'primary_domain' => $user["primary_domain"],
                                    'reseller' => $reseller,
                                    'usersc' => $user["usersc"],
                                    'impersonator' => $impersonator,
                                    'auth_token' => $authToken,
                                    'updated_at' => $updatedAt
                                ]
                        );
                    }
                }
            }
        }
        echo "Success: Synchronization has been done successfully.";
    }
}