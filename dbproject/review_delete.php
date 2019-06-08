<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$review_id = $_GET['review_id'];

$ret = mysqli_query($conn, "delete from rating where review_id = $review_id");
if(!$ret)
{
    msg('Query Error : '.mysqli_error($conn));
}
$review_del = mysqli_query($conn, "delete from review where review_id = $review_id");
if(!$review_del)
{
	msg('Query Error : '.mysqli_error($conn));
}
else {
    s_msg ('성공적으로 삭제 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=review_list.php'>";
}

?>

