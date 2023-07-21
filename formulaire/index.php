<!DOCTYPE html>
<html>
    <head>
        <title>Test formulaire</title>  <!-- Définit le titre de la page -->
        <meta charset="utf-8">  <!-- Définit l'encodage des caractères de la page -->
        <link rel="stylesheet" href="style.css">  <!-- Lie la page à une feuille de style CSS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  <!-- Importe la bibliothèque jQuery -->
        <script type="text/javascript">
          $(document).ready(function(){  // Lorsque le document est prêt,
              $("#myForm").submit(function(e){  // lorsque le formulaire est soumis,
                  e.preventDefault();  // empêche le comportement de soumission par défaut.

                  // Récupère les valeurs des champs du formulaire.
                  var entreprise = $("#entreprise").val();
                  var name = $("#name").val();
                  var prenom = $("#prenom").val();
                  var fonction = $("#fonction").val();
                  var tel = $("#tel").val();
                  var email = $("#email").val();
                  var demande = $("#demande").val();
                  var description = $("#description").val();

                  // Vérifie que tous les champs requis sont remplis et que l'email et le téléphone sont valides.
                  if(entreprise === "" || name === "" || prenom === "" || tel === "" || email === "" || demande ==="" || !validateEmail(email) || !validatePhone(tel)) {
                      // Si ce n'est pas le cas, affiche une alerte.
                      alert("Veuillez remplir tous les champs requis correctement.");
                  } else {
                    // Sinon, envoie les données à un script PHP à l'aide d'une requête AJAX.
                    $.post("controller.php", {entreprise: entreprise, name: name, prenom: prenom, fonction: fonction, tel: tel, email: email, demande: demande, description: description}, function(data, status){
                          if(status === 'success') {
                              // Si la requête a réussi, affiche une alerte.
                              alert("Vos données ont été envoyées avec succès !");
                          } else {
                              // Sinon, affiche une alerte d'erreur.
                              alert("Une erreur s'est produite. Veuillez réessayer plus tard.");
                          }
                      });
                  }
              });

              // Fonctions de validation pour l'email et le téléphone.
              function validateEmail(email) {
                  var re = /\S+@\S+\.\S+/;
                  return re.test(email);
              }

              function validatePhone(tel) {
                  var re = /^\d{10}$/;
                  return re.test(tel);
              }
          });
        </script>
    </head>
    <body>
        <div class="form-container">  <!-- Container pour le formulaire -->
            <form id="myForm">  <!-- Le formulaire lui-même -->
                <!-- Divers champs de formulaire pour recueillir différentes informations de l'utilisateur -->
                <div id="header">
                    <img id="logo" src="tel.png" alt="Logo" />
                    <p id="header-text">03 28 76 55 90</p>
                </div>
                <!-- ... -->
                <div class="form-field">
                    <button type="submit">GO !</button>  <!-- Bouton pour soumettre le formulaire -->
                </div>
          </form>
      </div>
    </body>
</html>
