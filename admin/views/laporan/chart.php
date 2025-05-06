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
    <div id="products" class="mt-10 mx-6 relative">
        <h2 class="text-4xl font-bold text-center mb-6 text-gray-800">Data Penjualan<?php if (isset($_GET['tanggal']) && !empty($_GET['tanggal'])) {
            echo " Tanggal ".$_GET['tanggal'];
        } if (isset($_GET['bulan']) && !empty($_GET['bulan'])) {
            $nama_bulan = date('F', mktime(0, 0, 0, $_GET['bulan'], 10));
            echo " $nama_bulan";
        } if (isset($_GET['tahun']) && !empty($_GET['tahun'])) {
            echo " ".$_GET['tahun'];
        }?></h2>
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
    <div>
        <div class="grid grid-cols-1 gap-4 mt-6">
        <h2 class="text-4xl font-bold text-center mb-6 text-gray-800">Grafik Penjualan<?php if (isset($_GET['tanggal']) && !empty($_GET['tanggal'])) {
                echo " Tanggal ".$_GET['tanggal'];
            } if (isset($_GET['bulan']) && !empty($_GET['bulan'])) {
                $nama_bulan = date('F', mktime(0, 0, 0, $_GET['bulan'], 10));
                echo " $nama_bulan";
            } if (isset($_GET['tahun']) && !empty($_GET['tahun'])) {
                echo " ".$_GET['tahun'];
            }?></h2>
            <div class="w-full max-w-sm aspect-square mx-auto">
                <canvas id="chartKeuntungan" class="w-full h-full"></canvas>
                <h2 class="px-2 py-2 text-center font-medium text-[clamp(0.45rem,1vw,1rem)]">Diagram Pie Penjualan</h2>
            </div>
            <div class="w-full max-w-xl aspect-[16/9] mx-auto">
                <div id="chartContainer" class="w-[80%] mx-auto h-full"></div>
                <h2 class="px-2 py-2 text-center font-medium text-[clamp(0.45rem,1vw,1rem)]">Grafik Penjualan Minggu Ini</h2>
            </div>
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
</body>
</html>
