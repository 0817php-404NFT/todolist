<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/todolist/src/");
define("FILE_HEADER", ROOT."header.php");
require_once(ROOT."lib/lib_db.php");
try{
    // 초기값설정
	$id = "";
	$conn = null;
    $page = "";

	// id확인
	if(isset($_GET["id"])){
		$id=$_GET["id"]; //id 셋팅
	} else {
		throw new Exception("Parameter ERROR : NO id"); //강제 예외 발생
	}
	if(isset($_GET["page"])){
		$page=$_GET["page"]; //id 셋팅
	} else {
		throw new Exception("Parameter ERROR : NO page"); //강제 예외 발생
	}

	if(!my_db_conn($conn)) {
		throw new Exception("DB Error : PDO Instance");
	}

	// 게시글 데이터 조회
	$param_id = [
		"id" => $id
	];
	$result=db_select_boards_id($conn, $param_id);

	// 게시글 조회 예외 처리
	if(!$result) {
		throw new Exception("DB Error : PDO Select_id");
	} else if(!(count($result) === 1)){
		throw new Exception("DB Error : PDO Select_id count," .count($resilt));
	} 
$item=$result[0];

} catch (Exception $e) {
	echo $e->getMessage(); //예외 메세지 출력
	exit; //처리종료
} finally {
	db_destroy_conn($conn);
}
	// 게시글 조회 count 에러
	
$page=$_GET["page"];	
?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="/todolist/src/css/style.css">
    <title>상세페이지</title>
</head>
<body>
    <?php require_once(FILE_HEADER); ?>
    
    <div class="detail-container">
        <table class="detail_table">
            <tr>
                <th>수행여부</th>
                <td><?php echo $item["chk_flg"]; ?></td>
            </tr>
            <tr>
                <th>작업 내용</th>
                <td><?php echo $item["content"]; ?></td>
            </tr>
            <tr>
                <th>날짜</th>
                <td><?php echo $item["write_date"]; ?></td>
            </tr>
        </table>

        <div class="detail-button-container">
        <a href="/todolist/src/update.php/?id=<?php echo $id; ?>&page=<?php echo $page ?>">수정</a>
        <a href="/todolist/src/delete.php/?id=<?php echo $id; ?>&page=<?php echo $page ?>">삭제</a>
    </div>
</div>
</body>
</html>
