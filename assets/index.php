
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Memories</title>
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

    <h1>Please login.</h1>

    <p>

        <a class="facebook-before"><span class="fontawesome-facebook"></span></a>
        <button class="facebook"  ng-click="loginauth()">Login Using Facebook</button>

    </p>

</div>


</body>
</html>