<?php
include("connect.php");
// header('Content-Type: text/html; charset=utf-8');

if(session_status() == PHP_SESSION_NONE){
	session_start();
}
$des = urlencode("회원.php");

print_r($_POST);
if(isset($_POST['update']) && !empty($_POST['update'])){ # UPDATE
	$conn = Connection();
	
	$id = $_POST['ID'];
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$sex = $_POST['sex'];
	$dob = $_POST['dob'];
	$address = $_POST['address'];
	$comment = (empty($_POST['comment'])) ? "-":$_POST['comment'];
	
	$sql = "UPDATE Customer_Info SET name='$name', mobile='$phone', sex='$sex', dob='$dob', address='$address', note='$comment' WHERE ID='$id'";
	if(mysqli_query($conn, $sql)){
		echo "SUCCESS, redirect in 1 second";
		//redirect
		if(isset($_POST['currentURL']) && !empty($_POST['currentURL'])){
			header( "Location: ".$_POST['currentURL'] ); 
		}else{
			//header( "refresh:1;url=".$des ); 
			header( "Location: ".$des ); 
		}
	}else{echo "UPDATE failed, Query='$sql'";}
	
	mysqli_close($conn);
}elseif(isset($_POST['delete']) && !empty($_POST['delete'])){ # DELETE
	$conn = Connection();
	
	$ID = $_POST['ID'];
	
	$sql = "DELETE FROM Customer_Info WHERE ID='$ID'";
	if(mysqli_query($conn, $sql)){
		echo "SUCCESS, redirect in 1 second";
		//redirect
		header( "Location: ".$des ); 
		
		mysqli_close($conn);
	}else{echo "DELETE failed, Query='$sql'";}
}elseif(isset($_POST['insert']) && !empty($_POST['insert'])){ # CREATE
	$conn = Connection();
	
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$sex = $_POST['sex'];
	$dob = $_POST['dob'];
	$address = (empty($_POST['address'])) ? "-":$_POST['address'];
	$comment = (empty($_POST['comment'])) ? "-":$_POST['comment'];
	
	$sql = "INSERT INTO Customer_Info (name, mobile, sex, dob, address, note) VALUES ('$name', '$phone', '$sex', '$dob', '$address', '$comment')";
	if(mysqli_query($conn, $sql)){
		echo "SUCCESS(Customer_Info). ";
		
		if($_POST['able1'] == "yes"){
			$reg_date1 = $_POST['reg_date1'];
			$how_long1 = $_POST['how_long1'];
			$sql = "INSERT INTO Register VALUES ((SELECT ID FROM Customer_Info WHERE name='$name' AND mobile='$phone'), '$reg_date1', $how_long1)";
			if(mysqli_query($conn, $sql)){
				echo "SUCCESS(Register). ";
			}else{
				die("INSERTION failed, Query='$sql'");
			}
		}
		if($_POST['able2'] == "yes"){
			$reg_date2 = $_POST['reg_date2'];
			$how_long2 = $_POST['how_long2'];
			$teacherID = $_POST['teacher'];
			$sql = "INSERT INTO Lesson_Register VALUES ((SELECT ID FROM Customer_Info WHERE name='$name' AND mobile='$phone'),$teacherID, '$reg_date2', $how_long2)";
			if(mysqli_query($conn, $sql)){
				echo "SUCCESS(Lesson). ";
			}else{
				die("INSERTION failed, Query='$sql'");
			}
		}
		if($_POST['able3'] == "yes"){
			$reg_date3 = $_POST['reg_date3'];
			$how_long3 = $_POST['how_long3'];
			$lockerID = $_POST['locker'];
			$sql = "INSERT INTO Locker_Register VALUES ((SELECT ID FROM Customer_Info WHERE name='$name' AND mobile='$phone'),$lockerID, '$reg_date3', $how_long3)";
			if(mysqli_query($conn, $sql)){
				echo "SUCCESS(Lesson). ";
			}else{
				die("INSERTION failed, Query='$sql'");
			}
			$sql = "UPDATE Locker SET occupied='' WHERE lockerID=$lockerID";
			if(mysqli_query($conn, $sql)){
				echo "SUCCESS(Locker).";
			}else{echo "UPDATE failed, Query='$sql'";}
		}
		
		$_SESSION['customerCreate'] = "고객 '$name' 님 DB에 추가되었습니다";
		$sql = "SELECT ID FROM Customer_Info WHERE name='$name' AND mobile='$phone'";
		$result = mysqli_query($conn, $sql);
		$tmp = mysqli_fetch_row($result);
		
		header( "Location: 검색.php?name_id=".$tmp[0]."&name_id_search=검색" ); 
	}else{echo "INSERTION failed, Query='$sql'";}
	
	mysqli_close($conn);
}else{echo "Wrong Access";}
?>