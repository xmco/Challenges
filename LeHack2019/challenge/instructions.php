<?php


$message = NULL;

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // valid email
        $handle = fopen('/tmp/emails/emails.txt', 'a');
        if ($handle !== FALSE) {
            $data = time() . ' - ' . $email . "\n";
            $message = "Email registered!";
            fwrite($handle, $data);
        } else $message = "Failure! can't open email file";
        fclose($handle);
    } else $message = "Failure! Not an email";
}

?>

<!DOCTYPE html>
<html>

<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="/static/main.css" />
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="shortcut icon" href="https://blog.xmco.fr/wp-content/uploads/2017/11/cert-xmco.png">

</head>

<body>

    <header>

        <nav>
            <div class="nav-wrapper">
                <a href="#" class="brand-logo">
                    <img src="https://www.xmco.fr/wp-content/uploads/2018/01/XMCO_logos_marron3.svg" alt="logo">
                </a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="index.php" color="white">Challenge</a></li>
                    <li><a href="instructions.php" color="white">Instructions</a></li>
                </ul>
            </div>
        </nav>
    </header>


    <main>

        <div class="main">
            <p class="flow-text">
                Welcome to the XMCO LeHack 2019 Challenge.
            </p>
            <p class="flow-text">
                The goal of the challenge is to find a vulnerability on the page <a href="index.php">Challenge</a> and to report it at the following email address: <a href="mailto:lehack2019@xmco.fr">lehack2019@xmco.fr</a>
            </p>
            <p class="flow-text">
                Winning this challenge will earn you a Nintendo Switch.
            </p>
            <p class="flow-text">
                We are going to choose the best report (we like Markdown)
            </p>
            <p class="flow-text">
                PS: There is no flag to retrieve, just find the vulnerability and write a report
            </p>
            <p class="flow-text">
                PS: This may be about XSS ;)
            </p>
            <p>
                If nobody win this challenge we are going to choose one winner among all the email adresses entered here (Please, do not try anything on this form):
                <form method="post" action="">
                    <div class="raw">
                        <div class="input-field col s6">
                            <input id="email" name="email" type="text" autofocus>
                            <label for="adress">Adress</label>
                        </div>
                    </div>

                </form>

                <?php
                if ($message !== NULL) {
                    ?>

                    <div class="collection">
                        <a href="#!" cla s s="collection-item"><?php echo $message; ?></a>
                    </div>
                <?php
                }
                ?>
            </p>
        </div>

    </main>



    <footer class="page-footer">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text">XMCO LeHack 2019 Challenge</h5>
                    <p class="black-text text-lighten-4">
                        Welcome to XMCO LeHack 2019 Challenge
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
                XMCO
                <a class="black-text text-lighten-4 right" href="#!"></a>
            </div>
        </div>
    </footer>
    <!--JavaScript at end of body for optimized loading-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>

</html>