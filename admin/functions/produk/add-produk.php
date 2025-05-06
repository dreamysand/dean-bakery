<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
	isset($_POST['nama']) &&
    isset($_POST['varian']) &&
    isset($_POST['expired']) &&
    isset($_POST['stok']) &&
    isset($_POST['modal']) &&
    isset($_POST['harga_jual']) &&
    isset($_POST['keuntungan']) &&
	isset($_POST['id_kategori']) &&
	isset($_POST['deskripsi'])) {

	$nama = htmlspecialchars($_POST['nama']);
    $varian = htmlspecialchars($_POST['varian']);
    $expired = htmlspecialchars($_POST['expired']);
    $stok = htmlspecialchars($_POST['stok']);
    $modal = htmlspecialchars($_POST['modal']);
    $harga_jual = htmlspecialchars($_POST['harga_jual']);
    $keuntungan = htmlspecialchars($_POST['keuntungan']);
	$id_kategori = htmlspecialchars($_POST['id_kategori']);
	$deskripsi = htmlspecialchars($_POST['deskripsi']);
    $table_produk = "produk";
    $table_varian = "detail_produk";

	if (isset($_FILES['gambar'])) {
		$dir_Separator = DIRECTORY_SEPARATOR;
        $root_Path = dirname(__DIR__, 4);
        $URL = "http://".$_SERVER['HTTP_HOST'];
        $image_Storage = [
            "dean-bakery",
            "admin",
            "assets",
            "produk"
        ];
        $path_Image = "$root_Path$dir_Separator$image_Storage[0]$dir_Separator$image_Storage[1]$dir_Separator$image_Storage[2]$dir_Separator$image_Storage[3]$dir_Separator";
        $URL_Path = "$URL$dir_Separator$image_Storage[0]$dir_Separator$image_Storage[1]$dir_Separator$image_Storage[2]$dir_Separator$image_Storage[3]$dir_Separator";
        $image = new Image();
        $produk = new Produk();

        $check_produk = $produk->CheckProduk($nama);
        if ($check_produk > 0) {
            $produk_data = $produk->SelectProduk(null, $nama);
            $id_produk = $produk_data['id_produk'];
            if ($produk->UpdateProduk($id_produk, $nama, $id_kategori, $deskripsi)) {
                $check_varian = $produk->CheckVarian($varian, $nama);
                if ($check_varian > 0) {
                    if ($varian_data = $produk->SelectVarian(null, null, $varian, $nama)) {
                        $id_varian = $varian_data['id'];
                        $image_old = $varian_data['gambar'];
                        $path_image_old = str_replace($URL, $root_Path, $image_old);

                        $image_File = $image->UpdateImage($_FILES['gambar'], $path_Image, $URL_Path, $path_image_old, $image_old);

                        if ($image_File == null) {
                            ?>
                            <script>
                                alert("Gambar kosong");
                                window.location.href = "register-admin.php";
                            </script>
                            <?php   
                        }
                        if ($produk->UpdateVarianA($id_varian, $varian, $expired, $stok, $modal, $harga_jual, $keuntungan, $image_File['url'])) {
                            echo "Berhasil Hore Hore";
                            exit();
                        } else {
                            echo "Yah Gagal";
                            exit();
                        }
                    }
                } else {
                    $image_File = $image->ImageUpload($_FILES['gambar'], $path_Image, $URL_Path);

                    if ($image_File == null) {
                        ?>
                        <script>
                            alert("Gambar kosong");
                            window.location.href = "register-admin.php";
                        </script>
                        <?php   
                    }
                    $kode_bar = rand(10000000, 99999999);
                    if ($produk->AddVarian($nama, $varian, $expired, $stok, $modal, $harga_jual, $keuntungan, $image_File['url'], $kode_bar)) {
                       ?>
                        <script>
                            alert("Berhasil");
                            window.location.href = "produk.php";
                        </script>
                        <?php   
                    } else {
                       ?>
                        <script>
                            alert("Gagal");
                            window.location.href = "produk.php";
                        </script>
                        <?php   
                    }
                }
            } else {
                ?>
                <script>
                    alert("Gagal ngapdet");
                    window.location.href = "produk.php";
                </script>
                <?php   
            }
        } else {
            if ($produk->AddProduk($nama, $id_kategori, $deskripsi)) {
                $image_File = $image->ImageUpload($_FILES['gambar'], $path_Image, $URL_Path);

                if ($image_File == null) {
                    ?>
                    <script>
                        alert("Gambar kosong");
                        window.location.href = "produk.php";
                    </script>
                    <?php	
                }

                $check_varian = $produk->CheckVarian($varian, $nama);
                if ($check_varian > 0) {
                    echo "Ping Ping";
                    exit();
                } else {
                    $kode_bar = rand(10000000, 99999999);
                    if ($produk->AddVarian($nama, $varian, $expired, $stok, $modal, $harga_jual, $keuntungan, $image_File['url'], $kode_bar)) {
                       ?>
                        <script>
                            alert("Berhasil");
                            window.location.href = "produk.php";
                        </script>
                        <?php   
                    } else {
                       ?>
                        <script>
                            alert("Gagal");
                            window.location.href = "produk.php";
                        </script>
                        <?php   
                    }
                }
            } else {
                ?>
                <script>
                    alert("Gagal nambah");
                    window.location.href = "produk.php";
                </script>
                <?php   
            }
        }
	}
}
?>