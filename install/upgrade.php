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


$latestversion = 1.11;
$status = 'ok';

# LOAD CONFIGURAGION FILE
if(file_exists("../config.php")) {
	require('../config.php');
}
else { $status = 'noconfig'; }


if($status == 'ok') {
    # INITIALIZE MEDOO
    require('../vendor/classes/class.medoo.php');
    $database = new medoo($config);
    $currentversion = $database->get("core_config", "value", [ "name" => "db_version" ]);

    // UPGRADE to 1.1
    if($currentversion == 1.0) {

        $sql = file_get_contents('sql/db_1.0-1.1.sql');
        $database->query($sql);
        sleep(1);

        $database->update("core_config", ["value" => "1.1"], ["name" => "db_version"]);
        $status = 'updated';
        sleep(1);

        $currentversion = $database->get("core_config", "value", [ "name" => "db_version" ]);

    }


    // UPGRADE to 1.2
    if($currentversion == 1.1) {

        $sql = file_get_contents('sql/db_1.1-1.2.sql');
        $database->query($sql);
        sleep(1);

        $database->update("core_config", ["value" => "1.2"], ["name" => "db_version"]);
        $status = 'updated';
        sleep(1);

        $currentversion = $database->get("core_config", "value", [ "name" => "db_version" ]);

    }

    // UPGRADE to 1.3
    if($currentversion == 1.2) {

        $sql = file_get_contents('sql/db_1.2-1.3.sql');
        $database->query($sql);
        sleep(1);

        $database->update("core_config", ["value" => "1.3"], ["name" => "db_version"]);
        $status = 'updated';
        sleep(1);

        $currentversion = $database->get("core_config", "value", [ "name" => "db_version" ]);

    }

    // UPGRADE to 1.4
    if($currentversion == 1.3) {

        $sql = file_get_contents('sql/db_1.3-1.4.sql');
        $database->query($sql);
        sleep(1);

        $database->update("core_config", ["value" => "1.4"], ["name" => "db_version"]);
        $status = 'updated';
        sleep(1);

        $currentversion = $database->get("core_config", "value", [ "name" => "db_version" ]);

    }

    // UPGRADE to 1.5
    if($currentversion == 1.4) {

        $database->update("core_config", ["value" => "1.5"], ["name" => "db_version"]);
        $status = 'updated';
        sleep(1);

        $currentversion = $database->get("core_config", "value", [ "name" => "db_version" ]);

    }

    // UPGRADE to 1.6
    if($currentversion == 1.5) {

        $database->update("core_config", ["value" => "1.6"], ["name" => "db_version"]);
        $status = 'updated';
        sleep(1);

        $currentversion = $database->get("core_config", "value", [ "name" => "db_version" ]);

    }

    // UPGRADE to 1.7
    if($currentversion == 1.6) {

        $database->update("core_config", ["value" => "1.7"], ["name" => "db_version"]);
        $status = 'updated';
        sleep(1);

        $currentversion = $database->get("core_config", "value", [ "name" => "db_version" ]);

    }

    // UPGRADE to 1.8
    if($currentversion == 1.7) {

        $sql = file_get_contents('sql/db_1.7-1.8.sql');
        $database->query($sql);
        sleep(1);

        $database->update("core_config", ["value" => "1.8"], ["name" => "db_version"]);
        $status = 'updated';
        sleep(1);

        $currentversion = $database->get("core_config", "value", [ "name" => "db_version" ]);

    }


    // UPGRADE to 1.9
    if($currentversion == 1.8) {

        $sql = file_get_contents('sql/db_1.8-1.9.sql');
        $database->query($sql);
        sleep(1);

        $database->update("core_config", ["value" => "1.9"], ["name" => "db_version"]);
        $status = 'updated';
        sleep(1);

        $currentversion = $database->get("core_config", "value", [ "name" => "db_version" ]);

    }

    // UPGRADE to 1.10
    if($currentversion == 1.9) {

        $sql = file_get_contents('sql/db_1.9-1.10.sql');
        $database->query($sql);
        sleep(1);

        $database->update("core_config", ["value" => "1.10"], ["name" => "db_version"]);
        $status = 'updated';
        sleep(1);

        $currentversion = $database->get("core_config", "value", [ "name" => "db_version" ]);

    }


    // UPGRADE to 1.11
    if($currentversion == 1.10) {


        $database->update("core_config", ["value" => "1.11"], ["name" => "db_version"]);
        $status = 'updated';
        sleep(1);

        $currentversion = $database->get("core_config", "value", [ "name" => "db_version" ]);

    }
    

    // UPGRADE to 1.12
    if($currentversion == 1.11) {


        $database->update("core_config", ["value" => "1.12"], ["name" => "db_version"]);
        $status = 'updated';
        sleep(1);

        $currentversion = $database->get("core_config", "value", [ "name" => "db_version" ]);

    }



}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>EyeNet Installer - Upgrade</title>
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
            .upgrade-content {
                text-align: center;
                margin: 2rem 0;
            }
            .version-info {
                margin: 2rem 0;
                padding: 1rem;
                background: #f8f9fa;
                border-radius: 0.5rem;
            }
            .version-item {
                display: flex;
                justify-content: space-between;
                padding: 0.5rem 0;
                border-bottom: 1px solid #dee2e6;
            }
            .version-item:last-child {
                border-bottom: none;
            }
        </style>
    </head>
    <body class="auth-page">
        <div class="installer-box">
            <div class="installer-logo">
                <h3><span class="text-primary">Eye</span>Net Upgrade</h3>
            </div>

            <?php if(isset($status)): ?>
            <div class="alert alert-<?php echo $status['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $status['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <div class="upgrade-content">
                <i class="fas fa-sync-alt fa-3x text-primary mb-3"></i>
                <h4>System Upgrade</h4>
                <p class="text-muted">Your EyeNet installation will be upgraded to the latest version</p>

                <div class="version-info">
                    <div class="version-item">
                        <span>Current Version</span>
                        <span class="text-muted">v<?php echo $currentversion; ?></span>
                    </div>
                    <div class="version-item">
                        <span>Latest Version</span>
                        <span class="text-primary">v<?php echo $latestversion; ?></span>
                    </div>
                </div>

                <?php if($currentversion < $latestversion): ?>
                <form action="upgrade.php" method="post" class="mt-4">
                    <input type="hidden" name="upgrade" value="1">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-arrow-circle-up me-2"></i>Start Upgrade
                    </button>
                </form>
                <?php else: ?>
                <div class="alert alert-success mt-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>Your system is up to date!
                </div>
                <a href="../index.php" class="btn btn-primary mt-3">
                    <i class="fas fa-home me-2"></i>Go to Dashboard
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Scripts -->
        <script src="../new-template/maxton/vertical-menu/assets/js/jquery.min.js"></script>
        <script src="../new-template/maxton/vertical-menu/assets/js/bootstrap.bundle.min.js"></script>
        <script src="../new-template/maxton/vertical-menu/assets/js/app.js"></script>
    </body>
</html>
