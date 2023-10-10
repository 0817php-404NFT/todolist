<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/TODOLIST/src/");
define("FILE_HEADER", ROOT."header.php");
require_once(ROOT."lib/lib_db.php");





?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <link rel="stylesheet" href="/TODOLIST/src/css/style.css">
    <title>작성페이지</title>
</head>
<body>
    <?php
            require_once(FILE_HEADER);
    ?>  
    <div class="insert_div1">
        <input class="insert_input" type="text" name="content" placeholder="내용을 입력해 주세요.">
    </div> 
    <div class="insert_div2">
        <img class="insert_sheep" src="/TODOLIST/src/img/sheeps.svg" alt="sheeps">
        <img class="insert_cat" src="/TODOLIST/src/img/cat2.png" alt="눈감은고양이">
    </div>
</body>
</html>