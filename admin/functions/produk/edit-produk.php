<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
    isset($_POST['id_produk']) && 
    isset($_POST['id_varian'])) {

    $id_produk = htmlspecialchars($_POST['id_produk']);
    $id_varian = htmlspecialchars($_POST['id_varian']);
    $table_produk = "produk";
    $table_varian = "detail_produk";

    $produk = new Produk();
    $produk_Data = $produk->SelectProduk($id_produk, null);
    if ($produk_Data != null) {
        ?>
        <script>
            console.log("Data produk berhasil diambil");
        </script>
        <?php   
        $varian_Data = $produk->SelectVarian($id_varian, $id_produk, null, null);
        if ($varian_Data != null) {
            ?>
            <script>
                console.log("Data varian berhasil diambil");
            </script>
            <?php   
        } else {
            ?>
            <script>
                console.log("Data varian gagal diambil");
            </script>
            <?php   
        }
    } else {
        ?>
        <script>
            console.log("Data produk gagal diambil");
        </script>
        <?php
    }
}
?>