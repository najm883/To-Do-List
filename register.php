<?php

$message = '';

$type = '';
 
// Connexion à la BDD

try {

    $pdo = new PDO("mysql:host=localhost;dbname=gestion_projets;charset=utf8", "root", "");

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Erreur de connexion à la base de données : " . $e->getMessage());

}
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = trim($_POST["nom"]);

    $prenom = trim($_POST["prenom"]);

    $mail = trim($_POST["mail"]);

    $pass = $_POST["pass"];

    $pass1 = $_POST["pass1"];

    $situation = $_POST["situation"]; // On renomme pour rester cohérent
 
    // Vérifications basiques

    if (empty($nom) || empty($prenom) || empty($mail) || empty($pass) || empty($pass1) || empty($situation)) {

        $message = "Veuillez remplir tous les champs.";

        $type = "danger";

    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {

        $message = "Adresse email invalide.";

        $type = "danger";

    } elseif ($pass !== $pass1) {

        $message = "Les mots de passe ne correspondent pas.";

        $type = "warning";

    } else {

        try {

            // Vérifier si l'email existe déjà

            $stmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateurs WHERE mail = ?");

            $stmt->execute([$mail]);

            $count = $stmt->fetchColumn();
 
            if ($count > 0) {

                $message = "Cet email est déjà utilisé.";

                $type = "danger";

            } else {

                $passHash = password_hash($pass, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, mail, pass, situation) VALUES (?, ?, ?, ?, ?)");

                $stmt->execute([$nom, $prenom, $mail, $passHash, $situation]);
 
                $message = "Inscription réussie ! Vous pouvez maintenant vous connecter.";

                $type = "success";

            }

        } catch (PDOException $e) {

            $message = "Erreur lors de l'inscription : " . $e->getMessage();

            $type = "danger";

        }

    }

}

?>
 
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Inscription</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="styleregister.css">
</head>
<body>
 
<section class="wrapper">
<div class="container">
<div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 text-center" id="cont">
<form class="rounded bg-white shadow p-4" method="POST">
<?php if (!empty($message)) : ?>
<div class="alert alert-<?= $type ?> alert-dismissible fade show" role="alert">
<?= htmlspecialchars($message) ?>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>
 
                <h3 class="text-dark fw-bolder fs-4 mb-4">INSCRIPTION</h3>
 
                <div class="form-floating mb-3">
<input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" required>
<label for="nom">Nom</label>
</div>
 
                <div class="form-floating mb-3">
<input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" required>
<label for="prenom">Prénom</label>
</div>
 
                <div class="form-floating mb-3">
<input type="email" class="form-control" id="mail" name="mail" placeholder="Adresse email" required>
<label for="mail">Adresse email</label>
</div>
 
                <div class="form-floating mb-3">
<input type="password" class="form-control" id="pass" name="pass" placeholder="Mot de passe" required>
<label for="pass">Mot de passe</label>
</div>
 
                <div class="form-floating mb-3">
<input type="password" class="form-control" id="pass1" name="pass1" placeholder="Confirmation du mot de passe" required>
<label for="pass1">Confirmer le mot de passe</label>
</div>
 
                <div class="form-floating mb-3">
<select class="form-select" id="situation" name="situation" required>
<option value="">Sélectionnez votre situation</option>
<option value="1">Étudiant</option>
<option value="2">Encadrant</option>
<option value="3">Stagiaire</option>
</select>
<label for="situation">Votre situation</label>
</div>
 
                <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
</form>
</div>
</div>
</section>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

 