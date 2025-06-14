<?php

// === ajouter_cour.php ===

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['situation'] !== '2') {

    header("Location: login.php");

    exit;

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conn = new mysqli("localhost", "root", "", "gestion_projets");

    if ($conn->connect_error) die("Erreur connexion: " . $conn->connect_error);
 
    $titre = $_POST['titre'];

    $description = $_POST['description'];

    $id_etudiant = $_POST['id_etudiant'];
 
    $stmt = $conn->prepare("INSERT INTO cours (titre, description, id_etudiant, date_creation) VALUES (?, ?, ?, NOW())");

    $stmt->bind_param("ssi", $titre, $description, $id_etudiant);

    $stmt->execute();

    $stmt->close();

    $conn->close();

    header("Location: dashboard_employe.php");

    exit;

}

?>
<form method="post">
<input type="text" name="titre" placeholder="Titre" required>
<textarea name="description" placeholder="Description"></textarea>
<input type="number" name="id_etudiant" placeholder="ID Étudiant" required>
<button type="submit">Ajouter Cours</button>
</form>

 
<?php

// === supprimer_tache.php ===

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['situation'] !== '2') {

    header("Location: index.php");

    exit;

}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $id = intval($_GET['id']);

    $conn = new mysqli("localhost", "root", "", "gestion_projets");

    if ($conn->connect_error) die("Erreur connexion: " . $conn->connect_error);

    $stmt = $conn->prepare("DELETE FROM taches WHERE id = ?");

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $stmt->close();

    $conn->close();

}

header("Location: dashboard_employe.php");

exit;

?>