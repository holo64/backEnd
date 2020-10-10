<?php

class AdresseManager {
    //lien vers la bdd
    private $db;

    public function __construct(){
        $this->db = NEW PDO('mysql:host=localhost;dbname=tartenpion;charset=utf8',
        'root','',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

    }

    public function readAllAdressesDuClient($id_client){
        $collectionAdresse =[];
        $sql= "SELECT * FROM adresses A,clients C WHERE A.id_client=C.id AND id_client=?";
        $r= $this->db->prepare($sql);
            $r->bindValue(1,$id_client,PDO::PARAM_INT);
            $r->execute();
        while($adresse = $r->fetch(PDO::FETCH_ASSOC)){
            $collectionAdresse[]=new Adresse($adresse);
        }
        return $collectionAdresse;

    }



    //lit une adresse qui est dans la base
    public function read($id){
        $sql="SELECT  * FROM adresses WHERE id_adresse = ?";
        $r= $this->db->prepare($sql);
        $r->bindValue(1,$id,PDO::PARAM_INT);
        $r->execute();
        $adresse =$r->fetch(PDO::FETCH_ASSOC);
        $adresseClient = new Adresse($adresse);
        
        //var_dump($adresse);
        //var_dump($adresseClient);

        return $adresseClient;
    }

    //lit une liste d'adresses qui avec  $defaut 
    public function readAdresseDefaut($id_client){
        $sql= "SELECT * FROM adresses  WHERE defaut=1 AND id_client=?";
        $r= $this->db->prepare($sql);
            $r->bindValue(1,$id_client,PDO::PARAM_INT);
            $r->execute();
            $adresse =$r->fetch(PDO::FETCH_ASSOC);
            $adresseClient = new Adresse($adresse);
        return $adresseClient;

    }

  
    //attention ajout éperluette!!
    private function create(Adresse &$adresse){
        $sql = "INSERT INTO adresses (intitule,ligne1,ligne2,cp,ville,defaut,id_client)
        VALUES (:intitule,:ligne1,:ligne2,:cp,:ville,:defaut,:id_client)";

        $r= $this->db->prepare($sql);
        $r->bindValue('intitule',$adresse->getIntitule(),PDO::PARAM_STR);
        $r->bindValue('ligne1',$adresse->getLigne1(),PDO::PARAM_STR);
        $r->bindValue('ligne2',$adresse->getLigne2(),PDO::PARAM_STR);
        $r->bindValue('cp',$adresse->getCp(),PDO::PARAM_INT);
        $r->bindValue('ville',$adresse->getVille(),PDO::PARAM_STR);
        $r->bindValue('defaut',$adresse->getDefaut(),PDO::PARAM_BOOL);
        $r->bindValue('id_client',$adresse->getId_client(),PDO::PARAM_INT);
        
        $ok = $r->execute();

        if($ok){
            $id = $this->db->lastInsertId();
            $adresse->setId_adresse($id);
        } 

    }

    public function save(Adresse $adresse){
        if($adresse->getId_adresse() > 0){
            $this->update($adresse);

        }else{
            $this->create($adresse);
        }
    }


     
    private function update(Adresse $adresse){

        //Requete SQL update
         $sql="UPDATE  adresses  SET
                intitule = :intitule,
                ligne1 = :ligne1,
                ligne2 = :ligne2,
                cp = :cp,
                ville = :ville,
                defaut = :defaut,
                id_client = :id_client
                WHERE id_adresse = :id_adresse
                ";

        $r= $this->db->prepare($sql);
        $r->bindValue('id_adresse',$adresse->getId_adresse(),PDO::PARAM_INT);
        $r->bindValue('intitule',$adresse->getIntitule(),PDO::PARAM_STR);
        $r->bindValue('ligne1',$adresse->getLigne1(),PDO::PARAM_STR);
        $r->bindValue('ligne2',$adresse->getLigne2(),PDO::PARAM_STR);
        $r->bindValue('cp',$adresse->getCp(),PDO::PARAM_INT);
        $r->bindValue('ville',$adresse->getVille(),PDO::PARAM_STR);
        $r->bindValue('defaut',$adresse->getDefaut(),PDO::PARAM_BOOL);
        $r->bindValue('id_client',$adresse->getId_client(),PDO::PARAM_INT);
 
        
        $r->execute();

    }

    //Attention l'eperluette
    public function del(Adresse &$id_client){
        $sql="DELETE FROM adresses  WHERE id_adresse= ?";
        $r= $this->db->prepare($sql);
        $r->bindValue(1,$id_client->getId_adresse(),PDO::PARAM_INT);
        $r->execute();   
     
        //var_dump($adresse);
        //var_dump($perso);

    }

}