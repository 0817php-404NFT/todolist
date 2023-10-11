<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/todolist/src/");
define("FILE_HEADER", ROOT."header.php");
// define("ERROR_MSG_PARAM", "%s: 필수 입력 사항입니다.");
require_once(ROOT."lib/lib_db.php");

$http_method = $_SERVER["REQUEST_METHOD"];
if($http_method === "POST") {
    try {
        $arr_post = $_POST;
        $conn = null;

        if(!my_db_conn($conn)) {
            throw new Exception ("DB Error : PDO instance");
        }

        $conn->beginTransaction();

        if(!db_insert_boards($conn, $arr_post)) {
            throw new Exception("DB Error : Insert Boards");
        }
        $conn->commit();

        header("Location: list.php");
        exit;
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    } finally {
        db_destroy_conn($conn);
    }
}



?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <link rel="stylesheet" href="/todolist/src/css/style.css">
    <title>작성페이지</title>
</head>
<body>
    <?php
            require_once(FILE_HEADER);
    ?>  
    <form action="/todolist/src/insert.php" method="post" class="insert_form">
            <input class="insert_input" type="text" name="content" placeholder="             내용을 입력해 주세요(최대30글자)." maxlength='30' required>
            <button class="insert_butt" type="submit">
                <img class="insert_pen" src="/todolist/src/img/흐리멍텅한연필.png" alt="연필">
            </button>
            <a class="insert_a"href="/todolist/src/list.php">
                <img src="/todolist/src/img/delete_cancel2.png" alt="연필">
            </a>
            <img class="insert_sheep" src="/todolist/src/img/sheeps.svg" alt="sheeps">
            <img class="insert_cat" src="/todolist/src/img/cat2.png" alt="눈감은고양이">
        </div>
    </form>
</body>
</html>