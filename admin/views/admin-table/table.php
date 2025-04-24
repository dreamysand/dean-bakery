<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="icon" type="image/png" href="assets/logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/c2a393db2e.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            background-color: #F9EFDA;
        }
    </style>
</head>
<body class="relative min-h-screen pb-[200px]">
    <!-- Navbar -->
    <?php include '../views/layout/navbar.php'; ?>

    <!-- Hero Section with Parallax -->
    <div class="bg-fixed bg-no-repeat bg-center h-3/4 bg-cover" style="background-image: url('../assets/background.jpg')">
        <div class="flex items-center justify-center h-full bg-black bg-opacity-50">
            <div class="text-center text-white">
                <h1 class="text-5xl font-bold mb-4">Halo Admin</h1>
                <p class="text-xl mb-8">Dean Bakery adalah toko roti yang terbaik di dunia.</p>
            </div>
        </div>
    </div>

    <!-- Produk Section -->
    <div id="products" class="mt-10 mx-6 relative">
        <h2 class="text-4xl font-bold text-center mb-6 text-gray-800">Daftar Admin Kami</h2>
        <div class="mb-6 flex items-center absolute top-3 right-6">
            <button class="bg-[#E7B548] px-4 py-2 rounded text-white mt-2 mr-2" onclick="window.location.href='register-admin.php'">Tambah Admin</button>
        </div>
        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
        <table class="min-w-full text-left text-gray-800 text-center text-wrap">
            <thead class="bg-[#E7B548] text-white">
                <tr>
                    <th class="px-2 py-2 border border-gray-300 font-medium text-[clamp(0.45rem,1vw,1rem)]">ID</th>
                    <th class="px-2 py-2 border border-gray-300 font-medium text-[clamp(0.45rem,1vw,1rem)]">Username</th>
                    <th class="px-2 py-2 border border-gray-300 font-medium text-[clamp(0.45rem,1vw,1rem)]">Email</th>
                    <th class="px-2 py-2 border border-gray-300 font-medium text-[clamp(0.45rem,1vw,1rem)]">Password</th>
                    <th class="px-2 py-2 border border-gray-300 font-medium text-[clamp(0.45rem,1vw,1rem)]">Status</th>
                    <th class="px-2 py-2 border border-gray-300 font-medium text-[clamp(0.45rem,1vw,1rem)]">Last Activity</th>
                    <th class="px-2 py-2 border border-gray-300 font-medium text-[clamp(0.45rem,1vw,1rem)]">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admins_Data as $admin): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)]"><?= $admin['id']?></td>
                        <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)]"><?= $admin['username']?></td>
                        <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)]"><?= $admin['email']?></td>
                        <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)]"><?= $admin['password']?></td>
                        <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)]"><?= $admin['status']?></td>
                        <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)]"><?= $admin['last_login']?></td>
                        <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)] flex justify-evenly">
                            <a href="#" onclick="editAdmin(<?=$admin['id'] ?>)" class="text-[clamp(0.45rem,1vw,4rem)] p-3 hover:bg-opacity-75 rounded-md w-max">
                                <i class="fa-solid fa-pen-to-square text-[#1B2ED6]"></i>
                            </a>
                            <a href="#" onclick="confirmDelete(<?=$admin['id'] ?>)" class="text-[clamp(0.45rem,1vw,4rem)] p-3 hover:bg-opacity-75 rounded-md w-max">
                                <i class="fa-solid fa-trash-can text-[#FF0909]"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <div class="w-full flex justify-center">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i ?>" class="px-2 py-1 border <?php echo $i == $page ? 'bg-[#E7B548] text-white' : '' ?>">
                <?php echo $i ?>
            </a>
        <?php endfor; ?>
        </div>
        </div>
    </div>
    
    <footer class="absolute bottom-0 right-0 left-0 bg-[#101018] p-6 text-center">
        <p class="text-white">&copy; 2025 Dean Bakery. All Right Reserved</p>
    </footer>

    <script>
        function confirmDelete(id) {
            if (confirm("Apakah anda yakin menghapus admin ini?")) {
                let form = document.createElement("form");
                form.method = "POST";
                form.action = "delete.php?admin";

                let input = document.createElement("input");
                input.type = "hidden";
                input.name = "id_admin";
                input.value = id;

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }
        function editAdmin(id) {
            let form = document.createElement("form");
            form.method = "POST";
            form.action = "edit.php?admin";

            let input = document.createElement("input");
            input.type = "hidden";
            input.name = "id_admin";
            input.value = id;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>
