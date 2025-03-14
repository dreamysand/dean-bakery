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
        <h2 class="text-4xl font-bold text-center mb-6 text-gray-800">Daftar Keranjang</h2>

        <!-- Container untuk produk dengan overflow-x -->
        <div class="flex justify-between mt-[5rem] items-end">
            <h3 class="text-[2.5rem] font-bold text-gray-800">Keranjang</h3>
            <h3 class="text-[1.5rem] font-bold text-[#E7B548] underline"><a href="">Lihat Semuanya</a></h3>
        </div>
        
        <div class="overflow-x-auto p-4">
            <?php foreach ($cart_Data as $id_produk => $data_produk): ?>
                <?php foreach ($data_produk as $id_varian => $data_varian): ?>
                    <div class="flex space-x-6 w-full mb-3">    
                        <div class="relative bg-white p-6 w-full flex rounded-lg shadow-lg transform transition ease-in-out duration-300 cursor-pointer border border-gray-200" onclick="window.location.href='table.php?type=obat&id=<?php echo $row['id']; ?>&page=<?php echo $page; ?>'">
                            <div class="w-[20%]">
                                <img src="<?= $data_varian['gambar'] ?>" alt="Produk 1" class="aspect-[1/1] w-full object-cover mb-4 rounded-md">
                            </div>
                            <div class="relative w-[80%]">
                                <div class="ml-[3vw] mt-5">
                                    <h3 class="text-xl font-semibold text-gray-800"><?= $data_varian['nama_produk'] ?></h3>
                                    <p class="text-gray-500"><?= $data_varian['varian'] ?></p> 
                                </div>
                                <div class="ml-[3vw] mb-6">
                                    <p id="price<?=$data_varian['id_produk']?><?=$data_varian['id_varian']?>">Rp <?php echo number_format($data_varian['harga_jual']*$data_varian['jumlah'], 0, ',', '.');  ?></p>
                                    <label for="jumlah_pembelian">Jumlah Pembelian</label>
                                    <input onchange="updateData(<?= $data_varian['id_produk'] ?>, <?= $data_varian['id_varian'] ?>, <?= $data_varian['harga_jual'] ?>)" type="number" id="jumlah_pembelian<?=$data_varian['id_produk']?><?=$data_varian['id_varian']?>" min="1" name="jumlah_pembelian" class="w-[5%] border border-black rounded" value="<?= $data_varian['jumlah'] ?>">
                                </div>
                            </div>
                            <div class="mb-6 flex items-center absolute right-6">
                                <input class="mr-2" type="checkbox" id="safety_quest" name="safety_quest">
                                <label class="text-sm" for="safety_quest">Pilih</label>
                            </div>
                            <div class="mb-6 flex items-center absolute bottom-3 right-6">
                                <p class="mr-4 countdown">Countdown: 90 Detik</p>
                                <a href="#" onclick="confirmDelete(<?= $data_varian['id_produk'] ?>, <?= $data_varian['id_varian'] ?>)" class="text-[clamp(0.45rem,1vw,4rem)] p-1 hover:bg-opacity-75 rounded-md">
                                    <i class="fa-solid fa-trash-can text-[#FF0909]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endforeach ?>
        </div>
    </div>
    
    <footer class="absolute bottom-0 right-0 left-0 bg-[#101018] p-6 text-center">
        <p class="text-white">&copy; 2025 Dean Bakery. All Right Reserved</p>
    </footer>

    <script>
        let target_time = new Date().getTime() + 30000;
        let countdownInterval;
        const cart_data = <?php echo json_encode($data_produk); ?>;
        const length_cart_data = Object.keys(cart_data).length;

        function updateCountdown() {
            let now = new Date().getTime();
            let remaining_time = Math.max((target_time - now) / 1000, 0).toFixed();
            const countdowns = document.getElementsByClassName("countdown");
            if (remaining_time > 0) {
                for (let i = 0; i < countdowns.length; i++) {
                countdowns[i].textContent = `Countdown: ${remaining_time} Detik`;
            }
            } else {
                clearInterval(countdownInterval);
                window.location.href = "keranjang.php?delete_all";
            }
        }

        function startCountdown() {
            clearInterval(countdownInterval);
            updateCountdown();
            setInterval(updateCountdown, 1000);
        }

        function resetCountdown() {
            target_time = new Date().getTime() + 30000;
            startCountdown();
        }

        function confirmDelete(id_produk, id_varian) {
            if (confirm("Apakah anda yakin menghapus produk ini dari keranjang?")) {
                let form = document.createElement("form");
                form.method = "POST";
                form.action = "keranjang.php?delete";

                let input_id_produk = document.createElement("input");
                input_id_produk.type = "hidden";
                input_id_produk.name = "id_produk";
                input_id_produk.value = id_produk;

                let input_id_varian = document.createElement("input");
                input_id_varian.type = "hidden";
                input_id_varian.name = "id_varian";
                input_id_varian.value = id_varian;

                form.appendChild(input_id_produk);
                form.appendChild(input_id_varian);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function updateData(id_produk, id_varian, default_price) {
            const value = parseInt(document.getElementById(`jumlah_pembelian${id_produk}${id_varian}`).value);
            const price = document.getElementById(`price${id_produk}${id_varian}`);

            if (value > 0) {
                let new_price = value*default_price;
                new_price = new_price.toLocaleString('id-ID'); 
                price.textContent = `Rp ${new_price}`;
            } else {
                let new_price = 0;
                new_price = new_price.toLocaleString('id-ID'); 
                price.textContent = `Rp ${new_price}`;
            }

            resetCountdown();
        }

        if (cart_data && Object.keys(cart_data).length > 0) {
            startCountdown();
        }

        if (Object.keys(cart_data).length > length_cart_data) {
            resetCountdown();
        }
    </script>
</body>
</html>
