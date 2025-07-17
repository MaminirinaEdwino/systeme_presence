<?php
// session_abort();
// session_start();
// session_destroy();
function login_view()
{
    ?>
    <form action="./controller/admin.php" method="post">
        <input type="email" name="email">
        <input type="password" name="mdp">
        <input type="submit" value="Log in" name="log_in">
    </form>
    <?php
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presence </title>
</head>

<body>
    <?php
    if (!isset($_SESSION["connected"])) {
        login_view();
    }
    ?>
</body>

</html>