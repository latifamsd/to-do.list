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
                <a href="/logout" class="bg-red-500 text-white py-2 px-5 rounded-lg shadow-lg hover:bg-red-600 transition duration-200">
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
                                    <a href="/edit/<?= $task['id'] ?>" class="text-blue-500 hover:underline">Edit</a> |
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
                                    <a href="/edit/<?= $task['id'] ?>" class="text-blue-500 hover:underline">Edit</a> |
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

        <!-- Floating Add Button with FontAwesome Icon -->
        <a href="/add" class="fixed bottom-6 right-6 bg-blue-500 text-white p-4 rounded-full shadow-lg hover:bg-blue-600 transition duration-200 flex items-center justify-center w-16 h-16">
            <i class="fa-solid fa-circle-plus text-2xl"></i>
        </a>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>

</body>
</html>
