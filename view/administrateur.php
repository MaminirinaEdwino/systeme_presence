<?php
include_once "../model/utilisateur.php";
session_start();

function addUserView()
{
    ?>
    <form action="./controller/admin.php" method="post">
        <h1>Ajouter utilisateur</h1>
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
    <div>
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
        </div>
        <?php
        }
}

function listJourView()
{
    $admin = new Administrateur();
    $listDay = $admin->listDay();
    ?>
    <div>
        <div>
            <span>id_jour</span>
            <span>date</span>
        </div>

        <?php
        foreach ($listDay as $key => $value) {
            ?>
            <div>
                <span><?php echo $value['id_jour'] ?></span>
                <span><?php echo $value['date_jour'] ?></span>
               <form action="../controller/admin.php" method="post">
                    <input type="hidden" name="id_jour" value="<?php echo $value['id_jour'] ?>">
                    <input type="submit" value="Delete" name="delete_day_btn">
               </form>
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
    <form action="../controller/admin.php" method="post">
        Add Jour de travail
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
    <title>Présence - Admin</title>
</head>

<body>
    <form action="../controller/admin.php" method="post">
        <input type="submit" value="Log out" name="log_out">
    </form>
    <?php

    echo "admin";

    addUserView();
    listUserView();
    $db = new DB();
    $db->connect();

    $state = $db->connexion->query("select compare_date_now() as state")->fetch()["state"];
    echo $state;

    if ($state) {
        AddDayView();
    }

    listJourView();
    ?>
</body>

</html>