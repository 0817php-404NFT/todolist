<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/TODOLIST/src/");
define("FILE_HEADER", ROOT."header.php");
require_once(ROOT."lib/lib_db.php");

$conn = null; // DB connection 변수

$today = date("Y-m-d");
$list_cnt = 4; // 한 페이지 최대 표시 수
$page_num = 1; // 페이지 번호 초기화
try {
    // DB 접속
    if(!my_db_conn($conn)){
        // DB Instance 에러
        throw new Exception("DB Error : PDO instance"); //강제예외발생 : DB Insrance
    }
    // -------------
    // 페이징 처리
    // -------------
    $boards_cnt = db_select_boards_cnt($conn);
    if($boards_cnt === false) {
        throw new Exception("DB Error : SELECT Count"); // 강제 예외 발생 : DB SELECT Count
    }

    $max_page_num = ceil($boards_cnt / $list_cnt); // 최대페이지 수
    
    $offset = ($page_num - 1)* $list_cnt; //오프셋계산
    
    // DB 조회시 사용할 데이터 배열
    $arr_param = [
        "list_cnt" => $list_cnt
        ,"offset" => $offset
    ];
       
    // 게시글 리스트 조회 
    $result  = db_select_boards_paging($conn, $arr_param);
    if($result === false){
        throw new Exception("DB Error : SELECT boards"); // 강제 예외 발생 : SELECT boards
    }
} catch(Exception $e) {
    // echo $e->getMessage(); //예외발생 메세지 출력  //v002 del
    header("Location: error.php/?err_msg={$e->getMessage()}");
    exit; //처리종료
} finally {
    db_destroy_conn($conn); //DB파기
}




?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    
    <link rel="stylesheet" href="/TODOLIST/src/css/style.css">
    <title>리스트페이지</title>
</head>
<body>
    <?php
            require_once(FILE_HEADER);
    ?>
        <table class="list_table">     
            <div>  
                <tr>
                    <td class="list_head_td">오늘의할일                   
                    <form action="">           
                            <label class="list_label">
                                <input type="date" name="date" required class="list_search_input" value="<?php echo $today; ?>">
                                <button type="submit" class="list_search_btn"><img src="../img/search_btn.png" alt=""></button>
                            </label>
                    </form>
                    </td>
                </tr>
            </div>
        <?php
        // 리스트를 생성
            foreach($result as $item){
        ?>
            <tr>
                <td>
                    <label>
                        <input type="checkbox" class="list_chk">
                        <a class="" href="/todolist/src/detail.php/?id=<?php echo $item["id"]; ?>"><?php echo $item["content"]; ?></a>
                    </label>
                </td>
            </tr>
        <?php    
            }
        ?>   
            <tr>
                <td>
                    <img src="../src/img/list_paper.svg" alt="" class="list_img_1">
                </td>
            </tr>
        </table>
</body>
</html>