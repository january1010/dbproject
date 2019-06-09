<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력";
$action = "product_insert.php";

if (array_key_exists("store_id", $_GET)) {
    $store_id = $_GET["store_id"];
    $query =  "select * from store where store_id = $store_id";
    $res = mysqli_query($conn, $query);
    $store = mysqli_fetch_array($res);
    if(!$store) {
        msg("가게가 존재하지 않습니다.");
    }
    $mode = "수정";
    $action = "product_modify.php";
}

$dishes = array();

$query = "select * from dish";
$res = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($res)) {
    $dishes[$row['dish_id']] = $row['dish_name'];
}

?>

    <div class="container">
        <form name="product_form" action="<?=$action?>" method="post" class="fullwidth">
            <input type="hidden" name="store_id" value="<?=$store['store_id']?>"/>
            <h3>식당 정보 <?=$mode?></h3>
            <p>
                <label for="dish_id">메뉴</label>
                <select name="dish_id" id="dish_id">
                    <option value="-1">선택해 주십시오.</option>
                    <?
                        foreach($dishes as $id => $name) {
                            if($id == $store['dish_id']){
                                echo "<option value='{$id}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
            </p>
            <p>
                <label for="product_name">식당 이름</label>
                <input type="text" placeholder="식당 이름 입력" id="store_name" name="store_name" value="<?=$store['store_name']?>"/>
            </p>
            <p>
                <label for="location">위치</label>
                <input type="text" placeholder="영어로 입력" id="location" name="location" value="<?=$store['location']?>" />
            </p>

            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>

            <script>
                function validate() {
                    if(document.getElementById("dish_id").value == "-1") {
                        alert ("메뉴를 선택해 주십시오"); return false;
                    }
                    else if(document.getElementById("store_name").value == "") {
                        alert ("가게명을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("location").value == "") {
                        alert ("위치를 입력해 주십시오"); return false;
                    }
                    return true;
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>