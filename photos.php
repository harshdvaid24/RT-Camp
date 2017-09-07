<?php
include "authkey.php";
if (isset($_GET['useralbumid'])) {
    if (isset($_SESSION['facebook_access_token'])) {
        $fb_obj->setDefaultAccessToken($_SESSION['facebook_access_token']);
        try {
            $profile_request = $fb_obj->get('/me?fields=picture.width(200).height(200),id,name,cover');
            $profile = $profile_request->getGraphNode()->asArray();

            $useralbumimage_response = $fb_obj->get("/" . $_GET['useralbumid'] . "/photos?fields=source,name,id");
            $useralbumimages = $useralbumimage_response->getGraphEdge()->asArray();
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
    } else {
        header("location:localhost/rtDemo/");
    }
} else {
    header("location:./");
}
?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Memories</title>

		<!--BOOTSTRAP INCLUDES-->
		<link rel="stylesheet" type="text/css" href="lib/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
          <link rel="shortcut icon" type="image/x-icon" href="lib/img/fav1.ico ">
		<!--FONTAWESOME INCLUDES-->

		<link rel="stylesheet" type="text/css" href="lib/css/font.css">
		<link rel="stylesheet" type="text/css" href="lib/css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="lib/css/font-awesome.min.css">

		<link rel="stylesheet" type="text/css" href="lib/css/profile.css">
		<link rel="stylesheet" type="text/css" href="lib/css/gallery-grid.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a  " class="navbar-brand" href="Profile.php"> <i class="fa fa-camera-retro fa-2x "></i> Memories</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li><a class="navbar-toggle" href="logout.php" style="margin-top: 7px;">FB LOGOUT</a></li>
                <li></li>

            </ul>
        </div>
    </div>
</nav>
<div class="container"  style=" border:transparent ;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); margin:auto;" >
    <?php echo '<div class="container-fluid cover-pic" style=" background-image:linear-gradient( rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6) ),url('.$profile['cover']['source'].'); background-size: cover;background-position: center center; background-repeat: no-repeat; height: auto; margin-top: 70px;">'?>
    <div class="" style="margin-top: 150px;">
        <?php echo'<center><img  style="border: 4px solid #fff; border-radius:50%;" src="'. $profile['picture']['url'] .'" alt="Ash" />
    <h2 style="color: #ffffff;">   '.$profile['name'].'    </h2></center>'?>
    </div>
    <?php echo '</div>'?>

<div class="container gallery-container" id="gallery">

 <center><div style=" border-top: 3px solid #000; margin-top: 20px; width: 20%;"></div></center>
    <div class="text-center"><h2 class="heading_h2" style="margin-top: 20px;color: #145c9e;">GALLERY</h2></div>
  <center><div style=" border-top: 3px solid #000; margin-top: 20px; width:  20%;"></div></center>
    
    <div class="tz-gallery">

        <div class="row"><?php
        foreach ($useralbumimages as $useralbumimage) {
            echo '<div class="col-sm-6 col-md-4 card-img-top img-responsive">
                <a class="lightbox" href="' . $useralbumimage['source'] . '">
                    <img src="' . $useralbumimage['source'] . '" height="300px" width="300px" alt="Park">
                </a>
            </div>';
            }?>

        </div>

    </div>

</div>

<div class="copyright">
        <div class="container">
           <p class="footer-class">© 2017 All Rights Reserved and Developed by Harsh Vaid</p>
        </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
<script>
    baguetteBox.run('.tz-gallery');
</script>

<script type="text/javascript" src="lib/js/jquery.min.js"></script>

<!--BOOTSTRAP JS INCLUDES-->
<script type="text/javascript" src="lib/js/js.js"></script>
<script type="text/javascript" src="lib/js/bootstrap.js"></script>
</body>
</html>