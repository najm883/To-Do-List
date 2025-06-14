<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['situation'] !== '2') {
    header("Location: login.php");
    exit;
}
$utilisateur_id = $_SESSION['user_id'];
$nom_utilisateur = $_SESSION['nom'] ?? "Utilisateur";
$conn = new mysqli("localhost", "root", "", "gestion_projets");
if ($conn->connect_error) die("Erreur de connexion : " . $conn->connect_error);
 
if (isset($_GET['supprimer_tout']) && $_GET['supprimer_tout'] == 1) {
    $conn->query("DELETE FROM projets WHERE id_utilisateur = $utilisateur_id");
    $conn->query("DELETE FROM cours WHERE id_utilisateur = $utilisateur_id");
    $conn->query("DELETE FROM taches WHERE id_utilisateur = $utilisateur_id");
    $_SESSION['success_message'] = "Tous les projets, cours et tâches ont été supprimés.";
    header("Location: dashboard_employe.php");
    exit;
}
 
$sql_projets = "SELECT id, titre, description, statut, date_creation FROM projets WHERE id_utilisateur = ? ORDER BY date_creation DESC";
$stmt_projets = $conn->prepare($sql_projets);
$stmt_projets->bind_param("i", $utilisateur_id);
$stmt_projets->execute();
$result_projets = $stmt_projets->get_result();
$projets = $result_projets->fetch_all(MYSQLI_ASSOC);
$stmt_projets->close();
 
$sql_taches = "SELECT id, titre, description, statut, date_creation FROM taches WHERE id_utilisateur = ?";
$stmt_taches = $conn->prepare($sql_taches);
$stmt_taches->bind_param("i", $utilisateur_id);
$stmt_taches->execute();
$result_taches = $stmt_taches->get_result();
$taches = $result_taches->fetch_all(MYSQLI_ASSOC);
$stmt_taches->close();
 
$sql_cours = "SELECT id, titre, description, date_creation FROM cours WHERE id_utilisateur = ?";
$stmt_cours = $conn->prepare($sql_cours);
$stmt_cours->bind_param("i", $utilisateur_id);
$stmt_cours->execute();
$result_cours = $stmt_cours->get_result();
$cours = $result_cours->fetch_all(MYSQLI_ASSOC);
$stmt_cours->close();
 
$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8">
<title>Dashboard Employé</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light">
<div class="container my-5">
<div class="bg-warning text-dark p-4 rounded text-center">
<h1>Bienvenue, <?= htmlspecialchars($nom_utilisateur) ?> 🧑‍💼</h1>
<p>Rôle : Encadrant / Employé</p>
<div class="mt-3 d-flex flex-wrap justify-content-center gap-2">
  <a href="logout.php" class="btn btn-dark">Se déconnecter</a>
  <a href="ajouter_projet.php" class="btn btn-success">+ Ajouter un projet</a>
  <a href="ajouter_tache.php" class="btn btn-primary">+ Ajouter une tâche</a>
  <a href="ajouter_cour.php" class="btn btn-danger">+ Ajouter un cours</a>
  <a href="?supprimer_tout=1" class="btn btn-outline-danger" onclick="return confirm('Confirmez-vous la suppression de tous les éléments ?');">🗑️ Supprimer tout</a>
</div></div>
 
<?php if (isset($_SESSION['success_message'])): ?>
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
<?= htmlspecialchars($_SESSION['success_message']) ?>
<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['success_message']); endif; ?>
 
<!-- Projets -->
<div class="card mt-4"><div class="card-header bg-secondary text-white">Mes projets</div>
<div class="card-body">
<?php if (count($projets) > 0): ?>
<div class="row">
<?php foreach($projets as $projet): ?>
<div class="col-md-6 mb-3">
<div class="card">
<div class="card-header text-white bg-warning d-flex justify-content-between">
<h6><?= htmlspecialchars($projet['titre']) ?></h6>
<span class="badge bg-light text-dark"><?= ucfirst($projet['statut']) ?></span></div>
<div class="card-body">
<p><?= nl2br(htmlspecialchars($projet['description'])) ?></p>
<small class="text-muted">Créé le <?= date('d/m/Y', strtotime($projet['date_creation'])) ?></small>
<div class="mt-2">
<a href="modifier_projet.php?id=<?= $projet['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
<a href="voir_projet.php?id=<?= $projet['id'] ?>" class="btn btn-info btn-sm">Détails</a>
<a href="supprimer_projet.php?id=<?= $projet['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce projet ?');">Supprimer</a>
</div></div></div></div>
<?php endforeach; ?>
</div>
<?php else: ?>
<div class="alert alert-info text-center">Aucun projet trouvé.</div>
<?php endif; ?>
</div></div>
 
<!-- Tâches -->
<div class="card mt-4">
  <div class="card-header bg-primary text-white">Mes tâches</div>
  <div class="card-body">
    <?php if (count($taches) > 0): ?>
    <div class="row">
      <?php foreach($taches as $tache): ?>
      <div class="col-md-6 mb-3">
        <div class="card border border-primary">
          <div class="card-header bg-primary text-white d-flex justify-content-between">
            <strong><?= htmlspecialchars($tache['titre']) ?></strong>
            <span class="badge bg-light text-dark"><?= ucfirst($tache['statut']) ?></span>
          </div>
          <div class="card-body">
            <p><?= nl2br(htmlspecialchars($tache['description'])) ?></p>
            <small class="text-muted">Créée le <?= date('d/m/Y', strtotime($tache['date_creation'])) ?></small>
            <div class="mt-2">
              <a href="supprimer_tache.php?id=<?= $tache['id'] ?>" class="btn btn-danger btn-sm"
                 onclick="return confirm('Supprimer cette tâche ?');">Supprimer</a>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="alert alert-info text-center">Aucune tâche créée.</div>
    <?php endif; ?>
  </div>
</div>
 
<!-- Cours -->
<div class="card mt-4">
  <div class="card-header bg-danger text-white">Mes cours</div>
  <div class="card-body">
    <?php if (count($cours) > 0): ?>
    <div class="row">
      <?php foreach($cours as $cour): ?>
      <div class="col-md-6 mb-3">
        <div class="card border border-danger">
          <div class="card-header bg-danger text-white"><?= htmlspecialchars($cour['titre']) ?></div>
          <div class="card-body">
            <p><?= nl2br(htmlspecialchars($cour['description'])) ?></p>
            <small class="text-muted">Créé le <?= date('d/m/Y', strtotime($cour['date_creation'])) ?></small>
            <div class="mt-2">
              <a href="supprimer_cours.php?id=<?= $cour['id'] ?>" class="btn btn-danger btn-sm"
                 onclick="return confirm('Supprimer ce cours ?');">Supprimer</a>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="alert alert-info text-center">Aucun cours créé.</div>
    <?php endif; ?>
  </div>
</div>
 
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body></html>