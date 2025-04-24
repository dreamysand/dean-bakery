<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="icon" type="image/png" href="assets/logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/c2a393db2e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <div id="products" class="mt-10 mx-6 relative">
        <h2 class="text-4xl font-bold text-center mb-6 text-gray-800">Data Penjualan<?php if (isset($_GET['tanggal']) && !empty($_GET['tanggal'])) {
            echo " Tanggal ".$_GET['tanggal'];
        } if (isset($_GET['bulan']) && !empty($_GET['bulan'])) {
            $nama_bulan = date('F', mktime(0, 0, 0, $_GET['bulan'], 10));
            echo " $nama_bulan";
        } if (isset($_GET['tahun']) && !empty($_GET['tahun'])) {
            echo " ".$_GET['tahun'];
        }?></h2>
        <div class="mb-6 flex items-center absolute top-[-5] right-6 bg-[#E7B548] px-4 py-2 rounded text-white mt-2 mr-2">
          <form method="GET" action="" class="flex items-center space-x-2 text-sm text-white">
            <!-- Tahun -->
            <label for="tahun" class="mr-1">Tahun:</label>
            <select name="tahun" id="tahun" onchange="UpdateTanggal()" class="text-black rounded px-1 py-1">
                <option value="" selected>Tahun</option>
                <?php
                $tahun_sekarang = date("Y");
                for ($i = $tahun_sekarang; $i >= $tahun_sekarang - 10; $i--) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>

            <!-- Bulan -->
            <label for="bulan" class="ml-2 mr-1">Bulan:</label>
            <select name="bulan" id="bulan" onchange="UpdateTanggal()" class="text-black rounded px-1 py-1">
                <option value="" selected>Bulan</option>
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    $value_bulan = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $nama_bulan = date('F', mktime(0, 0, 0, $i, 10));
                    echo "<option value='$value_bulan'>$nama_bulan</option>";
                }
                ?>
            </select>

            <!-- Tanggal -->
            <label for="tanggal" class="ml-2 mr-1">Tanggal:</label>
            <select name="tanggal" id="tanggal" class="text-black rounded px-1 py-1">
                <option value="" selected>Tanggal</option>
            </select>

            <!-- Tombol -->
            <button type="submit" class="ml-3 bg-white text-[#E7B548] px-3 py-1 rounded hover:bg-gray-200">Tampilkan</button>
            <button type="button" onclick="window.location.href='laporan.php'" class="ml-3 bg-white text-[#E7B548] px-3 py-1 rounded hover:bg-gray-200">Reset</button>
          </form>
        </div>
        <div class="overflow-x-auto bg-white rounded-lg shadow-lg mt-6">
        <table class="min-w-full text-left text-gray-800 text-center text-wrap">
            <thead class="bg-[#E7B548] text-white">
                <tr>
                    <th class="px-2 py-2 border border-gray-300 font-medium text-[clamp(0.45rem,1vw,1rem)]">Total Modal</th>
                    <th class="px-2 py-2 border border-gray-300 font-medium text-[clamp(0.45rem,1vw,1rem)]">Total Penjualan</th>
                    <th class="px-2 py-2 border border-gray-300 font-medium text-[clamp(0.45rem,1vw,1rem)]">Total Keuntungan</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)]"><?= number_format($total_modal, 0, ',', '.')?></td>
                    <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)]"><?= number_format($total_penjualan, 0, ',', '.')?></td>
                    <td class="px-2 py-2 border border-gray-300 text-[clamp(0.45rem,1vw,1rem)]"><?= number_format($total_keuntungan, 0, ',', '.')?></td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4 mt-6">
        <div class="w-full max-w-lg aspect-square mx-auto">
            <canvas id="chartKeuntungan" class="w-full h-full"></canvas>
            <h2 class="px-2 py-2 text-center font-medium text-[clamp(0.45rem,1vw,1rem)]">Diagram Pie Penjualan</h2>
        </div>
        <div class="w-full aspect-[16/9]">
            <div id="chartContainer" class="w-[80%] mx-auto h-full"></div>
            <h2 class="px-2 py-2 text-center font-medium text-[clamp(0.45rem,1vw,1rem)]">Grafik Penjualan Minggu Ini</h2>
        </div>
    </div>
    
    <script>
    window.onload = function () {
        // Chart pertama
        var chart1 = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "Grafik Modal & Keuntungan Minggu Ini"
            },
            axisY: {
                title: "Jumlah (Rp)"
            },
            toolTip: {
                shared: true
            },
            data: [
                {
                    type: "line",
                    name: "Modal",
                    showInLegend: true,
                    dataPoints: <?php echo json_encode($modalPoints, JSON_NUMERIC_CHECK); ?>
                },
                {
                    type: "line",
                    name: "Keuntungan",
                    showInLegend: true,
                    dataPoints: <?php echo json_encode($keuntunganPoints, JSON_NUMERIC_CHECK); ?>
                }
            ]
        });
        chart1.render();
    }
    </script>


    <script>
        var ctx = document.getElementById('chartKeuntungan').getContext('2d');
        var chartKeuntungan = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Modal', 'Penjualan'],
                datasets: [{
                    data: [<?= $total_modal ?>, <?= $total_penjualan ?>],
                    backgroundColor: ['#D40909' ,'#20C10B']  
                }]
            }
        });
    </script>
    
    <script>
        function UpdateTanggal() {
            const tahun = document.getElementById("tahun");
            const bulan = document.getElementById("bulan");
            const tanggal = document.getElementById("tanggal");

            const jumlah_hari = new Date(tahun.value, bulan.value, 0).getDate();

            for (var i = 1; i <= jumlah_hari; i++) {
                const padded = String(i).padStart(2, '0');
                const tanggal_option = document.createElement("option");
                tanggal_option.value = padded;
                tanggal_option.innerText = padded;

                tanggal.appendChild(tanggal_option);
            }
        }
        UpdateTanggal();
    </script>

    <footer class="absolute bottom-0 right-0 left-0 bg-[#101018] p-6 text-center">
        <p class="text-white">&copy; 2025 Dean Bakery. All Right Reserved</p>
    </footer>
</body>
</html>
