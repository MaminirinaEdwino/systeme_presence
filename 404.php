<?php
$code = $_SERVER["REDIRECT_STATUS"];
$uri = $_SERVER["REQUEST_URI"];
?>
<html>
<head>
    <title>Page d'erreur HTTP <?php echo $code; ?></title>
</head>
<body style="display: flex; justify-content: center; align-item: center">
    <h2>Vous venez de rencontrer une erreur HTTP <?php echo $code; ?> pour la page <?php echo $uri; ?>.</h2>
</body>
</html>   