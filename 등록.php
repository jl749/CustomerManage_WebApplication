<?php
include("connect.php");
$conn = Connection();
?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title>회원등록 페이지</title>
<style>
.container {
  margin: 2rem;
  border-radius: 10px;
  background-color: #f2f2f2;
  padding: 20px;
  height: 51.5rem;
}

input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
  margin-top: 0.3rem;
}

input[type=submit]:hover {
  background-color: #45a049;
}

form > input {
  width: 12rem;
}

form { 
  margin: 0 auto; 
  width: 350px;
}

.title {
  font-size: 1.5rem;
  font-weight: bold;
  margin: 1rem 0;
  text-align: center;
  margin-bottom: 1.5rem;
}

.section {
  margin: 1rem 0;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
	<div style="width: 34rem;" class="container">
		<div class="title">회원등록</div>
		<!-- $_SESSION['customerCreate'] -->
		<form action="./CUD_customer.php" method="POST">
			<label for="name">이름: </label><br>
			<input type="text" id="name" name="name" required><br>
			<label for="phone">전화번호: </label><br>
			<input type="tel" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{4}-[0-9]{4}" required></br>
			<label for="phone">생일: </label><br>
			<input type="date" id="dob" name="dob" required></br>
			
			
			<div class="section">
				<label>연습장: </label>
				<div style="display: inline;">
				  <input type="radio" id="yes1" name="able1" value="yes">
				  <label for="yes1">YES</label>
				  <input type="radio" id="no1" name="able1" value="no">
				  <label for="no1">NO</label>
				</div><br>
				<input class="reg1" type="date" name="reg_date1" value="<?php echo date('Y-m-d'); ?>">
				<input class="reg1" style="width: 2.6rem;" type="number" min=1 max=12 name='how_long1' value=1>개월<br>
			</div>
			
			<div class="section">
				<label>락커: </label>
				<div style="display: inline;">
				  <input type="radio" id="yes3" name="able3" value="yes">
				  <label for="yes3">YES</label>
				  <input type="radio" id="no3" name="able3" value="no">
				  <label for="no3">NO</label>
				</div><br>
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
?>
				<input class="reg3" type="date" name="reg_date3" value="<?php echo date('Y-m-d'); ?>">
				<input class="reg3" style="width: 2.6rem;" type="number" min=1 max=12 name='how_long3' value=1>개월<br>
			
				<select class="reg3" style="width: 10rem;" name="locker" id="locker">
<?php
					foreach($arr as $a){
?>
						<option value="<?php echo $a; ?>"><?php echo $a; ?></option>
<?php
					}
					if($result!=false)
						mysqli_free_result($result);
?>
				</select>
			</div>
			
			<div class="section">
				<label>레슨: </label>
				<div style="margin-left: 1rem; display: inline;">
				  <input type="radio" id="yes2" name="able2" value="yes">
				  <label for="yes2">YES</label>
				  <input type="radio" id="no2" name="able2" value="no">
				  <label for="no2">NO</label>
				</div><br>
<?php
				$sql = 'SELECT teacherID, name FROM Teacher_Info';
				
				$result = mysqli_query($conn, $sql);
				$arr = array();
				if ($result!=false && mysqli_num_rows($result) > 0) {
					$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
					foreach($rows as $row) {
						array_push($arr, [$row['teacherID'], $row['name']]);
					}
				}else{$arr = ["강사가", "없습니다"];}
?>
				<input class="reg2" type="date" name="reg_date2" value="<?php echo date('Y-m-d'); ?>">
				<input class="reg2" style="width: 2.6rem;" type="number" min=1 max=12 name='how_long2' value=1>개월<br>

				<select class="reg2" style="width: 10rem;" name="teacher" id="teacher">
<?php
					foreach($arr as $a){
?>
						<option value="<?php echo $a[0]; ?>"><?php echo $a[0]." ",$a[1]; ?></option>
<?php
					}
					if($result!=false)
						mysqli_free_result($result);
?>
				</select>
			</div>
		
			<label for="address">주소: </label><br>
			<textarea id="address" rows="2" cols="45" name="address"></textarea></br>
			<label for="comment">비고: </label><br>
			<textarea id="comment" rows="4" cols="45" name="comment"></textarea>
			<div><input style="float:right;" type="submit" name="insert" value="등록"></div>
		</form>
	</div>
	
<script>
$( document ).ready(function() {
	$(".reg1").prop( "disabled", true );
	$(".reg2").prop( "disabled", true );
	$(".reg3").prop( "disabled", true );
	$("#no1").prop("checked", true);
	$("#no2").prop("checked", true);
	$("#no3").prop("checked", true);
	
	jQuery("input[name='able1']").click(function(){
		if($("#yes1").is(":checked")){
			$(".reg1").prop( "disabled", false );
		}else if($("#no1").is(":checked")){
			$(".reg1").prop( "disabled", true );
		}
	});
	jQuery("input[name='able2']").click(function(){
		if($("#yes2").is(":checked")){
			$(".reg2").prop( "disabled", false );
		}else if($("#no2").is(":checked")){
			$(".reg2").prop( "disabled", true );
		}
	});
	jQuery("input[name='able3']").click(function(){
		if($("#yes3").is(":checked")){
			$(".reg3").prop( "disabled", false );
		}else if($("#no3").is(":checked")){
			$(".reg3").prop( "disabled", true );
		}
	});
});
</script>
</body>
</html>