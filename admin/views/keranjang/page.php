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
            <div class="flex space-x-6 w-full">    
                <div class="relative bg-white p-6 w-full flex rounded-lg shadow-lg transform transition ease-in-out duration-300 cursor-pointer border border-gray-200" onclick="window.location.href='table.php?type=obat&id=<?php echo $row['id']; ?>&page=<?php echo $page; ?>'">
                    <div class="w-[20%]">
                        <img src="../assets/roti-tawar.jpg" alt="Produk 1" class="aspect-[1/1] w-full object-cover mb-4 rounded-md">
                    </div>
                    <div class="relative w-[80%]">
                        <div class="ml-[3vw] mt-5">
                            <h3 class="text-xl font-semibold text-gray-800">Roti Tawar</h3>
                            <p class="text-gray-500">Original</p> 
                        </div>
                        <div class="ml-[3vw] mb-6">
                            <p>Rp 10.000</p>
                            <label for="jumlah_pembelian">Jumlah Pembelian</label>
                            <input type="number" name="jumlah_pembelian" class="w-[5%] border border-black rounded">
                        </div>
                    </div>
                    <div class="mb-6 flex items-center absolute right-6">
                        <input class="mr-2" type="checkbox" id="safety_quest" name="safety_quest">
                        <label class="text-sm" for="safety_quest">Pilih</label>
                    </div>
                    <div class="mb-6 flex items-center absolute bottom-3 right-6">
                        <p class="mr-4">Countdown: 90 Detik</p>
                        <a href="" class="text-[clamp(0.45rem,1vw,4rem)] p-1 hover:bg-opacity-75 rounded-md">
                            <i class="fa-solid fa-trash-can text-[#FF0909]"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="absolute bottom-0 right-0 left-0 bg-[#101018] p-6 text-center">
        <p class="text-white">&copy; 2025 Dean Bakery. All Right Reserved</p>
    </footer>
</body>
</html>
