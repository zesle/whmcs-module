<?php

use WHMCS\Database\Capsule;

require_once dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/init.php';
if ($_POST["action"] == "editUser") {
    $useId = $_POST["useId"];
    $user = Capsule::table('mod_zeslecp_users')->where('user_id', $useId)->first();
    $responseData = array(
        "name" => $user->name,
        "username" => $user->username,
        'password' => $user->password,
        "primary_domain" => $user->primary_domain,
        "email" => $user->email,
        "package_id" => $user->package_id,
    );
    $response = json_encode($responseData);
    echo $response;
}
