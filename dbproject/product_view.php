<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("store_id", $_GET)) {
    $store_id = $_GET["store_id"];
    $query = "select * from store natural join dish where store_id = $store_id";
    $res = mysqli_query($conn, $query);
    $store = mysqli_fetch_assoc($res);
    if (!$store) {
        msg("식당이 존재하지 않습니다.");
    }
}
?>
    <div class="container fullwidth">

        <h3>식당 정보 상세 보기</h3>

       <p>
            <label for="store_name">식당 이름</label>
            <input readonly type="text" id="store_name" name="store_name" value="<?= $store['store_name'] ?>"/>
        </p>

        <p>
            <label for="manufacturer_name">메뉴</label>
            <input readonly type="text" id="dish_name" name="dish_name" value="<?= $store['dish_name'] ?>"/>
        </p>
        
        <p>
            <label for="location">위치</label>
            <input readonly type="text" id="location" name="location" value="<?= $store['location'] ?>"/>
        </p>

    </div>
<? include("footer.php") ?>