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

function randomString($chars=10) { //generate random string
    $characters = '0123456789abcdef';
    $randstring = '';
    for ($i = 0; $i < $chars; $i++) { $randstring .= $characters[rand(0, strlen($characters) -1)]; }
    return $randstring;
}

$encryption_key = randomString(64);

require('../vendor/classes/class.medoo.php');
$database = new medoo([
    "database_type"=>"mysql",
    "database_name"=> $_POST['dbname'],
    "server"=> $_POST['dbserver'],
    "username"=> $_POST['dbuser'],
    "password"=> $_POST['dbpassword'],
    "charset"=>"utf8",
    "port"=>3306
]);

$sql = file_get_contents('sql/db.sql');
$database->query($sql);

sleep(5);

$password = sha1($_POST['password']);
$email = strtolower($_POST['email']);
$name = $_POST['name'];

$database = new medoo([
    "database_type"=>"mysql",
    "database_name"=> $_POST['dbname'],
    "server"=> $_POST['dbserver'],
    "username"=> $_POST['dbuser'],
    "password"=> $_POST['dbpassword'],
    "charset"=>"utf8",
    "port"=>3306
]);

$database->insert("core_users", [
    "roleid" => "1",
    "name" => $name,
    "email" => $email,
    "password" => $password,
    "groups" => 'a:1:{i:0;s:1:"0";}',
    "theme" => "skin-green",
    "sidebar" => "opened",
    "layout" => "",
    "notes" => "",
    "sessionid" => "",
    "resetkey" => "",
    "lang" => "en",
    "autorefresh" => 0,
]);

$database->insert("app_contacts", [
    "groupid" => 1,
    "status" => 1,
    "name" => $name,
    "email" => $email,
    "mobilenumber" => "",
    "pushbullet" => "",
    "twitter" => "",
    "pushover" => "",
]);

$database->update("core_config", ["value" => rtrim($_POST['app_url'], '/') . '/'], ["name" => "app_url"]);

$data = '<?php $config = array(
    "database_type"=>"mysql",
    "database_name"=>"'.$_POST['dbname'].'",
    "server"=>"'.$_POST['dbserver'].'",
    "username"=>"'.$_POST['dbuser'].'",
    "password"=>"'.$_POST['dbpassword'].'",
    "charset"=>"utf8",
    "port"=>3306,
    "encryption_key"=>"'.$encryption_key.'" ); ?>';
$file = fopen("../config.php","w+");
fwrite($file,$data);
fclose($file);

$ok = true;

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>EyeNet Installer - Installation</title>
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
            .success-container {
                margin: 2rem 0;
                padding: 1rem;
                border-radius: 0.5rem;
                background: #f0fff4;
                border: 1px solid #9ae6b4;
            }
            .error-container {
                margin: 2rem 0;
                padding: 1rem;
                border-radius: 0.5rem;
                background: #fff5f5;
                border: 1px solid #feb2b2;
            }
        </style>
    </head>
    <body class="auth-page">
        <div class="installer-box">
            <div class="installer-logo">
                <h3><span class="text-primary">Eye</span>Net Installer</h3>
            </div>

            <?php if($ok == true): ?>
            <div class="success-container">
                <div class="text-center">
                    <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                    <h4>Installation Successful!</h4>
                </div>
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    Please delete the "install" directory before proceeding.
                </div>
                <div class="mt-4">
                    <h5>Your Login Details:</h5>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($_POST['email']); ?></p>
                    <p><strong>Password:</strong> <?php echo htmlspecialchars($_POST['password']); ?></p>
                </div>
                <div class="mt-4 text-center">
                    <a href="../index.php" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i>Go to Login
                    </a>
                </div>
            </div>
            <?php endif; ?>

            <?php if($ok == false): ?>
            <div class="error-container">
                <div class="text-center">
                    <i class="fas fa-times-circle text-danger fa-3x mb-3"></i>
                    <h4>Installation Error</h4>
                    <p>We were unable to install EyeNet. Please try again.</p>
                </div>
                <div class="mt-4 text-center">
                    <a href="index.php" class="btn btn-outline-danger">
                        <i class="fas fa-arrow-left me-2"></i>Back to Setup
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Scripts -->
        <script src="../new-template/maxton/vertical-menu/assets/js/jquery.min.js"></script>
        <script src="../new-template/maxton/vertical-menu/assets/js/bootstrap.bundle.min.js"></script>
        <script src="../new-template/maxton/vertical-menu/assets/js/app.js"></script>
    </body>
</html>
