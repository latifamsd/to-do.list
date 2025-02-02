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
</head>
<body class="h-screen flex items-center justify-center bg-blue-50">

    <!-- Formulaire avec fond gris clair et ombre -->
    <div class="w-full max-w-md bg-white rounded-lg shadow-xl p-8">        
        <h2 class="text-3xl font-bold text-center text-blue-600 mb-6">Créer un compte</h2>
        
        <form method="POST" action="/signup" class="space-y-4">
            <input type="text" name="name" placeholder="Nom" required 
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

            <input type="email" name="email" placeholder="Email" required 
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

            <input type="password" name="password" placeholder="Mot de passe" required 
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

            <button type="submit" 
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-lg transition duration-300">
                S'inscrire
            </button>
        </form>
        
        <p class="text-center text-gray-600 mt-4">
            Déjà un compte? <a href="/login" class="text-blue-500 hover:underline">Connectez-vous</a>
        </p>
    </div>

</body>
</html>
