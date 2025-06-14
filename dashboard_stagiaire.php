<?php
// === dashboard_stagiaire.php ===
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$stagiaire_id = $_SESSION['user_id'];
$nom_utilisateur = $_SESSION['nom'] ?? "Utilisateur";
$conn = new mysqli("localhost", "root", "", "gestion_projets");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}
$sql = "SELECT id, titre, description, date_debut, date_fin FROM projets WHERE id_stagiaire = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $stagiaire_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8">
<title>Dashboard Stagiaire</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light">
<div class="container my-5">
<div class="bg-primary text-white p-4 rounded text-center">
<h1>Bienvenue, <?= htmlspecialchars($nom_utilisateur) ?> 👋</h1>
<p>Rôle : Stagiaire</p>
<a href="logout.php" class="btn btn-light mt-3">Se déconnecter</a></div>
<div class="mt-4">
<div class="card mb-3"><div class="card-header bg-secondary text-white text-center">Mes projets assignés</div>
<div class="card-body">
<?php if ($result->num_rows > 0): while ($row = $result->fetch_assoc()): ?>
<div class="card mt-3">
<div class="card-header text-center"> <?= htmlspecialchars($row['titre']) ?> </div>
<div class="card-body">
<div class="row text-center">
<div class="col-md-4"><h6>Description</h6><p><?= nl2br(htmlspecialchars($row['description'])) ?></p></div>
<div class="col-md-4"><h6>Date de début</h6><p><?= htmlspecialchars($row['date_debut']) ?></p></div>
<div class="col-md-4"><h6>Date de fin</h6><p><?= htmlspecialchars($row['date_fin']) ?></p></div>
</div></div></div>
<?php endwhile; else: ?>
<p>Aucun projet assigné pour le moment.</p>
<?php endif; ?>
</div></div>
<div class="card mb-3"><div class="card-header bg-secondary text-white">Mes missions</div>
<div class="card-body">
<ul class="list-group list-group-flush">
<li class="list-group-item">✔️ Suivre la tâche A</li>
<li class="list-group-item">✔️ Rédiger le rapport de stage</li>
<li class="list-group-item">✔️ Participer à la réunion du jeudi</li>
</ul></div></div>
<div class="card"><div class="card-header bg-secondary text-white">Mon planning</div>
<div class="card-body">
<p><strong>Heures de présence :</strong> 9h00 - 17h00</p>
<p><strong>Encadrant :</strong> Mme Durand</p>
</div></div></div></div>
<script src="stagiairescript.js"></script></body></html>
 
 