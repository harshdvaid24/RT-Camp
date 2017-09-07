<?php
//session_start();
//Include Google client library
include_once 'lib/google-api-php-client/src/Google/Client.php';
include_once 'lib/google-api-php-client/src/Google/Auth/OAuth2.php';
/*
 * Configuration and setup Google API
 */
$clientId = '266564509095-b9sigd858l3n1v9egq8rt1kt11kok5l1.apps.googleusercontent.com'; //Google client ID
$clientSecret = 'CMtmYhOyx36MDRFolUJ0sB_U'; //Google client secret
$redirectURL = 'http://www.harshvaid.com/rt/Profile.php'; //Callback URL
$SCOPES = array(
    'https://www.googleapis.com/auth/drive.file',
    'https://www.googleapis.com/auth/userinfo.email',
    'https://www.googleapis.com/auth/userinfo.profile');

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Memories');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);
$gClient->setScopes($SCOPES);

$google_oauthV2 = new Google_Service_Oauth2($gClient);
?>