<?php
// === dashboard_etudiant.php ===
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$etudiant_id = $_SESSION['user_id'];
$nom_utilisateur = $_SESSION['nom'] ?? "Utilisateur";
$conn = new mysqli("localhost", "root", "", "gestion_projets");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}
$sql = "SELECT titre, description, date_creation FROM cours WHERE id_etudiant = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $etudiant_id);
$stmt->execute();
$result = $stmt->get_result();
$cours = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8" /><title>Dashboard Étudiant</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" /></head>
<body class="bg-light">
<div class="container my-5">
<div class="bg-success text-white p-4 rounded text-center">
<h1>Bienvenue, <?= htmlspecialchars($nom_utilisateur) ?> 🎓</h1>
<p>Rôle : Étudiant</p>
<a href="logout.php" class="btn btn-light mt-3">Se déconnecter</a></div>
<div class="mt-4">
<div class="card mb-3"><div class="card-header bg-secondary text-white">Mes cours</div>
<div class="card-body">
<?php if (count($cours) > 0): foreach ($cours as $row): ?>
<div class="card mb-3">
<div class="card-header bg-info text-white"> <?= htmlspecialchars($row['titre']) ?> </div>
<div class="card-body">
<p class="mb-1"><?= nl2br(htmlspecialchars($row['description'])) ?></p>
<small class="text-muted">Créé le <?= date('d/m/Y', strtotime($row['date_creation'])) ?></small>
</div></div>
<?php endforeach; else: ?>
<div class="alert alert-warning text-center">Aucun cours assigné pour le moment.</div>
<?php endif; ?>
</div></div>
<div class="card"><div class="card-header bg-secondary text-white">Mon emploi du temps</div>
<div class="card-body">
<p><strong>Heures de cours :</strong> 8h30 - 16h30</p>
<p><strong>Encadrant pédagogique :</strong> M. Benali</p>
</div></div></div></div></body></html>
 
 