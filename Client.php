<?php
/*
 *Classe Client
 *Permet de créer un client
 */

class Client {
    /**
     * @var integer id client
     */
    private $id = 0;
    /**
     * @var string nom du client
     */
    private $nom = '';
    /**
     * @var string prénom du client
     */
    private $prenom = '';
    /**
     * @var integer téléphone
     */
    private $tel = 0;
    /**
     * @var string Email
     */
    private $email= '';



    public function __construct($data=[]){
        $this->hydrate($data);
    
    }


    public function setId($id){
        $id =intval($id);
        if($id>0 && $this->id === 0){
            $this->id = $id;
        }
    }


    public function setNom($nom){
       if(is_string($nom)){
           if(mb_strlen($nom) > 50){
           $nom = substr ($nom,0,50);
           }
       }
       else{
        $nom ='';
       }
       $this->nom = $nom;
    }

    
    public function setPrenom($prenom){
        if(is_string($prenom)){
            if(mb_strlen($prenom) > 50){
            $prenom = substr ($prenom,0,50);
            }
        }
        else{
         $prenom ='';
        }
        $this->prenom = $prenom;
    }

         
    public function setTel($tel){
        // if (preg_match('#(^0)+([0-9]{9})$#', $tel)) {         
        // }
        if (mb_strlen($tel) > 10){
            $tel = substr ($tel,0,10);
        }
            
         $this->tel = $tel;
    }

    public function setEmail($email){
        if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
           $email='';
        }

        $this->email = $email;
    }


    
    public function getId(){
        return $this->id;
    }

  
    public function getNom(){
        return $this->nom;
    }

    public function getPrenom(){
        return $this->prenom;
    }

    public function getTel(){
        return $this->tel;
    }

    public function getEmail(){
        return $this->email;
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

