<?php
// session_abort();
// session_start();
// session_destroy();
function login_view()
{
    ?>
    <form action="./controller/admin.php" method="post" id="log_in">
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
        <label for="mdp">Mot de passe</label>
        <input type="password" name="mdp" id="mdp">
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
    <link rel="stylesheet" href="view/style/style.css">
    <title>Presence </title>
</head>

<body>
    <section id="landing_page">
        <h1>Plateforme de présence</h1>
        <?php
        if (!isset($_SESSION["connected"])) {
            login_view();
        }
        ?>
    </section>
</body>

</html>