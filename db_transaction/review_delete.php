<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$review_id = $_GET['review_id'];

mysqli_query($conn, "set autocommit=0");
mysqli_query($conn, "set transaction isolation level serializable");
mysqli_query($conn, "begin");

//후기 하나를 지우려면 review table과 rating table에 있는 값을 둘 다 지워야 함
$ret = mysqli_query($conn, "delete from rating where review_id = $review_id");
if(!$ret)
{
	mysqli_query($conn, "rollback");
    msg('Query Error : '.mysqli_error($conn));
}

$review_del = mysqli_query($conn, "delete from review where review_id = $review_id");

if(!$review_del)
{
	mysqli_query($conn, "rollback");
	msg('Query Error : '.mysqli_error($conn));
}
else {
	mysqli_query($conn, "commit");
    s_msg ('성공적으로 삭제 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=review_list.php'>";
}

?>

