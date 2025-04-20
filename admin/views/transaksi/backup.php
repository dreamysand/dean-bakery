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

    <!-- Produk Section -->
    <div id="products" class="mt-[10vh] mx-6">
        <div class="overflow-x-auto p-4">
            <div class="mx-auto mt-10 p-6 bg-white rounded-lg shadow-lg">
                <h2 class="text-center text-[2.5rem] font-bold mb-4">TRANSAKSI</h2>

                <!-- Tabel -->
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-[#E7B548] text-white">
                                <th class="border border-gray-300 px-4 py-2">Nama Produk</th>
                                <th class="border border-gray-300 px-4 py-2">Varian</th>
                                <th class="border border-gray-300 px-4 py-2">Jumlah</th>
                                <th class="border border-gray-300 px-4 py-2">Harga</th>
                                <th class="border border-gray-300 px-4 py-2">Tanggal</th>
                                <th class="border border-gray-300 px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody id="transactions">
                            <?php if (!empty($transaksi_Data)): ?>
                                <?php foreach ($transaksi_Data as $id_produk => $varians): ?>
                                    <?php foreach ($varians as $id_varian => $transaksi): ?>
                                        <tr data-id-transaksi="">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <select class="w-full px-3 py-2" type="password" id="id_produk" name="id_produk" required readonly>
                                                    <option value="<?php echo $transaksi['id_produk'] ?>" readonly><?php echo $transaksi['nama_produk'] ?></option>
                                                </select>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <select class="w-full px-3 py-2" type="password" id="id_varian" name="id_varian" required readonly>
                                                    <option value="<?php echo $transaksi['id_varian'] ?>" readonly selected><?php echo $transaksi['varian'] ?></option>
                                                </select>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <input type="number" id="jumlah" name="jumlah" class="w-full px-3 py-2" value="<?php echo $transaksi['jumlah'] ?>" required readonly min="0">
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <input type="number" id="harga" name="harga" data-harga-id-transaksi="" value="<?php echo $transaksi['subtotal'] ?>" class="w-full px-3 py-2" required readonly>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <input type="date" id="date" value="<?php echo date('Y-m-d'); ?>" name="date" class="w-full px-3 py-2" required readonly>
                                            </td>
                                            <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)] flex justify-evenly">
                                                <a href="edit.php?id_admin=<?= $admin['f_id'] ?>" class="text-[clamp(0.45rem,1vw,4rem)] p-3 hover:bg-opacity-75 rounded-md w-max">
                                                    <i class="fa-solid fa-pen-to-square text-[#1B2ED6]"></i>
                                                </a>
                                                <a href="#" onclick="confirmDelete(<?=$admin['f_id'] ?>)" class="text-[clamp(0.45rem,1vw,4rem)] p-3 hover:bg-opacity-75 text-white rounded-md w-max">
                                                    <i class="fa-solid fa-trash-can text-[#FF0909]"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endforeach ?>
                            <?php endif ?>
                            <tr data-id-transaksi="">
                                <td class="border border-gray-300 px-4 py-2">
                                    <select class="w-full px-3 py-2" type="password" id="id_produk" name="id_produk" required onchange="UpdateIdProduk(this); ChangeVarian(this);">
                                        <?php
                                        $table_produk = "produk";
                                        $table_varian = "detail_produk";
                                        $produk = new Produk();
                                        $produks = $produk->SelectProduks();
                                        ?>
                                        <option value="" disabled selected>Pilih Produk</option>
                                        <?php foreach ($produks as $produk_data): ?>
                                            <?php
                                            $varians = $produk->SelectVarians($produk_data['id_produk']);
                                            foreach ($varians as $varian) {
                                                $data_produk[$produk_data['id_produk']][$varian['id']] = [
                                                    "id_varian" => $varian['id'],
                                                    "varian" => $varian['varian'],
                                                    "harga_jual" => $varian['harga_jual'],
                                                ]; 
                                            }
                                            print_r($data_produk);
                                            ?>
                                        <option value="<?php echo $produk_data['id_produk'] ?>"><?php echo $produk_data['nama_produk'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <select class="w-full px-3 py-2" type="password" id="id_varian" name="id_varian" required onchange="UpdateIdVarian(this); GetValue();">
                                        <option value="" disabled selected>Pilih Varian</option>

                                    </select>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="number" id="jumlah" name="jumlah" class="w-full px-3 py-2" required onchange="UpdateHarga()" min="0">
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="number" id="harga" name="harga" data-harga-id-transaksi="" class="w-full px-3 py-2" required readonly>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="date" id="date" value="" name="date" class="w-full px-3 py-2" required readonly>
                                </td>
                                <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)] flex justify-evenly">
                                    <a href="edit.php?id_admin=<?= $admin['f_id'] ?>" class="text-[clamp(0.45rem,1vw,4rem)] p-3 hover:bg-opacity-75 rounded-md w-max">
                                        <i class="fa-solid fa-pen-to-square text-[#1B2ED6]"></i>
                                    </a>
                                    <a href="#" onclick="confirmDelete(<?=$admin['f_id'] ?>)" class="text-[clamp(0.45rem,1vw,4rem)] p-3 hover:bg-opacity-75 text-white rounded-md w-max">
                                        <i class="fa-solid fa-trash-can text-[#FF0909]"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <button class="bg-yellow-500 text-white px-4 py-2 mt-4 rounded-lg hover:bg-yellow-600" id="add_transaction">Tambah</button>

                <!-- Form Transaksi -->
                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div>
                        <label class="block font-medium">METODE PEMBAYARAN</label>
                        <select name="" id="" class="w-full border p-2 rounded">
                            <option value="">BIPANG</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium">ID MEMBER</label>
                        <select name="" id="" class="w-full border p-2 rounded">
                            <option value="">BIPANG</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium">TOTAL HARGA</label>
                        <input type="number" value="0" class="w-full border p-2 rounded" id="total_harga">
                    </div>
                    <div>
                        <label class="block font-medium">POTONGAN HARGA</label>
                        <input type="text" class="w-full border p-2 rounded">
                    </div>
                    <div>
                        <label class="block font-medium">UANG BAYAR</label>
                        <input type="text" class="w-full border p-2 rounded">
                    </div>
                    <div>
                        <label class="block font-medium">KEMBALIAN</label>
                        <input type="text" class="w-full border p-2 rounded">
                    </div>
                </div>

                <button class="bg-yellow-500 text-white px-4 py-2 mt-6 rounded-lg hover:bg-yellow-600 w-full">Bayar</button>
            </div>
        </div>
    </div>
    
    <footer class="absolute bottom-0 right-0 left-0 bg-[#101018] p-6 text-center">
        <p class="text-white">&copy; 2025 Dean Bakery. All Right Reserved</p>
    </footer>

    <script>
        const varian_data = <?php echo json_encode($data_produk); ?>;
        function ChangeVarian(element) {
            const row = event.target.closest("tr");
            const select_varian = row.querySelector("select[id='id_varian']");
            const id_produk = element.getAttribute("data-id-produk");

            select_varian.innerHTML = '<option value="" disabled selected>Pilih Varian</option>';
            Object.keys(varian_data[id_produk]).forEach(key => {
                const varian = varian_data[id_produk][key];

                const varian_option = document.createElement("option");
                varian_option.value = varian.id_varian;
                varian_option.innerText = varian.varian;

                select_varian.appendChild(varian_option);
            })
        }

        function UpdateIdProduk(element) {
            element.setAttribute("data-id-produk", element.value);
        }

        function UpdateIdVarian(element) {
            element.setAttribute("data-id-varian", element.value);
        }

        function AddToTransaksi() {
            
        }

        function GetValue() {
            const row = event.target.closest("tr");
            const id_produk = row.querySelector("select[data-id-produk]").value;
            const id_varian = row.querySelector("select[data-id-varian]").value;
            const jumlah = row.querySelector("td #jumlah");
            const harga = row.querySelector("input[data-harga-id-transaksi]");
            const date = row.querySelector("td #date");
            if (
                id_produk &&
                id_varian
                ) {
                jumlah.value = jumlah.value != null ? jumlah.value : 1;

                harga.value = harga.value != null ? harga.value : varian_data[id_produk][id_varian]['harga_jual'];
                date.valueAsDate = new Date();

                UpdateTotalHarga();
            }   
        }

        function UpdateHarga() {
            const row = event.target.closest("tr");
            const id_produk = row.querySelector("select[data-id-produk]").value;
            const id_varian = row.querySelector("select[data-id-varian]").value;
            const jumlah = row.querySelector("td #jumlah").value;
            const harga = row.querySelector("input[data-harga-id-transaksi]");

            let harga_jual = varian_data[id_produk][id_varian]['harga_jual'];

            console.log(jumlah);
            console.log(harga_jual);
            harga.value = jumlah * harga_jual;

            UpdateTotalHarga();
        }

        function UpdateIdRowTransaksi() {
            const tr_transaksi = document.querySelectorAll("tr[data-id-transaksi]");
            const td_harga = document.querySelectorAll("input[data-harga-id-transaksi]");

            tr_transaksi.forEach((row, key) => {
                row.setAttribute("data-id-transaksi", key+1);
            });
            td_harga.forEach((row, key) => {
                row.setAttribute("data-harga-id-transaksi", key+1);
            });
        }

        function UpdateTotalHarga() {
            const harga_cols = document.querySelectorAll("input[data-harga-id-transaksi]");
            const total_harga = document.querySelector("#total_harga");

            let total = 0;
            harga_cols.forEach(row => {
                total += Number(row.value);
            });

            total_harga.value = parseInt(total);
        }

        document.getElementById('add_transaction').addEventListener("click", () => {
            const table_body = document.getElementById("transactions");
            const tr = document.querySelector("#transactions tr");

            const new_row = document.createElement('tr');
            new_row.setAttribute("data-id-transaksi", "");
            new_row.innerHTML = `<tr data-id-transaksi="">
                                <td class="border border-gray-300 px-4 py-2">
                                    <select class="w-full px-3 py-2" type="password" id="id_produk" name="id_produk" required onchange="UpdateIdProduk(this); ChangeVarian(this);">
                                        <?php
                                        $table_produk = "produk";
                                        $table_varian = "detail_produk";
                                        $produk = new Produk();
                                        $produks = $produk->SelectProduks();
                                        ?>
                                        <option value="" disabled selected>Pilih Produk</option>
                                        <?php foreach ($produks as $produk_data): ?>
                                            <?php
                                            $varians = $produk->SelectVarians($produk_data['id_produk']);
                                            foreach ($varians as $varian) {
                                                $data_produk[$produk_data['id_produk']][$varian['id']] = [
                                                    "id_varian" => $varian['id'],
                                                    "varian" => $varian['varian'],
                                                    "harga_jual" => $varian['harga_jual'],
                                                ]; 
                                            }
                                            print_r($data_produk);
                                            ?>
                                        <option value="<?php echo $produk_data['id_produk'] ?>"><?php echo $produk_data['nama_produk'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <select class="w-full px-3 py-2" type="password" id="id_varian" name="id_varian" required onchange="UpdateIdVarian(this); GetValue();">
                                        <option value="" disabled selected>Pilih Varian</option>

                                    </select>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="number" id="jumlah" name="jumlah" class="w-full px-3 py-2" required onchange="UpdateHarga()" min="0">
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="number" id="harga" name="harga" data-harga-id-transaksi="" class="w-full px-3 py-2" required readonly>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="date" id="date" value="" name="date" class="w-full px-3 py-2" required readonly>
                                </td>
                                <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)] flex justify-evenly">
                                    <a href="edit.php?id_admin=<?= $admin['f_id'] ?>" class="text-[clamp(0.45rem,1vw,4rem)] p-3 hover:bg-opacity-75 rounded-md w-max">
                                        <i class="fa-solid fa-pen-to-square text-[#1B2ED6]"></i>
                                    </a>
                                    <a href="#" onclick="confirmDelete(<?=$admin['f_id'] ?>)" class="text-[clamp(0.45rem,1vw,4rem)] p-3 hover:bg-opacity-75 text-white rounded-md w-max">
                                        <i class="fa-solid fa-trash-can text-[#FF0909]"></i>
                                    </a>
                                </td>
                            </tr>`;

            table_body.appendChild(new_row);
            UpdateIdRowTransaksi();
        });

        window.addEventListener("load", () => {
            UpdateIdRowTransaksi();
        });
    </script>
</body>
</html>
