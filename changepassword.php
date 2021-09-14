<?php
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require('bdd.php'); /* Fichier contenant nos identifiants à la base de données */

    if ( isset($_POST['password']) && isset($_POST['confirm_password']) && $_POST['password']!=="" && $_POST['confirm_password']!=="" )
    {
        try{
            $pdo = new PDO("mysql:host=".HOST.";dbname=".DBNAME, USERNAME, PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            $_SESSION['message']="Une erreur est survenue lors de la connexion à la base de données";
            /* ERREUR, on redirige vers le formulaire */
            header('Location: formpassword.php');
        }
        

        $login = htmlentities($_SESSION['login']);
        if ($_POST['password'] === $_POST['confirm_password']){
            $password = password_hash(htmlentities($_POST['password']), PASSWORD_DEFAULT);

            
            $change_password = $pdo->prepare("UPDATE users set password=:password WHERE login=:login");
            $change_password->bindParam(':login', $login);
            $change_password->bindParam(':password', $password);
            
            try{
                $change_password->execute();
            }catch(PDOException $e){
                $_SESSION['message']="Une erreur est survenue lors du changement de votre mot de passe";
                /* ERREUR, on redirige vers le formulaire */
                header('Location: formpassword.php');
            }

            $_SESSION['message']=""; // On vide les messages
            // Succès, on redirige vers la page de bienvenue
            header('Location: welcome.php');             
            
        }else{
            $_SESSION['message']="You entered two different passwords";
            // ERREUR, On redirige vers le formulaire si les mots de passe sont différents
            header('Location: formpassword.php');
        }
        
    }else{
        $_SESSION['message']="Please complete both fields";
        // ERREUR, On redirige vers le formulaire si il manque un paramètre
        header('Location: formpassword.php');
    }
}else{
    /* ERREUR, On redirige vers signin.php si ce n'est pas la méthode POST ou que l'utilisateur n'est pas connecté*/
    header('Location: signin.php');
}
?>
