<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" &&
	isset($_POST['id_produk']) && 
	isset($_POST['id_varian'])) {

	$id_member = htmlspecialchars($_POST['id_member']);
    $table = "member";
	$member = new Member();
	$image = new Image();
	$member_Data = $member->SelectMember($id_member);
	if ($member_Data != null) {
        if ($member->DeleteMember($id_member)) {
	    	?>
	    	<script>
	    		alert("member berhasil dihapus");
	    		window.location.href = "member-table.php";
	    	</script>
	    	<?php
	    } else {
	    	?>
	    	<script>
	    		alert("member gagal dihapus");
	    		window.location.href = "member-table.php";
	    	</script>
	    	<?php
	    }

	}
}
?>