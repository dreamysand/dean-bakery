<?php
if (isset($_GET['delete_all'])) {
	$cart = isset($_SESSION['cart']) ? unserialize($_SESSION['cart']) : new Cart();
	$cart->DeleteAllItems();
	$_SESSION['cart'] = serialize($cart);

	$json = [
		"status" => "success",
		"html" => "<h2 class='text-4xl font-bold text-center mb-6 text-gray-800'>Daftar Keranjang</h2>

        <div class='flex justify-between mt-[5rem] items-end'>
            <h3 class='text-[2.5rem] font-bold text-gray-800'>Keranjang</h3>
        </div>"
	];
	echo json_encode($json);
	exit();
}
?>