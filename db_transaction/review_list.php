<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select * from review natural join store natural join user";
    $res = mysqli_query($conn, $query);
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>
	<h3>후기 목록</h3><br>
	<button type="button" class="button danger" id="ratingbutton" style="padding: 10px 25px;" onclick="javacript:rating_click()">평점 1위 식당은</button>
	<br><br>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>no</th>
            <th>식당 이름</th>
            <th>user ID</th>
            <th>기능</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td><a href='review_view.php?review_id={$row['review_id']}'>{$row_index}</a></td>";
            echo "<td>{$row['store_name']}</td>";
            echo "<td>{$row['user_id']}</td>";
            echo "<td width='17%'>
                 <button onclick='javascript:deleteConfirm({$row['review_id']})' class='button danger small'>삭제</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        $query = "select store_name from rating natural join review natural join store group by store_id order by avg(rating) desc limit 1";
        $do=mysqli_query($conn,$query);
        $rat_row=mysqli_fetch_array($do);
        $num_one=$rat_row['store_name'];
        ?>
        </tbody>
    </table>
    <script>
        function deleteConfirm(review_id) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "review_delete.php?review_id= " + review_id;
            }else{   //취소
                return;
            }
        }
        function rating_click(){
			var numone = '<?php echo $num_one;?>';
			alert(numone);
        }
    </script>
</div>
<? include("footer.php") ?>
