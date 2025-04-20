<?php
$table = "member";
$members = new Member();
$members_Data = $members->SelectMembers();
if ($members_Data != null) {
	?>
	<script>
		console.log("Tabel member berhasil diambil");
	</script>
	<?php 	
	foreach ($members_Data as $member_Data) {
		$last_transaction = $members->CheckActiveTime($member_Data['id_member']);

		if ($last_transaction) {
			$members->UpdateStatusMember1($member_Data['id_member']);
		}
	}
} else {
	?>
	<script>
		console.log("Tabel member gagal diambil");
	</script>
	<?php
}
?>