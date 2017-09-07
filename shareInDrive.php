<?php

//require __DIR__.'/google-api-php-client/autoload.php';
include "deletefolder.php";
include "authkey.php";
include 'Google.php';
$gle = new Google();
// include "gpConfig.php";
// include 'google-api-php-client/src/Google/Service/Drive.php';


$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$gle->g_client->setAccessToken($_SESSION["token"]);
//$func=new UtilityFunction();
$fb_obj->setDefaultAccessToken($_SESSION["facebook_access_token"]);
function generateRandomString($length = 10){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
date_default_timezone_set('UTC');
$rndmString="assets/UserData/".generateRandomString(26)."_".date("h-i");
mkdir($rndmString);
try {
    $profile_request = $fb_obj->get('/me?fields=name');
    $profile = $profile_request->getGraphNode()->asArray();
    $service = new Google_Service_Drive($gle->g_client);
    $folderId=$gle->getFolderExistsCreate($service,"facebook_".str_replace(" ", "_", $profile['name'])."_album","");
    foreach ($request->data as $key => $value) {
        $albumID=$value->useralbumid;
        $albumName=str_replace("+", " ", $value->useralbumname);
        $useralbumimage_response = $fb_obj->get("/" . $albumID . "/photos?fields=source");
        $useralbumimages = $useralbumimage_response->getGraphEdge()->asArray();
        $subFolderId=$gle->createSubFolder($service,$folderId,$albumName);
        foreach ($useralbumimages as $key => $value) {
            $data=file_get_contents($value['source']);
            $fp = fopen($rndmString."/".$albumName.$key.".jpg","w");
                    if (!$fp) exit;
                    fwrite($fp, $data);

            $title=$albumName.$key;
            $filename=$rndmString."/".$albumName.$key.".jpg";
            $mimeType=mime_content_type ( $filename );
           $gle->insertFile($service, $title,  $mimeType, $filename, $subFolderId);
        }
    }
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    header("Location: ./");
    exit;
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
?>