<?php
// === supprimer_cours.php ===
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['situation'] !== '2') {
    header("Location: index.php");
    exit;
}
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn = new mysqli("localhost", "root", "", "gestion_projets");
    if ($conn->connect_error) die("Erreur connexion: " . $conn->connect_error);
    $stmt = $conn->prepare("DELETE FROM cours WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}
header("Location: dashboard_employe.php");
exit;
?>