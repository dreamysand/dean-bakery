<?php
if (!isset($_SESSION['forgot']) || $_SESSION['forgot'] == 0) {
	if ($_SERVER['REQUEST_METHOD'] == "POST" &&
		isset($_POST['email'])) {
		$email = htmlspecialchars($_POST['email']);
    	$table = "admin";	
    	$account = new Account();
		$account_Check = $account->CheckEmail($email);
		if ($account_Check > 0) {
			$_SESSION['forgot'] = 1;
			$_SESSION['forgot_email'] = $email;
		}
	}
} elseif (isset($_SESSION['forgot']) && $_SESSION['forgot'] == 1) {
	if ($_SERVER['REQUEST_METHOD'] == "POST" &&
		isset($_POST['password']) &&
		isset($_POST['confirm'])) {
		$email = $_SESSION['forgot_email'];
		$password = htmlspecialchars($_POST['password']);
		$confirm = htmlspecialchars($_POST['confirm']);
    	$table = "admin";	
    	$account = new Account();
		$account_Data = $account->SelectAccount($email);
		
		if (!is_null($account_Data)) {
			$id_admin = $account_Data['id'];
			if ($password === $confirm) {
				$password = $account->HashPassword($password);
				if ($account->UpdatePassword($id_admin, $password)) {
					?>
	                <script>
	                    alert("Password berhasil diganti");
	                    window.location.href = "login.php";
	                </script>
	                <?php
				} else {
					?>
	                <script>
	                    alert("Password gagal diganti");
	                </script>
	                <?php
				}
			} else {
				?>
                <script>
                    alert("Password tidak sesuai");
                </script>
                <?php
			}
		}
	}
}