<?php
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require('bdd.php'); /* Fichier contenant nos identifiants à la base de données */

    if ( isset($_POST['login']) && isset($_POST['password']) && isset($_POST['confirm_password']) )
    {
        try{
            $pdo = new PDO("mysql:host=".HOST.";dbname=".DBNAME, USERNAME, PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            $_SESSION['message']="Une erreur est survenue lors de la connexion à la base de données";
            /* ERREUR, on redirige vers signup */
            header('Location: signup.php');
        }
        

        $login = htmlentities($_POST['login']);
        if ($_POST['password'] === $_POST['confirm_password']){
            $password = password_hash(htmlentities($_POST['password']), PASSWORD_DEFAULT);

            /* On vérifie si le login n'est pas déjà utilisé */
            $verif_login=$pdo->prepare("SELECT * FROM users WHERE login=:user");
            $verif_login->bindParam(":user",$login);
            $verif_login->execute();
            $result_login = $verif_login->fetch();
            if($result_login==null){

                    $tentative_inscription = $pdo->prepare("INSERT INTO users (login, password) VALUES (:login, :password)");
                    $tentative_inscription->bindParam(':login', $login);
                    $tentative_inscription->bindParam(':password', $password);

                    try{
                        $tentative_inscription->execute();
                    }catch(PDOException $e){
                        $_SESSION['message']="Une erreur est survenue lors de la création de votre compte";
                        // ERREUR, on redirige vers la page d'inscription
                        header('Location: signup.php');
                    }

                    $_SESSION['message']=""; // On vide les messages
                    // Succès, on redirige vers la page de connexion
                    header('Location: signin.php');             

            }else{
                $_SESSION['message']="This login already exist"; //Verifier l'orthographe
                // ERREUR, On redirige si le login est déjà utilisé
                header('Location: signup.php');
        }

        }else{
            $_SESSION['message']="You entered two different passwords";
            // ERREUR, On redirige si les mot de passes sont différents
            header('Location: signup.php');
        }
        
    }else{
        // ERREUR, On redirige vers signup.php si il manque un paramètre
        header('Location: signup.php');
    }
}else{
    /* ERREUR, On redirige vers index.php si ce n'est pas la méthode POST */
    header('Location: index.php');
}
?>
