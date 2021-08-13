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
<title>회원검색</title>
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
  border-collapse: collapse;
}
.title {
  margin-top: 1rem;
  font-size: 1.5rem;
  font-weight: bold;
}
.regInput {
  width: 130px;
}

td > form {
  margin: 0 0;
  display: inline;
}

th {
  background-color: #e8d5f5;
}

.regInput {
  width: 10rem;
  margin: 0.1rem;
}


/*  MODAL EDIT FROM HERE */
.clickable_s:hover {
  cursor:pointer;
  text-decoration: underline;
}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%;
  height: 100%
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
  margin-top: 8%;
  padding: 30px;
  height: 37rem;
  width: 20rem;
  margin-left:auto;
  margin-right:auto;
  overflow: auto;
}

/* The Close Button */
#close {
  color: #aaaaaa;
  font-size: 28px;
  font-weight: bold;
  display: block;
}

#close:hover,
#close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

form#modal_form > input {
  width: 10rem;
}
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<div>
	<form class="m-4" method="GET">
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
		$result = mysqli_query($conn, "SELECT ID FROM Customer_Info WHERE ID='$name_id'");
		if($result!=false && mysqli_num_rows($result) > 0){
			array_push($id, $name_id);
		}else
			$id = null;
		
		echo "회원번호로 검색: ".$name_id."\n";
		if($result!=false)
			mysqli_free_result($result);
	}else{
		$result = mysqli_query($conn, "SELECT ID FROM Customer_Info WHERE name='$name_id'");
		
		if($result!=false && mysqli_num_rows($result) > 0){
			$rows = mysqli_fetch_all($result);
			foreach($rows as $row)
				array_push($id, $row[0]);
		}else
			$id = null;
		
		echo "이름으로 검색: ".$name_id."\n";
		$name = $name_id;
		if($result!=false)
			mysqli_free_result($result);
	}

	if($id != null){
?>
		</br>
		<!-- 회원정보 -->
		<div class="title" style="display: inline-block;">[회원정보]</div> 
		<form style="margin: 0 0; margin-left: 0.8rem; display: inline;" target="_blank" id="checkin_record" method="GET" action="./checkinRecord.php">
			<input id="checkinID" type="text" name="ID" hidden>
			<a href="javascript:{}" onclick="document.getElementById('checkin_record').submit();">체크인 기록</a>
        </form>
		
		<div>
			<table class="table table-bordered table-hover table-condensed">
				<tr class="table-warning"><th>회원 ID</th><th>이름</th><th>전화번호</th><th>생일</th><th>나이</th><th>주소</th><th>비고</th></tr>
<?php
		foreach($id as $x){
			$result = mysqli_query($conn, "SELECT ID, name, mobile, dob, (SELECT TIMESTAMPDIFF(YEAR, Customer_Info.dob, CURDATE())) AS age, address, note FROM Customer_Info WHERE ID='$x'");
			$row = mysqli_fetch_assoc($result);
?>
			<tr>
				<td class="checkinID"><?= $row["ID"]; ?></td>
				<td><span class="clickable_s"><?= $row["name"]; ?></span></td>
				<td><span class="clickable_s"><?= $row["mobile"]; ?></span></td>
				<td><span class="clickable_s"><?= $row["dob"]; ?></span></td>
				<td><?= $row["age"]; ?></td>
				<td><span class="clickable_s"><?= $row["address"]; ?></span></td>
				<td><span class="clickable_s"><?= empty($row["note"])? "-" : $row["note"]; ?></span></td>
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
			<table class="table table-bordered table-hover table-condensed" style="margin-bottom: 0;">
				<tr class="table-warning"><th>회원 ID</th><th>등록일</th><th>기간</th><th>마감일</th><th>-</th></tr>
<?php
		// REGISTRATION........
		foreach($id as $x){
			$sql = "SELECT customerID, registered, how_long, (SELECT DATE_ADD(Register.registered,INTERVAL +Register.how_long MONTH)) AS expires FROM Register WHERE customerID='$x' ORDER BY expires";
			$result = mysqli_query($conn, $sql);

			$size = mysqli_num_rows($result);
			if ($result!=false && $size > 0) {
				$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
				//print_r($rows);
				
				foreach($rows as $row) {
?>
					<tr>
						<td><?= $row["customerID"]; ?></td>
						<td><?= $row["registered"]; ?></td>
<?php

					if($row["expires"] < date("Y-m-d")){
?>
						<td><?= $row["how_long"]; ?></td>
<?php 
					}else{
?>
						<td><?= $row["how_long"]; ?> 
							<form action='./CUD_locker.php' method='POST'>
								<input class="currentURL" type="text" name="currentURL" hidden>
								<input class="ID" type="text" name="ID" hidden>
								<input class="registered" type="text" name="registered" hidden>
								<input style="width: 2.6rem;" type="number" min=1 max=12 name='how_long' value=1>
								<input class="lockerID" type="text" name="lockerID" hidden>
								<input type="submit" name="extend" value="연장">
							</form>
						</td>
<?php
					}
?>

						<td><?= $row["expires"]; ?></td>
						
						<td class="table-danger">
						<form action="./CUD_reg.php" method="POST">
							<input class="currentURL" type="text" name="currentURL" hidden>
							<input class="registered" type="text" name="registered" hidden>
							<input class="ID" type="text" name="ID" hidden>
							<input class="how_long" type="text" name="how_long" hidden>
							<input type="submit" name="delete" class="del" value="X"> <!-- onclick="return confirm('지울까요?')" -->
						</form>
						</td>
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
			  <form action="./CUD_reg.php" method="POST">
				<input class="regInput currentURL" type="text" name="currentURL" hidden>
				아이디:
				<input class="regInput" type="text" name="customer_id" value="<?php echo $id[0];?>" required></br>
				등록일:
				<input class="regInput" type="date" name="reg_date" value="<?php echo date("Y-m-d");?>" required></br>
				개월수:
				<input class="regInput" style="width: 6.5rem;;" type="text" name="how_long" required>
				<input type="submit" name="insert_reg" value="추가">
			  </form>
			</div> 
		</div>
		<!-- 락커 -->
		<div class="title">[락커]</div>
		<div>
			<table class="table table-bordered table-hover table-condensed" style="margin-bottom: 0;">
				<tr class="table-warning"><th>회원 ID</th><th>등록일</th><th>락커 ID</th><th>기간</th><th>마감일</th><th>-</th></tr>
<?php
		// LOCKER........
		foreach($id as $x){
			$sql = "SELECT customerID, lockerID, registered, how_long, (SELECT DATE_ADD(Locker_Register.registered,INTERVAL +Locker_Register.how_long MONTH)) AS expires  FROM Locker_Register WHERE customerID='$x' ORDER BY expires";
			$result = mysqli_query($conn, $sql);
			$size = mysqli_num_rows($result);

			if ($result!=false && $size > 0) {
				$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
				foreach($rows as $row) {
?>
					<tr>
						<td><?= $row["customerID"]; ?></td>
						<td><?= $row["registered"]; ?></td>
						<td><?= $row["lockerID"]; ?></td>
<?php

					if($row["expires"] < date("Y-m-d")){
?>
						<td><?= $row["how_long"]; ?></td>
<?php 
					}else{
?>
						<td><?= $row["how_long"]; ?> 
							<form action='./CUD_locker.php' method='POST'>
								<input class="currentURL" type="text" name="currentURL" hidden>
								<input class="ID" type="text" name="ID" hidden>
								<input class="registered" type="text" name="registered" hidden>
								<input style="width: 2.6rem;" type="number" min=1 max=12 name='how_long' value=1>
								<input class="lockerID" type="text" name="lockerID" hidden>
								<input type="submit" name="extend" value="연장">
							</form>
						</td>
<?php
					}
?>
						<td><?= $row["expires"]; ?></td>
						
						<td class="table-danger">
						<form action="./CUD_locker.php" method="POST">
							<input class="currentURL" type="text" name="currentURL" hidden>
							<input class="registered" type="text" name="registered" hidden>
							<input class="ID" type="text" name="ID" hidden>
							<input class="lockerID" type="text" name="lockerID" hidden>
							<input type="submit" name="delete" class="del" value="X"> <!-- onclick="return confirm('지울까요?')" -->
						</form>
						</td>
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
			  <form action="./CUD_locker.php" method="POST">
				<input class="currentURL" type="text" name="currentURL" hidden>
				아이디:
				<input class="regInput" type="text" name="customer_id" value="<?php echo $id[0];?>" required></br>
				락커번호:
				<select class="regInput" style="width: 9rem;" name="locker" id="locker">
<?php
				$sql = 'SELECT lockerID FROM (SELECT lockerID, DATE_ADD(MAX(registered), INTERVAL +how_long MONTH) as expire FROM locker_register GROUP BY lockerID) as T WHERE T.expire < CURDATE()';
				
				$result = mysqli_query($conn, $sql);
				$arr = array();
				if ($result!=false && mysqli_num_rows($result) > 0) {
					$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
					foreach($rows as $row) {
						array_push($arr, $row['lockerID']);
					}
				}else{$arr = ["빈 락커가 업습니다"];}
				foreach($arr as $a){
?>
					<option value="<?php echo $a; ?>"><?php echo $a; ?></option>
<?php
				}
?>
				</select></br>
				등록일:
				<input class="regInput" type="date" name="reg_date" value="<?php echo date("Y-m-d");?>" required></br>
				개월수:
				<input class="regInput" style="width: 6.5rem;" type="text" name="how_long" required>
				<input type="submit" name="insert_locker" value="추가">
			  </form>
			</div> 
		</div>
		<!-- 수업 -->
		<div class="title">[레슨]</div>
		<div>
			<table class="table table-bordered table-hover table-condensed" style="margin-bottom: 0;">
				<tr class="table-warning"><th>회원 ID</th><th>등록일</th><th>기간</th><th>마감일</th><th>강사 ID</th><th>강사 이름</th><th>-</th></tr>
<?php
		if($result!=false)
			mysqli_free_result($result);
		
		// LESSON........
		foreach($id as $x){
			$sql = "SELECT customerID, teacherID, (SELECT name FROM Teacher_Info WHERE teacherID=Lesson_Register.teacherID) as teacherName, registered, how_long, (SELECT DATE_ADD(Lesson_Register.registered,INTERVAL +Lesson_Register.how_long MONTH)) AS expires FROM Lesson_Register WHERE customerID='$x'";
			$result = mysqli_query($conn, $sql);

			if ($result!=false && mysqli_num_rows($result) > 0) {
				$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
				foreach($rows as $row) {
?>
					<tr>
						<td><?= $row["customerID"]; ?></td>
						<td><?= $row["registered"]; ?></td>
<?php

					if($row["expires"] < date("Y-m-d")){
?>
						<td><?= $row["how_long"]; ?></td>
<?php 
					}else{
?>
						<td><?= $row["how_long"]; ?> 
							<form action='./CUD_lesson.php' method='POST'>
								<input class="currentURL" type="text" name="currentURL" hidden>
								<input class="ID" type="text" name="ID" hidden>
								<input class="registered" type="text" name="registered" hidden>
								<input style="width: 2.6rem;" type="number" min=1 max=12 name='how_long' value=1>
								<input class="teacherID" type="text" name="teacherID" hidden>
								<input type="submit" name="extend" value="연장">
							</form>
						</td>
<?php
					}
?>
						<td><?= $row["expires"]; ?></td>
						<td><?= $row["teacherID"]; ?></td>
						<td><?= $row["teacherName"]; ?></td>
						<td class="table-danger">
						<form action="./CUD_lesson.php" method="POST">
							<input class="currentURL" type="text" name="currentURL" hidden>
							<input class="registered" type="text" name="registered" hidden>
							<input class="ID" type="text" name="ID" hidden>
							<input class="how_long" type="text" name="how_long" hidden>
							<input class="teacherID" type="text" name="teacherID" hidden>
							<input type="submit" name="delete" class="del" value="X"> <!-- onclick="return confirm('지울까요?')" -->
						</form>
						</td>
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
			  <form action="./CUD_lesson.php" method="POST">
				<input class="currentURL" type="text" name="currentURL" hidden>
				아이디:
				<input class="regInput" type="text" name="customer_id" value="<?php echo $id[0];?>" required></br>
				
				강사:
				<select class="regInput" style="margin-left: 1.1rem;" name="teacherID" id="locker">
<?php
				$sql = 'SELECT teacherID, name FROM teacher_info';
				
				$result = mysqli_query($conn, $sql);
				$arr = array();
				if ($result!=false && mysqli_num_rows($result) > 0) {
					$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
					foreach($rows as $row) {
						array_push($arr, [$row['teacherID'], $row['name']]);
					}
				}else{$arr = ["강사가 없습니다"];}
				foreach($arr as $a){
?>
					<option value="<?php echo $a[0]; ?>"><?php echo $a[0].'-'.$a[1]; ?></option>
<?php
				}
				if($result!=false)
					mysqli_free_result($result);
?>
				</select></br>
				
				등록일:
				<input class="regInput" type="date" name="reg_date" value="<?php echo date("Y-m-d");?>" required></br>
				개월수:
				<input class="regInput" style="width: 6.5rem;" type="text" name="how_long" required>
				<input type="submit" name="insert_lesson" value="추가">
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

<!-- Modal Content -->
<div id="myModal" class="modal">
	<div class="modal-content" style="width: 30rem;">
	<div style="text-align: right;">
		<span id="close" style="display: inline;">&times;</span>
	</div>
		
		<form id="modal_form" style="margin: 0 1rem;" action="./CUD_customer.php" method="POST">
			<input class="currentURL" type="text" name="currentURL" hidden>
			<input id="instanceID" type="text" name="ID" hidden>
			<label for="name">이름: </label><br>
			<input type="text" id="name" name="name" required><br>
			<label for="phone">전화번호: </label><br>
			<input type="tel" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{4}-[0-9]{4}" required></br>
			<label for="phone">생일: </label><br>
			<input type="date" id="dob" name="dob" required></br>
			<label for="age">나이: </label><br>
			<input type="number" id="age" name="age" min="10" max="100" disabled></br>
			<label for="address">주소: </label><br>
			<textarea id="address" rows="2" cols="30" name="address"></textarea></br>
			<label for="comment">비고: </label><br>
			<textarea id="comment" rows="4" cols="30" name="comment"></textarea>
			<div><input style="float:right;" type="submit" name="update" value="수정"></div>
		</form>
	</div>
</div>
<script>
	$('.del').click(function(){
		$del_info = [$(this).parent().parent().parent().children(':first-child').text(), $(this).parent().parent().parent().children(':nth-child(2)').text()];
		return confirm('('+$del_info[0]+', '+$del_info[1]+')\n삭제합니다까?');
	});
	
	// FILL HIDDENs
	$('.currentURL').each(function() {
		$(this).val(window.location.href);
    });
	$('.ID').each(function() {
		$(this).val($(this).parent().parent().parent().children(':first-child').text());
    });
	$('.registered').each(function() {
		$(this).val($(this).parent().parent().parent().children(':nth-child(2)').text());
    });
	$('.how_long').each(function() {
		$(this).val($(this).parent().parent().parent().children(':nth-child(3)').text());
    });
	$('.lockerID').each(function() {
		$(this).val($(this).parent().parent().parent().children(':nth-child(3)').text());
    });
	$('.teacherID').each(function() {
		$(this).val($(this).parent().parent().parent().children(':nth-child(5)').text());
    });
	$('#checkinID').each(function() {
		$ids = $(".checkinID");
		$result = ' ';
		$.each( $ids, function( key, value ) {
		  $result += value.innerHTML + ' ';
		});
		$(this).val($result.trim());
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
	
	/** EDIT INFO FROM HERE**/
	function getAge(dateString) {
		var today = new Date();
		var birthDate = new Date(dateString);
		var age = today.getFullYear() - birthDate.getFullYear();
		var m = today.getMonth() - birthDate.getMonth();
		if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
			age--;
		}
		return age;
	}
	jQuery('#dob').on('input', function() {
		var age = document.getElementById("age");
		var dob = document.getElementById("dob");
		//console.log(dob.value);
		//console.log(getAge(dob.value));
		age.value = getAge(dob.value);
	});
	var modal = document.getElementById("myModal");

	// Get the button that opens the modal
	var btns = document.getElementsByClassName("clickable_s");

	// Get the <span> element that closes the modal
	var span = document.getElementById("close");

	const fields = ["name", "phone", "dob", "age", "address", "comment"]; 

	// When the user clicks on the button, open the modal
	for(var i=0; i < btns.length ; i++){
		btns[i].onclick = function() {
			modal.style.display = "block";
			$clickedTXT = $(this).text();
			$('#instanceID').val($(this).parent().parent().children(':first-child').text());
			console.log($('#instanceID').val());
			//console.log($(this).parent().parent().children(':nth-child(2)').text());
			
			for(var i=0 ; i < 6 ; i++)
				document.getElementById(fields[i]).value = null;
			for(var j=2 ; j < 8 ; j++)
				if($clickedTXT != $(this).parent().parent().children(':nth-child(' + j + ')').text()) {
					document.getElementById(fields[j-2]).value = $(this).parent().parent().children(':nth-child('+ j +')').text();
				}else{
					document.getElementById(fields[j-2]).focus(); //move cursor on input
					document.getElementById(fields[j-2]).select();
				}
		}
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
	  modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modal) {
		modal.style.display = "none";
	  }
	} 
</script>
</body>
</html>