<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/todolist/src/");// 상수 설정
define("FILE_HEADER", ROOT."header.php");
require_once(ROOT."lib/lib_db.php");// db파일 불러오기
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
		throw new Exception("DB Error : PDO Select_id count," .count($result));
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


//$result 배열에서 첫번째 요소를 가져와서 $item 변수에 할당함
//이건 데이터 베이스 조회 결과에서 첫번째 게시물을 나타냄
//if($item["chk_flg"] === "0"){ ... }은 
//$item배열에서 chk_flg	키의 값을 검사함
//밑에서 수행여부 O X 를 위해 적음
//체크플래그가 0이면 O X 중 X를 $ox문자열에 할당하고
//체크플래그가 1이면 O X 중 O를 $ox문자열에 할당함
//catch (Exception $e)은 예외 처리를 위한 블록임
//예외가 발생했을 때 실행돼서 $e는 예외 객체를 나타냄
//예외가 발생하면 해당 $e에 예외 정보가 저장됨
//echo $e->getMessage();는 예외 객체 메세지를 출력 에러 메세지임
//exit;는 스크립트 실행 종료함, 즉 예외가 발생하면 스크립트 실행이 중지되기위해 적음
?>







<!DOCTYPE html>
<!-- 문서 정의함 html 로 할거라는 뜻 -->
<html lang="ko">
	<!-- 언어는 한국어로 설정 -->
<head>
	<!-- 페이지 정보랑 스타일 정의하는 섹션임 -->
    <meta charset="UTF-8">
	<!-- 웹 페이지 문자 인코딩을 UTF-8로 설정함 한국어랑 다른 언어때매 함 -->
    <meta name="viewport" content="width=, initial-scale=1.0">
	<!-- 뷰포트 설정 정의함 웹 페이지가 올바르게 화면에 맞게 표시되기 위해서 적음 -->
    <link rel="stylesheet" href="/todolist/src/css/style.css">
	<!-- 외부 스타일 시트를 연결하는 경로가 적힌 코드 -->
    <title>상세페이지</title>
	<!-- 웹 페이지 제목인 detail페이지니까 상세 페이지라 정의함 브라우저 탭에 표시됨 -->
</head>

<body>
    <?php
		require_once(FILE_HEADER);
//PHP 스크립트에서 다른 파일을 포함 또는 요청하는 코드임
//require_once(FILE_HEADER) 변수에 저장된 파일을 한번만 포함하도록 요청하는 명령임
//require_once 함수는 파일을 포함하고, 이미 포함되었거나 중복으로 포함하는걸 방지해줌
//달이랑 꿀잠 공통 헤더 파일을 포함해야해서 이 코드를 사용함 (여러번 페이지나 스크립트에 중복해서 적지않기위해)
	?>  
	
    <div class="detail-container">
		<!-- 상세 페이지 컨테이너 정의하는 div임 상세 페이지 콘텐츠 감싸기위해 적음 -->
        <table class="detail_table center">     
				<!--테이블 요소를 정의함 detail_table이랑 center클래스 갖고있음 상세 페이지 레이아웃이며 클래스를 써서 스타일 적용함 -->
            <tr>
				<!-- tr은 테이블 행을 나타냄 각 행의 콘텐츠를 나누기 위해서 적음 -->
                <td colspan="3" class="detail_head center">
                    <span>수행여부: <?php echo $ox; ?></span>
                </td>
				<!-- PHP코드를 사용해서 변수 $ox값을 출력함 수행여부 : O,X -->
            </tr>
            <tr>
                <td colspan="3" class="detail_content_1">
						<?php echo $item["content"]; ?>
						<!-- HTML 테이블 데이터 셀을 나타냄 게시물 값 출력을 위해서 적음 -->
						<!-- colspan으로 셀을 세개의 열(수정 삭제 나가기 버튼)을 병합한 영역으로 지정함 -->
					</td>
				</tr>
				<tr>
					<td colspan="3" class="detail_content_2">
						<?php echo $item["write_date"]; ?>
						<!-- tr과 td블록은 게시물 작성 날짜를 표시해줌 -->
                </td>
            </tr>
			<tr>
				<td>
					<a href="/todolist/src/update.php/?id=<?php echo $id; ?>&page=<?php echo $page ?>" class="detail_btn">수정</a>
				</td>
				<!-- 업데이트(수정페이지)로 가는 버튼 -->
				<td>
				<a href="/todolist/src/delete.php/?id=<?php echo $id; ?>&page=<?php echo $page ?>" class="detail_btn">삭제</a>
				</td>
				<!-- 딜리트(삭제페이지)로 가는 버튼 -->
				<td>
				<a href="/todolist/src/list.php/?page=<?php echo $page ?>" class="detail_btn">나가기</a>
				</td>
				<!-- 나가기(리스트페이지)로 가는 버튼 -->
			</tr>
			<tr>
				<td>
					<img src="/todolist/src/img/labtop.png" alt="" class="detail_img labtop">
					<!-- 노트북 이미지 넣기 -->
					<img src="/todolist/src/img/c_star.png" alt="" class="detail_img c_star">
					<!-- 별의 커비 이미지 넣기 -->
					<img src="/todolist/src/img/cloude.png" alt="" class="detail_img cloude">
					<!-- 구름 이미지 넣기 -->
				</td>
			</tr>
        </table>

	</div>
	<div class="stars"></div>
	<!-- 배경에 반짝이는 별 넣기 -->
</body>
</html>
