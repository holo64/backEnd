<?php
/*
 *Classe Adresse
 *Permet de créer une adresse
 */

class Adresse {
    /**
     * @var integer id adresse
     */
    private $id_adresse = 0;
    /**
     * @var string intitule adresse
     */
    private $intitule = '';
    /**
     * @var string adresse 1
     */
    private $ligne1 = '';
    /**
     * @var string adresse2
     */
    private $ligne2 ='';
    /**
     * @var integer code Postal
     */
    private $cp= '';
    /**
    *@var string ville
    */
    private $ville= '';
     /**
    *@var boolean defaut
    */
    private $defaut= false;
    /**
     * @var integer id_client adresse
     */
    private $id_client = 0;


    public function __construct($data=[]){
        $this->hydrate($data);
        
    }


    public function setId_adresse($id_adresse){
        $id_adresse =intval($id_adresse);
        if($id_adresse>0 && $this->id_adresse === 0){
            $this->id_adresse = $id_adresse;
        }
    }


    public function setIntitule($intitule){
       if(is_string($intitule)){
           if(mb_strlen($intitule) > 50){
            $intitule = substr ($intitule,0,50);
           }
       }
       else{
        $intitule ='';
       }
       $this->intitule = $intitule;
    }

    
    public function setLigne1($ligne1){
        if(is_string($ligne1)){
            if(mb_strlen($ligne1) > 50){
            $ligne1 = substr ($ligne1,0,50);
            }
        }
        else{
         $ligne1 ='';
        }
        $this->ligne1 = $ligne1;
     }
     public function setLigne2($ligne2){
        if(is_string($ligne2)){
            if(mb_strlen($ligne2) > 50){
            $ligne2 = substr ($ligne2,0,50);
            }
        }
        else{
         $ligne2 ='';
        }
        $this->ligne2 = $ligne2;
     }

         
    public function setCp($cp){
        if(mb_strlen($cp) > 5){
            $cp = substr ($cp,0,5);
        }
        $cp =intval($cp);
        $this->cp = $cp;
             
    }

    public function setVille($ville){
        if(is_string($ville)){
            if(mb_strlen($ville) > 50){
            $ville = substr ($ville,0,50);
            }
        }
        else{
            $ville ='';
        }
        $this->ville = $ville;
    }

    public function setDefaut($defaut){
        $this->defaut = $defaut;
    }

    public function setId_client($idClient){

        $this->id_client = $idClient;
    }

 
    public function getId_adresse(){
        return $this->id_adresse;
    }

  
    public function getIntitule(){
        return $this->intitule;
    }

    public function getLigne1(){
        return $this->ligne1;
    }

    public function getLigne2(){
        return $this->ligne2;
    }

    public function getCp(){
        return $this->cp;
    }

    public function getVille(){
        return $this->ville;
    }

    public function getDefaut(){
        return $this->defaut;
    }

    public function getId_client(){
        return $this->id_client;
    }


    private function hydrate($donnees){
        //var_dump($donnees);
        foreach($donnees as $key => $value){
            $methodName = 'set'.ucfirst($key);
            //echo $methodName;
    
            //tester si la methide existe
            if(method_exists($this,$methodName)){
                $this->$methodName($value);
            }
        }
    
    
    }
    

}

