<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$store_id = $_POST['store_id'];
$store_name = $_POST['store_name'];
$location = $_POST['location'];
$dish_id = $_POST['dish_id'];

$ret = mysqli_query($conn, "update store set store_name = '$store_name', location = '$location', dish_id = $dish_id where store_id = $store_id");

if(!$ret)
{
    msg('Query Error : '.mysqli_error($conn));
}
else
{
    s_msg ('성공적으로 수정 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=product_list.php'>";
}

?>

