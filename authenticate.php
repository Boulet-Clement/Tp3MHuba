<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    session_start();
    require('bdd.php'); /* Fichier contenant nos identifiants à la base de données */

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
            print_r($result_login);
            print_r($result_login['login']);
            print_r($result_login['password']);
        }
        
        /*if($result_login!=null){
            $verif_password=$pdo->prepare("SELECT * FROM users WHERE login=:user AND password=:pwd");
            $verif_password->bindParam(":user",$login);
            $verif_password->bindParam(":pwd",$password);
            $verif_password->execute();
            $result_password = $verif_password->fetch();
            if($result_password!=null){ 
                $_SESSION['login']=$result_password['login'];
                header('Location: welcome.php');
            }else{
                $_SESSION['message']="Mot de passe incorrect";
                header('Location: signin.php');
            }
        }else{
            $_SESSION['message']="Login incorrect";
            header('Location: signin.php');
        }*/
    }else{
        /* On redirige vers signin.php si il manque un paramètre */
        header('Location: signin.php');
    }
}else{
    /* On redirige vers signin.php si ce n'est pas la méthode POST */
    header('Location: signin.php');
}
?>
