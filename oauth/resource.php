<?php
// include our OAuth2 Server object
require_once __DIR__ . '/server.php';

// include our LDAP object
require_once __DIR__ . '/LDAP/LDAP.php';
require_once __DIR__ . '/LDAP/config_ldap.php';

// Handle a request to a resource and authenticate the access token
if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
    $server->getResponse()->send();
    die;
}

// set default error message
$resp = array("error" => "Unknown error", "message" => "An unknown error has occurred, please report this bug");

// get information on user associated to the token
$info_oauth = $server->getAccessTokenData(OAuth2\Request::createFromGlobals());
$user = $info_oauth["user_id"];
$assoc_id = $info_oauth["assoc_id"];

// Open a LDAP connection
$ldap = new LDAP($hostname, $port);

// Try to get user data on the LDAP
try {
    $data = $ldap->getDataForMattermost($base, $filter, $bind_dn, $bind_pass, $search_attribute, $user);
    $user = mb_strtolower(substr($user, 0, -12)); // remove .mnogomed.ru from end of username
    $fio = $data['sn'] . " " . $data['givenName'];
    $resp = array(
        "name" => $fio,
        "username" => $user,
        "id" => $assoc_id,
        "state" => "active",
        "email" => mb_strtolower($data['mail']),
        "location" => $data['post']
    );
    error_log("Client: " . var_export($resp, true), 0);
} catch (Exception $e) {
    $resp = array("error" => "Impossible to get data", "message" => $e->getMessage());
}

echo json_encode($resp);
