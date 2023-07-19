<?php
    // Vérifie qu'il provient d'une requête POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Identifiants MySQL
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "test_technique";
        
        // Récupère les données du formulaire
        $name = $_POST["name"]; 
        $prenom = $_POST["prenom"];
        $fonction = $_POST["fonction"] ?? NULL;  // Permet à la fonction d'être NULL
        $tel = $_POST["tel"];
        $email = $_POST["email"];
        $entreprise = $_POST["entreprise"];
        $demande = $_POST["demande"];
        $description = $_POST["description"];


        // Ouvre une nouvelle connexion au serveur MySQL
        $mysqli = new mysqli($host, $username, $password, $database);
        
        // Affiche toute erreur de connexion
        if ($mysqli->connect_error) {
            http_response_code(500);  // Renvoie une erreur HTTP 500
            echo 'Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error;
            exit();
        }
        
        $statement = $mysqli->prepare("INSERT INTO users (name, prenom, tel, entreprise, fonction, email, demande, description) VALUES(?, ?, ?, ?, ?, ?, ?, ?)"); 

        $statement->bind_param("ssssssss", $name, $prenom, $tel, $entreprise, $fonction, $email, $demande, $description); 
        
        if($statement->execute()){
            // Si l'insertion a réussi, envoie un e-mail
            $to = "cyprien.prouvot@gmail.com";
            $subject = "Nouvelle inscription";
            $message = "Un nouvel utilisateur s'est inscrit. Voici les informations fournies :\n\n" . 
            "Nom : " . $name . "\n" . 
            "Prénom : " . $prenom . "\n" .
            "Fonction : " . ($fonction ?? "Non fourni") . "\n" .
            "Téléphone : " . $tel . "\n" .
            "Entreprise : " . $entreprise . "\n" .
            "E-mail : " . $email;
            $headers = "de ". $email;
            
            mail($to, $subject, $message, $headers);

            http_response_code(200);  // Renvoie une réponse HTTP 200
            echo "http 200 ";
        } else {
            http_response_code(500);  // Renvoie une erreur HTTP 500
            echo $mysqli->error; 
        }
    } else {
        http_response_code(405);  // Renvoie une erreur HTTP 405 si la méthode n'est pas POST
        echo "Méthode non autorisée.";
    }
?>
