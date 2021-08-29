<?php
include("connect.php");

if(session_status() == PHP_SESSION_NONE){
	session_start();
}
?>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>체크인</title>
<style>
table, th, td {
  border: 1px solid black;
  text-align: center;
}

table {
  max-width: 50%;
}

td > form {
  margin: 0 0;
  display: inline;
}
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<div>
	<form class="m-4" method="GET">
		<input type="text" name="code" placeholder="핸드폰 뒷자리..." autofocus>
		<input type="submit" name="checkin-serach" value="체크인">
	</form>
</div>
<hr size="3">
<?php
if(isset($_GET["checkin-serach"])){ 
	$conn = Connection();
	
	$today = date("Y-m-d");
	$code = $_GET["code"];
	$result1 = mysqli_query($conn, "SELECT b.ID, b.name, b.mobile, a.expires FROM (SELECT customerID, DATE_ADD(registered,INTERVAL +how_long MONTH) AS expires FROM Register) AS a INNER JOIN Customer_Info AS b ON a.customerID = b.ID WHERE mobile LIKE '%$code' AND (a.expires > CURDATE())");
	if($result1!=false && mysqli_num_rows($result1) > 0){
		$rows = mysqli_fetch_all($result1);
?>
		<table class="table table-bordered table-hover table-condensed">
			<tr class="table-light"><th>회원 ID</th><th>이름</th><th>전화번호</th><th>-</th><th>마감일</th></tr>
<?php
			foreach($rows as $row) {
?>
				<tr>
					<td><a class="link"><?= $row[0]; ?></a></td>
					<td><?= $row[1]; ?></td>
					<td><?= $row[2]; ?></td>
					<td>
						<form action="./CD_check.php" method="POST">
							<input class="currentURL" type="text" name="currentURL" hidden>
							<input class="ID" type="text" name="ID" hidden>
							<input type="submit" name="checkin" value="&#10004;"> <!-- onclick="return confirm('지울까요?')" -->
						</form>
					</td>
					<td class="table-danger"><?= $row[3]; ?></td>
				</tr>
<?php		
			}
	}else{
?>
		<div class="title" style="text-align: center; font-size: 2em;">검색결과 없음...</div>
<?php
	}
	if($result1!=false)
		mysqli_free_result($result1);
	mysqli_close($conn);
}
?>
<script>
$('.link').on("click",function(){
  window.open("./검색.php?name_id="+$(this).text()+"&name_id_search=검색");
});

$('.currentURL').each(function() {
	$(this).val(window.location.href);
});
$('.ID').each(function() {
	$(this).val($(this).parent().parent().parent().children(':first-child').text());
});
</script>
</body>
</html>