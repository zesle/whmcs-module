<?php

use WHMCS\Database\Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function zeslecp_config() {
    $configarray = array(
        "name" => "ZesleCP",
        "description" => "Create package and import user from ZesleCP",
        "version" => "1.0",
        "author" => "Mahander",
        "language" => "english",
        "fields" => [
            'API_Key' => [
                'FriendlyName' => 'API Key',
                'Type' => 'text',
                'Size' => '35',
                'Default' => '',
                'Description' => '',
            ],
            'API_Secret' => [
                'FriendlyName' => 'API Secret',
                'Type' => 'text',
                'Size' => '45',
                'Default' => '',
                'Description' => '',
            ],
            'Server_URL' => [
                'FriendlyName' => 'ZesleCP Server URL',
                'Type' => 'text',
                'Size' => '40',
                'Default' => '',
                'Description' => '',
            ],
        ]
    );
    return $configarray;
}

/**
 *  Acivate Addon
 * @return array
 */
function zeslecp_activate() {
    if (!Capsule::schema()->hasTable('mod_zeslecp_users')) {
        Capsule::schema()->create('mod_zeslecp_users', function ($table) {
            $table->increments('id');
            $table->bigInteger('user_id');
            $table->integer('package_id');
            $table->string('name');
            $table->string('username');
            $table->string('password');
            $table->string('email');
            $table->string('owner');
            $table->string('role');
            $table->integer('status');
            $table->string('primary_domain');
            $table->integer('reseller');
            $table->integer('usersc');
            $table->string('impersonator');
            $table->string('auth_token');
            $table->timestamps();
        }
        );
    }
    return array('status' => 'success', 'description' => 'Addon Successfully Installed');
}

function zeslecp_deactivate() {
    Capsule::schema()->dropIfExists('mod_zeslecp_users');
    return array('status' => 'success', 'description' => 'Addon is deactivated successfully');
}

function zeslecp_output($vars) {
    if ($_GET["action"] == "users") {
        require_once "Admin/users.php";
    } elseif ($_GET["action"] == "resellers") {
        require_once "Admin/resellers.php";
    } else {
        require_once "Admin/home.php";
    }
}
