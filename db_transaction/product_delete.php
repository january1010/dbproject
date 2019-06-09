<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$store_id = $_GET['store_id'];

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

mysqli_query($conn, "set autocommit=0");
mysqli_query($conn, "set transaction isolation level serializable");
mysqli_query($conn, "begin");

$ret = mysqli_query($conn, "delete from store where store_id = $store_id");

if(!$ret)
{	//delete에 실패한 경우
	mysqli_query($conn, "rollback");
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query($conn, "commit");
    s_msg ('성공적으로 삭제 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=product_list.php'>";
}

?>

