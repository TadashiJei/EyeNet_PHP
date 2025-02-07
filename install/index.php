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


function baseURL() { //return base url for cron jobs
	 $requesturi = explode("?",$_SERVER["REQUEST_URI"]);
	 $subdir =  $requesturi[0];
	 $pageURL = 'http';
	 if(isset($_SERVER["HTTPS"])) { if($_SERVER["HTTPS"] == "on") {$pageURL .= "s";} }
	 $pageURL .= "://";
	 if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") {
	  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"] . $subdir;
	 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"] . $subdir;
	 }
	 return str_ireplace("install/","",$pageURL);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>EyeNet Installer</title>
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
                max-width: 850px;
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
            .requirements-list {
                margin-top: 1rem;
            }
            .requirements-list .requirement-item {
                padding: 0.5rem 0;
                border-bottom: 1px solid #eee;
            }
            .form-group {
                margin-bottom: 1rem;
            }
        </style>
    </head>
    <body class="auth-page">
        <div class="installer-box">
            <div class="installer-logo">
                <h3><span class="text-primary">Eye</span>Net Installer</h3>
            </div>

            <?php if(isset($status)): ?>
            <div class="alert alert-<?php echo $status['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $status['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Installation Settings</h4>
                            <form action="check.php" method="post">
                                <div class="form-group">
                                    <label class="form-label">Database Host</label>
                                    <input type="text" name="dbserver" class="form-control" value="localhost" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Database Name</label>
                                    <input type="text" name="dbname" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Database Username</label>
                                    <input type="text" name="dbuser" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Database Password</label>
                                    <input type="password" name="dbpassword" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">EyeNet URL</label>
                                    <input type="text" name="app_url" class="form-control" value="<?php echo baseURL();?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Admin Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary w-100">Continue</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Requirements</h4>
                            <div class="requirements-list">
                                <?php if (!is_writable(dirname('../config.php'))) { ?>
                                <div class="requirement-item text-danger">
                                    <i class="fas fa-times-circle"></i> Config file is not writable
                                </div>
                                <?php } else { ?>
                                <div class="requirement-item text-success">
                                    <i class="fas fa-check-circle"></i> Config file is writable
                                </div>
                                <?php } ?>

                                <?php if (version_compare(PHP_VERSION, '7.3.0', '<')) { ?>
                                <div class="requirement-item text-danger">
                                    <i class="fas fa-times-circle"></i> PHP 7.3.0+ is required
                                </div>
                                <?php } else { ?>
                                <div class="requirement-item text-success">
                                    <i class="fas fa-check-circle"></i> PHP version is compatible
                                </div>
                                <?php } ?>

                                <?php if (!extension_loaded('pdo_mysql')) { ?>
                                <div class="requirement-item text-danger">
                                    <i class="fas fa-times-circle"></i> MySQLi extension is required
                                </div>
                                <?php } else { ?>
                                <div class="requirement-item text-success">
                                    <i class="fas fa-check-circle"></i> MySQLi extension is installed
                                </div>
                                <?php } ?>

                                <?php if (!function_exists('fsockopen')) { ?>
                                <div class="requirement-item text-warning">
                                    <i class="fas fa-exclamation-circle"></i> PHP FSOCKOPEN is disabled
                                </div>
                                <?php } else { ?>
                                <div class="requirement-item text-success">
                                    <i class="fas fa-check-circle"></i> PHP FSOCKOPEN is enabled
                                </div>
                                <?php } ?>

                                <?php if (!function_exists('exec')) { ?>
                                <div class="requirement-item text-warning">
                                    <i class="fas fa-exclamation-circle"></i> PHP EXEC is disabled
                                </div>
                                <?php } else { ?>
                                <div class="requirement-item text-success">
                                    <i class="fas fa-check-circle"></i> PHP EXEC is enabled
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="../new-template/maxton/vertical-menu/assets/js/jquery.min.js"></script>
        <script src="../new-template/maxton/vertical-menu/assets/js/bootstrap.bundle.min.js"></script>
        <script src="../new-template/maxton/vertical-menu/assets/js/app.js"></script>
    </body>
</html>
