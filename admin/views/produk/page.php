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
            background-color: #ffffff;
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
        <h2 class="text-4xl font-bold text-center mb-6 text-gray-800">Daftar Produk Kami</h2>

        <!-- Container untuk produk dengan overflow-x -->
        <div class="flex justify-between mt-[5rem] items-end">
            <h3 class="text-[2.5rem] font-bold text-gray-800">Roti</h3>
            <h3 class="text-[1.5rem] font-bold text-[#E7B548] underline"><a href="">Lihat Semuanya</a></h3>
        </div>
        
        <div class="overflow-x-auto p-4">
            <div class="flex space-x-6 w-max">
                <?php foreach ($produks_Data as $produk): ?>
                    <?php
                    $firstVarian = true;
                    $list_Harga = [];
                    $id_produk = $produk['id_produk'];

                    $table_varian = "detail_produk";
                    $varians = $produks->SelectVarian($id_produk);
                    ?>
                    <div class="bg-white p-6 w-[300px] flex-none rounded-lg shadow-lg transform hover:scale-105 transition ease-in-out duration-300 cursor-pointer border border-gray-200" onclick="window.location.href='table.php?type=obat&id=<?php echo $row['id']; ?>&page=<?php echo $page; ?>'">
                        <?php foreach ($varians as $varian): ?>
                            <?php if ($firstVarian): ?>
                                <img src="<?php echo $varian['gambar'] ?>" alt="Produk 1" class="h-[200px] w-full object-cover mb-4 rounded-md">
                                <?php
                                $firstVarian = false;
                                ?>
                            <?php endif ?>
                        <?php endforeach ?>
                        
                        <h3 class="text-xl font-semibold text-center text-gray-800">Roti Tawar</h3>
                        <p class="text-center text-gray-500">
                            <?php foreach ($varians as $varian): ?>
                                <?php echo $varian['varian'] ?>,
                            <?php endforeach ?>
                        </p>
                        <?php
                        foreach ($varians as $varian) {
                            $list_Harga[] = $varian['harga_jual']; 
                        }
                        $harga_max = max($list_Harga);
                        $harga_min = min($list_Harga);
                        ?>

                        <?php if ($harga_max == $harga_min): ?>
                            <p class="text-center">Rp <?php echo number_format($harga_min, 0, ',', '.') ?></p>
                        <?php else: ?>
                            <p class="text-center">Rp <?php echo number_format($harga_min, 0, ',', '.') ?> - <?php echo number_format($harga_max, 0, ',', '.') ?></p>
                        <?php endif ?>
                        <div class="flex justify-evenly mt-3">
                            <a href="" class="text-[clamp(0.45rem,1vw,4rem)] p-1 hover:bg-opacity-75 rounded-md">
                                <i class="fa-solid fa-pen-to-square text-[#1B2ED6]"></i>
                            </a>
                            <a href="" class="text-[clamp(0.45rem,1vw,4rem)] p-1 hover:bg-opacity-75 rounded-md">
                                <i class="fa-solid fa-cart-shopping text-[#006E2A]"></i>
                            </a>
                            <a href="" class="text-[clamp(0.45rem,1vw,4rem)] p-1 hover:bg-opacity-75 rounded-md">
                                <i class="fa-solid fa-trash-can text-[#FF0909]"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    
    <footer class="absolute bottom-0 right-0 left-0 bg-[#101018] p-6 text-center">
        <p class="text-white">&copy; 2025 Dean Bakery. All Right Reserved</p>
    </footer>
</body>
</html>
