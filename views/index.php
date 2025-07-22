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
                        primary: '#2563eb',
                        secondary: '#22c55e',
                        warning: '#facc15',
                        danger: '#ef4444',
                        muted: '#94a3b8',
                        light: '#f8fafc',
                    }
                }
            }
        }
    </script>

</head>

<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 min-h-screen font-sans text-gray-700">
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Fonction pour vérifier si une tâche est en retard
    function isTaskOverdue($taskDate)
    {
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
        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-4 shadow-lg">
            <div class="container mx-auto px-6 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-exclamation-triangle text-xl animate-bounce"></i>
                    <span class="font-semibold text-lg">
                        🔥 Alerte! Vous avez <?= $overdueTasks ?> tâche<?= $overdueTasks > 1 ? 's' : '' ?> en retard à
                        terminer
                    </span>
                </div>
                <button onclick="this.parentElement.parentElement.style.display='none'"
                    class="text-white hover:text-red-100 text-2xl hover:scale-110 transition-all">
                    &times;
                </button>
            </div>
        </div>
    <?php endif; ?>

    <div class="container mx-auto px-8 py-10">
        <!-- Header avec design épuré -->
        <div class="flex justify-between items-center mb-12">
            <div class="flex items-center space-x-6">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-rocket text-white text-2xl"></i>
                </div>
                <div>
                    <h1
                        class="text-5xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">
                        TO-DO LIST
                    </h1>
                    <p class="text-gray-600 text-xl font-medium">Gérez vos projets avec simplicité</p>
                </div>
            </div>
            <?php if (isset($_SESSION['id'])): ?>
                <a href="/logout"
                    class="bg-gradient-to-r from-red-500 to-red-600 text-white py-3 px-6 rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-300 font-semibold">
                    <i class="fas fa-power-off mr-2"></i>
                    Logout
                </a>
            <?php endif; ?>
        </div>

        <!-- Statistics Cards avec design épuré -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div
                class="bg-white rounded-2xl shadow-md hover:shadow-lg p-6 border border-gray-100 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Total Tasks</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2"><?= count($tasks) ?></p>
                    </div>
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-layer-group text-white text-lg"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-md hover:shadow-lg p-6 border border-gray-100 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-semibold uppercase tracking-wider">En Cours</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">
                            <?= count(array_filter($tasks, function ($task) {
                                return $task['status'] === 'in_progress'; })) ?>
                        </p>
                    </div>
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl flex items-center justify-center">
                        <i class="fas fa-fire text-white text-lg"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-md hover:shadow-lg p-6 border border-gray-100 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Terminées</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">
                            <?= count(array_filter($tasks, function ($task) {
                                return $task['status'] === 'completed'; })) ?>
                        </p>
                    </div>
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center">
                        <i class="fas fa-trophy text-white text-lg"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-md hover:shadow-lg p-6 border border-gray-100 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-semibold uppercase tracking-wider">En Retard</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2"><?= $overdueTasks ?></p>
                    </div>
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-red-500 to-rose-500 rounded-xl flex items-center justify-center">
                        <i class="fas fa-bolt text-white text-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Tasks To Do Section -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg mr-3 flex items-center justify-center">
                            <i class="fas fa-hourglass-start text-white text-sm"></i>
                        </div>
                        À Faire
                        <span class="ml-auto bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm font-semibold">
                            <?= count(array_filter($tasks, function ($task) {
                                return $task['status'] === 'pending'; })) ?>
                        </span>
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="py-4 px-6 text-left font-semibold text-gray-700">Titre</th>
                                <th class="py-4 px-6 text-center font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($tasks as $task): ?>
                                <?php if (isset($task['status']) && $task['status'] === 'pending'): ?>
                                    <tr class="hover:bg-blue-25 transition-colors duration-200">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center">
                                                <div class="w-3 h-3 bg-blue-400 rounded-full mr-3"></div>
                                                <span
                                                    class="font-medium text-gray-800"><?= htmlspecialchars($task['title']) ?></span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <button onclick='openEditModal(<?= json_encode($task) ?>)'
                                                class="text-blue-600 hover:text-blue-700 font-medium mr-4 hover:underline transition-colors">
                                                <i class="fas fa-edit mr-1"></i>Edit
                                            </button>
                                            <a href="/delete/<?= $task['id'] ?>"
                                                class="text-red-600 hover:text-red-700 font-medium hover:underline transition-colors">
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
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 p-6 border-b border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-amber-500 to-orange-500 rounded-lg mr-3 flex items-center justify-center">
                            <i class="fas fa-fire text-white text-sm"></i>
                        </div>
                        En Cours
                        <span class="ml-auto bg-amber-100 text-amber-600 px-3 py-1 rounded-full text-sm font-semibold">
                            <?= count(array_filter($tasks, function ($task) {
                                return $task['status'] === 'in_progress'; })) ?>
                        </span>
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="py-4 px-6 text-left font-semibold text-gray-700">Titre</th>
                                <th class="py-4 px-6 text-center font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($tasks as $task): ?>
                                <?php if ($task['status'] === 'in_progress'): ?>
                                    <?php $isOverdue = isTaskOverdue($task['date']); ?>
                                    <tr
                                        class="<?= $isOverdue ? 'bg-red-25 hover:bg-red-50' : 'hover:bg-amber-25' ?> transition-colors duration-200">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-3 h-3 <?= $isOverdue ? 'bg-red-500 animate-pulse' : 'bg-amber-400' ?> rounded-full mr-3">
                                                </div>
                                                <div>
                                                    <span
                                                        class="font-medium text-gray-800"><?= htmlspecialchars($task['title']) ?></span>
                                                    <?php if ($isOverdue): ?>
                                                        <div class="flex items-center mt-1">
                                                            <i class="fas fa-exclamation-triangle text-red-500 text-sm mr-1"></i>
                                                            <span class="text-red-600 text-sm font-medium">RETARD -
                                                                <?= $task['date'] ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <button onclick="openEditModal(<?= $task['id'] ?>)"
                                                class="text-amber-600 hover:text-amber-700 font-medium mr-4 hover:underline transition-colors">
                                                <i class="fas fa-edit mr-1"></i>Edit
                                            </button>
                                            <a href="/delete/<?= $task['id'] ?>"
                                                class="text-red-600 hover:text-red-700 font-medium hover:underline transition-colors">
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
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 p-6 border-b border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-lg mr-3 flex items-center justify-center">
                            <i class="fas fa-trophy text-white text-sm"></i>
                        </div>
                        Terminées
                        <span
                            class="ml-auto bg-emerald-100 text-emerald-600 px-3 py-1 rounded-full text-sm font-semibold">
                            <?= count(array_filter($tasks, function ($task) {
                                return $task['status'] === 'completed'; })) ?>
                        </span>
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="py-4 px-6 text-left font-semibold text-gray-700">Titre</th>
                                <th class="py-4 px-6 text-center font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($tasks as $task): ?>
                                <?php if ($task['status'] === 'completed'): ?>
                                    <tr class="hover:bg-emerald-25 transition-colors duration-200">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center">
                                                <div class="w-3 h-3 bg-emerald-400 rounded-full mr-3"></div>
                                                <span
                                                    class="font-medium text-gray-500 line-through"><?= htmlspecialchars($task['title']) ?></span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <a href="/delete/<?= $task['id'] ?>"
                                                class="text-red-600 hover:text-red-700 font-medium hover:underline transition-colors">
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

        <!-- Bouton flottant épuré -->
        <button onclick="openModal()"
            class="fixed bottom-8 right-8 bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4 rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-300 flex items-center justify-center w-16 h-16 group">
            <i class="fa-solid fa-plus text-2xl group-hover:rotate-180 transition-transform duration-300"></i>
        </button>

        <!-- Modal avec design épuré -->
        <div id="addTaskModal"
            class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50 hidden">
            <div
                class="bg-white rounded-xl shadow-xl w-full max-w-sm mx-4 relative transform scale-95 transition-all duration-300">
                <button onclick="closeModal()"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-xl w-6 h-6 flex items-center justify-center rounded hover:bg-gray-100 transition-all">&times;</button>

                <div class="p-6">
                    <div class="text-center mb-6">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl mx-auto mb-3 flex items-center justify-center shadow-lg">
                            <i class="fas fa-plus text-white text-lg"></i>
                        </div>
                        <h1 class="text-xl font-bold text-gray-800">Nouvelle Tâche</h1>
                        <p class="text-gray-600 text-sm mt-1">Créez une nouvelle mission</p>
                    </div>

                    <form action="/add" method="post" enctype="multipart/form-data" class="space-y-4">
                        <div>
                            <label for="title" class="block text-gray-700 font-medium mb-1 text-sm">Titre</label>
                            <input type="text" id="title" name="title" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-gray-800 text-sm">
                        </div>
                        <div>
                            <label for="task" class="block text-gray-700 font-medium mb-1 text-sm">Description</label>
                            <input type="text" id="task" name="task" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-gray-800 text-sm">
                        </div>
                        <div>
                            <label for="date" class="block text-gray-700 font-medium mb-1 text-sm">Date
                                d'échéance</label>
                            <input type="date" id="date" name="date" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-gray-800 text-sm">
                        </div>
                        <div>
                            <label for="status" class="block text-gray-700 font-medium mb-1 text-sm">Statut</label>
                            <select id="status" name="status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-gray-800 text-sm">
                                <option value="pending">En attente</option>
                                <option value="in_progress">En cours</option>
                                <option value="completed">Terminée</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-2.5 rounded-lg hover:shadow-lg transform hover:scale-105 transition-all duration-200 font-medium text-sm">
                            <i class="fas fa-rocket mr-2"></i>Créer la tâche
                        </button>
                    </form>
                </div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"
        crossorigin="anonymous"></script>

    <!-- Modals d'édition avec le nouveau design épuré -->
<?php foreach ($tasks as $task): ?>
    <div id="editModal-<?= $task['id'] ?>"
        class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-sm mx-4 relative">
            <button onclick="closeEditModal(<?= $task['id'] ?>)"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-xl w-6 h-6 flex items-center justify-center rounded hover:bg-gray-100 transition-all">&times;</button>

            <div class="p-6">
                <div class="text-center mb-6">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl mx-auto mb-3 flex items-center justify-center shadow-lg">
                        <i class="fas fa-edit text-white text-lg"></i>
                    </div>
                    <h1 class="text-xl font-bold text-gray-800">Modifier la tâche</h1>
                    <p class="text-gray-600 text-sm mt-1">Mettez à jour votre mission</p>
                </div>

                <form action="/edit/<?= $task['id'] ?>" method="post" class="space-y-4">
                    <div>
                        <label for="title" class="block text-gray-700 font-medium mb-1 text-sm">Titre</label>
                        <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all text-gray-800 text-sm">
                    </div>
                    <div>
                        <label for="task" class="block text-gray-700 font-medium mb-1 text-sm">Description</label>
                        <input type="text" name="task" value="<?= htmlspecialchars($task['task']) ?>" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all text-gray-800 text-sm">
                    </div>
                    <div>
                        <label for="date" class="block text-gray-700 font-medium mb-1 text-sm">Date d'échéance</label>
                        <input type="date" name="date" value="<?= htmlspecialchars($task['date']) ?>" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all text-gray-800 text-sm">
                    </div>
                    <div>
                        <label for="status" class="block text-gray-700 font-medium mb-1 text-sm">Statut</label>
                        <select name="status" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all text-gray-800 text-sm">
                            <option value="pending" <?= $task['status'] === 'pending' ? 'selected' : '' ?>>En attente</option>
                            <option value="in_progress" <?= $task['status'] === 'in_progress' ? 'selected' : '' ?>>En cours</option>
                            <option value="completed" <?= $task['status'] === 'completed' ? 'selected' : '' ?>>Terminée</option>
                        </select>
                    </div>
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 text-white py-2.5 rounded-lg hover:shadow-lg transform hover:scale-105 transition-all duration-200 font-medium text-sm">
                        <i class="fas fa-save mr-2"></i>Mettre à jour
                    </button>
                </form>
            </div>
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