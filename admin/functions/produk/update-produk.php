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
    isset($_POST['deskripsi']) && 
    isset($_POST['id_produk']) && 
    isset($_POST['id_varian']) && 
    isset($_POST['old_img'])) {

    $nama = htmlspecialchars($_POST['nama']);
    $varian = htmlspecialchars($_POST['varian']);
    $expired = htmlspecialchars($_POST['expired']);
    $stok = htmlspecialchars($_POST['stok']);
    $modal = htmlspecialchars($_POST['modal']);
    $harga_jual = htmlspecialchars($_POST['harga_jual']);
    $keuntungan = htmlspecialchars($_POST['keuntungan']);
    $id_kategori = (int)htmlspecialchars($_POST['id_kategori']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $id_produk = (int)htmlspecialchars($_POST['id_produk']);
    $id_varian = (int)htmlspecialchars($_POST['id_varian']);
    $image_Old = htmlspecialchars($_POST['old_img']);

    $table_produk = "produk";
    $table_varian = "detail_produk";

    if (isset($_FILES['gambar'])) {
        $dir_Separator = DIRECTORY_SEPARATOR;
        $root_Path = dirname(__DIR__, 4);
        $URL = "http://".$_SERVER['HTTP_HOST'];
        $path_Image_Old = str_replace($URL, $root_Path, $image_Old);
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
        $check_produk = $produk->CheckProdukDuplication($nama, $id_produk);

        if ($check_produk > 0) {
            ?>
            <script>
                alert("Produk duplikat");
                window.location.href = "produk.php";
            </script>
            <?php
        } else {
            if ($produk->UpdateProduk($id_produk, $nama, $id_kategori, $deskripsi)) {
                $check_varian = $produk->CheckVarianDuplication($varian, $id_varian, $id_produk);
                if ($check_varian > 0) {
                    ?>
                    <script>
                        alert("Varian duplikat");
                        window.location.href = "produk.php";
                    </script>
                    <?php
                } else {
                   if ($varian_data = $produk->SelectVarian(null, null, $varian, $nama)) {
                        $id_varian = $varian_data['id'];
                        $image_old = $varian_data['gambar'];
                        $path_image_old = str_replace($URL, $root_Path, $image_old);

                        $image_File = $image->UpdateImage($_FILES['gambar'], $path_Image, $URL_Path, $path_image_old, $image_old);

                        if ($image_File == null) {
                            ?>
                            <script>
                                alert("Gambar kosong");
                            </script>
                            <?php   
                        }
                        if ($produk->UpdateVarianB($id_varian, $varian, $expired, $stok, $modal, $harga_jual, $keuntungan, $image_File['url'])) {
                             ?>
                            <script>
                                alert("Produk berhasil diperbarui secara keseluruhan");
                                window.location.href = "produk.php";
                            </script>
                            <?php
                        } else {
                             ?>
                            <script>
                                alert("Gambar kosong");
                            </script>
                            <?php 
                        }
                    }
                }
            } else {
                echo "Gagal ngapdet";
                exit();
            }
        }
    }
}
?>