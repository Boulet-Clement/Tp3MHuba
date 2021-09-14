<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    session_start();
    require('bdd.php'); // Fichier contenant nos identifiants à la base de données 

    if ( isset($_POST['login']) && isset($_POST['password']) )
    {
        $login = htmlentities($_POST['login']);
        $password = htmlentities($_POST['password']);

        try{
            $pdo = new PDO("mysql:host=".HOST.";dbname=".DBNAME, USERNAME, PASSWORD);
        }catch(PDOException $e){
            print "Erreur :" . $e->getMessage(). "<br/>";
        }

        $verif_login=$pdo->prepare("SELECT * FROM users WHERE login=:user");
        $verif_login->bindParam(":user",$login);
        $verif_login->execute();
        $result_login = $verif_login->fetch();
        if($verif_login!=null){
            if(password_verify($password,$result_login['password'])){
                $_SESSION['login']=$result_login['login'];
                // Succès, redirection vers la page d'accueil
                header('Location: welcome.php');
            }else{
                // Erreur, mot de passe incorrect
                $_SESSION['message']="Incorrect password";
                header('Location: signin.php');
            }
        }else{
            // Erreur, Login incorrect
            $_SESSION['message']="Incorrect login";
            header('Location: signin.php');
        }
    }else{
        // Erreur, on redirige vers signin.php si il manque un paramètre
        header('Location: signin.php');
    }
}else{
    // Erreur, on redirige vers signin.php si ce n'est pas la méthode POST
    header('Location: signin.php');
}
?>
