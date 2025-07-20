<?php
include "../database/db.php";
class Utilisateur
{
    protected $id, $nom, $prenom, $team, $email, $mdp, $role;

    public function __construct($email, $mdp, $role)
    {
        $this->email = $email;
        $this->mdp = $mdp;
        $this->role = $role;
    }

    public function authenticate()
    {
        $db = new DB();
        $db->connect();

        $result = $db->connexion->prepare("select id, email, mdp, role, nom, prenom, team from utilisateur where email=:email");
        $result->execute([
            "email" => $this->email
        ]);
        if ($result->rowCount() > 0) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            if ($row["mdp"] == sha1($this->mdp)) {
                echo "user connecté";
                session_start();
                $_SESSION["user"] = $row;
                $_SESSION["connected"] = true;
                if ($row['role'] == 'admin') {
                    header("Location: ../view/administrateur.php");
                }
                if ($row["role"] == 'user') {
                    header("location:../view/utilisateur.php");
                }
            }
        } else {
            echo "utilisateur not found";
        }
    }
}

class Membre extends Utilisateur
{
    public function __construct()
    {

    }
    public function ListJourTravail($id)
    {
        $db = new DB();
        $db->connect();
        $req = $db->connexion->prepare("select now() as now,jour.id,to_char(jour.date_jour, 'Day DD Month YYYY') as date_jour, presence.id as presence_id, to_char(presence.arrive, 'HH24:MI') as arrive, to_char(presence.depart, 'HH24:MI') as depart, utilisateur.nom, utilisateur.prenom from jour left join presence on jour.id = presence.id_jour left join utilisateur on utilisateur.id = presence.id_user where presence.id_user is null or presence.id_user = :id  group by jour.id, utilisateur.nom, utilisateur.prenom, presence.id order by jour.date_jour desc");
        $req->execute([
            "id" => $id
        ]);
        return $req->fetchAll();
    }
    public function present($id_jour, $id_user, $id_presence)
    {
        $db = new DB();
        $db->connect();
        $req = $db->connexion->prepare("insert into presence (id_jour, id_user, arrive) values (:id_jour, :id_user, now()) returning * ");
        $req->execute([
            "id_jour" => $id_jour,
            "id_user" => $id_user
        ]);

        header("location:../view/utilisateur.php");
    }
    public function depart($id_presence)
    {
        $db = new DB();
        $db->connect();
        $req = $db->connexion->prepare("update presence set depart = now() where id = :id_presence returning * ");
        $req->execute([
            "id_presence" => $id_presence,
        ]);
        header("location:../view/utilisateur.php");
    }
}

class Administrateur extends Utilisateur
{
    public function __construct()
    {

    }
    public function AddNewUser($nom, $prenom, $team, $role, $email, $mdp)
    {
        $db = new DB();
        $db->connect();
        $result = $db->connexion->prepare("INSERT INTO utilisateur (nom, prenom, role, team, email, mdp) VALUES (:nom, :prenom,:role,:team, :email,:mdp) RETURNING * ");
        $result->execute([
            "nom" => $nom,
            "prenom" => $prenom,
            "team" => $team,
            "role" => $role,
            "email" => $email,
            "mdp" => sha1("default")
        ]);
        if ($result->rowCount() > 0) {
            if ($role == "admin") {
                header("Location:../view/administrateur.php");
            }
        }
    }

    public function listUser()
    {
        $db = new DB();
        $db->connect();

        $result = $db->connexion->query("select id, nom, prenom, email, team from utilisateur where role='user' order by id desc");
        $result = $result->fetchAll();
        return $result;
    }

    public function deleteUser($id)
    {
        $db = new DB();
        $db->connect();
        $result = $db->connexion->prepare("delete from utilisateur where id = :id returning *");
        $result->execute([
            "id" => $_POST['id']
        ]);
        if ($result->rowCount() > 0) {
            header("Location:../controller/administrateur.php");
        }
    }
    public function AddNewDay()
    {
        $db = new DB();
        $db->connect();
        $tmp = $db->connexion->query("insert into jour (date_jour) values(now()) returning * ");
        if ($tmp->rowCount()) {
            header("Location:../view/administrateur.php");
        }
    }
    public function deleteDay($id_jour){
        $db = new DB();
        $db->connect();
        $tmp = $db->connexion->prepare("delete from jour where id = :id_jour returning * ");
        $tmp->execute(["id_jour"=> $id_jour]);
        header("location:../view/administrateur.php");
    }
    public function ListDay()
    {
        $db = new DB();
        $db->connect();
        return $db->connexion->query("select jour.id as id_jour, to_char(date_jour, 'DD-MM-YYYY') as date_jour, json_agg(json_build_object('nom',utilisateur.nom,'prenom', utilisateur.prenom, 'email',utilisateur.email,'team', utilisateur.team,'arrive', to_char(presence.arrive, 'HH24:MI'), 'depart',to_char(presence.depart, 'HH24:MI'), 'temp_total', to_char(presence.depart - presence.arrive, 'HH24 heure MI m'))) as user_info from jour left join presence on jour.id = presence.id_jour join utilisateur on utilisateur.id = presence.id_user where utilisateur.role = 'user'  group by jour.id, jour.date_jour;")->fetchAll();
    }
}

