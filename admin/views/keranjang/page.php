<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="icon" type="image/png" href="assets/logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
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
    <div id="carts" class="mt-10 mx-6">
        <h2 class="text-4xl font-bold text-center mb-6 text-gray-800">Daftar Keranjang</h2>

        <!-- Container untuk produk dengan overflow-x -->
        <div class="flex justify-between mt-[5rem] items-end">
            <h3 class="text-[2.5rem] font-bold text-gray-800">Keranjang</h3>
            <button class="bg-[#C23F17] px-4 py-2 rounded text-white mt-2 mr-2" id="scan-btn"><i class="fa-solid fa-camera"></i></button>
            <?php if (!empty($cart_Data)): ?>
            <div data-button-choice class="flex items-center">
                <button class="bg-[#FF0909] px-4 py-2 rounded text-white mt-2 mr-2" onclick="confirmDeleteAll()">Hapus Semua</button>
                <div class="flex items-center">
                    <label class="text-xl" for="select_all">Pilih Semua</label>
                    <input class="ml-2 w-4 h-4" type="checkbox" name="select_all" id="select_all" onclick="selectAll()">
                </div>
            </div>
            <?php endif ?>
        </div>
        <div id="scanner-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] md:w-[600px] max-w-full relative flex flex-col items-center">
                <button id="close-btn" class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-xl font-bold">
                ✕
                </button>
                <h2 class="text-lg font-semibold mb-4 text-center">Scan QR Code</h2>

                <!-- Dropdown Pilih Kamera -->
                <select id="camera-select" class="mb-4 p-2 border rounded w-full md:w-auto text-sm"></select>

                <!-- Tempat QR Reader -->
                <div id="reader" class="w-full flex justify-center items-center"></div>
            </div>
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
                                    <h3 data-produk data-id-produk="<?= $data_varian['id_produk'] ?>" data-id-varian="<?= $data_varian['id_varian'] ?>" class="text-xl font-semibold text-gray-800"><?= $data_varian['nama_produk'] ?></h3>
                                    <p data-varian data-id-produk="<?= $data_varian['id_produk'] ?>" data-id-varian="<?= $data_varian['id_varian'] ?>" class="text-gray-500"><?= $data_varian['varian'] ?></p> 
                                </div>
                                <div class="ml-[3vw] mb-6">
                                    <p data-price data-id-produk="<?= $data_varian['id_produk'] ?>" data-id-varian="<?= $data_varian['id_varian'] ?>">Rp <?php echo number_format($data_varian['harga_jual']*$data_varian['jumlah'], 0, ',', '.');  ?></p>
                                    <input type="hidden" data-price-input data-id-produk="<?= $data_varian['id_produk'] ?>" data-id-varian="<?= $data_varian['id_varian'] ?>" value="<?= $data_varian['harga_jual']*$data_varian['jumlah'] ?>" name="price_input">
                                    <label for="jumlah_pembelian">Jumlah Pembelian</label>
                                    <input data-value-input onchange="updateData(<?= $data_varian['id_produk'] ?>, <?= $data_varian['id_varian'] ?>)" type="number" data-id-produk="<?= $data_varian['id_produk'] ?>" data-id-varian="<?= $data_varian['id_varian'] ?>" id="jumlah_pembelian<?=$data_varian['id_produk']?><?=$data_varian['id_varian']?>" min="1" max="<?= $data_varian['stok'] ?>" name="jumlah_pembelian" class="w-[5%] border border-black rounded" value="<?= $data_varian['jumlah'] ?>">
                                </div>
                            </div>
                            <div class="mb-6 flex items-center absolute right-6">
                                <input data-checkbox-cart-item class="mr-2" type="checkbox" id="checkbox<?= $data_varian['id_produk'] ?><?= $data_varian['id_varian'] ?>" onclick="checkedCart()" name="checkbox" data-id-produk="<?= $data_varian['id_produk'] ?>" data-id-varian="<?= $data_varian['id_varian'] ?>">
                                <label class="text-sm" for="checkbox<?= $data_varian['id_produk'] ?><?= $data_varian['id_varian'] ?>">Pilih</label>
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

    <footer class="fixed bottom-0 right-0 left-0 z-[997] bg-[#101018] p-6 text-center flex justify-between items-center text-white">
        <p class="text-xl">Total Harga: <span id="totalHarga">Rp </span></p>
        <input type="hidden" id="hargaInput" value="0">
        <button class="bg-green-500 px-4 py-2 rounded text-white mt-2" onclick="AddToTransaksi()">Bayar</button>
    </footer>

    <script>
        let target_time = new Date().getTime() + 60000;
        let countdownInterval;
        const cart_data = <?php echo json_encode($cart_Data); ?>;
        const length_cart_data = Object.keys(cart_data).length;
        let html5QrcodeScanner;
        let selectedDeviceId = null;
        const cameraSelect = document.getElementById("camera-select");
        let isscanning = false;
        document.getElementById("scan-btn").addEventListener("click", () => {
          document.getElementById("scanner-modal").classList.remove("hidden");

          // Ambil daftar kamera
          Html5Qrcode.getCameras().then(devices => {
            cameraSelect.innerHTML = "";
            devices.forEach(device => {
              const option = document.createElement("option");
              option.value = device.id;
              option.text = device.label || `Camera ${cameraSelect.length + 1}`;
              cameraSelect.appendChild(option);
            });

            if (devices.length > 0) {
              selectedDeviceId = devices[0].id;
              startScanner();
            }
          }).catch(err => {
            console.error("Gagal ambil kamera:", err);
          });
        });

        cameraSelect.addEventListener("change", () => {
          selectedDeviceId = cameraSelect.value;
          if (html5QrcodeScanner) {
            html5QrcodeScanner.stop().then(() => {
              startScanner();
            });
          }
        });

        function startScanner() {
          html5QrcodeScanner = new Html5Qrcode("reader");
          html5QrcodeScanner.start(
            selectedDeviceId,
            { fps: 10, qrbox: 300 },
            onScanSuccess
          );
        }

        document.getElementById("close-btn").addEventListener("click", () => {
          if (html5QrcodeScanner) {
            html5QrcodeScanner.stop().then(() => {
              document.getElementById("scanner-modal").classList.add("hidden");
            });
          }
        });

        function onScanSuccess(decodedText, decodedResult) {

            if (isscanning) return;

            isscanning = true;
            console.log(`Hasil scan: ${decodedText}`);

            const formData = new FormData();
            formData.append("barcode", decodedText);

            fetch("keranjang.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                if (data) {
                    if (html5QrcodeScanner) {
                        html5QrcodeScanner.stop().then(() => {
                            alert("Produk sukses ditambahkan ke keranjang");
                            document.getElementById("scanner-modal").classList.add("hidden");
                            window.location.href = "keranjang.php";
                        });
                    }
                } else {
                    alert("Produk tidak ditemukan!");
                    isscanning = false;
                }
            });
        }

        function updateCountdown() {
            let now = new Date().getTime();
            let remaining_time = Math.max((target_time - now) / 1000, 0).toFixed();
            const countdowns = document.getElementsByClassName("countdown");
            if (remaining_time > 0) {
                for (let i = 0; i < countdowns.length; i++) {
                countdowns[i].textContent = `Countdown: ${remaining_time} Detik`;
            }
            } else {
                deleteAllCart();
                clearInterval(countdownInterval);
            }
        }

        function startCountdown() {
            clearInterval(countdownInterval);
            updateCountdown();
            setInterval(updateCountdown, 1000);
        }

        function resetCountdown() {
            target_time = new Date().getTime() + 60000;
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

        function confirmDeleteAll() {
            if (confirm("Apakah anda yakin menghapus semua produk ini dari keranjang?")) {
                deleteAllCart();
            }
        }

        function updateData(id_produk, id_varian) {
            const checkbox = document.getElementById(`checkbox${id_produk}${id_varian}`);
            const value = parseInt(document.getElementById(`jumlah_pembelian${id_produk}${id_varian}`).value);
            const price = document.querySelector(`p[data-price][data-id-produk="${id_produk}"][data-id-varian="${id_varian}"]`);
            const price_input = document.querySelector(`input[data-price-input][data-id-produk="${id_produk}"][data-id-varian="${id_varian}"]`);

            id_produk_array = parseInt(id_produk);
            id_varian_array = parseInt(id_varian);

            const default_price = cart_data[id_produk][id_varian]["harga_jual"];
            const stok = cart_data[id_produk][id_varian]["stok"];
            if (value > 0 && value <= stok) {
                let new_price = value*default_price;
                new_price = new_price.toLocaleString('id-ID'); 
                price.textContent = `Rp ${new_price}`;
                price_input.value = value*default_price;
            } else if (value > 0 && value > stok) {
                let new_price = stok*default_price;
                alert("Jumlah pembelian melebihi stok ynag tersedia");
                new_price = new_price.toLocaleString('id-ID'); 
                price.textContent = `Rp ${new_price}`;
                price_input.value = stok*default_price;
            } else {
                let new_price = 0;
                new_price = new_price.toLocaleString('id-ID'); 
                price.textContent = `Rp ${new_price}`;
                price_input.value = 0;
            }

            if (checkbox.checked) {
                checkedCart();
            }
            resetCountdown();
        }

        function checkedCart() {
            const checkboxes = document.querySelectorAll("input[name='checkbox']:checked");
            const price_view = document.getElementById("totalHarga");
            const price_input_total = document.getElementById("hargaInput");
            let total_price = 0;

            checkboxes.forEach((checkbox) => {
                const id_produk = checkbox.getAttribute("data-id-produk");
                const id_varian = checkbox.getAttribute("data-id-varian");
                const price_input = document.querySelector(`input[data-price-input][data-id-produk="${id_produk}"][data-id-varian="${id_varian}"]`);

                total_price += parseInt(price_input.value);
            });
            
            price_input_total.value = total_price;
            price_view.textContent = "Rp " + total_price.toLocaleString('id-ID');                
        }

        function AddToTransaksi() {
            const checkboxes = document.querySelectorAll("input[name='checkbox']:checked");

            let selected_items = [];

            checkboxes.forEach((checkbox) => {
                const id_produk = checkbox.getAttribute("data-id-produk");
                const id_varian = checkbox.getAttribute("data-id-varian");
                const produk = document.querySelector(`h3[data-produk][data-id-produk="${id_produk}"][data-id-varian="${id_varian}"]`);
                const varian = document.querySelector(`p[data-varian][data-id-produk="${id_produk}"][data-id-varian="${id_varian}"]`);
                const price_input = document.querySelector(`input[data-price-input][data-id-produk="${id_produk}"][data-id-varian="${id_varian}"]`);
                const value_input = document.querySelector(`input[data-value-input][data-id-produk="${id_produk}"][data-id-varian="${id_varian}"]`);

                selected_items.push({
                    id_produk: id_produk,
                    id_varian: id_varian,
                    produk: produk.innerText,
                    varian: varian.innerText,
                    price: price_input.value,
                    value: value_input.value
                })
            });

            console.log(selected_items);
            fetch("transaksi.php?add", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(selected_items)
            })
            .then(response => response.text())
            .then(data => {
                console.log("Respon dari server:", data);
                window.location.href="transaksi.php";
            })
            .catch(error => {
                console.error("Error:", error);
            });
        }

        function deleteAllCart() {
            fetch("keranjang.php?delete_all", {
                method: "GET",
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status == "success") {
                 document.querySelector("#carts").innerHTML = data.html;
                 document.getElementById("totalHarga").innerText = "Rp ";
                 document.getElementById("hargaInput").value = "";
                }
            })
            .catch(error => console.error(error));    
        }

        function selectAll() {
            const select_all_toggle = document.getElementById("select_all");
            const checkbox_cart_items = document.querySelectorAll("input[type='checkbox'][data-checkbox-cart-item]");

            if (select_all_toggle.checked == true) {
                checkbox_cart_items.forEach(checkbox => {
                    checkbox.checked = true;
                    checkedCart();
                })
            } else {
                checkbox_cart_items.forEach(checkbox => {
                    checkbox.checked = false;
                    checkedCart();
                })
            }
        }

        if (cart_data && Object.keys(cart_data).length > 0) {
            startCountdown();
        }

        if (Object.keys(cart_data).length > length_cart_data) {
            resetCountdown();
        }

        document.querySelectorAll("input[type='checkbox'][data-checkbox-cart-item]").forEach(checkbox => {
            checkbox.addEventListener("click", () => {
                const select_all_toggle = document.getElementById("select_all");
                const checkbox_cart_items = document.querySelectorAll("input[type='checkbox'][data-checkbox-cart-item]");

                const all_checked = [...checkbox_cart_items].every(check => check.checked);

                select_all_toggle.checked = all_checked;
            });
        });
    </script>
</body>
</html>
