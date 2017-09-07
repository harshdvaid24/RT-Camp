<?php
session_start();
require_once __DIR__ . '/lib/src/Facebook/autoload.php';
$fb_obj = new Facebook\Facebook([
    'app_id' => '1433674986708910',
    'app_secret' => '01b2946ca3ee846c5c479ec61cbec895',
    'default_graph_version' => 'v2.10',
]);
?>