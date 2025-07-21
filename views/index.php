<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="icon" href="./img/logo-todo.png" type="image/png" sizes="512x512">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#1E3A8A',
                    secondary: '#059669',
                    warning: '#F97316',
                    danger: '#DC2626',
                    muted: '#6B7280',
                    light: '#F3F4F6',
                }
            }
        }
    }
</script>

</head>

<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen font-sans">
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Fonction pour vérifier si une tâche est en retard
    function isTaskOverdue($taskDate) {
        $today = date('Y-m-d');
        return $taskDate < $today;
    }
    
    // Compter les tâches en retard
    $overdueTasks = 0;
    foreach ($tasks as $task) {
        if ($task['status'] === 'in_progress' && isTaskOverdue($task['date'])) {
            $overdueTasks++;
        }
    }
    ?>

    <!-- Alert Banner pour tâches en retard -->
    <?php if ($overdueTasks > 0): ?>
    <div class="bg-gradient-to-r from-red-500 to-pink-500 text-white p-4 shadow-lg">
        <div class="container mx-auto px-6 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <i class="fas fa-exclamation-triangle text-xl animate-pulse"></i>
                <span class="font-semibold">
                    ⚠️ Attention! Vous avez <?= $overdueTasks ?> tâche<?= $overdueTasks > 1 ? 's' : '' ?> en retard à terminer
                </span>
            </div>
            <button onclick="this.parentElement.parentElement.style.display='none'" 
                    class="text-white hover:text-gray-200 text-xl">
                &times;
            </button>
        </div>
    </div>
    <?php endif; ?>

    <div class="container mx-auto px-6 py-10">
        <!-- Header avec design amélioré -->
        <div class="flex justify-between items-center mb-12">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-tasks text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-5xl font-extrabold bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent">
                        Task Manager
                    </h1>
                    <p class="text-gray-600 text-lg mt-1">Organisez vos tâches efficacement</p>
                </div>
            </div>
            <?php if (isset($_SESSION['id'])): ?>
                <a href="/logout"
                    class="bg-gradient-to-r from-red-500 to-pink-500 text-white py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 font-semibold">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Logout
                </a>
            <?php endif; ?>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Tasks</p>
                        <p class="text-2xl font-bold text-gray-800"><?= count($tasks) ?></p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-blue-600"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">En Cours</p>
                        <p class="text-2xl font-bold text-gray-800">
                            <?= count(array_filter($tasks, function($task) { return $task['status'] === 'in_progress'; })) ?>
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Terminées</p>
                        <p class="text-2xl font-bold text-gray-800">
                            <?= count(array_filter($tasks, function($task) { return $task['status'] === 'completed'; })) ?>
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">En Retard</p>
                        <p class="text-2xl font-bold text-gray-800"><?= $overdueTasks ?></p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Tasks To Do Section -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border-t-4 border-blue-500">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <div class="w-8 h-8 bg-blue-500 rounded-lg mr-3 flex items-center justify-center">
                            <i class="fas fa-clipboard text-white text-sm"></i>
                        </div>
                        À Faire
                    </h2>
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                        <?= count(array_filter($tasks, function($task) { return $task['status'] === 'pending'; })) ?>
                    </span>
                </div>
                
                <div class="overflow-hidden rounded-xl border border-gray-200">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                                <th class="py-4 px-6 text-left font-semibold">Titre</th>
                                <th class="py-4 px-6 text-center font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($tasks as $task): ?>
                                <?php if (isset($task['status']) && $task['status'] === 'pending'): ?>
                                    <tr class="hover:bg-blue-50 transition-colors duration-200">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center">
                                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                                <span class="font-medium text-gray-800"><?= htmlspecialchars($task['title']) ?></span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <button onclick='openEditModal(<?= json_encode($task) ?>)'
                                                class="text-blue-600 hover:text-blue-800 font-medium mr-3 hover:underline transition-colors">
                                                <i class="fas fa-edit mr-1"></i>Edit
                                            </button>
                                            <a href="/delete/<?= $task['id'] ?>" 
                                               class="text-red-600 hover:text-red-800 font-medium hover:underline transition-colors">
                                                <i class="fas fa-trash mr-1"></i>Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tasks In Progress Section -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border-t-4 border-yellow-500">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <div class="w-8 h-8 bg-yellow-500 rounded-lg mr-3 flex items-center justify-center">
                            <i class="fas fa-clock text-white text-sm"></i>
                        </div>
                        En Cours
                    </h2>
                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                        <?= count(array_filter($tasks, function($task) { return $task['status'] === 'in_progress'; })) ?>
                    </span>
                </div>
                
                <div class="overflow-hidden rounded-xl border border-gray-200">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white">
                                <th class="py-4 px-6 text-left font-semibold">Titre</th>
                                <th class="py-4 px-6 text-center font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($tasks as $task): ?>
                                <?php if ($task['status'] === 'in_progress'): ?>
                                    <?php $isOverdue = isTaskOverdue($task['date']); ?>
                                    <tr class="<?= $isOverdue ? 'bg-red-50 hover:bg-red-100' : 'hover:bg-yellow-50' ?> transition-colors duration-200">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center">
                                                <div class="w-2 h-2 <?= $isOverdue ? 'bg-red-500 animate-pulse' : 'bg-yellow-500' ?> rounded-full mr-3"></div>
                                                <div>
                                                    <span class="font-medium text-gray-800"><?= htmlspecialchars($task['title']) ?></span>
                                                    <?php if ($isOverdue): ?>
                                                        <div class="flex items-center mt-1">
                                                            <i class="fas fa-exclamation-triangle text-red-500 text-xs mr-1"></i>
                                                            <span class="text-red-600 text-xs font-semibold">RETARD - <?= $task['date'] ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <button onclick="openEditModal(<?= $task['id'] ?>)"
                                                class="text-blue-600 hover:text-blue-800 font-medium mr-3 hover:underline transition-colors">
                                                <i class="fas fa-edit mr-1"></i>Edit
                                            </button>
                                            <a href="/delete/<?= $task['id'] ?>" 
                                               class="text-red-600 hover:text-red-800 font-medium hover:underline transition-colors">
                                                <i class="fas fa-trash mr-1"></i>Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Completed Tasks Section -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border-t-4 border-green-500">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <div class="w-8 h-8 bg-green-500 rounded-lg mr-3 flex items-center justify-center">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        Terminées
                    </h2>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                        <?= count(array_filter($tasks, function($task) { return $task['status'] === 'completed'; })) ?>
                    </span>
                </div>
                
                <div class="overflow-hidden rounded-xl border border-gray-200">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-green-500 to-green-600 text-white">
                                <th class="py-4 px-6 text-left font-semibold">Titre</th>
                                <th class="py-4 px-6 text-center font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($tasks as $task): ?>
                                <?php if ($task['status'] === 'completed'): ?>
                                    <tr class="hover:bg-green-50 transition-colors duration-200">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center">
                                                <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                                <span class="font-medium text-gray-800 line-through opacity-75"><?= htmlspecialchars($task['title']) ?></span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <a href="/delete/<?= $task['id'] ?>" 
                                               class="text-red-600 hover:text-red-800 font-medium hover:underline transition-colors">
                                                <i class="fas fa-trash mr-1"></i>Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Bouton flottant amélioré -->
        <a href="#" onclick="openModal()"
            class="fixed bottom-8 right-8 bg-gradient-to-r from-blue-500 to-purple-600 text-white p-4 rounded-full shadow-2xl hover:shadow-3xl transform hover:scale-110 transition-all duration-300 flex items-center justify-center w-16 h-16 group">
            <i class="fa-solid fa-plus text-2xl group-hover:rotate-90 transition-transform duration-300"></i>
        </a>

        <!-- Modal amélioré -->
        <div id="addTaskModal"
            class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
            <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md relative transform scale-95 transition-all duration-300">
                <button onclick="closeModal()"
                    class="absolute top-4 right-4 text-gray-400 hover:text-red-500 text-2xl w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition-all">&times;</button>

                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-plus text-white text-xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">Nouvelle Tâche</h1>
                    <p class="text-gray-600 text-sm mt-1">Ajoutez une nouvelle tâche à votre liste</p>
                </div>

                <form action="/add" method="post" enctype="multipart/form-data" class="space-y-6">
                    <div>
                        <label for="title" class="block text-gray-700 font-semibold mb-2">Titre de la tâche</label>
                        <input type="text" id="title" name="title" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                    </div>
                    <div>
                        <label for="task" class="block text-gray-700 font-semibold mb-2">Description</label>
                        <input type="text" id="task" name="task" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                    </div>
                    <div>
                        <label for="date" class="block text-gray-700 font-semibold mb-2">Date d'échéance</label>
                        <input type="date" id="date" name="date" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                    </div>
                    <div>
                        <label for="status" class="block text-gray-700 font-semibold mb-2">Statut</label>
                        <select id="status" name="status" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                            <option value="pending">En attente</option>
                            <option value="in_progress">En cours</option>
                            <option value="completed">Terminée</option>
                        </select>
                    </div>
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-200 font-semibold">
                        <i class="fas fa-plus mr-2"></i>Ajouter la tâche
                    </button>
                </form>
            </div>
        </div>

        <!-- JavaScript -->
        <script>
            function openModal() {
                const modal = document.getElementById('addTaskModal');
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.querySelector('.bg-white').classList.remove('scale-95');
                    modal.querySelector('.bg-white').classList.add('scale-100');
                }, 10);
            }
            
            function closeModal() {
                const modal = document.getElementById('addTaskModal');
                modal.querySelector('.bg-white').classList.remove('scale-100');
                modal.querySelector('.bg-white').classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 200);
            }
        </script>

    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>

    <!-- Exemple de boucle sur les tâches dans index.php -->
    <?php foreach ($tasks as $task): ?>
        <!-- Popup Edit Modal amélioré -->
        <div id="editModal-<?= $task['id'] ?>"
            class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
            <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md relative">
                <button onclick="closeEditModal(<?= $task['id'] ?>)"
                    class="absolute top-4 right-4 text-gray-400 hover:text-red-500 text-2xl w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition-all">&times;</button>
                
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-blue-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-edit text-white text-xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">Modifier la tâche</h1>
                    <p class="text-gray-600 text-sm mt-1">Modifiez les détails de votre tâche</p>
                </div>

                <form action="/edit/<?= $task['id'] ?>" method="post" class="space-y-6">
                    <div>
                        <label for="title" class="block text-gray-700 font-semibold mb-2">Titre de la tâche</label>
                        <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all">
                    </div>
                    <div>
                        <label for="task" class="block text-gray-700 font-semibold mb-2">Description</label>
                        <input type="text" name="task" value="<?= htmlspecialchars($task['task']) ?>" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all">
                    </div>
                    <div>
                        <label for="date" class="block text-gray-700 font-semibold mb-2">Date d'échéance</label>
                        <input type="date" name="date" value="<?= htmlspecialchars($task['date']) ?>" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all">
                    </div>
                    <div>
                        <label for="status" class="block text-gray-700 font-semibold mb-2">Statut</label>
                        <select name="status" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all">
                            <option value="pending" <?= $task['status'] === 'pending' ? 'selected' : '' ?>>En attente</option>
                            <option value="in_progress" <?= $task['status'] === 'in_progress' ? 'selected' : '' ?>>En cours</option>
                            <option value="completed" <?= $task['status'] === 'completed' ? 'selected' : '' ?>>Terminée</option>
                        </select>
                    </div>
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-green-500 to-blue-600 text-white py-3 rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-200 font-semibold">
                        <i class="fas fa-save mr-2"></i>Mettre à jour
                    </button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
    
    <script>
        function openEditModal(id) {
            document.getElementById('editModal-' + id).classList.remove('hidden');
        }

        function closeEditModal(id) {
            document.getElementById('editModal-' + id).classList.add('hidden');
        }
    </script>

</body>

</html>