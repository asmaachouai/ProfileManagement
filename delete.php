<?php
session_start();
require_once "pdo.php";

if (!isset($_SESSION['name'])) {
    die('ACCESS DENIED');
}

if (!isset($_GET['profile_id'])) {
    die('Profile ID missing');
}

if (isset($_POST['delete']) && isset($_POST['profile_id'])) {
    $stmt = $pdo->prepare('DELETE FROM Profile WHERE profile_id = :pid AND user_id = :uid');
    $stmt->execute(array(':pid' => $_POST['profile_id'], ':uid' => $_SESSION['user_id']));
    $_SESSION['success'] = "Profile deleted";
    header("Location: view.php");
    return;
}

$stmt = $pdo->prepare("SELECT first_name, last_name FROM Profile WHERE profile_id = :pid AND user_id = :uid");
$stmt->execute(array(':pid' => $_GET['profile_id'], ':uid' => $_SESSION['user_id']));
$profile = $stmt->fetch(PDO::FETCH_ASSOC);
if ($profile === false) {
    $_SESSION['error'] = "Could not load profile";
    header("Location: view.php");
    return;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asmaa CHOUAI - Delete Profile</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Gestion de CV</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>
<div class="container mt-5">
    <h1>Delete Profile</h1>
    <p>First Name: <?= htmlentities($profile['first_name']) ?></p>
    <p>Last Name: <?= htmlentities($profile['last_name']) ?></p>
    <form method="POST">
        <input type="hidden" name="profile_id" value="<?= htmlentities($_GET['profile_id']) ?>">
        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
        <a href="view.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


