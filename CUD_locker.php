<?php

include("connect.php");

/**
"락커 정보를 DB 에 등록 후 리다이랙트 합니다"
*/

print_r($_POST);
$des = "검색.";
if(isset($_POST['insert_locker']) && !empty($_POST['insert_locker'])){ # INSERT
	$conn = Connection();
	
	$id = $_POST['customer_id'];
	$reg_date = $_POST['reg_date'];
	$how_long = $_POST['how_long'];
	$locker = $_POST['locker'];
	
	$next = $_POST['currentURL'];
	$pattern = '/php.*/';
	preg_match($pattern, $next, $next);
	$next = $next[0];
	$next = $des.$next;
	
	$sql = "INSERT INTO Locker_Register VALUES ('$id', '$locker', '$reg_date', '$how_long')";
	if(mysqli_query($conn, $sql)){
		echo "SUCCESS, redirect in 1 second";
		//redirect
		header( "Location: $next" );
		mysqli_close($conn);
		die();
	}else{echo "INSERT failed, Query='$sql'";}
}elseif(isset($_POST['extend']) && !empty($_POST['extend'])){ # UPDATE
	$conn = Connection();
	
	$id = $_POST['ID'];
	$registered = $_POST['registered'];
	$how_long = $_POST['how_long'];
	$locker = $_POST['lockerID'];
	$matches = [];
	$next = $_POST['currentURL'];
	$pattern = '/php.*/';
	preg_match($pattern, $next, $next);
	$next = $next[0];
	$next = $des.$next;
	
	$sql = "UPDATE Locker_Register SET how_long=how_long+'$how_long' WHERE customerID='$id' AND registered='$registered' AND lockerID='$locker'";
	if(mysqli_query($conn, $sql)){
		echo "SUCCESS, redirect in 1 second";
		//redirect
		header( "Location: $next" );
		mysqli_close($conn);
		die();
	}else{echo "UPDATE failed, Query='$sql'";}
}elseif(isset($_POST['delete']) && !empty($_POST['delete'])){ # DELETE
	$conn = Connection();
	
	$id = $_POST['ID'];
	$next = $_POST['currentURL'];
	$pattern = '/php.*/';
	preg_match($pattern, $next, $next);
	$next = $next[0];
	$next = $des.$next;
	$registered = $_POST['registered'];
	$lockerID = $_POST['lockerID'];
	
	$sql = "DELETE FROM Locker_Register WHERE customerID='$id' AND registered='$registered' AND lockerID='$lockerID'";
	if(mysqli_query($conn, $sql)){
		echo "SUCCESS, redirect in 1 second";
		//redirect
		header( "Location: $next" );
		mysqli_close($conn);
		die();
	}else{echo "DELETE failed, Query='$sql'";}
}else{echo "Wrong Access";}
?>