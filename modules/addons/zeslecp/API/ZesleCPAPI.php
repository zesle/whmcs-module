<?php

class ZesleCPAPI {

    private $apiKey;
    private $apiSecret;
    private $apiURL;

    public function __construct($apiKey, $apiSecret, $apiURL) {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->apiURL = $apiURL;
    }

    public function getPackagesList() {
        $params = array(
            "method" => "GET",
            "URI" => "/api/v1/packages"
        );
        return $this->request($params);
    }
    public function getPackagesListPage($page) {
        $params = array(
            "method" => "GET",
            "URI" => "/api/v1/packages?page=" . $page
        );
        return $this->request($params);
    }
    public function addAPackage($json) {
        $params = array(
            "method" => "POST",
            "URI" => "/api/v1/packages",
            "payload" => $json
        );
        return $this->request($params);
    }

    public function getPackage($pkgId) {
        $params = array(
            "method" => "GET",
            "URI" => "/api/v1/packages/" . $pkgId,
        );
        return $this->request($params);
    }

    public function editPackage($json, $pkgId) {
        $params = array(
            "method" => "PUT",
            "URI" => "/api/v1/packages/" . $pkgId,
            "payload" => $json
        );
        return $this->request($params);
    }

    public function createUser($json) {
        $params = array(
            "method" => "POST",
            "URI" => "/api/v1/users",
            "payload" => $json
        );
        return $this->request($params);
    }

    public function suspendUser($json) {
        $params = array(
            "method" => "POST",
            "URI" => "/api/v1/users/suspend",
            "payload" => $json
        );
        return $this->request($params);
    }

    public function terminateUser($json) {
        $params = array(
            "method" => "POST",
            "URI" => "/api/v1/users/terminate",
            "payload" => $json
        );
        return $this->request($params);
    }

    public function updateUser($json, $id) {
        $params = array(
            "method" => "PUT",
            "URI" => "/api/v1/users/" . $id,
            "payload" => $json
        );
        return $this->request($params);
    }

    public function getUserAccountsList() {
        $params = array(
            "method" => "GET",
            "URI" => "/api/v1/users"
        );
        return $this->request($params);
    }

    public function getUserAccountsListByNextPage($page) {
        $params = array(
            "method" => "GET",
            "URI" => "/api/v1/users?page=" . $page
        );
        return $this->request($params);
    }
    public function getResellerAccountsListByNextPage($page) {
        $params = array(
            "method" => "GET",
            "URI" => "/api/v1/users?type=2&page=" . $page
        );
        return $this->request($params);
    }
    public function getResellerAccountsList() {
        $params = array(
            "method" => "GET",
            "URI" => "/api/v1/users?type=2"
        );
        return $this->request($params);
    }

    public function getUser($useId) {
        $params = array(
            "method" => "GET",
            "URI" => "/api/v1/users/" . $useId,
        );
        return $this->request($params);
    }

    public function editUser($json, $userId) {
        $params = array(
            "method" => "PUT",
            "URI" => "/api/v1/users/" . $userId,
            "payload" => $json
        );
        return $this->request($params);
    }

    private function request($params = array()) {
        $headers[] = "api-key: $this->apiKey";
        $headers[] = "api-secret: $this->apiSecret";
        $headers[] = "Content-Type: application/json";
        $headers[] = "Accept: application/json";
        $ch = curl_init();
        $serverUrl = rtrim($this->apiURL, "/");
        curl_setopt($ch, CURLOPT_URL, $serverUrl . $params["URI"]);
        if ($params["method"] == "PUT") {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params["payload"]);
        }
        if ($params["method"] == "POST") {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params["payload"]);
        }
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        if ($response === false) {
            return 'Error: ' . curl_error($ch);
        }
        curl_close($ch);
        return $response;
    }

}
