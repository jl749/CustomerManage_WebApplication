<?php
include("connect.php");

if(session_status() == PHP_SESSION_NONE){
	session_start();
}

$conn = Connection();
$sql = "SELECT teacherID, name, mobile, dob, (SELECT TIMESTAMPDIFF(YEAR, Teacher_Info.dob, CURDATE())) AS age, address, note FROM Teacher_Info";
$result = mysqli_query($conn, $sql);

//print_r($rows)
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>강사정보</title>
<style>
table {
  text-align: center;
}

.regInput {
  width: 10rem;
  margin: 0.1rem;
}

.collapsible {
  background-color: #eee;
  color: #444;
  cursor: pointer;
  width: 100%;
  border: none;
  text-align: center;
  outline: none;
  font-size: 15px;
  height: 1.5rem;
  font-weight: bold;
}

.active, .collapsible:hover {
  background-color: #ccc;
}

.content {
  padding: 0 1rem;
  display: none;
  overflow: hidden;
}

.title {
  font-size: 1.5rem;
  font-weight: bold;
  margin: 1rem 0;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="title">강사 페이지 입니다</div>
<div>
	<table class="table table-bordered table-hover table-condensed" style="margin-bottom: 0;">
		<tr class="table-success"><th>강사 ID</th><th>이름</th><th>전화번호</th><th>생일</th><th>나이</th><th>주소</th><th>비고</th><th>-</th></tr>
<?php
		if ($result!=false && mysqli_num_rows($result) > 0) {
			$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
			foreach($rows as $row) {
?>
				<tr>
					<td><?= $row["teacherID"]; ?></td>
					<td><?= $row["name"]; ?></td>
					<td><?= $row["mobile"]; ?></td>
					<td><?= $row["dob"]; ?></td>
					<td><?= $row["age"]; ?></td>
					<td><?= $row["address"]; ?></td>
					<td><?= $row["note"]; ?></td>
					<td class="table-danger">
						<form action="./CUD_teacher.php" method="POST">
							<input class="instanceID" type="text" name="ID" hidden>
							<input type="submit" name="delete" class="del" value="X"> <!-- onclick="return confirm('지울까요?')" -->
						</form>
					</td>
				</tr>
<?php
			}
		}
	mysqli_close($conn);
?>
	</table>
	<button type="button" class="collapsible">강사 추가▽</button>
	<div class="content">
	  <form action="./CUD_teacher.php" method="POST" id="inputform" style="margin-top: 0.3rem;">
		이름: 
		<input class="regInput" type="text" name="name" required></br>
		전화번호: 
		<input class="regInput" style="width: 8rem;" type="text" name="phone" placeholder="010-xxxx-xxxx" pattern="[0-9]{3}-[0-9]{4}-[0-9]{4}" required></br>
		생일: 
		<input class="regInput" type="date" name="dob" value="<?php echo date("Y-m-d");?>" required></br>
		<textarea id="address" rows="2" cols="50" name="address" placeholder="주소 입력란 ..."></textarea></br>
		<textarea rows="4" cols="50" name="comment" form="inputform" placeholder="비고 입력란 ..."></textarea>
		<input type="submit" name="insert" value="추가">
	  </form>
	</div> 
</div>

<script>
	$('.del').click(function(){
		$del_info = [$(this).parent().parent().parent().children(':first-child').text(), $(this).parent().parent().parent().children(':nth-child(2)').text()];
		return confirm('('+$del_info[0]+', '+$del_info[1]+')\n삭제합니다까?');
	});
	$('.instanceID').each(function() {
		//First child of td
		$id = $(this).parent().parent().parent().children(':first-child').text();
		$(this).val($id);
		//console.log($(this));
    });
	
	var coll = document.getElementsByClassName("collapsible");
	var i;

	for (i = 0; i < coll.length; i++) {
	  coll[i].addEventListener("click", function() {
		this.classList.toggle("active");
		var content = this.nextElementSibling;
		if (content.style.display === "block") {
		  content.style.display = "none";
		} else {
		  content.style.display = "block";
		}
	  });
	} 
</script>
</body>
</html>