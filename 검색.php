<?php
include("connect.php");

if(session_status() == PHP_SESSION_NONE){
	session_start();
}
?>
<html><head>
<style>
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
  margin-bottom: 1rem;
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
table, th, td {
  border: 1px solid black;
  text-align: center;
}
table {
  width: 100%;
}
.title {
  margin-top: 1rem;
  font-size: 1.5rem;
  font-weight: bold;
}
.regInput {
  width: 130px;
}
</style>
</head>
<body>
<div>
	<form method="GET">
		<input type="text" name="name_id">
		<input type="submit" name="name_id_search" value="검색">
	</form>
</div>
<hr size="3">
<?php
if(isset($_GET["name_id"])){ 
	$conn = Connection();
	$name_id = $_GET["name_id"];
	$pattern = "/^[0-9]+$/";
	$name = null;
	$id = [];
	if(preg_match($pattern, $name_id)) {
		$sql = "SELECT * FROM Register WHERE customerID='$name_id'";
		echo "회원번호로 검색: ".$name_id."\n";
		array_push($id, $name_id);
	}else{
		$sql = "SELECT * FROM Register WHERE customerID=(SELECT ID FROM Customer_Info WHERE name='$name_id')";
		$result = mysqli_query($conn, "SELECT ID FROM Customer_Info WHERE name='$name_id'");
		$rows = mysqli_fetch_all($result);
		
		foreach($rows as $row){
			array_push($id, $row[0]);
		}
		
		echo "이름으로 검색: ".$name_id."\n";
		$name = $name_id;
		mysqli_free_result($result);
	}

	if($id != null){
?>
		</br>
		<!-- 회원정보 -->
		<div class="title">[회원정보]</div>
		<div>
			<table>
				<tr><th>회원 ID</th><th>이름</th><th>전화번호</th><th>생일</th><th>나이</th><th>주소</th><th>비고</th></tr>
<?php
		foreach($id as $x){
			$result = mysqli_query($conn, "SELECT * FROM Customer_Info WHERE ID='$x'");
			$row = mysqli_fetch_assoc($result);
?>
			<tr>
				<td><?= $row["ID"]; ?></td>
				<td><?= $row["name"]; ?></td>
				<td><?= $row["mobile"]; ?></td>
				<td><?= $row["dob"]; ?></td>
				<td><?= $row["age"]; ?></td>
				<td><?= $row["address"]; ?></td>
				<td><?= $row["note"]; ?></td>
			</tr>
<?php
		}
?>
			</table>
		</div>
		<hr size="3">
		</br>
		<!-- 등록 -->
		<div class="title">[등록]</div>
		<div>
			<table>
				<tr><th>회원 ID</th><th>등록일</th><th>기간</th><th>마감일</th><th>-</th></tr>
<?php
		// REGISTRATION........
		foreach($id as $x){
			$sql = "SELECT * FROM Register WHERE customerID='$x'";
			$result = mysqli_query($conn, $sql);

			if ($result!=false && mysqli_num_rows($result) > 0) {
				$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
				//print_r($rows)
				foreach($rows as $row) {
?>
					<tr>
						<td><?= $row["customerID"]; ?></td>
						<td><?= $row["registered"]; ?></td>
						<td><?= $row["how_long"]; ?></td>
						<td><?= $row["expires"]; ?></td>
						<td><button type="button" class="del">X</button></td>
					</tr>
<?php
				}
			}
			if($result!=false)
				mysqli_free_result($result);
		}
?>
			</table>
			<button type="button" class="collapsible">회원권 추가▽</button>
			<div class="content">
			  <!-- FROM next??????? -->
			  <form action="./insertReg.php" method="POST">
				아이디:
				<input class="regInput" type="text" name="customer_id" value="<?php echo $id[0];?>"></br>
				등록일:
				<input class="regInput" type="date" name="reg_date" value="<?php echo date("Y-m-d");?>"></br>
				개월수:
				<input class="regInput" style="width: 82px;" type="text" name="how_long">
				<input type="submit" name="name_search" value="추가">
			  </form>
			</div> 
		</div>
		<!-- 락커 -->
		<div class="title">[락커]</div>
		<div>
			<table>
				<tr><th>회원 ID</th><th>락커 ID</th><th>등록일</th><th>기간</th><th>마감일</th><th>-</th></tr>
<?php
		// LOCKER........
		foreach($id as $x){
			$sql = "SELECT * FROM Locker_Register WHERE customerID='$x'";
			$result = mysqli_query($conn, $sql);

			if ($result!=false && mysqli_num_rows($result) > 0) {
				$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
				foreach($rows as $row) {
?>
					<tr>
						<td><?= $row["customerID"]; ?></td>
						<td><?= $row["lockerID"]; ?></td>
						<td><?= $row["registered"]; ?></td>
						<td><?= $row["how_long"]; ?></td>
						<td><?= $row["expires"]; ?></td>
						<td><button type="button" class="del">X</button></td>
					</tr>
<?php
				}
			}
			if($result!=false)
				mysqli_free_result($result);
		}
?>
			</table>
			<button type="button" class="collapsible">락커 추가▽</button>
			<div class="content">
			  <form action="./insertLoc.php" method="POST">
				아이디:
				<input class="regInput" type="text" name="customer_id" value="<?php echo $id[0];?>"></br>
				락커번호:
				<input class="regInput" style="width: 114px;" type="text" name="locker"></br>
				등록일:
				<input class="regInput" type="date" name="reg_date" value="<?php echo date("Y-m-d");?>"></br>
				개월수:
				<input class="regInput" style="width: 82px;" type="text" name="how_long">
				<input type="submit" name="name_search" value="추가">
			  </form>
			</div> 
		</div>
		<!-- 수업 -->
		<div class="title">[수업]</div>
		<div>
			<table>
				<tr><th>회원 ID</th><th>강사 ID</th><th>강사 이름</th><th>등록일</th><th>기간</th><th>마감일</th><th>-</th></tr>
<?php
		// LESSON........
		foreach($id as $x){
			$sql = "SELECT customerID, teacherID, (SELECT name FROM Teacher_Info WHERE teacherID=Lesson_Register.teacherID) as teacherName, registered, how_long, expires FROM Lesson_Register WHERE customerID='$x'";
			$result = mysqli_query($conn, $sql);

			if ($result!=false && mysqli_num_rows($result) > 0) {
				$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
				foreach($rows as $row) {
?>
					<tr>
						<td><?= $row["customerID"]; ?></td>
						<td><?= $row["teacherID"]; ?></td>
						<td><?= $row["teacherName"]; ?></td>
						<td><?= $row["registered"]; ?></td>
						<td><?= $row["how_long"]; ?></td>
						<td><?= $row["expires"]; ?></td>
						<td><button type="button" class="del">X</button></td>
					</tr>
<?php
				}
			}
			if($result!=false)
				mysqli_free_result($result);
		}
?>
			</table>
			<button type="button" class="collapsible">레슨 추가▽</button>
			<div class="content">
			  <!-- FROM -->
			  <form action="./insertLess.php" method="POST">
				아이디:
				<input class="regInput" type="text" name="customer_id" value="<?php echo $id[0];?>"></br>
				강사ID:
				<input class="regInput" type="text" name="teacher_id"></br>
				등록일:
				<input class="regInput" type="date" name="reg_date" value="<?php echo date("Y-m-d");?>"></br>
				개월수:
				<input class="regInput" style="width: 82px;" type="text" name="how_long">
				<input type="submit" name="name_search" value="추가">
			  </form>
			</div> 
		</div>
<?php
	}else{
?>
	<div class="title" style="text-align: center; font-size: 2em;">검색결과 없음...</div>
<?php
	}
	mysqli_close($conn);
}
?>

<script>
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