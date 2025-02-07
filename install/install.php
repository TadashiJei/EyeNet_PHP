<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Initialize variables
$ok = false;
$error_message = '';

try {
    // Function to validate required POST parameters
    function validatePostParams() {
        $required_params = ['dbname', 'dbserver', 'dbuser', 'password', 'email', 'name', 'app_url'];
        foreach ($required_params as $param) {
            if (!isset($_POST[$param]) || empty($_POST[$param])) {
                throw new Exception("Missing required parameter: " . $param);
            }
        }
    }

    // Generate random string for encryption
    function randomString($chars=10) {
        $characters = '0123456789abcdef';
        $randstring = '';
        for ($i = 0; $i < $chars; $i++) {
            $randstring .= $characters[rand(0, strlen($characters) -1)];
        }
        return $randstring;
    }

    // Validate POST parameters
    validatePostParams();

    $encryption_key = randomString(64);

    // Check if required files exist
    if (!file_exists('../vendor/classes/class.medoo.php')) {
        throw new Exception("Required file not found: vendor/classes/class.medoo.php");
    }

    if (!file_exists('sql/db.sql')) {
        throw new Exception("Required file not found: sql/db.sql");
    }

    // Include database class
    require('../vendor/classes/class.medoo.php');

    // Test database connection
    try {
        $database = new medoo([
            "database_type" => "mysql",
            "database_name" => $_POST['dbname'],
            "server" => $_POST['dbserver'],
            "username" => $_POST['dbuser'],
            "password" => $_POST['dbpassword'],
            "charset" => "utf8",
            "port" => 3306
        ]);

        // Test the connection
        $database->query("SELECT 1");
    } catch (Exception $e) {
        throw new Exception("Database connection failed: " . $e->getMessage());
    }

    // Import database structure
    try {
        $sql = file_get_contents('sql/db.sql');
        if ($sql === false) {
            throw new Exception("Could not read sql/db.sql file");
        }
        $database->query($sql);
    } catch (Exception $e) {
        throw new Exception("Database import failed: " . $e->getMessage());
    }

    // Prepare user data
    $password = sha1($_POST['password']);
    $email = strtolower($_POST['email']);
    $name = $_POST['name'];

    // Create admin user
    try {
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
    } catch (Exception $e) {
        throw new Exception("Failed to create admin user: " . $e->getMessage());
    }

    // Create contact
    try {
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
    } catch (Exception $e) {
        throw new Exception("Failed to create contact: " . $e->getMessage());
    }

    // Update app URL
    try {
        $database->update("core_config", 
            ["value" => rtrim($_POST['app_url'], '/') . '/'], 
            ["name" => "app_url"]
        );
    } catch (Exception $e) {
        throw new Exception("Failed to update app URL: " . $e->getMessage());
    }

    // Create config file
    $config_file = "../config.php";
    if (!is_writable(dirname($config_file))) {
        throw new Exception("Config directory is not writable");
    }

    $config_content = '<?php $config = array(
        "database_type"=>"mysql",
        "database_name"=>"'.$_POST['dbname'].'",
        "server"=>"'.$_POST['dbserver'].'",
        "username"=>"'.$_POST['dbuser'].'",
        "password"=>"'.$_POST['dbpassword'].'",
        "charset"=>"utf8",
        "port"=>3306,
        "encryption_key"=>"'.$encryption_key.'" 
    ); ?>';

    if (file_put_contents($config_file, $config_content) === false) {
        throw new Exception("Failed to write config file");
    }

    $ok = true;

} catch (Exception $e) {
    $ok = false;
    $error_message = $e->getMessage();
}

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
            .installation-progress {
                margin: 2rem 0;
            }
            .progress {
                height: 1rem;
            }
            .installation-steps {
                margin-top: 2rem;
            }
            .step-item {
                display: flex;
                align-items: center;
                margin-bottom: 1rem;
                padding: 1rem;
                border-radius: 0.5rem;
                background: #f8f9fa;
            }
            .step-icon {
                width: 2rem;
                height: 2rem;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                margin-right: 1rem;
            }
            .step-content {
                flex: 1;
            }
            .step-title {
                margin: 0;
                font-size: 1rem;
                font-weight: 500;
            }
            .step-description {
                margin: 0;
                font-size: 0.875rem;
                color: #6c757d;
            }
            .error-container {
                margin: 2rem 0;
                padding: 1rem;
                border-radius: 0.5rem;
                background: #fff5f5;
                border: 1px solid #feb2b2;
            }
            .error-title {
                color: #c53030;
                font-weight: 600;
                margin-bottom: 0.5rem;
            }
            .error-message {
                color: #742a2a;
            }
            .success-container {
                margin: 2rem 0;
                padding: 1rem;
                border-radius: 0.5rem;
                background: #f0fff4;
                border: 1px solid #9ae6b4;
            }
            .success-title {
                color: #276749;
                font-weight: 600;
                margin-bottom: 0.5rem;
            }
        </style>
    </head>
    <body class="auth-page">
        <div class="installer-box">
            <div class="installer-logo">
                <h3><span class="text-primary">Eye</span>Net Installer</h3>
            </div>

            <?php if (!$ok && !empty($error_message)): ?>
            <div class="error-container">
                <div class="error-title">
                    <i class="fas fa-exclamation-circle"></i> Installation Error
                </div>
                <div class="error-message">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
                <div class="mt-3">
                    <a href="index.php" class="btn btn-outline-danger">
                        <i class="fas fa-arrow-left me-2"></i>Back to Setup
                    </a>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($ok): ?>
            <div class="success-container">
                <div class="success-title">
                    <i class="fas fa-check-circle"></i> Installation Complete
                </div>
                <p>EyeNet has been successfully installed! Here are your login details:</p>
                <div class="mt-3">
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                    <p><strong>Password:</strong> <?php echo htmlspecialchars($_POST['password']); ?></p>
                </div>
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    Please delete the "install" directory before proceeding.
                </div>
                <div class="mt-3">
                    <a href="../index.php" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i>Go to Login
                    </a>
                </div>
            </div>
            <?php else: ?>
            <div class="installation-progress">
                <h5 class="mb-3">Installation Progress</h5>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" id="progress-bar"></div>
                </div>
            </div>

            <div class="installation-steps">
                <div class="step-item" id="step-database">
                    <div class="step-icon bg-primary text-white">
                        <i class="fas fa-database"></i>
                    </div>
                    <div class="step-content">
                        <h6 class="step-title">Database Setup</h6>
                        <p class="step-description">Creating database tables and structure</p>
                    </div>
                    <div class="step-status">
                        <i class="fas fa-spinner fa-spin text-primary"></i>
                    </div>
                </div>

                <div class="step-item" id="step-config">
                    <div class="step-icon bg-secondary">
                        <i class="fas fa-cog"></i>
                    </div>
                    <div class="step-content">
                        <h6 class="step-title">Configuration</h6>
                        <p class="step-description">Setting up system configuration</p>
                    </div>
                    <div class="step-status">
                        <i class="fas fa-clock text-secondary"></i>
                    </div>
                </div>

                <div class="step-item" id="step-admin">
                    <div class="step-icon bg-secondary">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="step-content">
                        <h6 class="step-title">Admin Account</h6>
                        <p class="step-description">Creating administrator account</p>
                    </div>
                    <div class="step-status">
                        <i class="fas fa-clock text-secondary"></i>
                    </div>
                </div>

                <div class="step-item" id="step-finish">
                    <div class="step-icon bg-secondary">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="step-content">
                        <h6 class="step-title">Finishing Up</h6>
                        <p class="step-description">Completing installation process</p>
                    </div>
                    <div class="step-status">
                        <i class="fas fa-clock text-secondary"></i>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Scripts -->
        <script src="../new-template/maxton/vertical-menu/assets/js/jquery.min.js"></script>
        <script src="../new-template/maxton/vertical-menu/assets/js/bootstrap.bundle.min.js"></script>
        <script src="../new-template/maxton/vertical-menu/assets/js/app.js"></script>
        <?php if (!$ok && empty($error_message)): ?>
        <script>
            // Installation progress simulation
            const steps = ['database', 'config', 'admin', 'finish'];
            let currentStep = 0;
            
            function updateProgress(step) {
                const progress = ((step + 1) / steps.length) * 100;
                $('#progress-bar').css('width', progress + '%');
                
                // Update previous steps
                for (let i = 0; i < step; i++) {
                    $(`#step-${steps[i]} .step-icon`).removeClass('bg-primary').addClass('bg-success');
                    $(`#step-${steps[i]} .step-status i`).removeClass('fa-spinner fa-spin text-primary').addClass('fa-check text-success');
                }
                
                // Update current step
                $(`#step-${steps[step]} .step-icon`).removeClass('bg-secondary').addClass('bg-primary');
                $(`#step-${steps[step]} .step-status i`).removeClass('fa-clock text-secondary').addClass('fa-spinner fa-spin text-primary');
                
                // Update next steps
                for (let i = step + 1; i < steps.length; i++) {
                    $(`#step-${steps[i]} .step-icon`).removeClass('bg-primary bg-success').addClass('bg-secondary');
                    $(`#step-${steps[i]} .step-status i`).removeClass('fa-check text-success fa-spinner fa-spin text-primary').addClass('fa-clock text-secondary');
                }
            }
            
            function nextStep() {
                if (currentStep < steps.length) {
                    updateProgress(currentStep);
                    currentStep++;
                    
                    if (currentStep < steps.length) {
                        setTimeout(nextStep, 1500);
                    } else {
                        // Installation complete
                        $(`#step-finish .step-icon`).removeClass('bg-primary').addClass('bg-success');
                        $(`#step-finish .step-status i`).removeClass('fa-spinner fa-spin text-primary').addClass('fa-check text-success');
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    }
                }
            }
            
            // Start installation process
            $(document).ready(function() {
                setTimeout(nextStep, 1000);
            });
        </script>
        <?php endif; ?>
    </body>
</html>
