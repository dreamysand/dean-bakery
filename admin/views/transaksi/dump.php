<?php
        session_start();
        include "koneksi.php";

        // Pastikan user sudah login
        if (!isset($_SESSION['email'])) {
            header("Location: login.php");
            exit();
        }

        $email = $_SESSION['email']; // Ambil email dari session
        // Hapus item dari keranjang jika sudah lebih dari 10 menit
        $query = "DELETE FROM cart WHERE TIMESTAMPDIFF(MINUTE, waktu_masuk, NOW()) > 5";
        mysqli_query($conn, $query);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['hapus_item']) && isset($_POST['cart_id'])) {
            $id = intval($_POST['id']);  // Hindari SQL Injection
            $query = "DELETE FROM cart WHERE id = $id";
            if (mysqli_query($conn, $query)) {
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "error"]);
            }
            exit;
        }

        if (isset($_POST['hapus_semua'])) {
            $sql = "DELETE FROM cart";
            if ($conn->query($sql)) {
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Gagal menghapus"]);
            }
            exit;
        }
    }

        // Ambil semua produk dalam keranjang berdasarkan id_produk
        $sql = "SELECT cart.id AS cart_id, cart.id_produk, cart.quantity, 
                    produk.nama_produk, produk.harga_jual, produk.gambar, produk.tanggal_expired 
                FROM cart 
                JOIN produk ON cart.id_produk = produk.id_produk";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $totalHarga = 0;
        ?>

        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Keranjang - Rich Noodles</title>
            <link rel="website icon" type="image/png" href="asset/Richa Mart.png">
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                body {
                    font-family: Arial, sans-serif;
                    background: url('asset/bg.jpeg') no-repeat center center fixed;
                    background-size: cover;
                    text-align: center;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                    min-height: 100vh;
                    overflow-x: hidden;
                }
                .header {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    background: white;
                    padding: 15px;
                    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
                }
                .back-btn {
                    margin: 20px;
                    margin-top: 5px;
                    background: white;
                    color: #5ca6ff;
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    cursor: pointer;
                    font-size: 24px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                }
                .logo img {
                    height: 50px;
                }

        .cart-header h2 {
            font-size: 24px;
            color: #333;
        }

        .cart-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        /* Mengubah posisi tombol "Hapus Semua" dan checkbox "Pilih Semua" ke kanan, sedikit lebih ke kiri */
        .cart-actions {
            display: flex;
            align-items: center;
            gap: 15px;
            justify-content: flex-end; /* Menempatkan elemen-elemen di sebelah kanan */
            margin-right: 20px; /* Memberikan sedikit ruang dari kanan */
        }

        /* Tombol hapus semua */
        #hapus-semua-btn {
            display: flex;
            align-items: center;
            background: transparent;
            color: red;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            gap: 10px; /* Menambahkan jarak antara ikon dan teks */
        }

        /* Mengubah latar belakang checkbox "Pilih Semua" */
        #pilih-semua {
            transform: scale(1.2);
            cursor: pointer;
            background: transparent;
        }
        .cart-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            margin-top: 20px; /* Mengurangi jarak antara keranjang dan tombol Hapus Semua */
        }

                .cart-item {
            display: flex;
            align-items: center;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            width: 95%;
            margin-bottom: 10px;
            justify-content: space-between;
        }
        .cart-item img {
            width: 120px;
            border-radius: 10px;
            margin-right: 15px;
        }
        .cart-details {
            flex-grow: 1;
            text-align: left;
        }
        .quantity-control {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .top-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .delete-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: red;
        }

        .select-item {
            transform: scale(1.2);
            cursor: pointer;
        }

        .quantity-buttons {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
        }

        .quantity-buttons button {
            background: #f5f5f5;
            border: none;
            width: 40px; /* Ukuran lebih besar */
            height: 40px;
            font-size: 20px;
            cursor: pointer;
        }

        .quantity-buttons input {
            width: 50px;
            text-align: center;
            border: none;
            font-size: 18px;
        }
        .cart-summary {
            display: flex;
            justify-content: space-between; /* Untuk membuat tombol ke pojok kiri dan kanan */
            align-items: center;
            margin-top: 20px;
            background: white;
            padding: 15px;
            border-radius: 5px;
            width: 100%;
            text-align: right;
        }

        #total-pembelian-btn {
            padding: 10px 20px;
            background: #f5f5f5;
            color: black;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            cursor: default; /* Tidak bisa diklik */
        }
                #bayar-btn {
                    padding: 10px 20px;
                    background: blue;
                    color: white;
                    border: none;
                    cursor: pointer;
                    border-radius: 5px;
                    font-size: 16px;
                }
            </style>
        </head>
        <body>

            <div class="header">
                <div class="logo">
                    <img src="asset/Richa Mart.png" alt="Rich Noodles">
                </div>
            </div>

            <div class="back-btn" onclick="window.location.href='produk.php';">&#8592;</div>
            <div class="cart-header">
            <h2>Keranjang</h2>
            <div class="cart-actions">
                <button id="hapus-semua-btn">
                    <i class="fa fa-trash"></i> Hapus Semua
                </button>
                <label>
                    <input type="checkbox" id="pilih-semua"> Pilih Semua
                </label>
            </div>
        </div>


            <div class="cart-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="cart-item">
                <img src="asset/<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['nama_produk']) ?>">
                <div class="cart-details">
                <h3><?= $row['nama_produk'] ?></h3>
                <p class="price">Rp. <?= number_format($row['harga_jual'], 0, ',', '.') ?> / pcs</p>
                <p>Expired: <?= $row['tanggal_expired'] ?></p>
                <p class="timer">TIMER: 10 MNT</p>
            </div>
            <div class="quantity-control">
            <div class="top-controls">
                <button class="delete-btn" data-cart-id="<?= $row['cart_id'] ?>">🗑</button>
                <label>
                    <input type="checkbox" class="select-item" data-cart-id="<?= $row['cart_id'] ?>"> Pilih
                </label>
            </div>
        <div class="quantity-buttons">
            <button class="minus-btn" data-cart-id="<?= $row['cart_id'] ?>">-</button>
            <input type="number" value="<?= $row['quantity'] ?>" min="1" class="quantity" data-cart-id="<?= $row['cart_id'] ?>">
            <button class="plus-btn" data-cart-id="<?= $row['cart_id'] ?>">+</button>
        </div>

        </div>

                </div>
                <?php $totalHarga += $row['harga_jual'] * $row['quantity']; ?>
            <?php endwhile; ?>
        </div>
        <div class="cart-summary">
            <button id="total-pembelian-btn">Total Pembelian: <span id="total-pembelian">0</span></button>
            <p>Total Harga: Rp. <span id="total-harga"><?= number_format($totalHarga, 0, ',', '.') ?></span></p>
            <button id="bayar-btn" onclick="window.location.href='transaksi/transaksi.php'">Chek Out</button>
        </div>
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            updateTotalPembelian();

            document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function () {
            const cartId = this.dataset.cartId;

            if (!cartId) {
                alert("ID produk tidak ditemukan.");
                return;
            }

            if (confirm("Apakah Anda yakin ingin menghapus produk ini dari keranjang?")) {
                fetch("keranjang.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: hapus_item=true&cart_id=${cartId}
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Response dari PHP:", data);
                    if (data.status === "success") {
                        this.closest(".cart-item").remove();
                        updateTotalPembelian(); // Pastikan fungsi ini ada
                    } else {
                        alert("Gagal menghapus produk.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Terjadi kesalahan, coba lagi.");
                });
            }
        });
    });


            // Event listener tombol hapus semua
            document.getElementById("hapus-semua-btn").addEventListener("click", function () {
                if (confirm("Apakah Anda yakin ingin menghapus semua produk dari keranjang?")) {
                    fetch("keranjang.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: "hapus_semua=true"
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            document.querySelectorAll(".cart-item").forEach(item => item.remove());
                            document.getElementById("total-harga").textContent = "Rp. 0";
                            document.getElementById("total-pembelian").textContent = "0";
                        } else {
                            alert("Gagal menghapus produk.");
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Terjadi kesalahan, coba lagi.");
                    });
                }
            });

            // Event listener tombol plus/minus
            document.querySelectorAll(".plus-btn, .minus-btn").forEach(button => {
            button.addEventListener("click", function () {
                const cartId = this.getAttribute("data-cart-id");
                const quantityInput = document.querySelector(.quantity[data-cart-id="${cartId}"]);
                let quantity = parseInt(quantityInput.value);

                if (this.classList.contains("plus-btn")) {
                    quantity++;
                } else if (this.classList.contains("minus-btn") && quantity > 1) {
                    quantity--;
                }

                // Update input tampilan sementara
                quantityInput.value = quantity;

                // Kirim update ke server pakai fetch/AJAX
                fetch("update_quantity.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: cart_id=${cartId}&quantity=${quantity}
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status !== "success") {
                        alert("Gagal update ke database: " + data.message);
                    } else {
                        // Optional: Refresh halaman supaya quantity dari DB ditampilkan
                        location.reload();
                    }
                });
            });
        });


            // Fungsi untuk update total pembelian & harga
            function updateTotalPembelian() {
                let totalPembelian = 0;
                let totalHarga = 0;

                document.querySelectorAll(".cart-item").forEach(item => {
                    const quantity = parseInt(item.querySelector(".quantity").value);
                    const harga = parseInt(item.querySelector(".price").textContent.replace("Rp. ", "").replace(/\./g, ""));
                    
                    totalPembelian += quantity;
                    totalHarga += harga * quantity;
                });

                document.getElementById("total-pembelian").textContent = totalPembelian;
                document.getElementById("total-harga").textContent = "Rp. " + totalHarga.toLocaleString();
            }
        });
        document.addEventListener("DOMContentLoaded", function () {
            const pilihSemuaCheckbox = document.getElementById("pilih-semua");
            const itemCheckboxes = document.querySelectorAll(".select-item");

            // Saat checkbox "Pilih Semua" di-klik
            pilihSemuaCheckbox.addEventListener("change", function () {
                itemCheckboxes.forEach(checkbox => {
                    checkbox.checked = pilihSemuaCheckbox.checked;
                });
            });

            // Saat ada perubahan pada salah satu checkbox item
            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener("change", function () {
                    // Jika ada 1 checkbox yang tidak dicentang, "Pilih Semua" harus nonaktif
                    const semuaTercentang = [...itemCheckboxes].every(cb => cb.checked);
                    pilihSemuaCheckbox.checked = semuaTercentang;
                });
            });
        });
        // Timer countdown 10 menit
        function updateTimers() {
            document.querySelectorAll(".timer").forEach(timer => {
                let waktuMasuk = parseInt(timer.getAttribute("data-waktu"));
                let sekarang = Math.floor(Date.now() / 1000);
                let sisaDetik = 600 - (sekarang - waktuMasuk);

                if (sisaDetik <= 0) {
                    let cartId = timer.closest(".cart-item").getAttribute("data-cart-id");
                    fetch("keranjang.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: hapus_item=true&cart_id=${cartId}
                    }).then(() => {
                        timer.closest(".cart-item").remove();
                        updateTotalHarga();
                    });
                } else {
                    let menit = Math.floor(sisaDetik / 600);
                    let detik = sisaDetik % 60;
                    timer.textContent = Sisa Waktu: ${menit}:${detik < 5 ? '0' : ''}${detik};
                }
            });
        }
        document.addEventListener("DOMContentLoaded", function () {
            const pilihSemuaCheckbox = document.getElementById("pilih-semua");
            const itemCheckboxes = document.querySelectorAll(".select-item");
            const totalHargaElement = document.getElementById("total-harga");
            const totalPembelianElement = document.getElementById("total-pembelian");

            function updateTotalPembelian() {
                let totalPembelian = 0;
                let totalHarga = 0;
                
                document.querySelectorAll(".cart-item").forEach(item => {
                    const checkbox = item.querySelector(".select-item");
                    if (checkbox.checked) {
                        const quantity = parseInt(item.querySelector(".quantity").value);
                        const harga = parseInt(item.querySelector(".price").textContent.replace("Rp. ", "").replace(/\./g, ""));
                        
                        totalPembelian += quantity;
                        totalHarga += harga * quantity;
                    }
                });

                totalPembelianElement.textContent = totalPembelian;
                totalHargaElement.textContent = totalHarga > 0 ? "Rp. " + totalHarga.toLocaleString() : "Rp. 0";
            }

            pilihSemuaCheckbox.addEventListener("change", function () {
                itemCheckboxes.forEach(checkbox => {
                    checkbox.checked = pilihSemuaCheckbox.checked;
                });
                updateTotalPembelian();
            });

            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener("change", function () {
                    const semuaTercentang = [...itemCheckboxes].every(cb => cb.checked);
                    pilihSemuaCheckbox.checked = semuaTercentang;
                    updateTotalPembelian();
                });
            });

            document.querySelectorAll(".quantity").forEach(input => {
                input.addEventListener("change", updateTotalPembelian);
            });


            // Set total harga ke Rp. 0 saat pertama kali
            updateTotalPembelian();
        });

        </script>
        <head>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <!-- Sisa head lainnya -->
        </head>

        </body>
        </html>