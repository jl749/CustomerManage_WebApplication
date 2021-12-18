<?php
/*
This API handles customer checkin Create, Delete
"체크인 정보를 DB에 등록 후 리다이랙트합니다"
*/

include("connect.php");
// header('Content-Type: text/html; charset=utf-8');

if(session_status() == PHP_SESSION_NONE){
	session_start();
}

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
	$next = urlencode("체크인.").$next;
	
	$sql = "INSERT INTO Check_In VALUES ('$id', '$today', '$currentTime')";
	if(mysqli_query($conn, $sql)){
		echo "체크인 완료 '$today', '$currentTime'";
		//redirect
		header( "refresh:1;url=".$next );
		mysqli_close($conn);
		die();
	}else{
		$lastcheck = 'SQL FAILED';
		$result = mysqli_query($conn, "SELECT checkinTime FROM Check_In WHERE customerID='$id' ORDER BY checkinDate DESC LIMIT 1");
		if ($result!=false && mysqli_num_rows($result) > 0) {
			$rows = mysqli_fetch_all($result);
			$lastcheck = $rows[0][0];
		}
		echo "Already checked, 최근 체크인 시간: '$lastcheck'";
	}
}elseif(isset($_POST['delete']) && !empty($_POST['delete'])){ # DELETE
	$conn = Connection();
	
	$id = $_POST['ID'];
	$next = $_POST['currentURL'];
	$pattern = '/php.*/';
	preg_match($pattern, $next, $next);
	$next = $next[0];
	$next = "checkinRecord.".$next;
	$today = $_POST['today'];
	
	$sql = "DELETE FROM Check_In WHERE customerID='$id' AND checkinDate='$today'";
	if(mysqli_query($conn, $sql)){
		echo "SUCCESS, redirect in 1 second";
		//redirect
		header( "Location: $next" );
		mysqli_close($conn);
		die();
	}else{echo "DELETE failed, Query='$sql'";}
}
?>