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
            <div class="mb-6 flex items-center absolute right-6 bg-[#E7B548] px-4 py-2 rounded text-white mt-2 mr-2">
              <form method="GET" action="" class="flex items-center space-x-2 text-sm text-white">
                <!-- id_kategori -->
                <?php
                $table = "kategori";
                $kategori = new Kategori();
                $list_kategori = $kategori->SelectKategoris();
                ?>
                <label for="id_kategori" class="mr-1">Kategori:</label>
                <select name="id_kategori" id="id_kategori" class="text-black rounded px-1 py-1">
                    <option value="" selected>Pilih Kategori</option>
                    <?php foreach ($list_kategori as $kategori): ?>
                        <option value="<?php echo $kategori['id_kategori'] ?>"><?php echo $kategori['kategori'] ?></option>
                    <?php endforeach ?>
                </select>
                <!-- Tombol -->
                <button type="submit" class="ml-3 bg-white text-[#E7B548] px-3 py-1 rounded hover:bg-gray-200">Tampilkan</button>
                <button type="button" onclick="window.location.href='produk.php'" class="ml-3 bg-white text-[#E7B548] px-3 py-1 rounded hover:bg-gray-200">Reset</button>
              </form>
            </div>
            <button type="button" onclick="window.location.href='add.php?produk'" class="ml-3 bg-[#E7B548] text-white px-3 py-1 rounded">Tambah Produk</button>

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
                        <div class="bg-white p-6 w-[300px] flex-none rounded-lg shadow-lg transform hover:scale-105 transition ease-in-out duration-300 border border-gray-200">
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
                            <p class="text-center text-gray-800">Expired : <?php echo $varian['tanggal_expired']; ?></p>
                            <div class="flex justify-center items-center space-x-2 my-2">
                                <button onclick="updateStok(<?= $produk['id_produk'] ?>, <?= $varian['id'] ?>, -1)" class="bg-gray-200 hover:bg-gray-300 text-black px-2 py-1 rounded-md text-lg">-</button>
                                <span data-stok data-id-produk="<?php echo $produk['id_produk'] ?>" data-id-varian="<?php echo $varian['id'] ?>" id="stok_<?= $varian['id'] ?>" class="text-lg font-semibold text-gray-800"><?php echo $varian['stok']; ?></span>
                                <button onclick="updateStok(<?= $produk['id_produk'] ?>, <?= $varian['id'] ?>, 1)" class="bg-gray-200 hover:bg-gray-300 text-black px-2 py-1 rounded-md text-lg">+</button>
                            </div>
                            <?php if (date("Y-m-d") > $varian['tanggal_expired']): ?>
                                <p class="text-center text-red-800">Expired</p>
                                <div class="flex justify-evenly mt-3 relative z-[900]">
                                    <a href="#" onclick="editProduk(<?php echo $produk['id_produk'] ?>, <?php echo $varian['id'] ?>)" class="text-[clamp(0.45rem,1vw,4rem)] p-1 hover:bg-opacity-75 rounded-md">
                                        <i class="fa-solid fa-pen-to-square text-[#1B2ED6]"></i>
                                    </a>
                                    <a href="#" class="text-[clamp(0.45rem,1vw,4rem)] p-1 hover:bg-opacity-75 rounded-md">
                                        <i class="fa-solid fa-trash-can text-[#FF0909]"></i>
                                    </a>
                                    <a href="detail-produk.php?id_produk=<?php echo $produk['id_produk'] ?>&id_varian=<?php echo $varian['id'] ?>" class="text-[clamp(0.45rem,1vw,4rem)] p-1 hover:bg-opacity-75 rounded-md">
                                        <i class="fa-solid fa-circle-info text-[#000000]"></i>
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="flex justify-evenly mt-3">
                                    <a href="#" onclick="editProduk(<?php echo $produk['id_produk'] ?>, <?php echo $varian['id'] ?>)" class="text-[clamp(0.45rem,1vw,4rem)] p-1 hover:bg-opacity-75 rounded-md">
                                        <i class="fa-solid fa-pen-to-square text-[#1B2ED6]"></i>
                                    </a>
                                    <?php if ($varian['stok'] > 0): ?>
                                    <a href="#" data-cart-btn data-id-produk='<?php echo $produk['id_produk'] ?>' data-id-varian='<?php echo $varian['id'] ?>' onclick="addToCart(<?= $produk['id_produk']; ?>, <?= $varian['id']; ?>)" class="text-[clamp(0.45rem,1vw,4rem)] p-1 hover:bg-opacity-75 rounded-md">
                                        <i class="fa-solid fa-cart-shopping text-[#006E2A]"></i>
                                    </a>
                                    <?php endif ?>
                                    <?php if ($varian['stok'] <= 0): ?>
                                    <a href="#" onclick="confirmDelete(<?php echo $produk['id_produk'] ?>, <?php echo $varian['id_varian'] ?>)" class="text-[clamp(0.45rem,1vw,4rem)] p-1 hover:bg-opacity-75 rounded-md">
                                        <i class="fa-solid fa-trash-can text-[#FF0909]"></i>
                                    </a>
                                    <?php endif ?>
                                    <a href="detail-produk.php?id_produk=<?php echo $produk['id_produk'] ?>&id_varian=<?php echo $varian['id'] ?>" class="text-[clamp(0.45rem,1vw,4rem)] p-1 hover:bg-opacity-75 rounded-md">
                                        <i class="fa-solid fa-circle-info text-[#000000]"></i>
                                    </a>
                                </div>
                            <?php endif ?>
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
        
        function checkStok() {
            const stokSpans = document.querySelectorAll(`span[data-stok][data-id-produk][data-id-varian]`);
            stokSpans.forEach((span) => {
                const id_produk = span.getAttribute('data-id-produk');
                const id_varian = span.getAttribute('data-id-varian');
                const cartbtn = document.querySelector(`a[data-cart-btn][data-id-produk='${id_produk}'][data-id-varian='${id_varian}']`);
                if (!cartbtn) return;

                if (span.innerText <= 0) {
                    cartbtn.classList.add("hidden");
                } else {
                    cartbtn.classList.remove("hidden");
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            checkStok();

            const targetNode = document.getElementById("products");

            const observer = new MutationObserver(() => {
                checkStok();
            });

            observer.observe(targetNode, {
                childList: true,
                subtree: true,
                characterData: true,
            });
        });
        function updateStok(id_produk, id_varian, change) {
            const stokSpan = document.querySelector(`span[data-stok][data-id-produk='${id_produk}'][data-id-varian='${id_varian}']`);
            let currentStok = parseInt(stokSpan.innerText);

            if (change === -1 && currentStok <= 0) return;

            const newStok = currentStok + change;
            stokSpan.innerText = newStok;

            const formData = new FormData();
            formData.append("id_produk", id_produk);
            formData.append("id_varian", id_varian);
            formData.append("stok", newStok);

            fetch('produk.php?updatestok', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                console.log("ping");
            })
            .catch(error => {
                console.error("Error:", error);
            });
        }
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
        function confirmDelete(id, idv) {
            if (confirm("Apakah anda yakin menghapus produk ini?")) {
                let form = document.createElement("form");
                form.method = "POST";
                form.action = "delete.php?produk";

                let input = document.createElement("input");
                input.type = "hidden";
                input.name = "id_produk";
                input.value = id;

                let input_var = document.createElement("input");
                input_var.type = "hidden";
                input_var.name = "id_varian";
                input_var.value = idv;

                form.appendChild(input);
                form.appendChild(input_var);
                document.body.appendChild(form);
                form.submit();
            }
        }
        function editProduk(id, idv) {
            let form = document.createElement("form");
            form.method = "POST";
            form.action = "edit.php?produk";

            let input = document.createElement("input");
            input.type = "hidden";
            input.name = "id_produk";
            input.value = id;

            let input_var = document.createElement("input");
            input_var.type = "hidden";
            input_var.name = "id_varian";
            input_var.value = idv;

            form.appendChild(input);
            form.appendChild(input_var);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>
