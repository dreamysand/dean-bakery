
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
                                                <input type="number" id="harga" name="harga" data-harga value="<?php echo $transaksi['subtotal'] ?>" class="w-full px-3 py-2" required readonly>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <input type="date" id="date" value="<?php echo date('Y-m-d'); ?>" name="date" class="w-full px-3 py-2" required readonly>
                                            </td>
                                            <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)] flex justify-evenly">
                                                <a href="#" onclick="confirmDelete(<?php echo $transaksi['id_produk'] ?>, <?php echo $transaksi['id_varian'] ?>)" class="text-[clamp(0.45rem,1vw,4rem)] p-3 hover:bg-opacity-75 text-white rounded-md w-max">
                                                    <i class="fa-solid fa-trash-can text-[#FF0909]"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>

                <!-- Form Transaksi -->
                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div>
                        <label class="block font-medium">METODE PEMBAYARAN</label>
                        <select data-metode name="metode" id="" class="w-full border p-2 rounded">
                            <option value="" disabled selected>Pilih Metode Pembayaran</option>
                            <?php
                            $transaksi = isset($_SESSION['transaksi']) ? unserialize($_SESSION['transaksi']) : new Transaksi();
                            $table_metode = "metode_pembayaran";

                            $result_payment = $transaksi->SelectPaymentMethods();
                            ?>
                            <?php foreach ($result_payment as $payment): ?>
                                <option value="<?php echo $payment['id_metode_pembayaran'] ?>"><?php echo $payment['metode_pembayaran'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium">MEMBER</label>
                        <select data-member name="member" id="" class="w-full border p-2 rounded" onchange="SetDataMember(this.value)">
                            <option value="" selected>Pilih Member</option>
                            <?php
                            $member = new Member();
                            $table = "member";

                            $result_member = $member->SelectMembers();
                            $members = [];
                            foreach ($result_member as $member) {
                                $members[$member['id_member']] = [
                                    "id_member" => $member['id_member'],
                                    "nama_member" => $member['id_member'],
                                    "no_telp" => $member['no_telp'],
                                    "point" => $member['point'],
                                    "status" => $member['status'],
                                    "last_transaction" => $member['last_transaction']
                                ];
                            }
                            ?>
                            <?php foreach ($result_member as $member): ?>
                                <option value="<?php echo $member['id_member'] ?>"><?php echo $member['no_telp'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium">TOTAL HARGA</label>
                        <input type="number" value="" data-total-harga class="w-full border p-2 rounded" id="total_harga" readonly>
                    </div>
                    <div>
                        <label class="block font-medium">POTONGAN HARGA</label>
                        <input type="number" disabled data-diskon class="w-full border p-2 rounded" value="0" max="0" oninput="TotalHarga(); ReturnCount();">
                    </div>
                    <div>
                        <label class="block font-medium">UANG BAYAR</label>
                        <input type="number" data-bayar class="w-full border p-2 rounded" oninput="ReturnCount()">
                    </div>
                    <div>
                        <label class="block font-medium">KEMBALIAN</label>
                        <input type="text" data-kembalian class="w-full border p-2 rounded" readonly>
                    </div>
                </div>

                <button data-tombol-bayar onclick="SendToInvoiceAndDB()" hidden class="bg-yellow-500 text-white px-4 py-2 mt-6 rounded-lg hover:bg-yellow-600 w-full">Bayar</button>
            </div>
        </div>
    </div>
    
    <footer class="absolute bottom-0 right-0 left-0 bg-[#101018] p-6 text-center">
        <p class="text-white">&copy; 2025 Dean Bakery. All Right Reserved</p>
    </footer>

    <script>
        const members = <?php echo json_encode($members); ?>
        
        console.log(members);
        function SetDataMember(id_member) {
            console.log(id_member);
            const diskon = document.querySelector("input[data-diskon]");

            if (!id_member) {
                diskon.setAttribute("disabled", true);
                diskon.value = "";
                TotalHarga();
            } else {
                diskon.removeAttribute("disabled");
            }
            const total_price = document.querySelector("input[data-total-harga]");
            const max_point_usage = Math.floor((total_price.value/1000)/2);

            if (members[id_member]['point'] >= max_point_usage) {
                document.querySelector("input[data-diskon]").setAttribute("max", max_point_usage);
            } else {
                document.querySelector("input[data-diskon]").setAttribute("max", members[id_member]['point']);
            }
        }

        function confirmDelete(id_produk, id_varian) {
            if (confirm("Apakah anda yakin menghapus produk ini dari keranjang?")) {
                let form = document.createElement("form");
                form.method = "POST";
                form.action = "transaksi.php?delete";

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

        function TotalHarga() {
            const prices = document.querySelectorAll(`input[data-harga]`);
            const total_price = document.querySelector(`input[data-total-harga]`);
            const diskon = document.querySelector("input[data-diskon]");
            let diskon_value = diskon.value * 1000;

            let total_price_value = 0;
            prices.forEach((price) => {
                total_price_value += parseFloat(price.value) || 0;
            });
            total_price_value -= parseFloat(diskon_value);
            total_price.value = total_price_value;
        }

        function ReturnCount() {
            const pay = document.querySelector(`input[data-bayar]`);
            const ret = document.querySelector(`input[data-kembalian]`);
            const total_price = document.querySelector(`input[data-total-harga]`);
            const button = document.querySelector(`button[data-tombol-bayar]`);
            let ret_val = 0;
            let total_price_value = parseFloat(total_price.value);
            console.log(total_price_value);

            ret_val = parseFloat(pay.value) - total_price_value;

            if (ret_val < 0 || isNaN(ret_val)) {
                ret.value = "Uang tidak mencukupi";
                button.setAttribute("hidden", true);
            } else {
                ret.value = ret_val;
                button.removeAttribute("hidden");
            }
        }
        
        function SendToInvoiceAndDB() {
            const trs = document.querySelectorAll("tr[data-id-transaksi]");
            const pay = document.querySelector(`input[data-bayar]`);
            const ret = document.querySelector(`input[data-kembalian]`);
            const total_price = document.querySelector(`input[data-total-harga]`);
            const metode = document.querySelector(`select[data-metode]`);
            const member = document.querySelector(`select[data-member]`);
            const diskon = document.querySelector("input[data-diskon]");

            const metode_opts = metode.options;
            const member_opts = member.options;

            let selected_metode;
            let selected_member;

            for (var i = 0; i < metode_opts.length; i++) {
                if (metode_opts[i].selected) {
                    selected_metode = metode_opts[i].innerText;
                }
            }

            for (var i = 0; i < member_opts.length; i++) {
                if (member_opts[i].selected) {
                    selected_member = member_opts[i].innerText;
                }
            }

            let member_point = 0;

            if (member.value) {
                member_point = parseFloat(members[member.value]['point']) || 0;
            }

            if (!metode.value) {
                alert("Isi metode pembayarannya");
                return;
            }

            let invoice_items = {
                pay: pay?.value,
                return: ret?.value,
                total_price: total_price?.value,
                id_metode: metode?.value,
                metode: selected_metode,
                id_member: member?.value,
                no_telp: selected_member,
                point_usage: diskon.value,
                data: []
            };


            if (member_point >= parseFloat(diskon.value) && parseFloat(diskon.value) <= parseFloat(diskon.getAttribute("max"))) {
                trs.forEach((row, index) => {
                    const produk = row.querySelector('select[name="id_produk"]')?.value;
                    const varian = row.querySelector('select[name="id_varian"]')?.value;
                    const jumlah = row.querySelector('input[name="jumlah"]')?.value;
                    const subtotal = row.querySelector('input[data-harga]')?.value;
                    const tanggal = row.querySelector('input[name="date"]')?.value;

                    invoice_items.data.push({
                        id_produk: produk,
                        id_varian: varian,
                        jumlah: jumlah,
                        subtotal: subtotal,
                        tanggal: tanggal
                    });
                });

                console.log(invoice_items);

                fetch("invoice.php?sendtodb", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(invoice_items)
                })
                .then(response => response.text())
                .then(data => {
                    console.log("Respon dari server:", data);
                    window.location.href="invoice.php";
                })
                .catch(error => {
                    console.error("Error:", error);
                });
            } else {
                console.log(parseFloat(diskon.value) <= parseFloat(diskon.getAttribute("max")))
                alert(`Anda sudah mencapai batas poin. Batas poin maksimal : ${parseFloat(diskon.getAttribute("max"))}`);
            }
        }

        window.addEventListener("load", () => {
            UpdateIdRowTransaksi();
            TotalHarga();
        });
    </script>
</body>
</html>
