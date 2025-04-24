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
                <div class="relative bg-white p-6 w-full flex rounded-lg shadow-lg transform transition ease-in-out duration-300 border border-gray-200">
                    <div class="w-[20%]">
                        <img src="<?php echo $varian_Data['gambar'] ?>" alt="<?php echo $produk_Data['id_produk'].$varian_Data['id'] ?>" class="aspect-[1/1] w-full object-cover mb-4 rounded-md">
                    </div>
                    <div class="relative w-[80%]">
                        <div class="ml-[3vw] mt-5">
                            <h3 class="text-xl font-semibold text-gray-800"><?php echo $produk_Data['nama_produk'] ?></h3>
                            <p class="text-gray-500"><?php echo $varian_Data['varian'] ?></p> 
                        </div>
                        <div class="ml-[3vw] mb-6">
                            <p>Rp <?php echo number_format($varian_Data['harga_jual'], 0, ',', '.') ?></p>
                            <p>Stok : <?php echo $varian_Data['stok'] ?></p>
                        </div>
                        <div class="ml-[3vw] w-[40%]">
                            <p><?php echo $produk_Data['deskripsi'] ?></p>
                        </div>
                        <div class="ml-[3vw] w-[40%] mt-5">
                            <?php
                            $kode = $varian_Data['kode_bar'];

                            $barcode = $generator->getBarcode($kode, $generator::TYPE_CODE_128);
                            ?>
                            <h3 class="text-xl font-semibold"><?= $barcode ?></h3>
                            <p class="text-gray-800">
                                <?php echo $kode ?>
                            </p>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="absolute bottom-0 right-0 left-0 bg-[#101018] p-6 text-center">
        <p class="text-white">&copy; 2025 Dean Bakery. All Right Reserved</p>
    </footer>
</body>
</html>
