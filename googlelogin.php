<?php
include 'gpConfig.php';
require_once 'lib/google-api-php-client/src/Google/Service/Drive.php';
$authUrl = "";
if (isset($_GET['code'])) {
    $gClient->authenticate($_GET['code']);
    $_SESSION['token'] = $gClient->getAccessToken();
    header('Location: ./');
}
if (isset($_SESSION['token'])) {
    $gClient->setAccessToken($_SESSION['token']);
}
if ($gClient->getAccessToken()) {
    $gpUserProfile = $google_oauthV2->userinfo->get();
    print_r($gpUserProfile);
    exit();
} else {
    $authUrl = $gClient->createAuthUrl();
    //header("location:" . $authUrl);
    //    $output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><img src="images/glogin.png" alt=""/></a>';
}
?>