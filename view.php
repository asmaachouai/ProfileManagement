<?php
session_start();
require_once "pdo.php";

if (!isset($_SESSION['name'])) {
    $logged_in = false;
} else {
    $logged_in = true;
}

$stmt = $pdo->query("SELECT profile_id, first_name, last_name, headline FROM Profile");
$profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asmaa CHOUAI - Résumés</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Resume Registry</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <?php if ($logged_in): ?>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add.php">Add New Entry</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center">Resume List</h1>
    <?php
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success" role="alert">' . htmlentities($_SESSION['success']) . '</div>';
        unset($_SESSION['success']);
    }

    if (!$logged_in) {
        echo '<p class="text-center"><a href="login.php">Please log in</a></p>';
    }
    ?>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Headline</th>
            <?php if ($logged_in) echo '<th scope="col">Action</th>'; ?>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($profiles as $profile) {
            echo "<tr>";
            echo '<td><a href="view.php?profile_id=' . $profile['profile_id'] . '">' . htmlentities($profile['first_name']) . ' ' . htmlentities($profile['last_name']) . '</a></td>';
            echo '<td>' . htmlentities($profile['headline']) . '</td>';
            if ($logged_in) {
                echo '<td><a href="edit.php?profile_id=' . $profile['profile_id'] . '">Edit</a> / <a href="delete.php?profile_id=' . $profile['profile_id'] . '">Delete</a></td>';
            }
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
