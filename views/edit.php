<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Favicon avec plusieurs tailles -->
    <link rel="icon" href="./img/logo-todo.png" type="image/png" sizes="32x32">
    <link rel="icon" href="./img/logo-todo.png" type="image/png" sizes="16x16">
    <link rel="icon" href="./img/logo-todo.png" type="image/png" sizes="48x48">
    <link rel="icon" href="./img/logo-todo.png" type="image/png" sizes="96x96">
    <link rel="icon" href="./img/logo-todo.png" type="image/png" sizes="192x192">
    <link rel="icon" href="./img/logo-todo.png" type="image/png" sizes="512x512">

    <title>Edit Task</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Task</h1>
            <form action="/edit/<?= $task['id'] ?>" method="post">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-semibold mb-2">Task Title</label>
                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($task['title']) ?>" required 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div class="mb-4">
                    <label for="task" class="block text-gray-700 font-semibold mb-2">Task</label>
                    <input type="text" id="task" name="task" value="<?= htmlspecialchars($task['task']) ?>" required 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div class="mb-4">
                    <label for="date" class="block text-gray-700 font-semibold mb-2">Date</label>
                    <input type="date" id="date" name="date" value="<?= htmlspecialchars($task['date']) ?>" required 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-gray-700 font-semibold mb-2">Status</label>
                    <select id="status" name="status" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="pending" <?= $task['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="in_progress" <?= $task['status'] == 'in_progress' ? 'selected' : '' ?>>In Processing</option>
                        <option value="completed" <?= $task['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                    </select>
                </div>
                <button type="submit" 
                    class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition duration-200">
                    Update Task
                </button>
            </form>
        </div>
    </div>

</body>
</html>
