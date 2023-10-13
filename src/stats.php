<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/todolist/src/");
define("FILE_HEADER", ROOT."header.php");
require_once(ROOT."lib/lib_db.php");

$conn = null; // DB connection 변수
$date = "";
$cnt = "";
$arr_param = [];
$clear_cnt = "";

try {
    // DB 접속
    if(!my_db_conn($conn)){
        // DB Instance 에러
        throw new Exception("DB Error : PDO instance"); //강제예외발생 : DB Insrance
    }
   	// id확인
	if(isset($_GET["date"])){
		$date=$_GET["date"]; //id 셋팅
	} else {
		throw new Exception("Parameter ERROR : NO id"); //강제 예외 발생
	}
     // DB 조회시 사용할 데이터 배열
    $arr_param = [
        "dat" => $date
    ];

    // 게시글 리스트 % 조회
    $result  = db_select_boards_stats($conn, $arr_param);
    if($result === false){
        throw new Exception("DB Error : SELECT boards %"); // 강제 예외 발생 : SELECT boards %
    }
    // 조회된 총 리스트 cnt
    $cnt = db_select_search_boards_stats_cnt($conn, $arr_param);
    if($cnt === false){
        throw new Exception("DB Error : SELECT boards cnt"); // 강제 예외 발생 : SELECT boards cnt
    }
    // 조회된 총 리스트 cnt 중 성공한 cnt
    $clear_cnt  = db_select_search_boards_clear_stats_cnt($conn, $arr_param);
    if($clear_cnt === false){
        throw new Exception("DB Error : SELECT boards cnt"); // 강제 예외 발생 : SELECT boards cnt
    }


} catch(Exception $e) {
    echo $e->getMessage(); //예외발생 메세지 출력  //v002 del
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
    <title>통계페이지</title>
</head>
<body>
    <colgroup>
        <col width="25%">
        <col width="50%">
        <col width="25%">
    </colgroup>
    <table class="stats_table">
        <?php
                require_once(FILE_HEADER);
        ?>
        <thead>
            <tr>
                <th>
                    <?php
                        if($date === "week"){
                    ?>
                    <a href="/todolist/src/stats.php/?date=month">월간통계</a>
                    <?php
                        }
                    ?>
                    <?php
                        if($date === "month"){
                    ?>
                    <a href="/todolist/src/stats.php/?date=week">주간통계</a>
                    <?php
                        }
                    ?>
                </th>
                <th>        
                    <?php
                        if($date === "week"){
                    ?>
                        <span>주간 달성률</span>
                    <?php
                        }
                    ?>
                    <?php
                        if($date === "month"){
                    ?>
                        <span>월간 달성률</span>
                    <?php
                        }
                    ?>
                </th>
                <th>
                    <a href="/todolist/src/list.php">메인으로</a>
                </th>
            </tr>
        </thead>
            <tr class="center stats_td_t">
                <td>
                    <?php echo $result; ?>%
                </td>
            </tr>
            <tr class="center stats_td_b">
                <td>    
                    <progress value="<?php echo $result; ?>" max="100" class="
                                                                            <?php
                                                                                if($result === 100){
                                                                            ?> 
                                                                                stats_progress_1
                                                                            <?php        
                                                                                }
                                                                            ?>
                                                                            <?php
                                                                                if($result < 100 && $result >= 75){
                                                                            ?> 
                                                                                stats_progress_2
                                                                            <?php        
                                                                                }
                                                                            ?>
                                                                            <?php
                                                                                if($result < 75 && $result >= 50){
                                                                            ?> 
                                                                                stats_progress_3
                                                                            <?php        
                                                                                }
                                                                            ?>
                                                                            <?php
                                                                                if($result < 50 && $result >= 25){
                                                                            ?> 
                                                                                stats_progress_4
                                                                            <?php        
                                                                                }
                                                                            ?>
                                                                            <?php
                                                                                if($result < 25 && $result >= 0){
                                                                            ?> 
                                                                                stats_progress_5
                                                                            <?php        
                                                                                }
                                                                            ?>
                                                                            ">
                    </progress>
            </td>
            </tr>
            <tr class="center">
                <td>
                    총 <?php echo $cnt ?>개 중 <?php echo $clear_cnt; ?>개 성공!
                </td>
            </tr>
            <tr>
                <td class="center stats_td_f">
                    <?php
                        if($result === 100){
                    ?>
                        <span>
                            !!!!! <?php echo $result; ?> % 꿀잠성공!!!!!
                        </span>
                    <?php        
                        }
                    ?>
                    <?php
                        if($result < 100 && $result >= 80){
                    ?>
                        <span>
                            다 왔어요! 조금만 더!
                        </span>
                    <?php        
                        }
                    ?>
                    <?php
                        if($result < 80 && $result >= 60){
                    ?>
                        <span>
                            오...힘을내요..!
                        </span>
                    <?php        
                        }
                    ?>
                    <?php
                        if($result < 60 && $result >= 40){
                    ?>
                        <span>
                            흠....네...뭐..
                        </span>
                    <?php        
                        }
                    ?>
                    <?php
                        if($result < 40 && $result >= 20){
                    ?>
                        <span>
                            고작...? 노력하세요!
                        </span>
                    <?php        
                        }
                    ?>
                    <?php
                        if($result < 20 && $result >= 0){
                    ?>
                        <span>
                            아니....? 잠을 포기하셨나요?
                        </span>
                    <?php        
                        }
                    ?>
                </td>
            </tr>	
    </table>
</body>
</html>