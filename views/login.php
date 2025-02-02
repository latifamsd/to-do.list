<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    
    <!-- Logo dans l'onglet -->
    <link rel="icon" href="./img/logo-todo.png" type="image/png" sizes="512x512">
    
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex items-center justify-center bg-blue-50">

    <!-- Formulaire avec fond gris clair et ombre -->
    <div class="w-full max-w-md bg-white rounded-lg shadow-xl p-8">
        <h2 class="text-3xl font-bold text-center text-blue-600 mb-6">Se connecter</h2>
        
        <form method="POST" action="/login" class="space-y-4">
            <input type="email" name="email" placeholder="Email" required 
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

            <input type="password" name="password" placeholder="Mot de passe" required 
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

            <button type="submit" 
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-lg transition duration-300">
                Connexion
            </button>
        </form>
        
        <p class="text-center text-gray-600 mt-4">
            Pas encore inscrit ? <a href="/signup" class="text-blue-500 hover:underline">Créez un compte</a>
        </p>
    </div>

</body>
</html>
