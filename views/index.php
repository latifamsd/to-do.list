<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="icon" href="./img/logo-todo.png" type="image/png" sizes="512x512">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100 font-sans">
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    ?>

    <div class="container mx-auto px-6 py-10">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800">Task List</h1>
            <?php if (isset($_SESSION['id'])): ?>
                <a href="/logout"
                    class="bg-red-500 text-white py-2 px-5 rounded-lg shadow-lg hover:bg-red-600 transition duration-200">
                    Logout
                </a>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Tasks To Do Section -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">To Do</h2>
                <table class="w-full">
                    <thead>
                        <tr class="bg-blue-500 text-white">
                            <th class="py-3 px-4 text-left">Title</th>
                            <th class="py-3 px-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                            <?php if (isset($task['status']) && $task['status'] === 'pending'): ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4"> <?= htmlspecialchars($task['title']) ?> </td>
                                    <td class="py-3 px-4 text-center">
                                        <a onclick='openEditModal(<?= json_encode($task) ?>)'
                                            class="text-blue-500 hover:underline">Edit</a> |
                                        <a href="/delete/<?= $task['id'] ?>" class="text-red-500 hover:underline">Delete</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tasks In Progress Section -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">In Progress</h2>
                <table class="w-full">
                    <thead>
                        <tr class="bg-yellow-500 text-white">
                            <th class="py-3 px-4 text-left">Title</th>
                            <th class="py-3 px-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                            <?php if ($task['status'] === 'in_progress'): ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4"> <?= htmlspecialchars($task['title']) ?> </td>
                                    <td class="py-3 px-4 text-center">
                                        <button onclick="openEditModal(<?= $task['id'] ?>)"
                                            class="text-blue-600 hover:underline">Edit</button>
                                        <a href="/delete/<?= $task['id'] ?>" class="text-red-500 hover:underline">Delete</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Completed Tasks Section -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Completed</h2>
                <table class="w-full">
                    <thead>
                        <tr class="bg-green-500 text-white">
                            <th class="py-3 px-4 text-left">Title</th>
                            <th class="py-3 px-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                            <?php if ($task['status'] === 'completed'): ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4"> <?= htmlspecialchars($task['title']) ?> </td>
                                    <td class="py-3 px-4 text-center">
                                        <a href="/delete/<?= $task['id'] ?>" class="text-red-500 hover:underline">Delete</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bouton flottant -->
        <a href="#" onclick="openModal()"
            class="fixed bottom-6 right-6 bg-blue-500 text-white p-4 rounded-full shadow-lg hover:bg-blue-600 transition duration-200 flex items-center justify-center w-16 h-16">
            <i class="fa-solid fa-circle-plus text-2xl"></i>
        </a>

        <!-- Modal -->
        <div id="addTaskModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md relative">
                <!-- Bouton de fermeture -->
                <button onclick="closeModal()"
                    class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-2xl">&times;</button>

                <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Add Task</h1>
                <form action="/add" method="post" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 font-semibold mb-2">Task Title</label>
                        <input type="text" id="title" name="title" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div class="mb-4">
                        <label for="task" class="block text-gray-700 font-semibold mb-2">Task</label>
                        <input type="text" id="task" name="task" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div class="mb-4">
                        <label for="date" class="block text-gray-700 font-semibold mb-2">Date</label>
                        <input type="date" id="date" name="date" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div class="mb-4">
                        <label for="status" class="block text-gray-700 font-semibold mb-2">Status</label>
                        <select id="status" name="status" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Processing</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-200">
                        Add Task
                    </button>
                </form>
            </div>
        </div>

        <!-- JavaScript -->
        <script>
            function openModal() {
                document.getElementById('addTaskModal').classList.remove('hidden');
            }
            function closeModal() {
                document.getElementById('addTaskModal').classList.add('hidden');
            }
        </script>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"
        crossorigin="anonymous"></script>

    <!-- Exemple de boucle sur les tâches dans index.php -->
    <?php foreach ($tasks as $task): ?>
        <!-- Bouton Edit -->

        <!-- Popup Edit Modal -->
        <div id="editModal-<?= $task['id'] ?>"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md relative">
                <button onclick="closeEditModal(<?= $task['id'] ?>)"
                    class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-2xl">&times;</button>
                <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Task</h1>
                <form action="/edit/<?= $task['id'] ?>" method="post">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 font-semibold mb-2">Task Title</label>
                        <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div class="mb-4">
                        <label for="task" class="block text-gray-700 font-semibold mb-2">Task</label>
                        <input type="text" name="task" value="<?= htmlspecialchars($task['task']) ?>" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div class="mb-4">
                        <label for="date" class="block text-gray-700 font-semibold mb-2">Date</label>
                        <input type="date" name="date" value="<?= htmlspecialchars($task['date']) ?>" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div class="mb-4">
                        <label for="status" class="block text-gray-700 font-semibold mb-2">Status</label>
                        <select name="status" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="pending" <?= $task['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="in_progress" <?= $task['status'] === 'in_progress' ? 'selected' : '' ?>>In
                                Processing</option>
                            <option value="completed" <?= $task['status'] === 'completed' ? 'selected' : '' ?>>Completed
                            </option>
                        </select>
                    </div>
                    <button type="submit"
                        class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition duration-200">
                        Update Task
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