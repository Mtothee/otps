<!DOCTYPE html>
<?php
/*
 * Date: 10/12/2014
 */
include ('secret.php');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php $configArray = parse_ini_file("config"); echo $configArray["siteName"];?></title>
        <link rel="stylesheet" type="text/css" media="all" href="css/styles.css">
        <link rel="icon" type="image/x-icon" href="images/favicon.ico">
        <script src="js/jquery.js"></script>
        <script src="js/autosize.js"></script>
    </head>
    <body>
      
        <?php
        $configArray = parse_ini_file("config");
        echo '<a href="' . $configArray["appUrl"] . '"><img src="images/' . $configArray["logo"] . '"/></a>';
        if (isset($_GET["secret"]) && preg_match('/^[0-9A-F]{32}$/i', $_GET["secret"])) {
            $secretToken = htmlspecialchars($_GET["secret"]);
            if (secretExist($secretToken)) {
                echo '
                <div id="wrapper">
                  <form action="view.php" method="POST">
                  <div class="col-1">
                    <label>
                    Bitte beachten: Das Passwort kann nur einmal angzeigt werden. Notieren Sie es an einem sicheren Ort.
                    <input type = "hidden" name = "token" value = "' . $secretToken . '" readonly = "readonly" />
                    </label>
                   </div>
                ';
               
                echo '
                <div class="col-submit">
                <button type="submit" class="submitbtn" name="showSecret" value="showSecret">Passwort anzeigen</button>
                </form>';
            } else {
                echo '
                  <div id="wrapper">
                  <form>
                  <div class="col-1">
                  <label>
                    A C H T U N G ! Das Passwort wurde bereits angesehen.
                  </label>
                  </div>
                  <div class="col-submit">
                    <button type="submit" class="submitbtn" name="goBack" value="goBack">Zurück</button>
                  </div>
                  </form>
                  </div>
                ';
            }
        } elseif (isset($_POST["showSecret"])) {
            $secretToken = htmlspecialchars($_POST["token"]);
            if (secretExist($secretToken)) {
                if (isSecretProtected($secretToken)) {
                    $password = htmlspecialchars($_POST["password"]);
                    $secretData = showSecret($secretToken, $password, true);
                    echo '
                      <div id="wrapper">
                      <form>
                      <div class="col-1">
                      <label>
                        Geteiltes Passwort
                        <input readonly value="'.$secretData.'" tabindex="1">
                      </label>
                      </div>
                      <div class="col-submit">
                        <button type="submit" class="submitbtn" name="createOwn" value="createOwn">Eigenes Passwort teilen</button>
                      </div>
                      </form>
                    ';
                } else {
                    $secretData = showSecret($secretToken, "", false);
                   echo '
                      <div id="wrapper">
                      <form>
                      <div class="col-1">
                      <label>
                        Geteiltes Passwort
                        <textarea class="auto-size" readonly tabindex="1">'.$secretData.'</textarea>
                      </label>
                      </div>
                      <div class="col-submit">
                        <button type="submit" class="submitbtn" name="createOwn" value="createOwn">Eigenes Passwort teilen</button>
                      </div>
                      </form>
                      <script>$(\'textarea.auto-size\').textareaAutoSize();</script>
                    ';
                }
            } else {
                echo '
                  <div id="wrapper">
                  <form>
                  <div class="col-1">
                  <label>
                    Passwort Link nicht vorhanden.
                  </label>
                  </div>
                  <div class="col-submit">
                    <button type="submit" class="submitbtn" name="goBack" value="goBack">Zurück</button>
                  </div>
                  </form>
                  </div>
                ';
            }
        } else {
            $configArray = parse_ini_file("config");
            header('Location:' . $configArray["appUrl"]);
            die();
        }
        ?>
    </body>
</html>
