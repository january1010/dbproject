<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select * from store";
    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query =  $query . " where store_name like '%$search_keyword%'";
    
    }
    $res = mysqli_query($conn, $query);
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>
    <h3>식당 목록</h3>
    <br>
    <p>
    	<button type="button" class="button danger large" id="reviewpage" name="reviewpage"><a href="review_list.php">후기보러가기</a></button>
    </p>
    <br><br>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>no</th>
            <th>식당 이름</th>
            <th>기능</th></th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td width= '10%'>{$row_index}</td>";
            echo "<td><a href='product_view.php?store_id={$row['store_id']}'>{$row['store_name']}</a></td>";
            echo "<td width='17%'>
                <a href='product_form.php?store_id={$row['store_id']}'><button class='button primary small'>수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['store_id']})' class='button danger small'>삭제</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
    <script>
        function deleteConfirm(store_id) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "product_delete.php?store_id=" + store_id;
            }else{   //취소
                return;
            }
        }
    </script>
</div>
<? include("footer.php") ?>
