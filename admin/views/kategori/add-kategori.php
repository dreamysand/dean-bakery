<html lang="en">
<head>
    <title>Add Kategori</title>
    <link rel="icon" type="image/png" href="assets/logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-[#F9EFDA] to-blue-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-[80%] lg:w-[30%] my-5">
        <h2 class="text-3xl font-bold text-center mb-6">TAMBAH KATEGORI</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="kategori">Kategori</label>
                <input class="w-full px-3 py-2 border border-black rounded" type="text" id="kategori" name="kategori" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="gambar">Gambar</label>
                <input name="gambar" type="file" id="gambar" class="w-full px-3 py-2 border border-black rounded" required></input>
            </div>
            <div class="text-center">
                <button class="bg-[#E7B548] text-white font-bold py-2 px-4 rounded-md w-full mb-2" type="submit">ADD</button>
            </div>
            <div class="text-center">
                <button class="bg-[#CB2828] text-white font-bold py-2 px-4 rounded-md w-full" type="submit">BACK</button>
            </div>
        </form>
    </div>
</body>
</html>