 
<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['situation'] !== '2') {
    header("Location: login.php");
    exit;
}
 
$conn = new mysqli("localhost", "root", "", "gestion_projets");
if ($conn->connect_error) die("Erreur connexion : " . $conn->connect_error);
 
$stagiaires = [];
$result = $conn->query("SELECT id, nom FROM utilisateurs WHERE situation = 3");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $stagiaires[] = $row;
    }
}
 
$success = false;
$error = "";
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre']);
    $description = trim($_POST['description']);
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $id_stagiaire = intval($_POST['id_stagiaire']);
    $id_utilisateur = $_SESSION['user_id'];
 
    if ($titre && $date_debut && $date_fin) {
        $stmt = $conn->prepare("INSERT INTO projets (titre, description, date_debut, date_fin, id_stagiaire, id_utilisateur) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssii", $titre, $description, $date_debut, $date_fin, $id_stagiaire, $id_utilisateur);
        $stmt->execute();
        $stmt->close();
        $success = true;
    } else {
        $error = "Champs obligatoires manquants.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter un projet</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">
<h2>Ajouter un projet</h2>
<?php if ($success): ?>
<div class="alert alert-success">Projet ajouté avec succès.</div>
<?php elseif ($error): ?>
<div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<form method="post" class="p-4 border rounded bg-white shadow-sm">
  <div class="mb-3">
    <label for="titre" class="form-label">Titre</label>
    <input type="text" class="form-control" name="titre" required>
  </div>
  <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control" name="description"></textarea>
  </div>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label for="date_debut" class="form-label">Date début</label>
      <input type="date" class="form-control" name="date_debut" required>
    </div>
    <div class="col-md-6 mb-3">
      <label for="date_fin" class="form-label">Date fin</label>
      <input type="date" class="form-control" name="date_fin" required>
    </div>
  </div>
  <div class="mb-3">
    <label for="id_stagiaire" class="form-label">Stagiaire concerné</label>
    <select name="id_stagiaire" class="form-select">
      <option value="">-- Choisir un stagiaire --</option>
      <?php foreach($stagiaires as $s): ?>
      <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nom']) ?> (ID <?= $s['id'] ?>)</option>
      <?php endforeach; ?>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Créer le projet</button>
</form>
</div>
</body>
</html>
 
 