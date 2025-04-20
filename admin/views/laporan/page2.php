<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan</title>
    <link rel="website icon" type="image/png" href="asset/Richa Mart.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
            padding: 10px 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .logo img {
            height: 50px;
        }
        .icons {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .icons img {
            width: 30px;
            height: 30px;
            cursor: pointer;
            border-radius: 50%;
            object-fit: cover;
        }
        table {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            border: 1px solid #A1B8FF;
            padding: 10px;
            text-align: center;
            font-size: 14px;
        }
        th {
            background: #A1B8FF;
            color: white;
        }
        .sidebar {
            position: fixed;
            left: -250px;
            top: 0;
            width: 250px;
            height: 100%;
            background: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            transition: left 0.3s ease-in-out;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar a {
            display: block;
            text-decoration: none;
            color: black;
            background: #A1B8FF;
            padding: 15px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background: #8fa3ff;
        }

        .logout {
            background: red !important;
            color: white;
            font-weight: bold;
            border-radius: 10px;
        }
        .laporan-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 8px 15px;
            background: #4A90E2;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }
        .laporan-button:hover {
            background: #357ABD;
        }
        .footer {
            padding: 20px;
            background: white;
            margin-top: 25px;
        }
        .filter-form {
            margin: 20px auto;
            background: white;
            padding: 15px;
            border-radius: 10px;
            width: 30%;
        }
        .filter-form input, .filter-form select {
            padding: 5px 10px;
            margin-right: 10px;
        }
        .filter-form button {
            padding: 5px 15px;
            background: #4A90E2;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .filter-form button:hover {
            background: #357ABD;
        }
        #chartKeuntungan {
    width: 20%;      /* Lebar diperkecil */
    height: 90px;   /* Tinggi juga diperkecil */
    margin: 0 auto;  /* Biar tetap di tengah */
}
    </style>
</head>
<body>
<div id="laporanfield">
<table>
    <tr>
        <th>Total Modal</th>
        <th>Total Penjualan</th>
        <th>Total Keuntungan</th>
    </tr>
    <tr>
        <td>Rp <?= number_format($total_modal, 0, ',', '.') ?></td>
        <td>Rp <?= number_format($total_penjualan, 0, ',', '.') ?></td>
        <td>Rp <?= number_format($total_keuntungan, 0, ',', '.') ?></td>
    </tr>
</table>

<canvas id="chartKeuntungan"></canvas>
<script>
    var ctx = document.getElementById('chartKeuntungan').getContext('2d');
var chartKeuntungan = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Keuntungan'],
        datasets: [{
            data: [<?= $total_keuntungan ?>],
            backgroundColor: ['#6495ED']  
        }]
    }
});
</script>
</div>
</body>
</html>
