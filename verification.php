<?php
session_start();
if(isset($_POST['username']) && isset($_POST['password']))
{
    // connexion à la base de données
    
    $db_username = 'barth';
    $db_password = 'test';
    $db_name     = 'XxXtestXxX';
    $db_host     = 'localhost';
    $db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
           or die('could not connect to database');
    
    
    //$db = new mysqli("localhost", "root", "", "base_de_certification_flt");
    
    // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
    // pour éliminer toute attaque de type injection SQL et XSS
    $username = mysqli_real_escape_string($db,htmlspecialchars($_POST['username'])); 
    $password = mysqli_real_escape_string($db,htmlspecialchars($_POST['password']));
    
    if($username !== "" && $password !== "")
    {
        $requete = "SELECT count(*) FROM login where 
              nom_utilisateur = '".$username."' and mot_de_passe = '".$password."' ";
        $exec_requete = mysqli_query($db,$requete);
        $reponse      = mysqli_fetch_array($exec_requete);
        $count = $reponse['count(*)'];
        if($count!=0) // nom d'utilisateur et mot de passe correctes
        {
           $_SESSION['username'] = $username;
           header('Location: index.html');
        }
        else
        {
           header('Location: login.html'); // utilisateur ou mot de passe incorrect
        }
    }
    else
    {
       header('Location: login.html php?erreur=2'); // utilisateur ou mot de passe vide
    }
}
else
{
   header('Location: login.html');
}
mysqli_close($db); // fermer la connexion
?>