<?php

session_start();

$message = '';

$type = '';
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Connexion à la base de données

    $conn = new mysqli("localhost", "root", "", "gestion_projets");

    if ($conn->connect_error) {

        die("Échec de connexion : " . $conn->connect_error);

    }
 
    // Récupération et sécurisation des données du formulaire

    $mail = trim($_POST["mail"]);

    $pass = $_POST["pass"];

    $role = $_POST["situation"];
 
    // Vérification des champs vides

    if (empty($mail) || empty($pass) || empty($role)) {

        $message = "Veuillez remplir tous les champs.";

        $type = "danger";

    } else {

        // Préparer et exécuter la requête

        $stmt = $conn->prepare("SELECT id, nom, pass, situation FROM utilisateurs WHERE mail = ?");

        $stmt->bind_param("s", $mail);

        $stmt->execute();

        $result = $stmt->get_result();
 
        // Vérification des résultats

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();
 
            // Vérifier le mot de passe

            if (password_verify($pass, $user["pass"])) {

                // Vérifier le rôle (situation)

                if ($user["situation"] == $role) {

                    $_SESSION["user_id"] = $user["id"];

                    $_SESSION["nom"] = $user["nom"];

                    $_SESSION["situation"] = $user["situation"];
 
                    // Redirection en fonction de la situation

                    switch ($user["situation"]) {

                        case "1":

                            header("Location: dashboard_etudiant.php");

                            exit;

                        case "2":

                            header("Location: dashboard_employe.php");

                            exit;

                        case "3":

                            header("Location: dashboard_stagiaire.php");

                            exit;

                        default:

                            $message = "Situation inconnue.";

                            $type = "danger";

                    }

                } else {

                    $message = "Votre rôle sélectionné ne correspond pas à votre compte.";

                    $type = "danger";

                }

            } else {

                $message = "Mot de passe incorrect.";

                $type = "danger";

            }

        } else {

            $message = "Adresse email introuvable.";

            $type = "danger";

        }
 
        $stmt->close();

    }
 
    $conn->close();

}

?>
 
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Connexion</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>
 
<section class="wrapper">
<div class="container">
<div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 text-center">
 
<form class="rounded bg-white shadow p-5" method="POST" action="index.php">
 
<?php if (!empty($message)) : ?>
<div class="alert alert-<?= $type ?> alert-dismissible fade show" role="alert">
<?= htmlspecialchars($message) ?>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
</div>
<?php endif; ?>
 
<h3 class="text-dark fw-bolder fs-4 mb-4">CONNEXION</h3>
 
<div class="mb-3">
<label for="mail" class="form-label">Adresse email</label>
<input type="email" class="form-control" id="mail" name="mail" required>
</div>
 
<div class="mb-3">
<label for="pass" class="form-label">Mot de passe</label>
<input type="password" class="form-control" id="pass" name="pass" required>
</div>
 
<div class="mb-3">
<label for="situation" class="form-label">Votre situation</label>
<select class="form-select" id="situation" name="situation" required>
<option value="">Sélectionnez votre situation</option>
<option value="1">Étudiant</option>
<option value="2">Encadrant</option>
<option value="3">Stagiaire</option>
</select>
</div>
 
<button type="submit" class="btn btn-primary w-100">Se connecter</button>
 
<div class="mt-3">
<a href="register.php" class="text-decoration-none">Créer un nouveau compte</a>
</div>
 
</form>
 
</div>
</div>
</section>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="scriptlogin.js"></script>
</body>
</html>

 