<?php
include("connect.php");

if(session_status() == PHP_SESSION_NONE){
	session_start();
}

$rows_per_page = 20;

$conn = Connection();
$result = mysqli_query($conn, "SELECT COUNT(ID) as cnt FROM Customer_Info");
$offset = 0;
$count = mysqli_fetch_row($result)[0];
mysqli_free_result($result);

$sql = "SELECT ID, name, mobile, dob, (SELECT TIMESTAMPDIFF(YEAR, Customer_Info.dob, CURDATE())) AS age, address, note FROM Customer_Info ORDER BY name"; //LIMIT 30 OFFSET 0
$result = mysqli_query($conn, $sql);

//print_r($rows)
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>회원 페이지</title>
<style>
.title {
  font-size: 1.5rem;
  font-weight: bold;
  margin: 1rem 0;
}

table {
  text-align: center;
}

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

form > input {
  width: 10rem;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="title">회원 페이지 입니다</div>
<div>
	<table class="table table-bordered table-hover">
		<tr class="table-primary"><th>회원 ID</th><th>이름</th><th>전화번호</th><th>생일</th><th>나이</th><th>주소</th><th>비고</th><th>-</th></tr>
<?php
		if ($result!=false && mysqli_num_rows($result) > 0) {
			$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
			foreach($rows as $row) {
?>
				<tr>
					<td><?= $row["ID"]; ?></td>
					<td><span class="clickable_s"><?= $row["name"]; ?></span></td>
					<td><span class="clickable_s"><?= $row["mobile"]; ?></span></td>
					<td><span class="clickable_s"><?= $row["dob"]; ?></span></td>
					<td><?= $row["age"]; ?></td>
					<td><span class="clickable_s"><?= $row["address"]; ?></span></td>
					<td><span class="clickable_s"><?= empty($row["note"])? "-" : $row["note"]; ?></span></td>
					<td class="table-danger"><button type="button" class="del">X</button></td>
				</tr>
<?php
			}
		}
	mysqli_close($conn);
?>
	</table>
</div>

<!-- Modal Content -->
<div id="myModal" class="modal">
	<div class="modal-content" style="width: 30rem;">
	<div style="text-align: right;">
	<span id="close" style="display: inline;">&times;</span>
	</div>
		
		<form style="margin: 0 1rem;">
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
		//console.log($(this).parent().parent().children(':first-child').text());
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