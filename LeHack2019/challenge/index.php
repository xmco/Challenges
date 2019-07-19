<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/predis/autoload.php';
Predis\Autoloader::register();

$G_CHARSET = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

function generate_token($length, $charset)
{
    $charactersLength = strlen($charset);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $charset[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Checks if a token is present
$token = $_GET['token'];
if (!isset($token) || $token == '') {
    header("Location: /?token=" . generate_token(64, $G_CHARSET));
    die();
}

// Get current user IP Address
$user_ip = $_SERVER['REMOTE_ADDR'];
if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != "") {
    $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    $user_ip = substr($user_ip, 0, 9);
    if (strpos($user_ip, " ") != false) {
        $user_ip = NULL;
    }
}

try {
    // This connection is for a remote server
    $redis = new Predis\Client(array(
        "scheme" => "tcp",
        "host" => "redis",
        "port" => 6379
    ));

    $redis_ip = $redis->get($token);
    $redis->set($token, $user_ip); // Store the new ip adress
} catch (Exception $e) {
    die($e->getMessage());
}



?>

<!DOCTYPE html>
<html>

<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="/static/main.css?token=<?php echo htmlspecialchars($token); ?>" />
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="https://blog.xmco.fr/wp-content/uploads/2017/11/cert-xmco.png">
</head>

<body>

    <header>

        <nav>
            <div class="nav-wrapper lime darken-1">
                <a href="https://www.xmco.fr/" class="brand-logo">
                    <img src="https://www.xmco.fr/wp-content/uploads/2018/01/XMCO_logos_marron3.svg" alt="logo">
                </a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="instructions.php" color="black">Instructions</a></li>
                    <li><a href="index.php" color="black">Challenge</a></li>
                </ul>
            </div>
        </nav>
    </header>


    <main>
        <div class="main">
            <div id="login-page" class="row">
                <div class="col s12 z-depth-6 card-panel">
                    <form id="login-form" action="" method="post">
                        <div class="row">
                            <h5 class="col12">Please login</h5>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">mail_outline</i>
                                <input class="validate" id="username" type="text" autofocus>
                                <label for="username">Username</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">lock_outline</i>
                                <input id="password" type="password">
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <button type="submit" class="btn waves-effect waves-light col s12">Login</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </main>



    <footer class="page-footer lime darken-1">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="black-text">XMCO LeHack 2019 Challenge</h5>
                    <p class="black-text text-lighten-4">
                        Your IP Address (<?php echo $redis_ip == NULL ? "NULL" : $redis_ip; ?>) has been logged!
                    </p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5 class="black-text">Links</h5>
                    <ul>
                        <li><a class="black-text text-lighten-3" href="https://www.xmco.fr/">XMCO</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                <a class="black-text text-lighten-4 right" href="#!"></a>
            </div>
        </div>
    </footer>
    <!--JavaScript at end of body for optimized loading-->
    <script src="/static/main.js?token=<?php echo htmlspecialchars($token); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>

</html>