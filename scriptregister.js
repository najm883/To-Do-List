function inscrit(){
    const nom = document.getElementById("nom");
    const prenom = document.getElementById("prenom");
    const mail = document.getElementById("mail");
    const pass = document.getElementById("pass");
    const pass1 = document.getElementById("pass1");
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const selecti = document.getElementById("floatingSelect");





    if(nom.value == ''){
        alert("Veuillez entrer votre nom! ");
    }
     else if(prenom.value == ''){
        alert("Veuillez entrer votre prenom! ");
    }
      else if(mail.value == ''){
        alert("Veuillez entrer votre adresse mail! ");
    }
      else if(pass.value == ''){
        alert("Veuillez entrer votre mot de passe! ");
    }
      else if(pass1.value == ''){
        alert("Mot de passe non confirmé! ");
    }
       else if (!emailRegex.test(mail.value.trim())) {
        alert("Adresse mail invalide !");
     }
    else if(pass.value.length < 8){
        alert("Le mot de passe doit contenir 8 caractéres !")
    }
       else if(pass.value !== pass1.value){
        alert("Le mots de passe identiques")
    }
       else if(selecti.value == ''){
        alert("Choisir la situation ")
       }
    
}