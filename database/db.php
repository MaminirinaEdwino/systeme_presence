<?php
    class DB{
        private $source_db = "pgsql:host=localhost;port=5432;dbname=systeme_presence_simple;user=postgres;password=root";
        public $connexion = "";
        public function connect(){
            $this->connexion = new PDO($this->source_db);
        }
    }
?>