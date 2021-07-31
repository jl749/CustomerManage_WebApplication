<?php

include("connect.php");

/**
"회원 연장을 DB 에 등록 후 리다이랙트 합니다"
*/

print_r($_POST);
if(isset($_POST['insert_reg']) && !empty($_POST['insert_reg'])){ # INSERT
	$conn = Connection();
	
	$id = $_POST['customer_id'];
	$reg_date = $_POST['reg_date'];
	$how_long = $_POST['how_long'];
	
	$next = urlencode($_POST['currentURL']);
	
	$sql = "INSERT INTO Register VALUES ('$id', '$reg_date', '$how_long')";
	if(mysqli_query($conn, $sql)){
		echo "SUCCESS, redirect in 1 second";
		//redirect
		header( "refresh:1;url=".$next ); 
	}else{echo "INSERT failed, Query='$sql'";}
	
	mysqli_close($conn);
}elseif(isset($_POST['extend']) && !empty($_POST['extend'])){ # UPDATE
	$conn = Connection();
	
	$id = $_POST['ID'];
	$registered = $_POST['registered'];
	$how_long = $_POST['how_long'];
	$next = urlencode($_POST['currentURL']);
	
	$sql = "UPDATE Register SET how_long=(SELECT how_long FROM Register WHERE customerID=101 ORDER BY registered DESC LIMIT 1)+'$how_long' WHERE customerID='$id' AND registered='$registered'";
	if(mysqli_query($conn, $sql)){
		echo "SUCCESS, redirect in 1 second";
		//redirect
		header( "refresh:1;url=".$next ); 
	}else{echo "UPDATE failed, Query='$sql'";}
}elseif(isset($_POST['delete']) && !empty($_POST['delete'])){ # DELETE
	$conn = Connection();
	
	$id = $_POST['ID'];
	$next = urlencode($_POST['currentURL']);
	$registered = $_POST['registered'];
	$how_long = $_POST['how_long'];
	
	$sql = "DELETE FROM Register WHERE customerID='$id' AND registered='$registered' AND how_long='$how_long'";
	if(mysqli_query($conn, $sql)){
		echo "SUCCESS, redirect in 1 second";
		//redirect
		header( "refresh:1;url=".$next ); 
		mysqli_close($conn);
	}else{echo "DELETE failed, Query='$sql'";}
}else{echo "Wrong Access";}
?>