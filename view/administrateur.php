<?php
include_once "../model/utilisateur.php";
session_start();

function addUserView()
{
    ?>
    <form action="./controller/admin.php" method="post" id="add-user-form">
        <h2>Ajouter utilisateur</h2>
        <label for="nom">Nom</label>
        <input type="text" name="nom">
        <label for="prenom">Prenom</label>
        <input type="text" name="prenom">
        <label for="email">Email</label>
        <input type="email" name="email">
        <label for="team">Team</label>
        <select name="team" id="">
            <option value="dev">Dev</option>
            <option value="commercial">Commercial</option>
            <option value="marketing">Marketing</option>
            <option value="Droit">Droite</option>
        </select>
        <input type="submit" value="Ajouter" name="add_user">
    </form>
    <?php
}

function listUserView()
{
    $admin = new Administrateur();
    $listUser = $admin->listUser();
    ?>
    <div class="list-user">
        <div>
            <span>id</span>
            <span>Nom</span>
            <span>Prenom</span>
            <span>Team</span>
            <span>Email</span>
            <span>Action</span>
        </div>
        <?php
        foreach ($listUser as $key => $value) {
            ?>
            <div>
                <span><?php echo $value["id"]; ?></span>
                <span><?php echo $value["nom"]; ?></span>
                <span><?php echo $value["prenom"]; ?></span>
                <span><?php echo $value["team"]; ?></span>
                <span><?php echo $value["email"]; ?></span>
                <span>
                    <form action="controller/admin.php" method="post">
                        <input type="hidden" name="idDelete" value="<?php echo $value["id"]; ?>">
                        <input type="submit" value="delete" name="deleteUser">
                    </form>
                </span>
            </div>
        <?php } ?>

    </div>
    <?php
}

function listJourView()
{
    $admin = new Administrateur();
    $listDay = $admin->listDay();
    ?>
    <div class="list-Jour">


        <?php
        foreach ($listDay as $key => $value) {
            ?>
            <div>
                <div>
                    <!-- <span><?php echo $value['id_jour'] ?></span> -->
                    <span><?php echo $value['date_jour'] ?></span>
                    <form action="../controller/admin.php" method="post">
                        <input type="hidden" name="id_jour" value="<?php echo $value['id_jour'] ?>">
                        <input type="submit" value="Delete" name="delete_day_btn">
                    </form>
                </div>
                <div>
                    <span>nom</span>
                    <span>prenom</span>
                    <span>email</span>
                    <span>team</span>
                    <span>arrive</span>
                    <span>depart</span>
                </div>
                <?php foreach ((json_decode($value['user_info'])) as $key => $value2) {
                    $test = (array) $value2;
                    ?>
                    <div>
                        <span><?php echo $test["nom"] ?></span>
                        <span><?php echo $test["prenom"] ?></span>
                        <span><?php echo $test["email"] ?></span>
                        <span><?php echo $test["team"] ?></span>
                        <span><?php echo $test["arrive"] ?></span>
                        <span><?php echo $test["depart"] ?></span>
                        <span><?php echo $test["temp_total"] ?></span>
                    </div>
                    <?php
                } ?>

            </div>
            <?php
        }

        ?>

    </div>
    <?php
}


function AddDayView()
{
    ?>
    <form action="../controller/admin.php" method="post" id="add-day">
        <h2>Add Jour de travail</h2>
        <input type="submit" value="Add" name="add_day">
    </form>

    <?php
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Présence - Admin</title>
</head>

<body>
    <header class="header-admin">
        <h2>Admin Interface</h2>
        <nav>
            <form action="./administrateur.php" method="post">
                <input type="submit" value="Users" name="users-btn">
                <input type="submit" value="Days" name="Day-btn">
            </form>
        </nav>
        <form action="../controller/admin.php" method="post">
            <input type="submit" value="Log out" name="log_out">
        </form>
    </header>

    <div class="content">
    <?php



if (isset($_POST['users-btn'])) {
    addUserView();
    listUserView();
} else {
    $db = new DB();
    $db->connect();

    $state = $db->connexion->query("select compare_date_now() as state")->fetch()["state"];

    if ($state) {
        AddDayView();
    }
    listJourView();
}


?>
    </div>
    <?php include "footer.php" ?>
</body>

</html>