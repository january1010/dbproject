<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);


$store_name = $_POST['store_name'];
$location = $_POST['location'];
$dish_id = $_POST['dish_id'];

mysqli_query($conn, "set autocommit =0");
mysqli_query($conn, "set transaction isolation level serializable");
mysqli_query($conn, "begin");

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

//새로운 가게를 insert하기 전에 원래 있는 가게 이름과 겹치는지 확인한다.
$query = "select * from store where store_name = '$store_name'";
$res = mysqli_query($conn, $query);
$row = mysqli_fetch_array($res);

if($row['store_name']!=$store_name){
	//겹치지 않는 경우
	$ret = mysqli_query($conn, "insert into store values('$store_id', '$store_name', '$location', '$dish_id')");
	if(!$ret)
	{	//insert가 실패
		mysqli_query($conn, "rollback");
		echo mysqli_error($conn);
    	msg('Query Error : '.mysqli_error($conn));
	}
	else
	{
		mysqli_query($conn,"commit");
    	s_msg ('성공적으로 입력 되었습니다');
    	echo "<meta http-equiv='refresh' content='0;url=product_list.php'>";
	}
}
else{//겹치는 경우
	echo "값이 중복되었습니다";
	mysqli_query($conn, "rollback");
	echo mysqli_error($conn);
    msg('Query Error : '.mysqli_error($conn));
}
?>

