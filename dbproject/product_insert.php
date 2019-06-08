<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$query = "select max(store_id) as max_id from store";
$data = mysqli_query($conn,$query);
$count=mysqli_fetch_assoc($data);

if($count)
{
	$store_id= $count['max_id'] + 1;
}
else
{
	$store_id= 1;		
}

$store_name = $_POST['store_name'];
$location = $_POST['location'];
$dish_id = $_POST['dish_id'];

$ret = mysqli_query($conn, "insert into store values('$store_id', '$store_name', '$location', '$dish_id')");
if(!$ret)
{
	echo mysqli_error($conn);
    msg('Query Error : '.mysqli_error($conn));
}
else
{
    s_msg ('성공적으로 입력 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=product_list.php'>";
}
?>

