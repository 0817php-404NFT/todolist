<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/todolist/src/");
define("FILE_HEADER", ROOT."header.php");
require_once(ROOT."lib/lib_db.php");

$conn = null; // DB connection 변수 초기화
$search_day = ""; // 변수초기화 
$today="";

$today = date("Y-m-d");
$search_day = isset($_GET["date"])? $_GET["date"]:date("Y-m-d");
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
    $arr_param=[
        "write_date" => $search_day
    ];
    $boards_cnt = db_search_boards_cnt($conn, $arr_param);
    if($boards_cnt === false) {
        throw new Exception("DB Error : SELECT Count"); // 강제 예외 발생 : DB SELECT Count
    }
    // 만약 오늘로 검색할시
    if($search_day === $today){
        header("Location: /todolist/src/list.php/?page=1"); // 리스트 페이지로 이동
    }

     // 삼항연산자로 작성
    $page_num = isset($_GET["page"]) ? $_GET["page"] : 1;
    
    $offset = ($page_num - 1)* $list_cnt; //오프셋계산
    
    // DB 조회시 사용할 데이터 배열
    $arr_param = [
        "list_cnt" => $list_cnt
        ,"offset" => $offset
        ,"write_date" => $search_day
    ];

    // 게시글 리스트 조회 
    $result  = db_search_boards($conn, $arr_param);
    if($result === false){
        throw new Exception("DB Error : SELECT boards"); // 강제 예외 발생 : SELECT boards
    }
} catch(Exception $e) {
    echo $e->getMessage(); //예외발생 메세지 출력  //v002 del
    // header("Location: /error.php/?err_msg={$e->getMessage()}");
    exit; //처리종료
} finally {
    db_destroy_conn($conn); //DB파기
}




?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/todolist/src/css/style.css">
    <title>검색페이지</title>
</head>

<body>
    <?php
            require_once(FILE_HEADER);
    ?>
        <table class="search_table">
            <thead>       
                <tr>
                    <td class="search_head_td">
                        <?php echo $search_day ?>
                        <a class="search_out_btn" href="/todolist/src/list.php/?page=1">메인으로</a>
                    </td>
                </tr>
            </thead>
        <?php
        // 리스트를 생성
        foreach ($result as $item) {
        ?>
            <tr>
                <td colspan="2">
                <?php if($item["chk_flg"] === "0"){ ?>
                    <span class="search_content" href="/todolist/src/detail.php/?id=<?php echo $item["id"]; ?>&page=<?php echo $page_num; ?>">
                        <?php echo $item["content"]; ?>
                    </span>
                <?php } ?>
                <?php if($item["chk_flg"] === "1"){ ?>
                    <span class="search_content_chk" href="/todolist/src/detail.php/?id=<?php echo $item["id"]; ?>&page=<?php echo $page_num; ?>">
                        <?php echo $item["content"]; ?>
                    </span>
                <?php } ?>
                </td>
            </tr>
        <?php
        }
        ?>
        <tr>
            <td>
                <img src="/todolist/src/img/list_paper.svg" alt="" class="list_img_1">
            </td>
        </tr>
        <tfoot>
            <tr>
                <td class="center">
                    <?php                  
                        for ($i = 1; $i <= 3; $i++) {
                                // 삼항연산자 : 조건 ? 참일때처리 : 거짓일때처리
                                $class = ($i == $page_num) ? "list_now_page" : "";
                    ?>
                    <a class="lsit_page <?php echo $class; ?> " href="/todolist/src/search.php/?page=<?php echo $i ?>&date=<?php echo $search_day ?>">●</a>        
                    <?php
                        }
                    ?>
                    </td>
            </tr>
        </tfoot>
        </table>
</body>
</html>