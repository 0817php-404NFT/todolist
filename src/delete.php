<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/TODOLIST/src/");
define("FILE_HEADER", ROOT."header.php");
require_once(ROOT."lib/lib_db.php");


try {
    // 2. DB Connect
    // 2-1. connection 함수호출
    $conn=null; // PDO 객체변수
    if(!my_db_conn($conn)){
        // 2-2 예외처리
        throw new Exception("DB Error : PDO instance");
    }
    // Method 획득
    $http_method = $_SERVER["REQUEST_METHOD"]; 

    if($http_method === "GET"){
        // 3-1. GET일 경우 (상세 페이지의 삭제 버튼 클릭)
        // 3-1-1. 파라미터에서 id 획득
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        $page = isset($_GET["page"]) ? $_GET["page"] : "";

        // 3-1-2. 게시글 정보 획득
        $arr_param = [
            "id" => $id
        ];
        $result = db_select_boards_id($conn, $arr_param);

        // 3-1-3. 예외 처리
        if($result === false){
            throw new Exception("DB Error : Select id");
        } else if(!(count($result) === 1)){
            throw new Exception("DB Error : Select id count");
        }
        $item = $result[0];
    } else {
        // 3-2-1.파라미터에서 id 획득
        $id = isset($_POST["id"]) ? $_POST["id"] : "";
        // 3-2-2.Transaction 시작
        $conn->beginTransaction();

        // 3-2-3. 게시글 정보 삭제
        $arr_param = [
            "id" => $id
        ];

        // 3-2-4. 예외 처리
        if(!db_delete_boards_id($conn, $arr_param)){
            throw new Exception("DB Error : Delete Boards id");
        }

        $conn->commit(); // commit
        header("Location: list.php"); // 리스트 페이지로 이동 
        exit;
    }
} catch(Exception $e) {
    if($http_method === "POST"){
        $conn->rollback();
    }
    echo $e->getMessage(); //에러 메세지 출력
    exit; // 처리종료
} finally{
    db_destroy_conn($conn);
}

?>




<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <link rel="stylesheet" href="/TODOLIST/src/css/style.css">
    <title>삭제페이지</title>
</head>
<body>
    <?php
        require_once(FILE_HEADER);
    ?>  
    <main>
        <table  style="text-align: center;" class="delete_table">
            <img src="/TODOLIST/src/img/delete_box.png" alt="delete" class="delete_img">
            <caption class="delete_caption" style="color:black"> 
                <p class="delete_p"style="color:red">- Warning -</p>
                <br>
                <br>
                한번 삭제한 리스트는 복구가 불가능 합니다.
                <br>
                <br>
                그래도 하시겠습니까?
                <br>
                <br>
            </caption>
            <tr class = "delete_tr">
                <td class = "delete_td"><?php echo $item["content"] ?></td>
            </tr>
            <!-- <a href="" class="delete_content">" 자기전에 발 닦고 자기 "</a> -->
        </table>
    </main>
    <section class="delete_section">
        <form action="/todolist/src/delete.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <img src="/TODOLIST/src/img/delete_chk2.png" class="delete_btn_img"> 
            <button class="delete_btn" type="submit">
                <span class="delete_span">확인</span>
            </button>

            <img src="/TODOLIST/src/img/delete_cancel2.png"  class="delete_btn_img2" alt="">
            <a class="delete_a" href="/TODOLIST/src/detail.php/?id=<?php echo $id; ?>&page=<?php echo $page; ?> ">
                <span class="delete_span">취소</span>
            </a>
        </form>
    </section>
</body>
</html>

