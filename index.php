<!DOCTYPE html>
<?php
include('EmailFunktiot.php');
    $returnMessage = "";
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if($email) {
        $emailFunktiot = new EmailFunktiot();
        $returnMessage = $emailFunktiot->saveEmail($email);
    }

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sähköpostit</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <form method="post" action="?">
            <fieldset>
                <legend>Sähköpostiosoitteiden keräys</legend>
                <label for="email" class='fieldset-row-label'>Sähköposti: </label><input type="email" id="email" name="email" class='fieldset-row-input-email' autofocus required>                                      
                <input type="submit" class='fieldset-submit' autofocus value="Tallenna sähköposti">
                <div><?php print $returnMessage?></div>

            </fieldset>
        </form>

    </body>
</html>
