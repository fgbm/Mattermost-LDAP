<?php
session_start();

// include our OAuth2 Server object
require_once __DIR__ . '/server.php';

$request = OAuth2\Request::createFromGlobals();
$response = new OAuth2\Response();

// validate the authorize request
if (!$server->validateAuthorizeRequest($request, $response)) {
    $response->send();
    die;
}

if (!isset($_SESSION['uid'])) {
    //store the authorize request
    $explode_url = explode("/", strip_tags(trim($_SERVER['REQUEST_URI'])));
    $_SESSION['auth_page'] = end($explode_url);
    header('Location: index.php');
    exit();
}
error_log('Session: ' . $_SESSION['uid']);

////error_log(var_export($_SERVER,true),0);

$uid = $_SESSION['uid'];
$is_authorized = true;

$server->handleAuthorizeRequest($request, $response, $is_authorized, $uid);

//error_log('Location: '.var_export($response->getHttpHeader('Location'), true), 0);

$code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=') + 5, 40);
header('Location: ' . $response->getHttpHeader('Location'));

//
session_unset();

exit("SUCCESS! Authorization Code: $code");
