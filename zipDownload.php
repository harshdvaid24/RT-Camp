<?php
include "deletefolder.php";
require_once 'authkey.php';
function generateRandomString($length = 10){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$postdata = file_get_contents("php://input");
$albumrequest = json_decode($postdata);

$fb_obj->setDefaultAccessToken($_SESSION["facebook_access_token"]);

$zip = new ZipArchive;
date_default_timezone_set('UTC');
$rndmString="assets/UserData/".generateRandomString(26)."_".date("h-i");
mkdir($rndmString);
if ($zip->open($rndmString . '/album.zip', ZipArchive::CREATE) === TRUE) {
    try {
        foreach ($albumrequest->data as $key => $value) {
            $albumID = $value->useralbumid;
            $albumName = str_replace("+", " ", $value->useralbumname);
            $useralbumimage_response = $fb_obj->get("/" . $albumID . "/photos?fields=source");
            $useralbumimages = $useralbumimage_response->getGraphEdge()->asArray();
            foreach ($useralbumimages as $key => $value) {
                $data = file_get_contents($value['source']);
                $fp = fopen($rndmString . "/" . $albumName . $key . ".jpg", "w");
                     if (!$fp) exit;
                     fwrite($fp, $data);
                $filename = $rndmString . "/" . $albumName . $key . ".jpg";
                $path = $albumName . '/' . $key . '.jpg';
                $zip->addFile($filename, $path);
            }
        }
    } catch (Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        // redirecting user back to app login page
        header("Location: ./");
        exit;
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other lqocal issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
    $zip->close();
}
echo $rndmString . "/album.zip";
?>