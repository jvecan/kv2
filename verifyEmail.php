<!DOCTYPE html>
<?php
include('EmailFunktiot.php');
$returnMessage = "";
$email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
$verificationCode = filter_input(INPUT_GET, 'verify', FILTER_SANITIZE_STRING);
if ($email && $verificationCode) {
    $emailFunktiot = new EmailFunktiot();
    $returnMessage = $emailFunktiot->validateVerificationEmail($email, $verificationCode);
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
        <div><?php print $returnMessage; ?></div>

    </body>
</html>
