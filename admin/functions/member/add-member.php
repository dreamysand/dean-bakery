<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
    isset($_GET['member']) &&
	isset($_POST['nama']) &&
    isset($_POST['no_telp'])) {

    $nama = htmlspecialchars($_POST['nama']);
	$no_telp = htmlspecialchars($_POST['no_telp']);
    $table = "member";

    $member = new Member();
    $member_column = $member->CheckMember($no_telp);
        if ($member_column > 0) {
            ?>
            <script>
                alert("Member sudah ada");
                window.location.href = "member-table.php";
            </script>
            <?php
        }
    if ($member->AddMember($nama, $no_telp)) {
        ?>
        <script>
            alert("Member berhasil ditambahkan");
            window.location.href = "member-table.php";
        </script>
        <?php
    } else {
        ?>
        <script>
            alert("Member gagal ditambahkan");
            window.location.href = "member-table.php";
        </script>
        <?php
    }
}
?>