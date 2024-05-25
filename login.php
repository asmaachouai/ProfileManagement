<?php
session_start();
require_once "pdo.php";

$salt = 'XyZzy12*_';

if (isset($_POST['email']) && isset($_POST['pass'])) {
    // Calculer le hachage du mot de passe fourni
    $check = hash('md5', $salt.$_POST['pass']);

    // Préparer et exécuter la requête pour vérifier les informations d'identification
    $stmt = $pdo->prepare('SELECT user_id, name FROM users WHERE email = :em AND password = :pw');
    $stmt->execute(array(':em' => $_POST['email'], ':pw' => $check));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row !== false) {
        // Si une ligne est trouvée, mettre à jour la session et rediriger vers index.php
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
        header("Location: view.php");
        return;
    } else {
        // Si aucune ligne n'est trouvée, définir un message d'erreur et rediriger vers login.php
        $_SESSION['error'] = "Incorrect password.";
        header("Location: login.php");
        return;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asmaa CHOUAI - Login</title>
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
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1 class="text-center">Please Log In</h1>
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger" role="alert">' . htmlentities($_SESSION['error']) . '</div>';
                unset($_SESSION['error']);
            }
            ?>
            <form method="POST" onsubmit="return doValidate();">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="pass">Password</label>
                    <input type="password" class="form-control" id="pass" name="pass">
                </div>
                <button type="submit" class="btn btn-primary">Log In</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function doValidate() {
        var em = document.getElementById('email').value;
        var pw = document.getElementById('pass').value;

        if (em === '' || pw === '') {
            alert("Both fields must be filled out");
            return false;
        }
        if (em.indexOf('@') === -1) {
            alert("Invalid email address");
            return false;
        }
        return true;
    }
</script>

</body>
</html>


