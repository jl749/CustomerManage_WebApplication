<?php
/*
This API handles customer registration info Create, Update, Delete
"회원등록 정보를 DB 에 등록 후 리다이랙트 합니다"
*/

include("connect.php");

print_r($_POST);
$des = "검색.";
if(isset($_POST['insert_reg']) && !empty($_POST['insert_reg'])){ # INSERT
	$conn = Connection();
	
	$id = $_POST['customer_id'];
	$reg_date = $_POST['reg_date'];
	$how_long = $_POST['how_long'];
	
	$next = $_POST['currentURL'];
	
	$pattern = '/php.*/';
	preg_match($pattern, $next, $next);
	$next = $next[0];
	$next = $des.$next;  // concat
	
	$sql = "INSERT INTO Register VALUES ('$id', '$reg_date', '$how_long', 0)";
	if(mysqli_query($conn, $sql)){
		echo "SUCCESS, redirect in 1 second";
		//redirect
		header( "Location: $next" );
		mysqli_close($conn);
		die();
	}else{echo "INSERT failed, Query='$sql'";}
}elseif(isset($_POST['extend']) && !empty($_POST['extend'])){ # UPDATE extend month
	$conn = Connection();
	
	$id = $_POST['ID'];
	$registered = $_POST['registered'];
	$how_long = $_POST['how_long'];
	$matches = [];
	$next = $_POST['currentURL'];
	$pattern = '/php.*/';
	preg_match($pattern, $next, $next);
	$next = $next[0];
	$next = $des.$next;
	
	$sql = "UPDATE Register SET how_long=how_long+'$how_long' WHERE customerID='$id' AND registered='$registered'";
	if(mysqli_query($conn, $sql)){
		echo "SUCCESS, redirect in 1 second";
		//redirect
		header( "Location: $next" );
		die();
		mysqli_close($conn);
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
	$how_long = $_POST['how_long'];
	
	$sql = "DELETE FROM Register WHERE customerID='$id' AND registered='$registered' AND how_long='$how_long'";
	if(mysqli_query($conn, $sql)){
		echo "SUCCESS, redirect in 1 second";
		//redirect
		header( "Location: $next" );
		die();
		mysqli_close($conn);
	}else{echo "DELETE failed, Query='$sql'";}

}elseif(isset($_POST['day_plus']) && !empty($_POST['day_plus'])){ # UPDATE shift_expr_date+
	$conn = Connection();
	
	$table_name = $_POST['day_plus'];
	$id = $_POST['ID'];
	$registered = $_POST['registered'];

	$next = $_POST['currentURL'];
	$pattern = '/php.*/';
	preg_match($pattern, $next, $next);
	$next = $next[0];
	$next = $des.$next;
	
	
	$sql = "UPDATE $table_name SET offset=offset+1 WHERE customerID='$id' AND registered='$registered'";
	if(mysqli_query($conn, $sql)){
		echo "SUCCESS, redirect in 1 second";
		//redirect
		header( "Location: $next" );
		die();
		mysqli_close($conn);
	}else{echo "UPDATE failed, Query='$sql'";}
}elseif(isset($_POST['day_minus']) && !empty($_POST['day_minus'])){ # UPDATE shift_expr_date+
	$conn = Connection();
	
	$table_name = $_POST['day_minus'];
	$id = $_POST['ID'];
	$registered = $_POST['registered'];

	$next = $_POST['currentURL'];
	$pattern = '/php.*/';
	preg_match($pattern, $next, $next);
	$next = $next[0];
	$next = $des.$next;
	
	
	$sql = "UPDATE $table_name SET offset=offset-1 WHERE customerID='$id' AND registered='$registered'";
	if(mysqli_query($conn, $sql)){
		echo "SUCCESS, redirect in 1 second";
		//redirect
		header( "Location: $next" );
		die();
		mysqli_close($conn);
	}else{echo "UPDATE failed, Query='$sql'";}

}else{echo "Wrong Access";}
?>