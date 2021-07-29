<?php
include("connect.php");
// header('Content-Type: text/html; charset=utf-8');

if(session_status() == PHP_SESSION_NONE){
	session_start();
}

if(isset($_POST['insert']) && !empty($_POST['insert'])){
	$conn = Connection();
	
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$dob = $_POST['dob'];
	$address = $_POST['address'];
	$comment = (empty($_POST['comment'])) ? "-":$_POST['comment'];
	
	$sql = "INSERT INTO Teacher_Info (name, mobile, dob, address, note) VALUES ('$name', '$phone', '$dob', '$address', '$comment')";
	if(mysqli_query($conn, $sql)){
		echo "SUCCESS, redirect in 1 second";
		//redirect
		$des = urlencode("강사.php");
		header( "refresh:2;url=".$des ); 
	}else{echo "INSERTION failed, Query='$sql'";}
	
	mysqli_close($conn);
}elseif(isset($_POST['delete']) && !empty($_POST['delete'])){
	$conn = Connection();
	
	$ID = $_POST['ID'];
	
	$sql = "DELETE FROM Teacher_Info WHERE teacherID='$ID'";
	if(mysqli_query($conn, $sql)){
		echo "SUCCESS, redirect in 1 second";
		//redirect
		$des = urlencode("강사.php");
		header( "refresh:1;url=".$des ); 
		
		mysqli_close($conn);
	}else{echo "DELETE failed, Query='$sql'";}
}else{echo "Wrong Access";}
?>