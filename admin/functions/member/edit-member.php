<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
	isset($_POST['id_member'])) {

	$id_member = htmlspecialchars($_POST['id_member']);
    $table = "member";
	$member = new Member();
    $member_Data = $member->SelectMember($id_member);
    if ($member_Data != null) {
        ?>
        <script>
            console.log("Data member berhasil diambil");
        </script>
        <?php   
    } else {
        ?>
        <script>
            console.log("Data member gagal diambil");
        </script>
        <?php
    }
}
?>