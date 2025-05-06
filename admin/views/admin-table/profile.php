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
        <div class="overflow-x-auto p-4 mt-[10vh]">
            <div class="flex space-x-6 w-full">    
                <div class="relative bg-white p-6 w-full flex rounded-lg shadow-lg transform transition ease-in-out duration-300 cursor-pointer border border-gray-200" onclick="window.location.href='table.php?type=obat&id=<?php echo $row['id']; ?>&page=<?php echo $page; ?>'">
                    <div class="w-[20%]">
                        <img src="<?= $gambar ?>" alt="Produk 1" class="aspect-[1/1] w-full object-cover mb-4 rounded-md">
                    </div>
                    <div class="relative w-[80%]">
                        <div class="ml-[3vw] mt-5">
                            <h3 class="text-xl font-semibold text-gray-800"><?= $username ?></h3>
                            <p class="text-gray-500"><?= $email ?></p> 
                        </div>
                        <div class="ml-[3vw] mb-6">
                            <p><?= $password ?></p>
                        </div>
                    </div>
                    <div class="mb-6 flex items-center absolute bottom-3 right-6">
                        <a href="#" onclick="editAdmin(<?php echo $id ?>)" class="bg-[#E7B548] p-1 hover:bg-opacity-75 text-white rounded-md mr-4">
                            <span class="hidden md:block">Edit Produk</span>
                        </a>
                        <a href="#" onclick="confirmDelete(<?=$id ?>)" class="bg-[#CB2828] p-1 hover:bg-opacity-75 text-white rounded-md">
                            <span class="hidden md:block">Hapus Produk</span>
                        </a>
                    </div>
                </div>
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
                form.action = "delete.php?profile";

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
            form.action = "edit.php?profile";

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
