<?php
session_start();
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_SESSION['login'])){
    require('bdd.php'); /* Fichier contenant nos identifiants à la base de données */

    try{
        $pdo = new PDO("mysql:host=".HOST.";dbname=".DBNAME, USERNAME, PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        $_SESSION['message']="Une erreur est survenue lors de la connexion à la base de données";
        /* ERREUR, on redirige vers le formulaire */
        header('Location: welcome.php');
    }
        

    $login = htmlentities($_SESSION['login']);


    $delete_user = $pdo->prepare("DELETE FROM users WHERE login=:login");
    $delete_user->bindParam(':login', $login);
            
    try{
        $delete_user->execute();
    }catch(PDOException $e){
        $_SESSION['message']="Une erreur est survenue lors de la suppression de votre compte";
        // ERREUR, on redirige vers la page de bienvenue
        header('Location: welcome.php');
    }

    session_destroy();
    // Succès, on redirige vers la page de connexion
    header('Location: signin.php');             
            
}else{
    // ERREUR, ce n'est pas la méthode GET ou, l'utilisateur n'est pas connecté
    header('Location: welcome.php');
}
?>
