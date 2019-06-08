<!DOCTYPE html>
<html lang='ko'>
<head>
    <title>foodlove</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<form action="product_list.php" method="post">
    <div class='navbar fixed'>
        <div class='container'>
            <a class='pull-left title' href="index.php">foodlove</a>
            <ul class='pull-right'>
                <li>
                    <input type="text" name="search_keyword" placeholder="식당 검색하기">
                </li>
                <li><a href='product_list.php'>식당 목록</a></li>
                <li><a href='product_form.php'>식당 등록</a></li>
                <li><a href='review_form.php'>후기 등록하기</a></li>
            </ul>
        </div>
    </div>
</form>