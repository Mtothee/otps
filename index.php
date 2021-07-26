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
        <script src="js/functions.js"></script>
        <script src="js/jquery.js"></script>
        <script src="js/autosize.js"></script>
    </head>
    <body>
        <?php
        $configArray = parse_ini_file("config");
        echo '<a href="' . $configArray["appUrl"] . '"><img src="images/' . $configArray["logo"] . '"/></a>';
        if (isset($_POST["submit"])) {
            $data = htmlspecialchars($_POST["data"]);
            $trimmedData = trim($data);
            $finalData = nl2br($trimmedData);
            $password = "immerdasgleiche";
            $timetolive = "100";
            $token = createSecret("$finalData", "$password", "$timetolive");
            echo '<div id="wrapper">
                  <form id="mainForm" action="index.php" method="POST">
                    <div class="col-1">
                      <label>
                      URL zum Teilen des Passworts
                      <input readonly name="sharingUrl" id="sharingUrl" value="'.$configArray["appUrl"].'/view.php?secret='.$token.'" tabindex="1">
                      </label>
                      <div class="col-submit">
                        <button onclick="copytoclipboard()" type="button" class="submitbtn" name="copy" value="copy" >URL kopieren</button>
                      </div>
                    </div>
                  </form>
                  </div>';
        } else {
           echo ' 
          <div id="wrapper"> 
          <form autocomplete="off" action="index.php" method="POST">
          <div class="col-1">
            <label>
              Passwort
              <textarea required placeholder="Passwort welches geteilt werden soll." class="auto-size" id="data" name="data" tabindex="1"></textarea>
            </label>
          </div>
          <div class="col-submit">
            <button type="submit" class="submitbtn" name="submit" value="submit">Link erstellen</button>
          </div>
          </form>
          </div>
          <script>$(\'textarea.auto-size\').textareaAutoSize();</script>
          ';
        }
        ?>

<script>  
    function copytoclipboard() {
        /* Get the text field */
        var copyText = document.getElementById("sharingUrl");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        document.execCommand("copy");

    }
</script>

    </body>
</html>
