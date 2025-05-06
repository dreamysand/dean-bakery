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
                <h2 class="text-center text-[2.5rem] font-bold mb-4">INVOICE</h2>

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
                            </tr>
                        </thead>
                        <tbody id="transactions">
                            <?php if (!empty($_SESSION['invoice_data'])): ?>
                                <?php
                                $produk = new Produk();
                                $table_produk = "produk";
                                $table_varian = "detail_produk";

                                $data = $_SESSION['invoice_data'];
                                ?>
                                <?php foreach ($data['data'] as $item): ?>
                                    <?php
                                        $data_produk = $produk->SelectProduk($item['id_produk'], null);
                                        $data_varian = $produk->SelectVarian($item['id_varian'], $item['id_produk'], null, null);
                                    ?>
                                    <tr data-id-transaksi="">
                                        <td class="border border-gray-300 px-4 py-2">
                                            <input type="text" id="produk" name="produk" class="w-full px-3 py-2" value="<?php echo $data_produk['nama_produk'] ?>" required readonly>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <input type="text" id="varian" name="varian" class="w-full px-3 py-2" value="<?php echo $data_varian['varian'] ?>" required readonly>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <input type="number" id="jumlah" name="jumlah" class="w-full px-3 py-2" value="<?php echo $item['jumlah'] ?>" required readonly min="0">
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <input type="number" id="harga" name="harga" data-harga value="<?php echo $item['subtotal'] ?>" class="w-full px-3 py-2" required readonly>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <input type="date" id="date" value="<?php echo $item['tanggal']; ?>" name="date" class="w-full px-3 py-2" required readonly>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>

                <!-- Form Transaksi -->
                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div>
                        <label class="block font-medium">METODE PEMBAYARAN</label>
                        <input type="text" data-metode value="<?php echo $data['metode'] ?>" class="w-full border p-2 rounded">
                    </div>
                    <div>
                        <label class="block font-medium">MEMBER</label>
                        <input type="text" data-member value="<?php echo $data['id_member'] ?> | <?php echo $data['no_telp'] ?>" class="w-full border p-2 rounded">
                    </div>
                    <div>
                        <label class="block font-medium">HARGA AWAL</label>
                        <input type="number" value="<?php echo $data['total_price'] + ($data['point_usage'] * 1000) ?>" data-total-harga class="w-full border p-2 rounded" id="total_harga" readonly>
                    </div>
                    <div>
                        <label class="block font-medium">POTONGAN HARGA</label>
                        <input type="number" data-diskon class="w-full border p-2 rounded" value="<?php echo $data['point_usage'] * 1000 ?>" readonly>
                    </div>
                    <div>
                        <label class="block font-medium">TOTAL HARGA</label>
                        <input type="number" value="<?php echo $data['total_price'] ?>" data-total-harga class="w-full border p-2 rounded" id="total_harga" readonly>
                    </div>
                    <div>
                        <label class="block font-medium">UANG BAYAR</label>
                        <input type="number" value="<?php echo $data['pay'] ?>" data-bayar class="w-full border p-2 rounded" readonly>
                    </div>
                    <div>
                        <label class="block font-medium">KEMBALIAN</label>
                        <input type="text" value="<?php echo $data['return'] ?>" data-kembalian class="w-full border p-2 rounded" readonly>
                    </div>
                </div>

                <button onclick="printInvoice()" class="bg-green-600 text-white px-4 py-2 my-4 rounded">Cetak Invoice</button>
                <button onclick="downloadInvoice()" class="bg-blue-600 text-white px-4 py-2 mt-4 rounded hover:bg-blue-700">
                    Download Invoice PDF
                </button>
                <?php if (isset($_SESSION['invoice_data']['no_telp']) && !empty($_SESSION['invoice_data']['no_telp'])): ?>
                <?php echo $_SESSION['invoice_data']['no_telp'] ?>
                <button onclick="sendWa()" class="bg-yellow-600 text-white px-4 py-2 mt-4 rounded hover:bg-yellow-700">
                    Send To Wa
                </button>
                <?php endif ?>
            </div>
        </div>
    </div>
    
    <footer class="absolute bottom-0 right-0 left-0 bg-[#101018] p-6 text-center">
        <p class="text-white">&copy; 2025 Dean Bakery. All Right Reserved</p>
    </footer>
    <script>
        let isdownload = false;
        let isprint = false;
        function printInvoice() {
            isprint = true;

            fetch('invoice.php?printpdf')
                .then(res => res.blob())
                .then(blob => {
                    const url = URL.createObjectURL(blob);

                    window.open(url); // tampilkan PDF
                    window.location.href = 'produk.php';
            });

            setInterval(() => {
                isprint = false;
            }, 100);
        }

        function sendWa() {
            isprint = true;

            fetch('invoice.php?sendwa')

            setInterval(() => {
                isprint = false;
            }, 100);
        }

        function downloadInvoice() {
            isdownload = true;
            const kode_unik = "<?php echo $_SESSION['invoice_data']['kode_unik']; ?>";
            const filename = `struk_transaksi_${kode_unik}.pdf`;

            fetch('invoice.php?downloadpdf')
                .then(res => res.blob())
                .then(blob => {
                    const url = URL.createObjectURL(blob);

                    const dllink = document.createElement("a");
                    dllink.href = url;
                    dllink.download = filename;
                    dllink.click();

                    window.open(url); // tampilkan PDF
                    window.location.href = 'produk.php';
            });

            setInterval(() => {
                isdownload = false;
            }, 100);
        }

        window.addEventListener("beforeunload", (e) => {
            if (!isdownload && !isprint) {
                fetch('invoice.php?close')
                    .then(response => response.json())
                    .then(data => console.log("Sesi berhasil dihapus"))
            }
        });
    </script>
</body>
</html>
