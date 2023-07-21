<?php
    // Vérifie que la requête provient d'une méthode POST.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Définit les identifiants pour la base de données MySQL.
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "test_technique";
        
        // Récupère les données soumises par le formulaire.
        $name = $_POST["name"]; 
        $prenom = $_POST["prenom"];
        $fonction = $_POST["fonction"] ?? NULL;  // La fonction peut être NULL si non renseignée.
        $tel = $_POST["tel"];
        $email = $_POST["email"];
        $entreprise = $_POST["entreprise"];
        $demande = $_POST["demande"];
        $description = $_POST["description"];


        // Tente d'ouvrir une nouvelle connexion au serveur MySQL.
        $mysqli = new mysqli($host, $username, $password, $database);
        
        // En cas d'erreur de connexion, affiche un message d'erreur.
        if ($mysqli->connect_error) {
            http_response_code(500);  // Envoie une réponse HTTP 500 pour signaler l'erreur.
            echo 'Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error;
            exit();
        }
        
        // Prépare une déclaration SQL pour insérer les données dans la base.
        $statement = $mysqli->prepare("INSERT INTO users (name, prenom, tel, entreprise, fonction, email, demande, description) VALUES(?, ?, ?, ?, ?, ?, ?, ?)"); 

        // Lie les paramètres à la déclaration SQL.
        $statement->bind_param("ssssssss", $name, $prenom, $tel, $entreprise, $fonction, $email, $demande, $description); 
        
        // Tente d'exécuter la déclaration SQL.
        if($statement->execute()){
            // Si l'insertion des données a réussi, envoie un e-mail pour notifier de la nouvelle inscription.
            $to = "cyprien.prouvot@gmail.com";
            $subject = "Nouvelle inscription";
            $message = "Un nouvel utilisateur s'est inscrit. Voici les informations fournies :\n\n" . 
                        "Nom : " . $name . "\n" . 
                        "Prénom : " . $prenom . "\n" .
                        "Fonction : " . ($fonction ?? "Non fourni") . "\n" .
                        "Téléphone : " . $tel . "\n" .
                        "Entreprise : " . $entreprise . "\n" .
                        "E-mail : " . $email . "\n" .
                        "Demande : " . $demande . "\n" .  
                        "Description : " . $description;
            $headers = "de ". $email;
            
            // Envoie l'e-mail.
            mail($to, $subject, $message, $headers);

            // Envoie une réponse HTTP 200 pour signaler le succès de l'opération.
            http_response_code(200);  
            echo "http 200 ";
        } else {
            // En cas d'erreur, envoie une réponse HTTP 500 et affiche le message d'erreur.
            http_response_code(500);  
            echo $mysqli->error; 
        }
    } else {
        // Si la requête ne provient pas d'une méthode POST, envoie une erreur HTTP 405.
        http_response_code(405);  
        echo "Méthode non autorisée.";
    }
?>
