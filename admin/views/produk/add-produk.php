<html lang="en">
<head>
    <title>Add Produk</title>
    <link rel="icon" type="image/png" href="assets/logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-[#F9EFDA] to-blue-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-[80%] lg:w-[30%] my-5">
        <h2 class="text-3xl font-bold text-center mb-6">TAMBAH PRODUK</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="nama">Nama Produk</label>
                <input class="w-full px-3 py-2 border border-black rounded" type="text" id="nama" name="nama" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="varian">Varian</label>
                <input class="w-full px-3 py-2 border border-black rounded" type="text" id="varian" name="varian" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="expired">Tanggal Expired</label>
                <input class="w-full px-3 py-2 border border-black rounded" type="date" id="expired" name="expired" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="stok">Stok</label>
                <input class="w-full px-3 py-2 border border-black rounded" type="number" id="stok" name="stok" required oninput="updateKeuntungan()">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="modal">Modal</label>
                <input class="w-full px-3 py-2 border border-black rounded" type="number" id="modal" name="modal" required oninput="updateKeuntungan()">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="harga_jual">Harga Jual</label>
                <input class="w-full px-3 py-2 border border-black rounded" type="number" id="harga_jual" name="harga_jual" required oninput="updateKeuntungan()">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="keuntungan">Keuntungan</label>
                <input class="w-full px-3 py-2 border border-black rounded" type="number" id="keuntungan" name="keuntungan" required readonly>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="id_kategori">Kategori</label>
                <select class="w-full px-3 py-2 border border-black rounded" type="password" id="id_kategori" name="id_kategori" required>
                    <?php
                    $table = "kategori";
                    $kategori = new Kategori();
                    $kategoris = $kategori->SelectKategoris();
                    ?>
                    <option value="" disabled selected>Pilih Kategori</option>
                    <?php foreach ($kategoris as $kategori): ?>
                        <option  value="<?php echo $kategori['id_kategori'] ?>"><?php echo $kategori['kategori'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="gambar">Gambar</label>
                <input name="gambar" type="file" id="gambar" class="w-full px-3 py-2 border border-black rounded" required></input>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="w-full px-3 py-2 border border-black rounded" rows="8" required></textarea>
            </div>
            <div class="text-center">
                <button class="bg-[#E7B548] text-white font-bold py-2 px-4 rounded-md w-full mb-2" type="submit">ADD</button>
            </div>
            <div class="text-center">
                <button class="bg-[#CB2828] text-white font-bold py-2 px-4 rounded-md w-full" type="submit">BACK</button>
            </div>
        </form>
    </div>
    <script>
        function updateKeuntungan() {
            const stok = document.getElementById("stok");
            const modal = document.getElementById("modal");
            const harga_jual = document.getElementById("harga_jual");
            const keuntungan = document.getElementById("keuntungan");

            let keuntungan_per_produk = harga_jual.value - (modal.value / stok.value);
            keuntungan.value = keuntungan_per_produk;  
        }
    </script>
</body>
</html>