<?php
include("connect.php");

if(session_status() == PHP_SESSION_NONE){
	session_start();
}
$conn = Connection();
?>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>말소확인</title>
<style>
table, th, td {
  text-align: center;
}
.title {
  margin: 1rem 0;
  font-size: 1.5rem;
  font-weight: bold;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<div class="title">[등록 마감]</div>
<div>
	<table class="table table-bordered table-hover">
		<tr class="table-warning"><th>회원 ID</th><th>이름</th><th>등록일</th><th>기간</th><th>마감일</th><th>남은 기간</th></tr>
<?php
// REGISTRATION........
$today = date("Y-m-d");
//DATE_ADD(CURDATE(),INTERVAL -5 DAY)
$sql = "SELECT customerID, (SELECT name FROM Customer_Info WHERE ID=Register.customerID) AS name, registered, how_long, (DATE_ADD(Register.registered,INTERVAL +Register.how_long MONTH)) AS expires, DATEDIFF((DATE_ADD(Register.registered,INTERVAL +Register.how_long MONTH)), CURDATE()) AS days_left FROM Register WHERE  DATEDIFF((DATE_ADD(Register.registered,INTERVAL +Register.how_long MONTH)), CURDATE()) between 0 AND 5";
$result = mysqli_query($conn, $sql);

if ($result!=false && mysqli_num_rows($result) > 0) {
	$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
	foreach($rows as $row) {
?>
		<tr>
			<td><a class="link"><?= $row["customerID"]; ?></a></td>
			<td><?= $row["name"]; ?></td>
			<td><?= $row["registered"]; ?></td>
			<td><?= $row["how_long"]; ?></td>
			<td><?= $row["expires"]; ?></td>
			<td class="table-danger"><?= $row["days_left"]; echo '일' ?></td>
		</tr>
<?php
	}
	if($result!=false)
		mysqli_free_result($result);
}
?>
	</table>
</div>

<div class="title">[락커 마감]</div>
<div>
	<table class="table table-bordered table-hover">
		<tr class="table-warning"><th>회원 ID</th><th>이름</th><th>락커 번호</th><th>등록일</th><th>기간</th><th>마감일</th><th>남은 기간</th></tr>
<?php
// LOCKER........
$today = date("Y-m-d");
//DATE_ADD(CURDATE(),INTERVAL -5 DAY)
$sql = "SELECT customerID, (SELECT name FROM Customer_Info WHERE ID=Locker_Register.customerID) AS name, lockerID, registered, how_long, (DATE_ADD(Locker_Register.registered,INTERVAL +Locker_Register.how_long MONTH)) AS expires, DATEDIFF((DATE_ADD(Locker_Register.registered,INTERVAL +Locker_Register.how_long MONTH)), CURDATE()) AS days_left FROM Locker_Register WHERE  DATEDIFF((DATE_ADD(Locker_Register.registered,INTERVAL +Locker_Register.how_long MONTH)), CURDATE()) between 0 AND 5";
$result = mysqli_query($conn, $sql);

if ($result!=false && mysqli_num_rows($result) > 0) {
	$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
	foreach($rows as $row) {
?>
		<tr>
			<td><a class="link"><?= $row["customerID"]; ?></td>
			<td><?= $row["name"]; ?></td>
			<td><?= $row["lockerID"]; ?></td>
			<td><?= $row["registered"]; ?></td>
			<td><?= $row["how_long"]; ?></td>
			<td><?= $row["expires"]; ?></td>
			<td class="table-danger"><?= $row["days_left"]; echo '일' ?></td>
		</tr>
<?php
	}
	if($result!=false)
		mysqli_free_result($result);
}
?>
	</table>
</div>

<div class="title">[레슨 마감]</div>
<div>
	<table class="table table-bordered table-hover">
		<tr class="table-warning"><th>회원 ID</th><th>이름</th><th>강사님</th><th>등록일</th><th>기간</th><th>마감일</th><th>남은 기간</th></tr>
<?php
// REGISTRATION........
$today = date("Y-m-d");
//DATE_ADD(CURDATE(),INTERVAL -5 DAY)
$sql = "SELECT customerID, (SELECT name FROM Customer_Info WHERE ID=Lesson_Register.customerID) AS name, (SELECT name FROM Teacher_Info WHERE teacherID=Lesson_Register.teacherID) AS teacher_name, registered, how_long, (DATE_ADD(Lesson_Register.registered,INTERVAL +Lesson_Register.how_long MONTH)) AS expires, DATEDIFF((DATE_ADD(Lesson_Register.registered,INTERVAL +Lesson_Register.how_long MONTH)), CURDATE()) AS days_left FROM Lesson_Register WHERE  DATEDIFF((DATE_ADD(Lesson_Register.registered,INTERVAL +Lesson_Register.how_long MONTH)), CURDATE()) between 0 AND 5";
$result = mysqli_query($conn, $sql);

if ($result!=false && mysqli_num_rows($result) > 0) {
	$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
	foreach($rows as $row) {
?>
		<tr>
			<td><a class="link"><?= $row["customerID"]; ?></td>
			<td><?= $row["name"]; ?></td>
			<td><?= $row["teacher_name"]; ?></td>
			<td><?= $row["registered"]; ?></td>
			<td><?= $row["how_long"]; ?></td>
			<td><?= $row["expires"]; ?></td>
			<td class="table-danger"><?= $row["days_left"]; echo '일' ?></td>
		</tr>
<?php
	}
	if($result!=false)
		mysqli_free_result($result);
}
?>
	</table>
</div>
<script>
$('.link').on("click",function(){
  window.open("./검색.php?name_id="+$(this).text()+"&name_id_search=검색");
});
</script>
</body>
</html>