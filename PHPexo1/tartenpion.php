<?php 
require('Client.php');
require('Adresse.php');
require('Formulaire.php');
require('ClientManager.php');
require('AdresseManager.php');



//initialise les valeurs par défaut du formulaire Ajouter
$clientModif = new Client([
    'nom'=>'',
    'prenom'=>'',
    'tel'=>'',
    'email'=>''
    ]);

    //var_dump ($clientModif);
    //echo $clientModif->getNom();

//initialise le texte sur les btns
$txtBtn="Ajouter";
$BtnAdresse="AjouterAdresse";



$clientManager= New ClientManager();
$adresseManager= New AdresseManager();



//prepare un tableau avec tous mes objets clients
$allPerso = $clientManager->readAll();
//var_dump($allPerso);




///////////////////////////////////////////////////////////////////////
//si btn fomulaire ajout est cliqué , création d'une instance de la classe Client
if(isset ($_POST['Ajouter'])){
   // var_dump($_POST);
   
    $monClient = new Client([
        'nom'=>$_POST['nom'],
        'prenom'=>$_POST['prenom'],
        'tel'=>$_POST['tel'],
        'email'=>$_POST['email']
        ]);
    
    //var_dump($monClient);
      $clientManager->save($monClient);
    //Redirection vers l'index
    header('location:index.php');
 }

//////////////////////////////////////////////////////
//Requete SQL  si clic sur le lien Supprimer un Client
if (isset ($_GET['del'])){
    $clientsup =  $clientManager->read($_GET['del']);
    // var_dump ($clientsup);
    
    $clientManager->del($clientsup);
    //Redirection vers l'index
    header('location:index.php');
}


///////////////////////////////////////////////////
//Requete SQL  si clic sur le lien Modifier
if (isset ($_GET['update']) && is_int(intval($_GET['update']))){

    // Change  le btn  Ajouter en Modifier
    $txtBtn="Modifier";

    $clientModif =  $clientManager->read($_GET['update']);
    //var_dump ($clientModif);

    
    if(isset ($_POST['Modifier'])){
        //echo 'soumissionmodif';
        
        $clientModif->setNom ($_POST['nom']) ;
        $clientModif->setPrenom ($_POST['prenom']);
        $clientModif->setTel($_POST['tel']);
        $clientModif->setEmail($_POST['email']);   

        //var_dump($clientModif);
        $clientManager->save($clientModif);
        //Redirection vers l'index
        header('location:index.php');
    }   
}  


///////////////////////////////////////////////////
//Requete SQL  si clic sur le lien Ajouter Adresse

if(isset ($_POST['AjouterAdresse'])){
    

    $id_client=$_POST['client'];
  
    // var_dump($_POST);
     $adresseClient = new Adresse([
         'intitule'=>$_POST['intitule'],
         'ligne1'=>$_POST['ligne1'],
         'ligne2'=>$_POST['ligne2'],
         'cp'=>$_POST['cp'],
         'ville'=>$_POST['ville'],
         'defaut'=>0,
         'id_client'=> $_POST['client']
         ]);
     
     //var_dump($adresseClient);
       $adresseManager->save($adresseClient);

    //Redirection vers l'index
    header('location:index.php');
  }

  
//////////////////////////////////////////////////////
//Requete SQL  si clic sur le lien Afficher la liste des adresses clients
if (isset ($_GET['affiche'])){
    $clientSelect =  $clientManager->read($_GET['affiche']);
    //$adresseManager2= New AdresseManager();
    
    //tableau avec mes objets Adresses par client
    $allAdressesByClient = $adresseManager->readAllAdressesDuClient($_GET['affiche']);
    //var_dump($allAdressesByClient);  

}

////////////////////////////////////////////////////////
//Formulaire pour ajouter des clients
$formClient = new Formulaire('POST');
$formClient->inputText('nom',$clientModif->getNom(),'required','Nom','nomClient');
$formClient->inputText('prenom',$clientModif->getPrenom(),'required','Prénom','prenomClient');
$formClient->inputText('email',$clientModif->getEmail(),'required','Email','emailClient');
$formClient->inputTel('tel',$clientModif->getTel(),'Téléphone','tel','required');

$formClient->inputSubmit($txtBtn,$txtBtn);



//Formulaire adresse
$formAdresse = new Formulaire('POST');
$formAdresse->select('client',adaptPersonnageForSelect($allPerso));
// $formAdresse->select('intitule',['Bd'=>'Bd','Rue'=>'Rue','Avenue'=>'Avenue']);
$formAdresse->inputText('intitule','','required','Intitulé','intitule');
$formAdresse->inputText('ligne1','','required','Adresse Ligne 1','ligne1Adresse');
$formAdresse->inputText('ligne2','','','Adresse Ligne 2','ligne2Adresse');
$formAdresse->inputText('cp','','required','Code Postal','cp');
$formAdresse->inputText('ville','','required','Ville','ville');
$formAdresse->inputSubmit($BtnAdresse,$BtnAdresse);



//******************************************** */
//Fct qui adapte les objets clients pour notre select
function adaptPersonnageForSelect($clients){
    $listeNomsClients=[];
    foreach($clients as $key => $client){
        $listeNomsClients[$client->getId()]= $client->getNom();
    }
    //var_dump($perso);
    return $listeNomsClients;
}


//*************************
function afficheClients ($clients){
    $html="<table class='tab'>
                <tr>
                    
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Tel</th>
                    <th>Email</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                    <th>Liste Adresses</th>
                </tr>";
    foreach ($clients as $client){
        
            $html.="<tr>
            <td>".$client->getNom()."</td>
            <td>".$client->getPrenom()."</td>
            <td>0".$client->getTel()."</td>
            <td>".$client->getEmail()."</td>
            <td><a href='?update=".$client->getId()."'>Modifier le client".$client->getId()."</a></td>
            <td><a href='?del=".$client->getId()."'>Supprimer ". $client->getNom()."</a></td>
            <td><a href='listeAdresses.php?affiche=".$client->getId()."'>Affiche adresses ". $client->getNom()."</a></td>
        </tr>"; 
   
    }
    $html .="</table><br/>";
    return $html;

}

function afficheAdresses ($adresses){
    $html="<table border=1>
                <tr>
                    <td>Intitulé</td>
                    <td>Ligne1</td>
                    <td>Ligne2</td>
                    <td>Code Postal</td>
                    <td>Ville</td>
                    <td>Définir par défaut</td>
                    <td>Modifier</td>
                    <td>Supprimer</td>
                </tr>";
    foreach ($adresses as $adresse){
        
            $html.="<tr>
            <td>".$adresse->getIntitule()."</td>
            <td>".$adresse->getLigne1()."</td>
            <td>".$adresse->getLigne2()."</td>
            <td>".$adresse->getCp()."</td>
            <td>".$adresse->getVille()."</td>
            <td>Définir cette adresse par défaut</td>
            <td><a href='?updateAdresse=".$adresse->getId_adresse()."'>Modifier l'adresse".$adresse->getId_adresse()."</a></td>
            <td><a href='?delAdresse=".$adresse->getId_adresse()."'>Supprimer  cette addresse". $adresse->getId_adresse()."</a></td>
        </tr>"; 
   
    }
    $html .="</table><br/>";
    return $html;

}
?>
