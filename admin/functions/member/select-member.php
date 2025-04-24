<?php
$table = "member";
$members = new Member();

$limit = 1;
$page = isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_rows = $members->CountMembers(); 
$total_pages = ceil($total_rows/$limit);

$members_Data = $members->SelectMembersWithOffsetLimit($limit, $offset);
$members_Data_All = $members->SelectMembers();
if ($members_Data != null) {
	?>
	<script>
		console.log("Tabel member berhasil diambil");
	</script>
	<?php 	
	foreach ($members_Data_All as $member_Data) {
		$last_transaction = $members->CheckActiveTime($member_Data['id_member']);

		if ($last_transaction) {
			$members->UpdateStatusMemberToActive($member_Data['id_member']);
		} else {
			?>
			<script>
				alert("Member dengan id: ".<?php echo $member_Data['id'] ?>." telah nonaktif")
			</script>
			<?php
			$members->UpdateStatusMemberToInactive($member_Data['id_member']);
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