<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("review_id", $_GET)) {
    $review_id = $_GET["review_id"];
    $query = "select * from store natural join review natural join rating where review_id = $review_id";
    $res = mysqli_query($conn, $query);
    $review = mysqli_fetch_assoc($res);
    if (!$review) {
        msg("후기가 존재하지 않습니다.");
    }
}
?>
    <div class="container fullwidth">

        <h3>상세 후기 보기</h3>

       <p>
            <label for="store_name">가게 이름</label>
            <input readonly type="text" id="store_name" name="store_name" value="<?= $review['store_name'] ?>"/>
        </p>

        <p>
            <label for="rating">평점</label>
            <input readonly type="text" id="rating" name="rating" value="<?= $review['rating'];?>"/>
        </p>
        
        <p>
            <label for="review_content">상세 후기</label>
            <textarea id="review_content" name="review_content" readonly rows=10><?=$review['content']?></textarea>
            </p>
    </div>
<? include("footer.php") ?>