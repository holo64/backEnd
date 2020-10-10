<?php
include ('tartenpion.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Ajouter un client</h2>
        <?php
            //affiche formulaire de saisie pour l'ajout de Client
            $formClient->render();

            //affiche les clients créés
            echo afficheClients($allPerso);

            
        ?>
    <h2>Ajouter une Adresse à un client</h2>
    
    <?php
        //affiche formulaire de saisie pour l'ajout des adresses
        $formAdresse->render();


    ?>

    <!-- <h2>Liste des Adresses pour un client</h2>
    <?php
    //affiche les adresses du client
    echo afficheAdresses($allAdressesByClient);
    ?>         -->

</body>
</html>