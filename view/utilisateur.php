<?php
session_start();
include "../model/utilisateur.php";
if (!isset($_SESSION["user"])) {
    header("location:../index.php");
}
$user = $_SESSION["user"];
$membre = new Membre();
$listJour = $membre->ListJourTravail($user['id']);

function markArrive($id_jour, $id_user, $id_presence)
{
    ?>
    <form action="../controller/admin.php" method="post">
        <input type="submit" value="Present" name="present_btn">
        <input type="hidden" name="id_jour" value="<?php echo $id_jour ?>">
        <input type="hidden" name="id_user" value="<?php echo $id_user ?>">
        <input type="hidden" name="id_presence" value="<?php echo $id_presence ?>">
    </form>
    <?php
}
function markDepart($id_jour, $id_user, $id_presence)
{
    ?>
    <form action="../controller/admin.php" method="post">
        <input type="submit" value="Depart" name="depart_btn">
        <input type="hidden" name="id_presence" value="<?php echo $id_presence ?>">
    </form>
    <?php
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presence - utilisateur</title>
</head>

<body>

    <header>
        <h1>Présence - <?php echo $user['nom'] . " " . $user['prenom'] ?></h1>
        <h2>Team <?php echo $user['team'] ?></h2>
        <h2>Email <?php echo $user['email'] ?></h2>

        <form action="../controller/admin.php" method="post">
            <input type="submit" value="Log out" name="log_out">
        </form>
    </header>

    <section>
        <h2>Liste de presence</h2>
        <div>
            <?php
            foreach ($listJour as $key => $value) {
                ?>
                <div>
                    <span><?php echo $value['date_jour'] ?></span>
                    <span><?php echo $value['nom'] ?></span>
                    <span><?php echo $value['prenom'] ?></span>
                    <span><?php echo $value['arrive'] ?></span>
                    <span><?php echo $value['depart'] ?></span>
                    <span>
                        <?php echo $value['arrive'] == null ? markArrive($value['id'], $user['id'], $value['presence_id']) : "" ?>
                    </span>
                    <span>
                        <?php echo $value['arrive'] != null and $value['depart'] == null ? markDepart($value['id'], $user['id'], $value['presence_id']) : "" ?>
                    </span>
                </div>
                <?php
            }
            ?>
        </div>

    </section>

</body>

</html>