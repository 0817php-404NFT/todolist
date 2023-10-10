<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/TODOLIST/src/");
define("FILE_HEADER", ROOT."header.php");
require_once(ROOT."lib/lib_db.php");

// $conn - null; // DB 연결용 변수
// $id = isset($_GET["id"]) ? $_GET["id"] : $_POST["id"]; // id 셋팅
// $page = isset($_GET["page"]) ? $_GET["page"] : $_POST["page"]; // page 셋팅
// $http_method = $_SERVER["REQUEST_METHOD"]; // Method 확인

// try {
//     // DB 연결
//         if(!my_db_conn($conn)) {
//         // DB Instance 에러
//             throw new Exception("DB Error : PDO Instance");
//         }    

//     // GET Method의 경우
//     if($http_method === "GET") {
//         // GET Method의 경우
//         // 게시글 데이터 조회를 위한 파라미터 셋팅

//         $arr_param =
//     }
// }


?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <link rel="stylesheet" href="/TODOLIST/src/css/style.css">
    <title>수정페이지</title>
</head>
<body>
    <?php
            require_once(FILE_HEADER);
    ?>  
    <form class="update_form" action="">
        <table>
            <img src="/TODOLIST/src/img/update_table.svg" alt="update_table">
            <input class="update_input" type="text" name="content" value="자기전에 휴대폰 사용시간 3시간 밑으로 하기">
        </table>
        <div class="update_div">
            <button class="update_a" type="submit">완료</button>
            <a class="update_a "href="/TODOLIST/src/detail.php">취소</a>
        </div>
    </form>
</body>
</html>