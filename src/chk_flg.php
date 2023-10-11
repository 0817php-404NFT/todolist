<?php 
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/TODOLIST/src/");
require_once(ROOT."lib/lib_db.php");

// 기본값 셋팅
$conn=null;
$id= "";
$chk_flg="";
$page="";

try {
    // DB 접속
    if(!my_db_conn($conn)){
        // DB Instance 에러
        throw new Exception("DB Error : PDO instance"); //강제예외발생 : DB Insrance
    }
    $id = isset($_GET["id"]) ? $_GET["id"] : ""; // id 셋팅
    $flg = isset($_GET["chk_flg"]) ? $_GET["chk_flg"] : ""; // flg 셋팅
    $page = isset($_GET["page"]) ? $_GET["page"] : ""; // fage 셋팅
    
    // chk_flg 반전
    if($flg === "1"){
        $chk_flg = "0";
    }
    if($flg === "0"){
        $chk_flg = "1";
    }

    
    // 게시글 수정을 위해 파라미터 셋팅
    $arr_param =[
        "id" => $id
        ,"chk_flg" => $chk_flg
    ];
    
    $conn->beginTransaction(); // 트랜잭션 시작
    // 게시글 수정 처리
    if(!db_update_chk_flg($conn, $arr_param)){
        throw new Exception("DB Error : Update_chk_flg");
    }
    $conn->commit(); // commit
    header("Location: /todolist/src/list.php/?page={$page}"); // 디테일 페이지로 이동
    exit;
    }
catch(Exception $e) {
        $conn->rollback(); // rollback
        echo $e->getMessage(); // Exception 메세지 출력
    exit; //처리종료
} finally {
    db_destroy_conn($conn);
}









?>