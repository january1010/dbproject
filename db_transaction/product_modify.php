<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$store_id = $_POST['store_id'];
$store_name = $_POST['store_name'];
$location = $_POST['location'];
$dish_id = $_POST['dish_id'];

mysqli_query($conn, "set autocommit=0");
mysqli_query($conn, "set transaction isolation level serializable");
mysqli_query($conn, "begin");

$ret = mysqli_query($conn, "update store set store_name = '$store_name', location = '$location', dish_id = $dish_id where store_id = $store_id");

if(!$ret)
{
	mysqli_query($conn, "rollback");
    msg('Query Error : '.mysqli_error($conn));
}
else
{	/*
같은 이름의 가게가 이미 존재할 경우(원래 가게 제외하고)
*/
	$name=mysqli_query($conn, "select count(store_id) as cnt from store where store_name='$store_name'");
	$cnt= mysqli_fetch_array($name);

	if($cnt['cnt']!=1)
	{
		echo "가게이름이 중복되었습니다";
		msg('Query Error: '.mysqli_error($conn));
		mysqli_query($conn, "rollback");
	}
	else
	{
		mysqli_query($conn, "commit");
    	s_msg ('성공적으로 수정 되었습니다');
    	echo "<meta http-equiv='refresh' content='0;url=product_list.php'>";
	}
}
?>

