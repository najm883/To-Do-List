function envoie(){
    const email = document.getElementById('mail');
    const pass = document.getElementById('pass');
    const situation = document.getElementById('situation');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

         if(email.value == ''){
             alert('Veuillez entrer votre adresse mail !')
          }

         else if(pass.value == ''){
            alert('Veuillez entrer votre mot de passe !')
           }
         else if(situation.value == ''){
            alert('Veuillez choisir votre situation ! ')
           }
             else if (!emailRegex.test(mail.value.trim())) {
            alert("Adresse mail invalide !");
           }

}