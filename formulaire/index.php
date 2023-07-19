<!DOCTYPE html>
<html>
    <head>
        <title>Test formulaire</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
          $(document).ready(function(){
              $("#myForm").submit(function(e){
                  e.preventDefault(); 

                  var entreprise = $("#entreprise").val();
                  var name = $("#name").val();
                  var prenom = $("#prenom").val();
                  var fonction = $("#fonction").val();
                  var tel = $("#tel").val();
                  var email = $("#email").val();
                  var demande = $("#demande").val();
                  var description = $("#description").val();

                  if(entreprise === "" || name === "" || prenom === "" || tel === "" || email === "" || demande ==="" || !validateEmail(email) || !validatePhone(tel)) {
                      alert("Veuillez remplir tous les champs requis correctement.");
                  } else {
                    $.post("controller.php", {entreprise: entreprise, name: name, prenom: prenom, fonction: fonction, tel: tel, email: email, demande: demande, description: description}, function(data, status){

                          if(status === 'success') {
                              alert("Vos données ont été envoyées avec succès !");
                          } else {
                              alert("Une erreur s'est produite. Veuillez réessayer plus tard.");
                          }
                      });
                  }
              });

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
    <div class="form-container">
            <form id="myForm">
                <div id="header">
                    <img id="logo" src="tel.png" alt="Logo" />
                    <p id="header-text">03 28 76 55 90</p>
                </div>
                <div id ="header2">
                    <img id="logo2" src="mail.png" alt="Logo" />
                    <p id="header-text2">Un besoin, une demande ?</p>
                </div>
                <div class="form-field">
                    <input id="entreprise" type="text" name="entreprise" placeholder="Entreprise *"/>
                </div>
                <div class="form-field">
                    <input id="name" type="text" name="name" placeholder="Nom *"/>
                </div>
                <div class="form-field">
                    <input id="prenom" type="text" name="prenom" placeholder="Prénom *"/>
                </div>
                <div class="form-field">
                    <input id="fonction" type="text" name="fonction" placeholder="Fonction"/>
                </div>  
                <div class="form-field">
                    <input id="tel" type="text" name="tel" placeholder="Tel *"/>
                </div>
                <div class="form-field">
                    <input id="email" type="email" name="email" placeholder="Email *"/>
                </div>
                <div class="form-field">
                    <label class="field-label" for="demande">Votre demande concerne *:</label>
                    <select id="demande" name="demande">
                        <option value="fonction1">Fonction 1</option>
                        <option value="fonction2">Fonction 2</option>
                        <option value="fonction3">Fonction 3</option>
                    </select>
                </div>
                <div class="form-field">
                    <label class="field-label" for="description">Votre besoin (objectifs/date/lieu) * :</label> 
                    <textarea id="description" name="description" rows="4" cols="50"></textarea>
                </div>
                <div class="form-field">
                    <button type="submit">GO !</button>
                </div>
          </form>
      </div>
    </body>
</html>
