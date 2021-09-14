<?php
	session_start();

    // Si la requête arrive avec un autre type que GET
	// ou que le client n'est pas considéré comme connecté,
    // renvoi vers le formulaire de connexion

	// sinon, on affiche la page de bienvenue

    if(($_SERVER['REQUEST_METHOD'] == 'GET')&& isset($_SESSION['login'])){
        /* Afficher le formulaire */
        /* cela ne me semble pas très propre de laisser ceci vide, à modifier après */
    }else{
        /* Renvoie vers le formulaire de connexion */ 
        header('Location: signin.php');
    }	
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>My account</title>
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

        <!-- Compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    </head>
    <?php include('header.php') ?>
    <body>
        <div class="container">
            <h1><?php echo 'Hello '. $_SESSION['login'].' !<br/>'; ?></h1>
            <p>Welcome on your account.</p>
        </div>
        
    </body>
</html>
