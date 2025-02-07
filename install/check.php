<?php

$debug = false;

if($debug == false) {
    error_reporting(0);
    ini_set('display_errors', '0');
}

if($debug == true) {
    error_reporting(E_ALL & ~E_NOTICE);
    ini_set('display_errors', '1');
}

require('../vendor/classes/class.medoo.php');

try {
    $database = new medoo([
        "database_type"=>"mysql",
        "database_name"=> $_POST['dbname'],
        "server"=> $_POST['dbserver'],
        "username"=> $_POST['dbuser'],
        "password"=> $_POST['dbpassword'],
        "charset"=>"utf8",
        "port"=>3306
    ]);
    $ok = true;
}
catch(Exception $e) {
    $ok = false;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>EyeNet Installer</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link rel="shortcut icon" href="../template/assets/icon.png"/>
        <link rel="apple-touch-icon image_src" href="../template/assets/icon-large.png"/>
        <link href="../template/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../template/assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- Install theme -->
        <link href="assets/css/install.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    </head>
    <body class="login-page">
        <div class="login-box">
            <div class="login-logo">
                <b>Eye</b>Net Installer
            </div>
            <div class="login-box-body">
                <div class="install-steps">
                    <div class="step">
                        <div class="step-number">1</div>
                        <div class="step-label">Requirements</div>
                    </div>
                    <div class="step active">
                        <div class="step-number">2</div>
                        <div class="step-label">Configuration</div>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <div class="step-label">Installation</div>
                    </div>
                </div>
