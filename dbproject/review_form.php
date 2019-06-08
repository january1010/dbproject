<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력";
$action = "review_insert.php";

if (array_key_exists("review_id", $_GET)) {
    $review_id = $_GET["review_id"];
    $query =  "select * from review where review_id= $review_id";
    $res = mysqli_query($conn, $query);
    $review = mysqli_fetch_array($res);
    
    if(!$review) {
        msg("리뷰가 존재하지 않습니다.");
    }
}

$stores = array();

$query = "select * from store";
$res = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($res)) {
    $stores[$row['store_id']] = $row['store_name'];
}

?>

    <div class="container">
        <form name="review_form" action="<?=$action?>" method="post" class="fullwidth">
            <input type="hidden" name="review_id" value="<?=$review['review_id']?>"/>
            <h3>후기 정보 <?=$mode?></h3>
            <p>
                <label for="store_id">식당</label>
                <select name="store_id" id="store_id">
                    <option value="-1">선택해 주십시오.</option>
                    <?foreach($stores as $id => $name) {
                            if($id == $review['store_id']){
                                echo "<option value='{$id}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                       	}
                    ?>
                </select>
            </p>
            
            <p>
                <label for="user_id">사용자 id</label>
                <input type="text" placeholder="영자 15자 이내" id="user_id" name="user_id"/>
            </p>

			<p>
                <label for="age">나이를 적어주세요</label><br>
                <input type="age" id="age" name="age" />
            </p>
            
            <p>
                <label for="rating">평점을 매겨주세요</label><br>
                <input type = "number" id="rating" name="rating" min=1 max=5 />
            </p>
            
            
            <p>
            	<label for="content">상세 내용 입력</label>
            	<textarea id="content" name="content" placeholder='상세한 후기를 적어주세요. 100자이내' rows=10><?=$reveiw['content']?></textarea>
            </p>

            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>

            <script>
                function validate() {
                    if(document.getElementById("store_id").value == "-1") {
                        alert ("가게를 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("user_id").value == "") {
                        alert ("id를 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("age").value == "") {
                        alert ("나이를 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("rating").value == "") {
                        alert ("평점을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("content").value == "") {
                        alert ("내용을 입력해 주십시오"); return false;
                    }
                    return true;
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>