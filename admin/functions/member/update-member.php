<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
    isset($_GET['member']) &&
    isset($_POST['nama']) &&
    isset($_POST['id_member']) &&
    isset($_POST['no_telp'])) {

    $nama = htmlspecialchars($_POST['nama']);
    $no_telp = htmlspecialchars($_POST['no_telp']);
    $table = "member";

    $member = new Member();
    $member_column = $member->CheckMemberUpdate($no_telp, $id_member);
        if ($member_column > 0) {
            ?>
            <script>
                alert("Member sudah ada");
                window.location.href = "member-table.php";
            </script>
            <?php
        }
    if ($member->UpdateMember($nama, $no_telp, $id_member)) {
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