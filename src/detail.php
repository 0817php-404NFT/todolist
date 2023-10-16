<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/todolist/src/");
define("FILE_HEADER", ROOT."header.php");
require_once(ROOT."lib/lib_db.php");
/*상수 정의: define 함수를 사용하여 두 개의 상수를 만듭니다.
ROOT: 이 상수는 현재 웹 애플리케이션의 루트 디렉토리 경로를 저장합니다.
FILE_HEADER: 이 상수는 ROOT와 "header.php" 문자열을 합쳐서
웹 페이지의 상단에 표시할 헤더 파일의 경로를 저장합니다.
라이브러리 포함: require_once 함수를 사용하여 "lib_db.php" 
파일을 현재 PHP 스크립트에 포함시킵니다. 
이 파일은 데이터베이스 작업을 처리하는 라이브러리 파일로,
웹 애플리케이션에서 데이터베이스 관련 작업을 수행할 때 사용됩니다.*/



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
	
/*변수 초기화: 몇 가지 변수(예: $id, $conn, $page, $ox)를 초기화합니다.

GET 매개변수 확인: 사용자로부터 받은 GET 매개변수인 "id"와 "page"를 확인합니다. 
이 매개변수가 없을 경우 예외를 발생시킵니다.

데이터베이스 연결: my_db_conn 함수를 사용하여 데이터베이스 연결을 시도하고,
 연결이 실패하면 데이터베이스 관련 예외를 발생시킵니다.

게시글 데이터 조회: "id"를 사용하여 게시글 데이터를 데이터베이스에서 가져옵니다.

예외 처리: 데이터베이스 조회 중에 예외가 발생하면 해당 예외 메시지를 출력하고 
스크립트 실행을 중단합니다. 예외가 발생하지 않으면 게시글 데이터를 확인하여 
"chk_flg" 값에 따라 $ox 변수를 설정합니다.

데이터베이스 연결 종료: db_destroy_conn 함수를 사용하여 데이터베이스 연결을 닫습니다.

이 코드는 주로 사용자로부터 받은 매개변수를 검증하고 데이터베이스와 
상호작용하는 웹 애플리케이션에서 사용됩니다. 
만약 예외가 발생하면, 해당 예외 메시지가 출력되고 스크립트 실행이 중지됩니다.*/	
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
        <table class="detail_table center">        
            <tr>
                <td colspan="3" class="detail_head center">
                    <span>수행여부: <?php echo $ox; ?></span>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="detail_content_1">
						<?php echo $item["content"]; ?>
					</td>
				</tr>
				<tr>
					<td colspan="3" class="detail_content_2">
						<?php echo $item["write_date"]; ?>
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
			<tr>
				<td>
					<img src="/todolist/src/img/labtop.png" alt="" class="detail_img labtop">
					<img src="/todolist/src/img/c_star.png" alt="" class="detail_img c_star">
					<img src="/todolist/src/img/cloude.png" alt="" class="detail_img cloude">
				</td>
			</tr>
        </table>

	</div>
	<div class="stars"></div>
</body>
</html>
<!--<HTML 문서 선언: <!DOCTYPE html>은 HTML5 문서임을 나타내며,
<html> 요소는 언어 속성으로 "ko"를 사용하여 한국어로 문서를 작성하겠다고 지정합니다.

헤더 설정: 웹 페이지의 문자 인코딩 및 뷰포트 설정을 정의합니다.

스타일 시트 링크: /todolist/src/css/style.css로 
연결된 스타일 시트를 가져와 페이지 스타일을 적용합니다.

페이지 제목: 웹 페이지의 타이틀을 "상세페이지"로 설정합니다.

헤더 파일 포함: require_once(FILE_HEADER)을 통해
웹 페이지의 상단에 공통적으로 표시되는 내용을 포함합니다.
이 부분은 다른 파일에서 정의한 것으로 보입니다.

상세 정보 표시: 게시글의 상세 내용을 표시하기 위한 테이블을 생성합니다.
이 테이블은 수행 여부, 내용, 작성 날짜 등의 정보를 표시합니다.

작업 버튼 링크: 수정, 삭제, 나가기 버튼을 표시하고, 
해당 버튼을 클릭하면 다른 페이지로 이동할 수 있도록 링크를 제공합니다.

이미지 표시: 페이지 하단에 세 가지 이미지를 표시합니다.
아마도 이러한 이미지는 웹 페이지의 장식이나 아이콘으로 사용될 것입니다. --!>