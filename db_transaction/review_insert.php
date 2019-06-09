<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$user_id=$_POST['user_id'];
$age=$_POST['age'];
$content=$_POST['content'];
$store_id= $_POST['store_id'];
$rating=$_POST['rating'];

$query = "select max(review_id) as max_re from review";
$data = mysqli_query($conn,$query);
$max=mysqli_fetch_array($data);

if($max)
{
	$review_id = $max['max_re'] + 1;
}
else
{
	$review_id = 1;
}


mysqli_query($conn, "set autocommit=0");
mysqli_query($conn, "set transaction isolation level serializable");
mysqli_query($conn, "begin");

$query = "select * from user where user_id like '$user_id'";
$check = mysqli_query($conn, $query);
$check_user = mysqli_fetch_array($check);

if (!$check_user)
{
	$ret_user = mysqli_query($conn, "insert into user values('$user_id', '$age')");
	if(!$ret_user)
	{	//insert에 실패한 경우
		mysqli_query($conn, "rollback");
		echo mysqli_error($conn);
    	msg('Query Error : '.mysqli_error($conn));
	}	
}

$ret_review = mysqli_query($conn, "insert into review values('$review_id', '$user_id', '$content', '$store_id')");
if(!$ret_review)
{	//review table에서 insert에 실패한 경우
	mysqli_query($conn, "rollback");
	echo mysqli_error($conn);
	msg('Query Error : '.mysqli_error($conn));
}

$ret_rating = mysqli_query($conn, "insert into rating values('$user_id','$review_id','$rating')");
if(!$ret_rating)
{	//rating에서 실패한 경우
	mysqli_query($conn, "rollback");
	echo mysqli_error($conn);
	msg('Query Error : '.mysqli_error($conn));
	echo "rating insert error";
}
else{//성공
	mysqli_query($conn, "commit");
	s_msg ('성공적으로 입력 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=review_list.php'>";
}
?>

