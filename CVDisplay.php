<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de CV</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <style>
        /* Add your custom styles here */
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Gestion de CV</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">CV</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Se connecter</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h1>Bienvenue dans l'application de gestion de CV</h1>
    <p>Vous pouvez consulter, ajouter, mettre à jour et supprimer des CV.</p>

    <!-- Zone pour afficher les CV -->
    <div id="cvList" class="row">
        <!-- Les CV ajoutés seront affichés ici -->
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Script pour récupérer et afficher les CV -->
<script>
    $(document).ready(function(){
        // Fonction pour récupérer les CV depuis le backend
        function getCvList() {
            $.ajax({
                url: '/cv', // URL de votre endpoint API pour récupérer les CV
                type: 'GET',
                success: function(data) {
                    displayCvList(data); // Appeler la fonction pour afficher les CV
                },
                error: function(xhr, status, error) {
                    console.error('Erreur lors de la récupération des CV:', error);
                }
            });
        }

        // Fonction pour afficher les CV dans la page
        function displayCvList(cvList) {
            var cvListContainer = $('#cvList');
            cvListContainer.empty(); // Vider la zone d'affichage

            // Parcourir les CV et les afficher
            cvList.forEach(function(cv) {
                var cvHtml = `
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">${cv.title}</h5>
                                <p class="card-text">${cv.description}</p>
                                <!-- Ajoutez d'autres informations du CV ici -->
                            </div>
                        </div>
                    </div>
                `;
                cvListContainer.append(cvHtml);
            });
        }

        // Appeler la fonction pour récupérer les CV au chargement de la page
        getCvList();
    });
</script>

</body>
</html>
