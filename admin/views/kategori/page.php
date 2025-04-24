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
    <div id="products" class="mt-10 mx-6">
        <h2 class="text-4xl font-bold text-center mb-6 text-gray-800">Daftar Kategori Produk Kami</h2>

        <!-- Container untuk produk dengan overflow-x -->
        <div class="flex justify-between mt-[5rem] items-end">
            <h3 class="text-[2.5rem] font-bold text-gray-800">Kategori</h3>
            <button class="bg-[#E7B548] px-4 py-2 rounded text-white mt-2 mr-2" onclick="window.location.href='add.php?kategori'">Tambah Kategori</button>
        </div>
        
        <div class="overflow-x-auto p-4">
            <div class="flex space-x-6 w-max">    
                <?php foreach ($kategoris_Data as $kategori): ?>
                    <div class="bg-white p-6 w-[300px] flex-none rounded-lg shadow-lg transform hover:scale-105 transition ease-in-out duration-300 cursor-pointer border border-gray-200" onclick="window.location.href='table.php?type=obat&id=<?php echo $row['id']; ?>&page=<?php echo $page; ?>'">
                        <img src="<?php echo $kategori['gambar'] ?>" alt="Produk 1" class="h-[200px] w-full object-cover mb-4 rounded-md">
                        <h3 class="text-xl font-semibold text-center text-gray-800"><?php echo $kategori['kategori'] ?></h3>
                        <?php
                        $table_produk = "produk";
                        $total_prod = $kategoris->CountProduk($kategori['id_kategori']);
                        ?>
                        <h3 class="text-md font-semibold text-center text-gray-800"><?php echo $total_prod ? $total_prod : 0 ?> Produk</h3>
                        <!-- <p class="text-center">100 Produk</p> -->
                        <div class="flex justify-evenly mt-3">
                            <a href="#" onclick="editKategori(<?=$kategori['id_kategori'] ?>)" class="text-[clamp(0.45rem,1vw,4rem)] p-3 hover:bg-opacity-75 rounded-md w-max">
                                <i class="fa-solid fa-pen-to-square text-[#1B2ED6]"></i>
                            </a>
                            <?php if ($total_prod <= 0): ?>
                            <a href="#" onclick="confirmDelete(<?=$kategori['id_kategori'] ?>)" class="text-[clamp(0.45rem,1vw,4rem)] p-3 hover:bg-opacity-75 rounded-md w-max">
                                <i class="fa-solid fa-trash-can text-[#FF0909]"></i>
                            </a>
                            <?php endif ?>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <script>
        function confirmDelete(id) {
            if (confirm("Apakah anda yakin menghapus kategori ini?")) {
                let form = document.createElement("form");
                form.method = "POST";
                form.action = "delete.php?kategori";

                let input = document.createElement("input");
                input.type = "hidden";
                input.name = "id_kategori";
                input.value = id;

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }
        function editKategori(id) {
            let form = document.createElement("form");
            form.method = "POST";
            form.action = "edit.php?kategori";

            let input = document.createElement("input");
            input.type = "hidden";
            input.name = "id_kategori";
            input.value = id;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
    <footer class="absolute bottom-0 right-0 left-0 bg-[#101018] p-6 text-center">
        <p class="text-white">&copy; 2025 Dean Bakery. All Right Reserved</p>
    </footer>
</body>
</html>
