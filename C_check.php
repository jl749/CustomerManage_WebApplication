<?php
include("connect.php");
// header('Content-Type: text/html; charset=utf-8');

if(session_status() == PHP_SESSION_NONE){
	session_start();
}
$des = urlencode("체크인.");

//print_r($_POST);
if(isset($_POST['checkin']) && !empty($_POST['checkin'])){
	$conn = Connection();
	
	$id = $_POST['ID'];
	$today = date("Y-m-d");
	$currentTime = date("h:i:sa");
	$next = $_POST['currentURL'];
	$pattern = '/php.*/';
	preg_match($pattern, $next, $next);
	$next = $next[0];
	$next = $des.$next;
	
	$sql = "INSERT INTO Check_In VALUES ('$id', '$today', '$currentTime')";
	if(mysqli_query($conn, $sql)){
		echo "체크인 완료 '$today', '$currentTime'";
		//redirect
		header( "refresh:1;url=".$next );
		mysqli_close($conn);
		die();
	}else{echo "체크인 실패";}
}
?>