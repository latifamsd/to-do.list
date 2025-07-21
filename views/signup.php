<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>

    <!-- Logo dans l'onglet avec différentes tailles -->
    <link rel="icon" href="./img/logo-todo.png" type="image/png" sizes="32x32">
    <link rel="icon" href="./img/logo-todo.png" type="image/png" sizes="16x16">
    <link rel="icon" href="./img/logo-todo.png" type="image/png" sizes="48x48">
    <link rel="icon" href="./img/logo-todo.png" type="image/png" sizes="96x96">
    <link rel="icon" href="./img/logo-todo.png" type="image/png" sizes="192x192">
    <link rel="icon" href="./img/logo-todo.png" type="image/png" sizes="512x512">

    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="h-screen flex items-center justify-center bg-blue-50">

    <!-- Formulaire avec fond gris clair et ombre -->
    <div class="w-full max-w-md bg-white rounded-lg shadow-xl p-8 flex flex-col items-center">
        <img src="./img/logo-todo.png" alt="logo" class="w-24 h-24 mb-2 items-center">
        <h2 class="text-3xl font-bold text-center text-blue-600 mb-6">Créer un compte</h2>

        <!-- Message d'erreur -->
        <?php if (isset($error)): ?>
            <div class="w-full mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <!-- Message de succès -->
        <?php if (isset($success)): ?>
            <div class="w-full mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span><?= htmlspecialchars($success) ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" action="/signup" class="space-y-4 w-full">
            <input type="text" name="name" placeholder="Nom" required
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">

            <input type="email" name="email" placeholder="Email" required
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">

            <!-- Champ mot de passe avec bouton œil -->
            <div class="relative">
                <input type="password" name="password" id="password" placeholder="Mot de passe" required
                    class="w-full p-3 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                <button type="button" id="togglePassword"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700">
                    <!-- Icône œil fermé (mot de passe masqué) -->
                    <i id="eyeClosedIcon" class="fa-solid fa-eye-slash text-lg"></i>

                    <!-- Icône œil ouvert (mot de passe visible) -->
                    <i id="eyeOpenIcon" class="fa-solid fa-eye text-lg hidden"></i>
                </button>
            </div>

            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-lg transition duration-300">
                S'inscrire
            </button>
        </form>

        <p class="text-center text-gray-600 mt-4">
            Déjà un compte? <a href="/login" class="text-blue-500 hover:underline">Connectez-vous</a>
        </p>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const eyeClosedIcon = document.getElementById('eyeClosedIcon');
            const eyeOpenIcon = document.getElementById('eyeOpenIcon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeClosedIcon.classList.add('hidden');
                eyeOpenIcon.classList.remove('hidden');
            } else {
                passwordField.type = 'password';
                eyeClosedIcon.classList.remove('hidden');
                eyeOpenIcon.classList.add('hidden');
            }
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.bg-red-100, .bg-green-100');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 500);
            });
        }, 5000);
    </script>

</body>

</html>