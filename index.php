<!DOCTYPE html>
<?php
// put your code here
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sähköpostit</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <form action="tallennaEmail.php">
            <fieldset>
                <legend>Sähköpostiosoitteiden keräys</legend>
                <label for="email">Sähköposti: </label><input type="email" id="email" autofocus>                                           
                <input type="submit" autofocus value="Tallenna sähköposti">

            </fieldset>
        </form>

    </body>
</html>
