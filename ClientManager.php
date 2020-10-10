<?php

class ClientManager {
    //lien vers la bdd
    private $db;

    public function __construct(){
        $this->db = NEW PDO('mysql:host=localhost;dbname=tartenpion;charset=utf8',
        'root','',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

    }

    public function readAll(){
        $collection =[];
        $sql= "SELECT * FROM clients";
        $results=$this->db->query($sql);
        while($client = $results->fetch(PDO::FETCH_ASSOC)){
            $collection[]=new Client($client);
        }
        return $collection;

    }

    //lit un client qui est dans la base
    public function read($id){
        $sql="SELECT  * FROM clients WHERE id = ?";
        $r= $this->db->prepare($sql);
        $r->bindValue(1,$id,PDO::PARAM_INT);
        $r->execute();
        $client =$r->fetch(PDO::FETCH_ASSOC);
        $perso = new Client($client);
        
        //var_dump($client);
        //var_dump($perso);

        return $perso;
    }
    //attention ajout éperluette!!
    private function create(Client &$client){
        $sql = "INSERT INTO clients (nom,prenom,tel,email)
        VALUES (:nom,:prenom,:tel,:email)";

        $r= $this->db->prepare($sql);
        $r->bindValue('nom',$client->getNom(),PDO::PARAM_STR);
        $r->bindValue('prenom',$client->getPrenom(),PDO::PARAM_STR);
        $r->bindValue('tel',$client->getTel(),PDO::PARAM_INT);
        $r->bindValue('email',$client->getEmail(),PDO::PARAM_STR);
        
        $ok = $r->execute();

        if($ok){
            $id = $this->db->lastInsertId();
            $client->setId($id);
        } 

    }

    public function save(Client $client){
        if($client->getid() > 0){
            $this->update($client);

        }else{
            $this->create($client);
        }
    }


     
      private function update(Client $client){

        //Requete SQL update
         $sql="UPDATE  clients  SET
                nom = :nom,
                prenom = :prenom,
                tel = :tel,
                email = :email
                WHERE id = :id
                ";

        $r= $this->db->prepare($sql);
        $r->bindValue('nom',$client->getNom(),PDO::PARAM_STR);
        $r->bindValue('prenom',$client->getPrenom(),PDO::PARAM_STR);
        $r->bindValue('tel',$client->getTel(),PDO::PARAM_INT);
        $r->bindValue('email',$client->getEmail(),PDO::PARAM_STR);
        $r->bindValue('id',$client->getId(),PDO::PARAM_INT);
        
        $r->execute();

    }

    //Attention l'eperluette
    public function del(Client &$client){
        $sql="DELETE FROM clients  WHERE id= ?";
        $r= $this->db->prepare($sql);
        $r->bindValue(1,$client->getId(),PDO::PARAM_INT);
        $r->execute();   
     
        //var_dump($client);
        //var_dump($perso);
    }


}