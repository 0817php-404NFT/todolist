<?php 
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/TODOLIST/src/");
require_once(ROOT."lib/lib_db.php");

$conn=null;
$id= "";
try {
    // DB 접속
    if(!my_db_conn($conn)){
        // DB Instance 에러
        throw new Exception("DB Error : PDO instance"); //강제예외발생 : DB Insrance
    }
    $id = isset($_POST["id"]) ? $_POST["id"] : ""; //id셋팅
    // 게시글 수정을 위해 파라미터 셋팅
    $arr_param =[
        "id" => $id
    ];
    
    $conn->beginTransaction(); // 트랜잭션 시작
    // 게시글 수정 처리
    if(!db_update_chk_flg($conn, $arr_param)){
        throw new Exception("DB Error : Update_boards_id");
    }
    $conn->commit(); // commit
    header("Location: /mini_test/src/detail.php/?id={$id}&page={$page}"); // 디테일 페이지로 이동
    exit;
    }
catch(Exception $e) {
        $conn->rollback(); // rollback
    exit; //처리종료
} finally {
    db_destroy_conn($conn);
}

print_r($_POST);









?>