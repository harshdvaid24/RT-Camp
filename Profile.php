<?php
include "authkey.php";
include 'Google.php';

$gle = new Google();
if (isset($_GET['code'])) {
  $gle->authcredentialscode($_GET['code']);
}


if ($gle->checkcredentials()) {
    $gpUserProfile = $gle->getuserinfo();
} else {
    $authUrl = $gle->g_client->createAuthUrl();
}
if (isset($_SESSION['facebook_access_token'])) {
  $fb_obj->setDefaultAccessToken($_SESSION['facebook_access_token']);
  try {
    $profile_request = $fb_obj->get('/me?fields=picture.width(200).height(200),id,name,cover');
    $profile = $profile_request->getGraphNode()->asArray();

    $useralbums_response = $fb_obj->get("/" . $profile["id"] . "/albums?fields=picture,name,id");
    $useralbums = $useralbums_response->getGraphEdge()->asArray();
    $albumjson=json_encode($useralbums);
  } catch (Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    header("Location: ./");
    exit;
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }
} else {
  header("location:http://www.harshvaid.com/rt/");
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Memories</title>
    <link rel="stylesheet" type="text/css" href="lib/src/css/HoldOn.css">


    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.5/angular.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="lib/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="lib/css/font-awesome.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="lib/img/fav1.ico ">
    <link rel="stylesheet" type="text/css" href="lib/css/profile.css">
    <link rel="stylesheet" type="text/css" href="lib/css/gallery-grid.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
    <script src="lib/src/js/HoldOn.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>

</head>
<body ng-app="fbalbum" ng-controller="albumController" >
<div  class="container">
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
                <li><?php if (!isset($_SESSION['token'])) {
                        echo '<a class="navbar-toggle"  ng-click="googleauth(\''.$authUrl.'\')" style="margin-top: 7px; margin-right:20px;"><i class="fa fa-google fa-2x"></i>OOGLE </a>';
                    } else {
                        echo '
                    <div class="dropdown">
                        <img src="'.$gpUserProfile['picture'].'" class="dropdown-toggle" data-toggle="dropdown" height="40px" width="40px" style="border-radius:50%; margin-top:15px; margin-right:30px;"/>
                    
                    <ul class="dropdown-menu" style="margin-top:10px;">
                        <li><a href="logout.php?session=token" class="logout-gmail" style="color:#000 !important;">Logout</a></li>
                    </ul>
                    </div> ';
                    }
                    ?></li>
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

  <div class="container-fluid"data-wow-delay=""">

   <center><div class="container" style="border-top: 3px solid #012c57; margin-top: 50px; width: 50%;"></div></center>
   <h2 class="text-center" style="color: #145c9e;">What We Can Do for You</h2>
   <center><div class="container" style=" border-bottom: 3px solid #012c57; margin-bottom: 30px; width: 50%;"></div></center   >
   <div class="row">



   <div class="col-sm-4" style="margin-top: 50px; color:  #012c57 ;">
      <center><img src="lib/img/slide.png" height="80px" width="80px"></center>
         <h3 class="text-center" >Album Slideshow </h3>
   </div>

       <div class="col-sm-4" style="margin-top: 50px; color:  #012c57 ;">
           <center><img src="lib/img/download.ico" height="80px" width="80px"></center>
           <h3 class="text-center" >Download Albums </h3>
       </div>

   <div class="col-sm-4" style="margin-top: 50px; color:  #012c57 ;" >
     <center><img src="lib/img/drive.png" height="80px" width="100px"></center>
         <h3 class="text-center">Move to Google Drive</h3>
   </div>
 </div>
</div>

<center><div class="container-fluid" style="margin-top: 50px;">
  <center><div class="container" style=" border-top: 3px solid #012c57; margin-top: 50px; width: 40%;"></div></center>
  <h2 class="text-center" style="color: #145c9e;">Sign in First from <i class="fa fa-google "></i> OOGLE </h2>

  <center><div class="container" style=" border-bottom: 3px solid #012c57; width: 40%;""></div></center>
  <div class="row">
    <button class="pure-button makebtn" style="border:transparent ;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border:2px solid #145c9e;" ng-click="download_All_Album()">
      <i class="fa fa-arrow-circle-o-down fa-3x"></i><p>Download All </p>
    </button>
    <button class="pure-button makebtn" style="border:transparent ;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border:2px solid #145c9e;" " ng-click="download_Multiple_Album()">
      <i class="fa fa-check-square-o fa-3x"></i><p><span class="badge blue">{{albumselected}}</span>&nbsp Selected for Download</p>
    </button>
     <?php
     echo '<button class="pure-button makebtn" style="border:transparent ;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border:2px solid #c12e2a;" ng-click="share_All_Album()"';
     if (!isset($_SESSION['token'])) {
          echo 'disabled';
      }
                echo '><i class="fa fa-google fa-3x"></i><p>Move All to Drive </p>
            </button>' ?>

<?php if(isset($_SESSION['token'])){
    echo '<button class="pure-button makebtn" style="border:transparent ;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border:2px solid #c12e2a;" ng-click="share_Multiple_Album()" id="sharemultiple">
      <i class="fa fa-check-square-o fa-3x"></i><p>Move  &nbsp  <span class="badge badge-info">{{albumselected}}</span> &nbsp to Drive </p>
    </button>';
}else{  echo '<button class="pure-button makebtn" style="border:transparent ;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border:2px solid #c12e2a;">
      <i class="fa fa-check-square-o fa-3x"></i><p>Move  &nbsp  <span class="badge badge-info">{{albumselected}}</span> &nbsp to Drive </p>
    </button>';}
    ?>

  </div>
</div></center>

<div class="container" style="margin-top: 5%;margin:auto; padding: 5%; margin-left: 4%;">
  <div class="row" style="width: 100%; margin:auto;">
    <?php
    $i = 0;
    foreach ($useralbums as $useralbum) {
    echo '<div class="col-sm-3" style="margin:2%;padding: 0%; border:transparent ;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border:2px solid #145c9e;" >
          <a href="photos.php?useralbumid=' . $useralbum['id'] .'"><img class="img" width="100%" height="200px" src="' . $useralbum['picture']['url'] .'" alt="Card image cap"></a>
      <div class="container-fluid">
        <h4 class="card-title "style="color: #145c9e;">';
        echo '<label  for="' . $useralbum['id'] . '" class="btn btn-outline-primary"> ';
                        echo '<input type="checkbox" name="' . $useralbum['name'] . '" id="' . $useralbum['id'] . '" ng-model="isalbum[' . $i . ']" ng-true-value="true" ng-false-value="false" ng-change="addalbum(' . $i . ',\'' . $useralbum['name'] . '\',' . $useralbum['id'] . ')"/>';
                        echo '</label>';
        
        echo $useralbum['name'].'</h4>
        <p>';
          echo '<button style="margin-right: 10px;"  class="btn btn-primary btn-block" ng-click="singledownload(\'' . $useralbum["name"] . '\',' . $useralbum["id"] . ')"><i class="fa fa-file-archive-o fa-1x" style="margin-right: 10px;" ></i> Download as Zip</button>'; ?>

          </p>
        <p><?php echo '<button " class="btn btn-danger btn-block "';
            if (!isset($_SESSION['token'])) {
                echo 'disabled ';
            }
            echo 'ng-click="singleshare(\'' . $useralbum["name"] . '\',' . $useralbum["id"] . ')">';
            echo  '<i class="fa fa-cloud-download fa-1x"style="margin-right: 10px;"></i>Move to Google Drive</button>'; ?>
            </p>
      </div>
    </div>
<?php  $i++;}
    ?>

  </div>
<div class="modal fade" id="exampleModal" style="margin-top: 200px" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">Download</h2>
                </div>
                <div class="modal-body">
                    <h6 id="filename" style="color: #3b5998;font-family: 'Roboto Condensed', sans-serif;"></h6>
                </div>
                <div class="modal-footer">
                   
                    <button class="btn btn-secondary" data-dismiss="modal">Cancle</button>
                    <button ng-click="downloadfolder(file.folder)" ng-model="file.folder" type="button"
                            class="btn btn-primary">Start Download 
                    </button>
                </div>
            </div>
        </div>
    </div>

  <div class="modal fade" id="gshareModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
       aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel"> Your album has been moved sucessfully</h5>
              </div>
              <div class="modal-body">
                  <h6 id="infotouser" style="color: #3b5998;font-family: 'Roboto Condensed', sans-serif;"></h6>
              </div>
              <div class="modal-footer">
                  <button class="btn btn-secondary" data-dismiss="modal">Ok</button>
              </div>
          </div>
      </div>
      </div>
  </div>





   <!--BOOTSTRAP JS INCLUDES-->
   <script type="text/javascript" src="lib/js/js.js"></script>
   <script type="text/javascript" src="lib/js/bootstrap.js"></script>

 <script type="text/javascript">

     angular.module("fbalbum", []).controller("albumController", function ($window, $scope, $http) {
         $scope.selectedalbum = [];
         $scope.file = {};
         $scope.file.filename;
         $scope.file.folder;
         $scope.sharestate = true;
         $scope.isalbum = [];
         $scope.albumselected = 0;
         $scope.addalbum = function (id, albumname, albumid) {
             if ($scope.isalbum[id] == true) {
                 $scope.selectedalbum.push({"useralbumid": albumid + "", "useralbumname": albumname});
                 $scope.albumselected += 1;
             } else {
                 for (i = 0; i < $scope.selectedalbum.length; i++) {
                     if ($scope.selectedalbum[i].useralbumid == albumid) {
                         $scope.selectedalbum.splice(i, 1);
                     }
                 }
                 $scope.albumselected -= 1;
             }
             if ($scope.albumselected > 0) {
                 $scope.sharestate = false;
                 document.getElementById("downloadmultiple").disabled = false;
             }
             else {
                 $scope.sharestate = true;
                 document.getElementById("downloadmultiple").disabled = true;
                 document.getElementById("sharemultiple").disabled = true;
             }
         }
         $scope.singleshare = function (albumname, albumid) {
             $scope.sharealbum({data: [{"useralbumid": albumid + "", "useralbumname": albumname}]});
         }
         $scope.singledownload = function (albumname, albumid) {
             $scope.downloadalbum({data: [{"useralbumid": albumid + "", "useralbumname": albumname}]});
         }
         $scope.share_Multiple_Album = function () {
             $scope.sharealbum({data: $scope.selectedalbum});
         }





         $scope.download_Multiple_Album = function () {
             $scope.downloadalbum({data: $scope.selectedalbum});
         }
         $scope.share_All_Album = function () {
             var allalbumjson = <?php print_r($albumjson); ?>;
             for (var i in allalbumjson) {
                 $scope.selectedalbum.push({
                     "useralbumid": allalbumjson[i]['id'] + "",
                     "useralbumname": allalbumjson[i]['name']
                 });
             }
             $scope.sharealbum({data: $scope.selectedalbum});
         }
         $scope.download_All_Album = function () {
             var allalbumjson = <?php print_r($albumjson); ?>;
             for (var i in allalbumjson) {
                 $scope.selectedalbum.push({
                     "useralbumid": allalbumjson[i]['id'] + "",
                     "useralbumname": allalbumjson[i]['name']
                 });
             }
             $scope.downloadalbum({data: $scope.selectedalbum});
         }
         $scope.downloadfolder = function (foldername) {
             $window.location = foldername;
         }
         /* $scope.deletefolder=function(foldername){
          var myobj;
          myobj=new ActiveXObject("Scripting.FileSystemObject");
          myobj.DeleteFolder(foldername);
          }*/
         $scope.sharealbum = function (data) {
             HoldOn.open({
                 theme: 'sk-cube',
                 message: "<h4>" + " Uploading your album</h4>"
             });
             $http({
                 method: "post", url: "shareInDrive.php", data: data,
                 headers: {'Content-Type': 'application/x-www-form-urlencoded'}
             }).then(function (result) {
                 HoldOn.close();
                 document.getElementById("infotouser").innerHTML = "Your album is successfully uploaded in your google drive";
                 $('#gshareModal').modal('show');
             }, function (reason) {
             });
         }
         $scope.downloadalbum = function (data) {
             HoldOn.open({
                 theme: 'sk-cube',
                 message: "<h4>" + " Preparing your zip file</h4>"
             });
             $http({
                 method: "post", url: "zipDownload.php", data: data,
                 headers: {'Content-Type': 'application/x-www-form-urlencoded'}
             }).then(function (result) {
                 HoldOn.close();
                 $scope.file.filename = result.data.split("/")[0].toString();
                 $scope.file.folder = result.data;
                 document.getElementById("filename").innerHTML = result.data.split("/")[1];
                 $('#exampleModal').modal('show');
             }, function (reason) {
             });
         }
         $scope.googleauth = function (url) {
             $window.location = url;
         }
     });
</script>
</div>

<div class="copyright">
    <div class="container">
        <p class="footer-class"> © 2017 All Rights Reserved and Developed by Harsh Vaid</p>
    </div>
</div>
 </body>
 </html>