<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['situation'] !== '2') {
    header("Location: login.php");
    exit;
}
 
$conn = new mysqli("localhost", "root", "", "gestion_projets");
if ($conn->connect_error) die("Erreur connexion : " . $conn->connect_error);
 
$etudiants = [];
$result = $conn->query("SELECT id, nom FROM utilisateurs WHERE situation = 1");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $etudiants[] = $row;
    }
}
 
$success = false;
$error = "";
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre']);
    $description = trim($_POST['description']);
    $id_etudiant = intval($_POST['id_etudiant']);
    $id_utilisateur = $_SESSION['user_id'];
 
    if ($titre && $id_etudiant) {
        $stmt = $conn->prepare("INSERT INTO cours (titre, description, id_etudiant, id_utilisateur, date_creation) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssii", $titre, $description, $id_etudiant, $id_utilisateur);
        $stmt->execute();
        $stmt->close();
        $success = true;
    } else {
        $error = "Tous les champs sont requis.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter un cours</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">
<h2>Ajouter un cours</h2>
<?php if ($success): ?>
<div class="alert alert-success">Cours ajoutée avec succès.</div>
<?php elseif ($error): ?>
<div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<form method="post" class="p-4 border rounded bg-white shadow-sm">
  <div class="mb-3">
    <label for="titre" class="form-label">Titre</label>
    <input type="text" class="form-control" id="titre" name="titre" required>
  </div>
  <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control" name="description" id="description"></textarea>
  </div>
  <div class="mb-3">
    <label for="id_etudiant" class="form-label">Étudiant concerné</label>
    <select name="id_etudiant" class="form-select" required>
      <option value="">-- Choisir un étudiant --</option>
      <?php foreach($etudiants as $e): ?>
      <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nom']) ?> (ID <?= $e['id'] ?>)</option>
      <?php endforeach; ?>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Créer la cours</button>
</form>
</div>
</body>
</html>
 