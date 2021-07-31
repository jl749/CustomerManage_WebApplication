<?php
include("connect.php");
// header('Content-Type: text/html; charset=utf-8');

if(session_status() == PHP_SESSION_NONE){
	session_start();
}
$des = urlencode("회원.php");

//print_r($_POST);
if(isset($_POST['update']) && !empty($_POST['update'])){ # UPDATE
	$conn = Connection();
	
	$id = $_POST['ID'];
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$dob = $_POST['dob'];
	$address = $_POST['address'];
	$comment = (empty($_POST['comment'])) ? "-":$_POST['comment'];
	
	$sql = "UPDATE Customer_Info SET name='$name', mobile='$phone', dob='$dob', address='$address', note='$comment' WHERE ID='$id'";
	if(mysqli_query($conn, $sql)){
		echo "SUCCESS, redirect in 1 second";
		//redirect
		//header( "refresh:1;url=".$des ); 
		header( "Location: ".$des ); 
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
	$dob = $_POST['dob'];
	$address = $_POST['address'];
	$comment = (empty($_POST['comment'])) ? "-":$_POST['comment'];
	
	$sql = "INSERT INTO Customer_Info (name, mobile, dob, address, note) VALUES ('$name', '$phone', '$dob', '$address', '$comment')";
	if(mysqli_query($conn, $sql)){
		echo "SUCCESS, redirect in 1 second";
		//redirect
		$_SESSION['customerCreate'] = "고객 '$name' 님 DB에 추가되었습니다";
		header( "Location: ".$des ); 
	}else{echo "INSERTION failed, Query='$sql'";}
	
	mysqli_close($conn);
}else{echo "Wrong Access";}
?>