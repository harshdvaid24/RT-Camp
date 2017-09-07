<?php
include 'authkey.php';
$helper = $fb_obj->getRedirectLoginHelper(); // optional
try {
    if (isset($_SESSION['facebook_access_token'])) {
        $accessToken = $_SESSION['facebook_access_token'];
    } else {
        $accessToken = $helper->getAccessToken();
    }
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
if (isset($accessToken)) {
    if (isset($_SESSION['facebook_access_token'])) {
        header("location:http://www.harshvaid.com/rt/Profile.php");
    } else {
        // getting short-lived access token
        $_SESSION['facebook_access_token'] = (string) $accessToken;
        // OAuth 2.0 client handler
        $oAuth2Client = $fb_obj->getOAuth2Client();
        // Exchanges a short-lived access token for a long-lived one
        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
        $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
        // setting default access token to be used in script
        $fb_obj->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }
    // redirect the user back to the same page if it has "code" GET variable
    if (isset($_GET['code'])) {
        header('Location:http://www.harshvaid.com/rt/Profile.php');
    }
} else {
    $permissions = ['email','user_photos'];
    // replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
    $loginUrl = $helper->getLoginUrl('http://www.harshvaid.com/rt/index.php', $permissions);
}
?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Memories Album</title>
		 <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.5/angular.min.js"></script>
		<!--BOOTSTRAP INCLUDES-->
		<link rel="stylesheet" type="text/css" href="lib/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
        <link rel="shortcut icon" type="image/x-icon" href="lib/img/fav1.ico ">
		<!--FONTAWESOME INCLUDES-->

		<link rel="stylesheet" type="text/css" href="lib/css/font.css">
		<link rel="stylesheet" type="text/css" href="lib/css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="lib/css/font-awesome.min.css">

		<link rel="stylesheet" type="text/css" href="lib/css/style.css">
</head>
<body ng-app="fbalbum" ng-controller="albumController">
<div id="login">

	<h2 style="font-size: 75px; margin-bottom: 50px; font-family: 'Saira Semi Condensed', sans-serif; color: #03396c;">
	<p style="font-size: 20px; margin-bottom: 30px;">Welcome to</p> Memories</h2>



    <p>

      <a class="facebook-before"><span class="fontawesome-facebook"></span></a>
      <button class="facebook"  ng-click="loginauth()">Login Using Facebook</button>
    <h2>YOU  MUST  BE  MY  FACEBOOK  FRIEND</h2>
    </p>

  </div> 

<script type="text/javascript" src="lib/js/jquery.min.js"></script>

<!--BOOTSTRAP JS INCLUDES-->
<script type="text/javascript" src="lib/js/js.js"></script>
<script type="text/javascript" src="lib/js/bootstrap.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
    <script src="lib/js/bootstrap.min.js"></script>
<script type="text/javascript">
angular.module("fbalbum", []).controller("albumController", function ($window, $scope, $http) {
            $scope.loginauth=function () {
                $window.location="<?php echo $loginUrl;?>";
            }
        });
</script>

</body>
</html>