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
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>EyeNet Installer - Checking Requirements</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../template/assets/icon.png"/>
        <link rel="apple-touch-icon image_src" href="../template/assets/icon-large.png"/>
        
        <!-- New template CSS -->
        <link href="../new-template/maxton/vertical-menu/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../new-template/maxton/vertical-menu/assets/plugins/fontawesome/css/all.min.css" rel="stylesheet" type="text/css" />
        <link href="../new-template/maxton/vertical-menu/assets/css/app.min.css" rel="stylesheet" type="text/css" />
        
        <style>
            .auth-page {
                background: #f3f3f9;
                display: flex;
                min-height: 100vh;
                align-items: center;
                justify-content: center;
            }
            .installer-box {
                max-width: 600px;
                width: 100%;
                margin: 0 auto;
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
                padding: 2rem;
            }
            .installer-logo {
                text-align: center;
                margin-bottom: 2rem;
            }
            .installer-logo h3 {
                font-size: 2rem;
                margin: 1rem 0;
            }
            .check-status {
                text-align: center;
                margin: 2rem 0;
            }
            .check-status i {
                font-size: 3rem;
                margin-bottom: 1rem;
            }
            .loading-spinner {
                width: 3rem;
                height: 3rem;
            }
        </style>
    </head>
    <body class="auth-page">
        <div class="installer-box">
            <div class="installer-logo">
                <h3><span class="text-primary">Eye</span>Net Installer</h3>
            </div>

            <div class="check-status">
                <div class="spinner-border text-primary loading-spinner" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h4 class="mt-3">Checking Requirements...</h4>
                <p class="text-muted">Please wait while we verify your system configuration.</p>
            </div>

            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Installation
                </a>
            </div>
        </div>

        <!-- Scripts -->
        <script src="../new-template/maxton/vertical-menu/assets/js/jquery.min.js"></script>
        <script src="../new-template/maxton/vertical-menu/assets/js/bootstrap.bundle.min.js"></script>
        <script src="../new-template/maxton/vertical-menu/assets/js/app.js"></script>
        <script>
            // Redirect to install.php after 2 seconds
            setTimeout(function() {
                window.location.href = 'install.php?' + window.location.search.substring(1);
            }, 2000);
        </script>
    </body>
</html>
