<?php
include realpath("../model/utilisateur.php");
if (isset($_POST["log_in"])) {
    if (!isset($_POST["email"]) || !isset($_POST["mdp"])) {
        echo "verifier votre email ou mot de passe";
    }
    $user = new Utilisateur($_POST['email'], $_POST['mdp'], "admin");
    $user->authenticate();
}

if (isset($_POST["log_out"])) {
    session_abort();
    session_destroy();
    header("Location:../index.php");
}

if (isset($_POST['add_user'])) {
    $admin = new Administrateur();
    $admin->AddNewUser($_POST['nom'], $_POST['prenom'], $_POST['team'], 'user', $_POST['email'], 'default');
}
if (isset($_POST["deleteUser"])){
    $admin = new Administrateur();
    $admin->deleteUser($_POST['id']);
}
if (isset($_POST['add_day'])) {
    $admin = new Administrateur();
    $admin->AddNewDay();
}
if (isset($_POST['delete_day_btn'])) {
    $admin = new Administrateur();
    $admin->deleteDay($_POST['id_jour']);
}

if (isset($_POST['present_btn'])) {
    $user = new Membre();
    $user->present($_POST['id_jour'], $_POST['id_user'], $_POST['id_presence']);
}
if (isset($_POST['depart_btn'])) {
    $user = new Membre();
    $user->depart($_POST['id_presence']);
}