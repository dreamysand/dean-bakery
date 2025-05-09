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
        <h2 class="text-4xl font-bold text-center mb-6 text-gray-800">Daftar Transaksi</h2>

        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
        <table class="min-w-full text-left text-gray-800 text-center text-wrap">
            <thead class="bg-[#E7B548] text-white">
                <tr>
                    <th class="px-2 py-2 border border-gray-300 font-medium text-[clamp(0.45rem,1vw,1rem)]">ID</th>
                    <th class="px-2 py-2 border border-gray-300 font-medium text-[clamp(0.45rem,1vw,1rem)]">Tanggal Pembelian</th>
                    <th class="px-2 py-2 border border-gray-300 font-medium text-[clamp(0.45rem,1vw,1rem)]">Total Harga</th>
                    <th class="px-2 py-2 border border-gray-300 font-medium text-[clamp(0.45rem,1vw,1rem)]">ID Admin</th>
                    <th class="px-2 py-2 border border-gray-300 font-medium text-[clamp(0.45rem,1vw,1rem)]">Total Bayar</th>
                    <th class="px-2 py-2 border border-gray-300 font-medium text-[clamp(0.45rem,1vw,1rem)]">Metode Pembayaran</th>
                    <th class="px-2 py-2 border border-gray-300 font-medium text-[clamp(0.45rem,1vw,1rem)]">Kembalian</th>
                    <th class="px-2 py-2 border border-gray-300 font-medium text-[clamp(0.45rem,1vw,1rem)]">Keuntungan</th>
                    <th class="px-2 py-2 border border-gray-300 font-medium text-[clamp(0.45rem,1vw,1rem)]">Status</th>
                    <th class="px-2 py-2 border border-gray-300 font-medium text-[clamp(0.45rem,1vw,1rem)]">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)]">p</td>
                    <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)]">p</td>
                    <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)]">p</td>
                    <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)]">p</td>
                    <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)]">p</td>
                    <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)]">p</td>
                    <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)]">p</td>
                    <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)]">p</td>
                    <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)]">p</td>
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
    </div>
    
    <footer class="absolute bottom-0 right-0 left-0 bg-[#101018] p-6 text-center">
        <p class="text-white">&copy; 2025 Dean Bakery. All Right Reserved</p>
    </footer>
</body>
</html>
