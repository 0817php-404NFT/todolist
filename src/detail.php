<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/todolist/src/");
define("FILE_HEADER", ROOT."header.php");
require_once(ROOT."lib/lib_db.php");

try{
    // 초기값설정
	$id = "";
	$conn = null;
    $page = "";
	$ox ="";
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
	// DB 연결
	if(!my_db_conn($conn)) {
		throw new Exception("DB Error : PDO Instance");
	}

	// 게시글 데이터 조회
	$arr_param = [
		"id" => $id
	];
	$result=db_select_boards_id($conn, $arr_param);

	// 게시글 조회 예외 처리
	if(!$result) {
		throw new Exception("DB Error : PDO Select_id");
	} else if(!(count($result) === 1)){
		throw new Exception("DB Error : PDO Select_id count," .count($resilt));
	} 
$item=$result[0];
	if($item["chk_flg"] === "0"){
		$ox = "X";
	}
	else if($item["chk_flg"] === "1"){
		$ox = "O";
	}
} catch (Exception $e) {
	echo $e->getMessage(); //예외 메세지 출력
	exit; //처리종료
} finally {
	db_destroy_conn($conn);
}
	// 게시글 조회 count 에러
	
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
    <?php
		require_once(FILE_HEADER);
	?>  
    <div class="detail-container">
        <img class="detail_img" src="/todolist/src/img/Group 7.svg" alt="">
        <table class="detail_table">        
            <tr>
                <td colspan="2" class="detail_head">
                    <span>수행여부: <?php echo $ox; ?></span>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="detail_content_1">
                    <div class="detail_typing-text"><?php echo $item["content"]; ?></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="detail_content_2">
                    <div class="detail_typing-text"><?php echo $item["write_date"]; ?></div>
                </td>
            </tr>
			<tr>
				<td>
					<a href="/todolist/src/update.php/?id=<?php echo $id; ?>&page=<?php echo $page ?>" class="detail_btn">수정</a>
				</td>
				<td>
				<a href="/todolist/src/delete.php/?id=<?php echo $id; ?>&page=<?php echo $page ?>" class="detail_btn">삭제</a>
				</td>
				<td>
				<a href="/todolist/src/list.php/?page=<?php echo $page ?>" class="detail_btn">나가기</a>
				</td>
			</tr>
        </table>
	</div>
	<div class="stars"></div>
</body>
</html>
