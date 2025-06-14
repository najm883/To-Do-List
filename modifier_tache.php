<?php
// modifier_tache.php

session_start();
$conn = new mysqli("localhost", "root", "", "gestion_projets");

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Vérifier que l'ID de la tâche est présent dans l'URL
if (!isset($_GET['id'])) {
    die("ID de tâche manquant.");
}

$tache_id = intval($_GET['id']);

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $statut = $_POST['statut'];

    $stmt = $conn->prepare("UPDATE taches SET titre = ?, description = ?, statut = ? WHERE id = ?");
    $stmt->bind_param("sssi", $titre, $description, $statut, $tache_id);

    if ($stmt->execute()) {
        header("Location: dashboard_employe.php");
        exit;
    } else {
        echo "Erreur lors de la mise à jour de la tâche.";
    }
}

// Récupérer les données de la tâche actuelle
$stmt = $conn->prepare("SELECT * FROM taches WHERE id = ?");
$stmt->bind_param("i", $tache_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Tâche introuvable.");
}

$tache = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier la Tâche</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4">Modifier la Tâche</h2>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Titre</label>
      <input type="text" name="titre" class="form-control" value="<?= htmlspecialchars($tache['titre']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="5" required><?= htmlspecialchars($tache['description']) ?></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Statut</label>
      <select name="statut" class="form-select">
        <option value="en cours" <?= $tache['statut'] === 'en cours' ? 'selected' : '' ?>>En cours</option>
        <option value="terminée" <?= $tache['statut'] === 'terminée' ? 'selected' : '' ?>>Terminée</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
    <a href="dashboard_employe.php" class="btn btn-secondary">Annuler</a>
  </form>
</div>

</body>
</html>
