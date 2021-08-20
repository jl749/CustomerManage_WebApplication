<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>체크인 기록</title>
<style>
table, th, td {
  border: 1px solid black;
  text-align: center;
}

table {
  max-width: 40%;
}

td > form {
  margin: 0 0;
  display: inline;
}
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<body>
<?php
	include("connect.php");
	// header('Content-Type: text/html; charset=utf-8');

	if(session_status() == PHP_SESSION_NONE){
		session_start();
	}

	//print_r($_GET);
	$conn = Connection();
	$ids = explode(" ", $_GET['ID']);

?>
	<table class="mt-5 table table-bordered table-hover table-condensed">
		<tr class="table-light"><th>회원 ID</th><th>날짜</th><th>시간</th><th>-</th></tr>
<?php

	foreach($ids as $id){
		$sql = "SELECT * FROM Check_In WHERE customerID='$id' AND checkinDate > DATE_ADD(checkinDate, INTERVAL -1 MONTH) ORDER BY checkinDate DESC";
		$result = mysqli_query($conn, $sql);
		if ($result!=false && mysqli_num_rows($result) > 0) {
			$rows = mysqli_fetch_all($result);
				foreach($rows as $row) {
?>
					<tr>
						<td><?= $row[0]; ?></td>
						<td><?= $row[1]; ?></td>
						<td><?= $row[2]; ?></td>
						<td>
							<form action="./CD_check.php" method="POST">
								<input class="currentURL" type="text" name="currentURL" hidden>
								<input class="ID" type="text" name="ID" hidden>
								<input class="today" type="text" name="today" hidden>
								<input type="submit" name="delete" class="del" value="X"> <!-- onclick="return confirm('지울까요?')" -->
							</form>
						</td>
					</tr>
<?php
				}
		}
	}
	mysqli_close($conn);
?>
	<table>
<script>
$('.currentURL').each(function() {
	$(this).val(window.location.href);
});
$('.ID').each(function() {
	$(this).val($(this).parent().parent().parent().children(':first-child').text());
});
$('.today').each(function() {
	$(this).val($(this).parent().parent().parent().children(':nth-child(2)').text());
});

$('.del').click(function(){
	$del_info = [$(this).parent().parent().parent().children(':first-child').text(), $(this).parent().parent().parent().children(':nth-child(2)').text()];
	return confirm('('+$del_info[0]+', '+$del_info[1]+')\n삭제합니다까?');
});
</script>
</body>
</html>