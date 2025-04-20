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
                    $id_produk = $produk['id_produk'];

                    $table_varian = "detail_produk";
                    $varians = $produks->SelectVarians($id_produk);
                    foreach ($varians as $varian) {
                        $data_produk[$id_produk][$varian['id']] = [
                            "id_produk" => $id_produk,
                            "id_varian" => $varian['id'],
                            "nama_produk" => $produk['nama_produk'],
                            "varian" => $varian['varian'],
                            "harga_jual" => $varian['harga_jual'],
                            "tanggal_expired" => $varian['tanggal_expired'],
                            "gambar" => $varian['gambar'],
                            "stok" => $varian['stok'],
                            "kode_bar" => $varian['kode_bar']
                        ];
                    }
                    ?>
                    <?php foreach ($varians as $varian): ?>
                        <div class="bg-white p-6 w-[300px] flex-none rounded-lg shadow-lg transform hover:scale-105 transition ease-in-out duration-300 cursor-pointer border border-gray-200">
                            <img src="<?php echo $varian['gambar'] ?>" alt="Produk 1" class="h-[200px] w-full object-cover mb-4 rounded-md">
                            <?php
                            $kode = $varian['kode_bar'];

                            $barcode = $generator->getBarcode($kode, $generator::TYPE_CODE_128);
                            ?>
                            <h3 class="text-xl font-semibold text-center flex justify-center"><?= $barcode ?></h3>
                            <p class="text-center text-gray-800">
                                <?php echo $kode ?>
                            </p>  
                            <h3 class="text-xl font-semibold text-center text-gray-800"><?= $produk['nama_produk'] ?></h3>
                            <p class="text-center text-gray-500">
                                <?php echo $varian['varian'] ?>
                            </p>
                            <p class="text-center">Rp <?php echo number_format($varian['harga_jual'], 0, ',', '.') ?></p>
                            <div class="flex justify-evenly mt-3">
                                <a href="" class="text-[clamp(0.45rem,1vw,4rem)] p-1 hover:bg-opacity-75 rounded-md">
                                    <i class="fa-solid fa-pen-to-square text-[#1B2ED6]"></i>
                                </a>
                                <a href="#" onclick="addToCart(<?= $produk['id_produk']; ?>, <?= $varian['id']; ?>)" class="text-[clamp(0.45rem,1vw,4rem)] p-1 hover:bg-opacity-75 rounded-md">
                                    <i class="fa-solid fa-cart-shopping text-[#006E2A]"></i>
                                </a>
                                <a href="" class="text-[clamp(0.45rem,1vw,4rem)] p-1 hover:bg-opacity-75 rounded-md">
                                    <i class="fa-solid fa-trash-can text-[#FF0909]"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php endforeach ?>
            </div>
        </div>
    </div>

    <footer class="absolute bottom-0 right-0 left-0 bg-[#101018] p-6 text-center">
        <p class="text-white">&copy; 2025 Dean Bakery. All Right Reserved</p>
    </footer>

    <script>
        const data_produk = <?php echo json_encode($data_produk); ?>;
        console.log(data_produk);
        function addToCart(id_produk, id_varian) {
            let form = document.createElement("form");
            form.method = "POST";
            form.action = "keranjang.php";

            let input_id_produk = document.createElement("input");
            input_id_produk.type = "hidden";
            input_id_produk.name = "id_produk";
            input_id_produk.value = id_produk;

            let input_id_varian = document.createElement("input");
            input_id_varian.type = "hidden";
            input_id_varian.name = "id_varian";
            input_id_varian.value = id_varian;

            let nama_produk_input = document.createElement("input");
            nama_produk_input.type = "hidden";
            nama_produk_input.name = "nama_produk";
            nama_produk_input.value = data_produk[id_produk][id_varian]["nama_produk"];

            let varian_input = document.createElement("input");
            varian_input.type = "hidden";
            varian_input.name = "varian";
            varian_input.value = data_produk[id_produk][id_varian]["varian"];

            let harga_jual_input = document.createElement("input");
            harga_jual_input.type = "hidden";
            harga_jual_input.name = "harga_jual";
            harga_jual_input.value = data_produk[id_produk][id_varian]["harga_jual"];

            let tanggal_expired_input = document.createElement("input");
            tanggal_expired_input.type = "hidden";
            tanggal_expired_input.name = "tanggal_expired";
            tanggal_expired_input.value = data_produk[id_produk][id_varian]["tanggal_expired"];

            let gambar_input = document.createElement("input");
            gambar_input.type = "hidden";
            gambar_input.name = "gambar";
            gambar_input.value = data_produk[id_produk][id_varian]["gambar"];

            let stok_input = document.createElement("input");
            stok_input.type = "hidden";
            stok_input.name = "stok";
            stok_input.value = data_produk[id_produk][id_varian]["stok"];

            form.appendChild(input_id_produk);
            form.appendChild(input_id_varian);
            form.appendChild(nama_produk_input);
            form.appendChild(varian_input);
            form.appendChild(harga_jual_input);
            form.appendChild(tanggal_expired_input);
            form.appendChild(gambar_input);
            form.appendChild(stok_input);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>
