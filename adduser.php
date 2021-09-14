<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    session_start();
    require('bdd.php'); /* Fichier contenant nos identifiants à la base de données */

    if ( isset($_POST['login']) && isset($_POST['password']) && isset($_POST['confirm_password']) )
    {
        try{
            $pdo = new PDO("mysql:host=".HOST.";dbname=".DBNAME, USERNAME, PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            $_SESSION['message']="Une erreur est survenue lors de la création de votre compte";
            /* ERREUR, on redirige vers signup */
            header('Location: signun.php');
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
                    $tentative_inscription->execute();

                    $_SESSION['message']="Votre compte à bien été enregistré"; // Ici j'aimerais que le message s'affiche en vert
                    // Tout est bon, on redirige vers la page de connexion
                    header('Location: signin.php');             

            }else{
                $_SESSION['message']="This login already exist"; //Verifier l'orthographe
                // ERREUR, On redirige si le login est déjà prit
                header('Location: signup.php');
        }

        }else{
            $_SESSION['message']="You entered two different passwords";
            // ERREUR, On redirige si les mot de passes sont différents
            header('Location: signup.php');
        }
        
    }else{
        // ERREUR, On redirige vers signin.php si il manque un paramètre
        header('Location: signin.php');
    }
}else{
    /* ERREUR, On redirige vers signin.php si ce n'est pas la méthode POST */
    header('Location: signin.php');
}
?>
