<?php 
require('Client.php');
require('Adresse.php');
require('Formulaire.php');
require('ClientManager.php');
require('AdresseManager.php');


$clientManager2= New ClientManager();
$adresseManager2= New AdresseManager();



//initialise les valeurs par défaut du formulaire Modifier une adresse
$adresseModif = new Adresse([
    'intitule'=>'',
    'ligne1'=>'',
    'ligne2'=>'',
    'cp'=>'',
    'ville'=>'',
    'defaut'=>'',
    'id_client'=>''
    ]);


if($_GET['affiche']== ''){
    //Redirection vers l'index
    header('location:index.php');
}


//tableau avec toutes les adresses d'un client
$adressesClient = $adresseManager2->readAllAdressesDuClient($_GET['affiche']);
$clientSelect=$clientManager2->read($_GET['affiche']);

//////////////////////////////////////////////////////
//Requete SQL  si clic sur le lien Supprimer une adresse du Client
if (isset ($_GET['delAdresse'])){

    $adressesup =  $adresseManager2->read($_GET['delAdresse']);
    //var_dump ($adressesup);
    
    $adresseManager2->del($adressesup);
    //Redirection vers la liste
    header("location:listeAdresses.php?affiche=".$_GET['affiche']);
}


///////////////////////////////////////////////////
//Requete SQL  si clic sur le lien Modifier
if (isset ($_GET['updateAdresse']) && is_int(intval($_GET['updateAdresse']))){

    $adresseModif =  $adresseManager2->read($_GET['updateAdresse']);
    //var_dump ($adresseModif);

    
    if(isset ($_POST['Modifier'])){
        
        $adresseModif->setIntitule ($_POST['intitule']) ;
        $adresseModif->setLigne1 ($_POST['ligne1']);
        $adresseModif->setLigne2($_POST['ligne2']);
        $adresseModif->setCp($_POST['cp']); 
        $adresseModif->setVille($_POST['ville']);   

        //var_dump($adresseModif);
        $adresseManager2->save($adresseModif);
        //Redirection vers l'index
        header("location:listeAdresses.php?affiche=".$_GET['affiche']);
    }   
} 

///////////////////////////////////////////////////
//Requete SQL  si clic sur le bouton ok pour définir adresse par defaut
if(isset ($_POST['ok'])){
    //boucle pour savoir si une adresse par defaut existe
    foreach ($adressesClient as $adresseClient){
        if ($adresseClient->getDefaut()== 1){
            $adresseDefautOld = $adresseClient;

            //var_dump($adresseDefautOld);
            //change la valeur du champs defaut pour le passer à 0
            $adresseDefautOld->setDefaut(0);
            $adresseManager2->save($adresseDefautOld);

        }
        
    }

    //echo $_POST['adresse_defaut'];
    //change la valeur de de defaut dans la BDD
    $adresseDefaut = $adresseManager2->read($_POST['adresse_defaut']);
    $adresseDefaut->setDefaut(1);
    //var_dump($adresseDefaut);

    $adresseManager2->save($adresseDefaut);
    //Redirection vers la liste
    header("location:listeAdresses.php?affiche=".$_GET['affiche']);

}


//Formulaire adresse
$formAdresse2 = new Formulaire('POST');
$formAdresse2->inputText('intitule',$adresseModif->getIntitule(),'required','Intitulé','intitule');
$formAdresse2->inputText('ligne1',$adresseModif->getLigne1(),'required','Adresse Ligne 1','ligne1Adresse');
$formAdresse2->inputText('ligne2',$adresseModif->getLigne2(),'','Adresse Ligne 2','ligne2Adresse');
$formAdresse2->inputText('cp',$adresseModif->getCp(),'required','Code Postal','cp');
$formAdresse2->inputText('ville',$adresseModif->getVille(),'required','Ville','ville');
$formAdresse2->inputSubmit('Modifier','Modifier');

//Forlumaire Adresse par defaut
$formAdresse3 = new Formulaire('POST');
$formAdresse3->select('adresse_defaut',adaptAdresseForSelect($adressesClient));
$formAdresse3->inputSubmit('ok','ok');


function afficheAdresses ($adresses){
    $html="<table class='tab'>
                <tr>
                    <th>Intitulé</th>
                    <th>Ligne1</th>
                    <th>Ligne2</th>
                    <th>Code Postal</th>
                    <th>Ville</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>";
    foreach ($adresses as $adresse){
        
            $html.="<tr>
            <td>".$adresse->getIntitule()."</td>
            <td>".$adresse->getLigne1()."</td>
            <td>".$adresse->getLigne2()."</td>
            <td>".$adresse->getCp()."</td>
            <td>".$adresse->getVille()."</td>
            <td><a href='?updateAdresse=".$adresse->getId_adresse()."&affiche=".$_GET['affiche']."'>Modifier l'adresse".$adresse->getId_adresse()."</a></td>
            <td><a href='?delAdresse=".$adresse->getId_adresse()."&affiche=".$_GET['affiche']."'>Supprimer  cette addresse". $adresse->getId_adresse()."</a></td>
        </tr>"; 
   
    }
    $html .="</table><br/>";
    return $html;

}

//******************************************** */
//Fct qui adapte les objets adresses pour notre select
function adaptAdresseForSelect($adresses){
    $allAdresses=[];
    foreach($adresses as $key => $adresse){
        $tag = $adresse->getDefaut();
        //echo $tag;
        if ($tag == 0){
             $allAdresses[$adresse->getId_adresse()]= $adresse->getIntitule();
        }      
    }   
    return $allAdresses;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Liste des adresses de <?php echo $clientSelect->getNom(); ?></h2>
        <?php
       //affiche les adresses du client
        echo afficheAdresses ($adressesClient);

        ?> 
    <h2><a href="index.php">Ajouter une adresse</a></h2>  
    <h2>Modifier une adresse</h2>
        <?php
            //affiche formulaire de saisie pour modifier une adresse
            $formAdresse2->render();
         
        ?>

    <h2>Choisir une adresse par défaut pour <?php echo $clientSelect->getNom(); ?></h2>
        <?php
            //affiche formulaire de saisie pour choisir une adresse par défaut
            $formAdresse3->render();
         
        ?>


    <h2><a href="index.php">Retour vers la liste des clients</a></h2>   


</body>
</html>