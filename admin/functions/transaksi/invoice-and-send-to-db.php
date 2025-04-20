<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$_SESSION['invoice_data'] = json_decode(file_get_contents("php://input"), true);
}

if (isset($_SESSION['invoice_data']) &&
	isset($_GET['sendtodb'])
) {
	$member = new Member();
	$transaksi = isset($_SESSION['transaksi']) ? unserialize($_SESSION['transaksi']) : new Transaksi();
	$table_varian = "detail_produk";
	$table = "member";
	$table_transaksi = "transaksi";
	$table_detail_transaksi = "detail_transaksi";

	$data = $_SESSION['invoice_data'];
	$pay = $data['pay'];
	$ret = $data['return'];
	$total_price = $data['total_price'];
	$no_telp = $data['no_telp'];
	$metode_pembayaran = $data['metode'];
	$id_member = $data['id_member'];
	$id_metode_pembayaran = $data['id_metode'];
	$usage_point = $data['point_usage'];

	$kode_unik_transaksi = bin2hex(random_bytes(5));
	$_SESSION['invoice_data']['kode_unik'] = $kode_unik_transaksi;
		
	$produk = new Produk();
	$total_keuntungan = 0;

	foreach ($data['data'] as $item) {
		$data_produk = $produk->SelectVarian($item['id_varian'], $item['id_produk'], null, null);
		$total_keuntungan += $data_produk['keuntungan_per_produk'] * $item['jumlah'];
	}

	$istransaksiset = false;
	foreach ($data['data'] as $item) {
		$id_produk = $item['id_produk'];
		$id_varian = $item['id_varian'];
		$jumlah = $item['jumlah'];
		$subtotal = $item['subtotal'];
		$tanggal = $item['tanggal'];
		
		if (!$istransaksiset) {
			if ($transaksi->SendToTableTransaksi($kode_unik_transaksi, $tanggal, $total_price, 13, $pay, $usage_point*1000, $id_metode_pembayaran, $ret, $total_keuntungan)) {
				$istransaksiset = true;

				if ($transaksi->SendToTableDetailTransaksi($kode_unik_transaksi, $id_varian, $id_member, $jumlah, $subtotal)) {
					if ($member->SubtractPoint($id_member, $usage_point)) {
						if ($total_price + ($usage_point*1000) > 10000) {
							$point_gained = floor(($total_price + ($usage_point*1000))/10000);
							if ($member->AddPoint($id_member, $point_gained)) {
								echo "Hurayo";
							}
						}
					}
					if ( $member->UpdateActiveTime($id_member)) {
						echo "Huraya";
					}
					if ($member->UpdateStatusMemberToActive($id_member)) {
						echo "Hurayi";
					}
				} else {
					echo "Oh SHite";
				}
			} else {
				echo "Omg";
			}
		} else {
			if ($transaksi->SendToTableDetailTransaksi($kode_unik_transaksi, $id_varian, $id_member, $jumlah, $subtotal)) {
				echo "Omgshit";
			} else {
				echo "Oh Min";
			}
		}
	}

	$transaksi->DeleteAllTransaksi();
	$_SESSION['transaksi'] = serialize($transaksi);
}

if (isset($_SESSION['invoice_data']) &&
	isset($_GET['downloadpdf']) ||
	isset($_GET['printpdf']) ||
	isset($_GET['sendwa'])
) {
	if (!empty($_SESSION['invoice_data'])) {
		$produk = new Produk();
        $table_produk = "produk";
        $table_varian = "detail_produk";
        $data = $_SESSION['invoice_data'];

        $pay = $data['pay'];
		$ret = $data['return'];
		$total_price = $data['total_price'];
		$kode_unik_transaksi = $_SESSION['invoice_data']['kode_unik'];
		$no_telp = $data['no_telp'];
		$metode_pembayaran = $data['metode'];
		$row = '';
        foreach ($data['data'] as $item) {
        	$data_produk = $produk->SelectProduk($item['id_produk'], null);
        	$data_varian = $produk->SelectVarian($item['id_varian'], $item['id_produk'], null, null);

        	$row .= "
        	<tr>
	            <td>".$data_produk['nama_produk']."</td>
	            <td>".$data_varian['varian']."</td>
	            <td>".$item['jumlah']."</td>
	            <td>Rp. ".$item['subtotal']."</td>
	            <td>".$item['tanggal']."</td>
	        </tr>
        	";
        }

		$html = "
		<!DOCTYPE html>
		<html>
		<head>
		    <meta charset='UTF-8'>
		    <style>
		        body {
		            font-family: sans-serif;
		            padding: 30px;
		            background-color: #ffffff;
		        }
		        h1 {
		            text-align: center;
		            font-size: 24px;
		            font-weight: bold;
		            margin-bottom: 30px;
		            color: #1f2937;
		        }
		        table {
		            width: 100%;
		            border-collapse: collapse;
		            font-size: 14px;
		        }
		        th, td {
		            border: 1px solid #d1d5db;
		            padding: 10px;
		        }
		        th {
		            background-color: #f3f4f6;
		            text-align: left;
		        }
		        td.text-right {
		            text-align: right;
		        }
		        .total {
		            font-weight: bold;
		            background-color: #f9fafb;
		        }
		    </style>
		</head>
		<body>
		    <h1>Invoice Pembelian - Dean Bakery</h1>
		    <h3>Kode Unik         : ".$kode_unik_transaksi."</h3>
		    <h3>Member            : ".$no_telp."</h3>
		    <h3>Metode Pembayaran : ".$no_telp."</h3>
		    <table>
		        <thead>
		            <tr>
		                <th>Produk</th>
		                <th>Varian</th>
		                <th>Jumlah</th>
		                <th>Subtotal</th>
		                <th>Tanggal</th>
		            </tr>
		        </thead>
		        <tbody>
		            ".$row."
		            <tr class='total'>
		                <td colspan='3'>Harga Awal</td>
		                <td class='text-right'>Rp. ".number_format($total_price, 0, ',', '.')."</td>
		            </tr>
		            <tr class='total'>
		                <td colspan='3'>Potongan Harga</td>
		                <td class='text-right'>Rp. ".number_format($pay, 0, ',', '.')."</td>
		            </tr>
		            <tr class='total'>
		                <td colspan='3'>Total Harga</td>
		                <td class='text-right'>Rp. ".number_format($pay, 0, ',', '.')."</td>
		            </tr>
		            <tr class='total'>
		                <td colspan='3'>Bayar</td>
		                <td class='text-right'>Rp. ".number_format($pay, 0, ',', '.')."</td>
		            </tr>
		            <tr class='total'>
		                <td colspan='3'>Kembali</td>
		                <td class='text-right'>Rp. ".number_format($ret, 0, ',', '.')."</td>
		            </tr>
		        </tbody>
		    </table>

		    <p style='margin-top: 30px; font-size: 13px;'>Terima kasih telah berbelanja di Dean Bakery.</p>
		</body>
		</html>
		";

		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();

		header("Content-Type: application/pdf");
		header("Content-Disposition: attachment; filename='struk_transaksi_'.$kode_unik_transaksi.'.pdf'");
		$output = $dompdf->output();
		echo $output;

		if (isset($_GET['sendwa'])) {
			$token = 'wiq10sk3b9i4p4w9';
			$instanceId = 'instance111688';
			$phone = '088210266308'; // no WA tujuan

			$url = "https://api.ultramsg.com/$instanceId/messages/document";
			$data = [
			    'token' => $token,
			    'to' => $phone,
			    'filename' => 'invoice.pdf',
			    'document' => ' https://82ae-114-10-31-241.ngrok-free.app/aca/kasir/' . $tempFilePath // Harus URL akses publik
			];

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			$response = curl_exec($ch);
			curl_close($ch);

			echo $response;
		}
		exit();
	}
}

if (isset($_SESSION['invoice_data']) &&
	isset($_GET['close'])
) {
	unset($_SESSION['invoice_data']);
}
?>