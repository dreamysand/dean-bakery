<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
	isset($_POST['email']) &&
	isset($_POST['password'])) {

	$email = htmlspecialchars($_POST['email']);
	$password = htmlspecialchars($_POST['password']);
    $table = "admin";
	
	$account = new Account();
	$account_Check = $account->CheckEmail($email);
	if ($account_Check > 0) {
		$account_Data = $account->SelectAccount($email);
		if ($account_Data != null) {
			$db_Password = $account_Data['password'];
			$email = $account_Data['email'];
			$username = $account_Data['username'];
			$id_admin = $account_Data['id'];
			$gambar = $account_Data['gambar'];
			if ($account->PasswordVerify($password, $db_Password)) {
				$status = $account->UpdateStatusAdmin($id_admin);
				$login_time = $account->UpdateActiveTime($id_admin);
				if (!$status['value'] && !$login_time) {
					?>
	                <script>
	                    alert("<?= $status['msg']; ?>");
	                    window.location.href = "login.php";
	                </script>
	                <?php
				}

				$account_Verified = new Account($id_admin, $email, $username, $password, $gambar);
				$_SESSION['admin'] = serialize($account_Verified);
				?>
                <script>
                    alert("Log in berhasil");
                    window.location.href = "admin/dashboard.php";
                </script>
                <?php
			} else {
				?>
                <script>
                    alert("Password salah");
                    window.location.href = "login.php";
                </script>
                <?php
			}
		} else {
			?>
            <script>
                alert("Data akun gagal diambil");
                window.location.href = "login.php";
            </script>
            <?php
		}
	} else {
		?>
        <script>
            alert("Email gagal ditemukan");
            window.location.href = "login.php";
        </script>
        <?php
	}
}
?>