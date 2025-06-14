// Affichage dynamique de la date/heure
document.addEventListener("DOMContentLoaded", function () {
  const now = new Date();
  const horloge = document.getElementById("horloge");

  if (horloge) {
    horloge.textContent = "📅 " + now.toLocaleDateString("fr-FR") + " | ⏰ " + now.toLocaleTimeString("fr-FR");
  }

  // Alerte de bienvenue
  setTimeout(() => {
    alert("Bienvenue dans votre tableau de bord, stagiaire !");
  }, 1000);
});
