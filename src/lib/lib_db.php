<?php

// -------------------------------
// 함수명   : my_db_conn
// 기능     : DB Connect
// 파라미터 : PDO    &$conn
//           Array  &$arr_param
// 리턴     : boolen
// 제작     : 20231010 정훈
// -------------------------------


function my_db_conn( &$conn ) {
    $db_host    = "192.168.0.173"; // host
    $db_user    = "team4"; // user
    $db_pw      = "team4"; // password
    $db_name = "todolist"; // DB name
    $db_charset = "utf8mb4"; // charset
    $db_dns     = "mysql:host=".$db_host.";dbname=".$db_name.";charset=".$db_charset;

try {
    $db_options = [
        // DB의 prepared Statement 기능을 사용하도록 설정
        PDO::ATTR_EMULATE_PREPARES      => false
        // PDO Exception을 Throws하도록 설정
        ,PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION
        // 연상배열로 Fetch를 하도록 설정
        ,PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC
    ];

    // PDO Class로 DB 연동
    $conn = new PDO($db_dns, $db_user, $db_pw, $db_options);
    return true;
    }catch (Exception $e){
        echo $e->getMessage(); // Exception 메세지 출력
        $conn = null;
        return false;
    }
}


// -------------------------------
// 함수명   : db_destroy_conn
// 기능     : DB Destroy
// 파라미터 : PDO  &$conn
//           Array  &$arr_param
// 리턴     : 없음
// 제작     : 20231010 정훈
// -------------------------------

// DB 파기
function db_destroy_conn(&$conn){
    $conn = null;
}


// -------------------------------
// 함수명   : db_select_boards_paging
// 기능     : boards paging 조회
// 파라미터 : PDO  &$conn
//           Array  &$arr_param
// 리턴     : Array /false
// 제작     : 20231010 정훈
// -------------------------------
function db_select_boards_paging(&$conn, &$arr_param){
    try {
        $sql =
        " SELECT "
        ."      id  "
        ."      ,content "
        ."      ,chk_flg "
        ." FROM "
        ."      boards "
        ." WHERE "
        ."      write_date >= CURDATE() " 
        ." AND " 
        ."      del_flg = '0' "
        ." ORDER BY "
        ."      chk_flg ASC "
        ."      ,id DESC "
        ."      LIMIT :list_cnt " 
        ."      OFFSET :offset "
        ;

        $arr_ps = [
            ":list_cnt" => $arr_param["list_cnt"]
            ,":offset" => $arr_param["offset"]
        ];

        $stmt = $conn->prepare($sql);
        $stmt->execute($arr_ps);
        $result = $stmt->fetchALL();
        return $result; //정상
    } catch(Exception $e){
        echo $e->getMessage(); // Exception 메세지 출력
        return false; //예외발생
    }
}

// -------------------------------
// 함수명   : db_select_boards_cnt
// 기능     : boards count
// 파라미터 : PDO  &$conn
// 리턴     : Array /false
// 제작     : 20231010 정훈
// -------------------------------

function db_select_boards_cnt( &$conn ){
        $sql =
        " SELECT "
        ."      count(id) as cnt "
        ." FROM "
        ."      boards "
        ." WHERE "
        ."      write_date >= CURDATE() " 
        ." AND " 
        ."      del_flg = '0' "
        ;
    try {
        $stmt = $conn->query($sql);
        $result = $stmt->fetchAll();
        return (int)$result[0]["cnt"]; //정상 : 쿼리 결과 리턴
    } catch(Exception $e){
        echo $e->getMessage(); // Exception 메세지 출력
        return false; //예외발생 : false리턴
    }


}




// -------------------------------
// 함수명   : db_insert_boards
// 기능     : DB insert
// 파라미터 : PDO       &$conn
//           Array      &arr_param 쿼리 작성용 배열
// 리턴     : Array /false
// 제작     : 20231010 정훈
// -------------------------------
function db_insert_boards(&$conn, &$arr_param){
    $sql =
        " INSERT INTO " 
        ." boards ( "
        ."      content "
        ." ) "
        ." VALUES ( "
        ."      :content "
        ." ) "
        ;
    $arr_ps = [
        ":content" => $arr_param["content"]
    ];

    try{
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute($arr_ps);
        return $result; // 정상 : 쿼리 결과 리턴
    } catch(Exception $e) {
        echo $e->getMessage(); // Exception 메세지 출력
        return false; // 예외발생 : flase 리턴
    }


}



// -------------------------------
// 함수명   : db_search_boards_title
// 기능     : search_boards_id
// 파라미터 : PDO       &$conn &$arr_apram
//           Array      &arr_param 쿼리 작성용 배열
// 리턴     : array / false
// 제작     : 20231011 정훈
// -------------------------------

function db_search_boards(&$conn, &$arr_param)
{
    $sql =
    " SELECT "
    ."     id "
    ."     ,content "
    ."     ,chk_flg "
    ." FROM "
    ."     boards "
    ." WHERE "
    ." DATE_FORMAT(write_date, '%Y-%m-%d') = :write_date "
    ." AND "
    ."      del_flg = '0' "
    ." ORDER BY "
    ."      chk_flg ASC "
    ."      ,id DESC "
    ." LIMIT :list_cnt " 
    ." OFFSET :offset ";

    $arr_ps = [
        ":write_date" => $arr_param["write_date"],
        ":list_cnt" => $arr_param["list_cnt"],
        ":offset" => $arr_param["offset"]
    ];
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($arr_ps);
        $result = $stmt->fetchAll();
        return $result; // 정상 : 쿼리 결과 리턴
    } catch (Exception $e) {
        echo $e->getMessage(); // Exception 메세지 출력
        return false;
    }
}

// -------------------------------
// 함수명   : db_search_boards_cnt
// 기능     : 검색한 보드 카운트
// 파라미터 : PDO       &$conn
//           Array      &$arr_param
// 리턴     : int / false
// 제작     : 20231011 정훈
// -------------------------------

function db_search_boards_cnt(&$conn, &$arr_param)
{
    $sql =
        " SELECT "
        . "      count(id) as cnt "
        . " FROM "
        . "      boards "
        ." WHERE "
        ." DATE_FORMAT(write_date, '%Y-%m-%d') = :write_date "
        ." AND "
        ."      del_flg = '0' "
        ;
        $arr_ps = [
            ":write_date"  => $arr_param["write_date"]
        ];

        
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($arr_ps);
        $result = $stmt->fetchAll();

        return (int)$result[0]["cnt"]; // 정상 : 쿼리 결과 리턴
    } catch (Exception $e) {
        echo $e->getMessage(); // Exception 메세지 출력
        return false; // 예외 발생 : false 리턴
    }
}

// --------------------------------
// 함수명    : db_update_boards_id
// 기능      : boards 레코드 작성
// 파라미터  : PDO    &$conn
//            Array    &$arr_param 쿼리 작성용 배열
// 리턴      : boolean
// 제작      : 20231010 민주
// --------------------------------

function db_update_boards_id(&$conn, &$arr_param) {
    $sql = 
        " UPDATE "
        ."      boards "
        ." SET "
        ."      content = :content "
        ." WHERE "
        ."      id = :id "
        ;

        $arr_ps = [
            ":id" => $arr_param["id"]
            ,":content" => $arr_param["content"]
        ];

        try {
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute($arr_param);
            return $result;

        } catch (Exception $e) {
            echo $e->getMessage(); // Exception 메세지 출력
            return false; // 예외발생 : false
        }
}

//  ---------------------------------------------
//  함수명 db_delete_boards_id
//  기능 : 특정 id의 레코드 삭제처리
//  파라미터 : pdo &$conn
//			&$arr_param 	
//  생성일 : 2023-10-10 홍다윗
// -----------------------------------------------


function db_delete_boards_id(&$conn, &$arr_param) {
	$sql =
	" UPDATE boards"
	." SET "
	." 		del_date = now() "
	." 		,del_flg = '1' "
	." WHERE "
	." 		id = :id "
	;

	$arr_ps = [
		":id" => $arr_param["id"]
	];

	try {
		$stmt = $conn->prepare($sql);
		$result = $stmt->execute($arr_ps);
		return $result;
	} catch (Exception $e) {
		echo $e->getMessage();
		return false;
	} 
}

//  ---------------------------------------------
//  함수명 db_detail_boards_id
//  기능 : 디테일 데이터 조회
//  파라미터 : pdo &$conn
//			&$arr_param 	
//  생성일 : 2023-10-10 김민정
// -----------------------------------------------
function db_select_boards_id( &$conn, &$arr_param) {
    $sql =
    " SELECT "
    ."      chk_flg "
    ."      ,content "
    ."      ,write_date"
    ." FROM "
    ."      boards "
    ." WHERE "
    ."      id = :id "
    ." AND "
    ."      del_flg = '0' "
    ;
    $arr_ps = [
    ":id" => $arr_param["id"]
    ];
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($arr_ps);
        $result = $stmt->fetchAll();
        return $result;
    } catch (Exception $e) {
        echo $e->getMessage(); //예외 메세지 출력
    } 
}


// -------------------------------
// 함수명   : db_update_chk_flg
// 기능     : 수행완료된거 chk_flg 변경
// 파라미터 : PDO       &$conn 
//           Array      &arr_param 쿼리 작성용 배열
// 리턴     : boolean
// 제작     : 20231012 정훈
//-------------------------------

function db_update_chk_flg(&$conn, &$arr_param) {
    $sql =
        " UPDATE "
        ."      boards "
        ." SET "
        ."      chk_date = NOW() "
        // ."      ,chk_flg = '1' " // del 1011 정훈
        ."      ,chk_flg = :chk_flg " // add 1011 정훈
        ." WHERE "
        ."      id = :id "
    ;

    $arr_ps = [
        ":id" => $arr_param["id"]
        ,":chk_flg" =>$arr_param["chk_flg"]
    ];

    try {
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute($arr_ps);
        
        return $result;  // 정상 : 쿼리 결과 리턴
    } catch (Exception $e) {
        echo $e->getMessage(); // Exception 메세지 출력
        return false; // 예외발생 : false 리턴
    }
}


// -------------------------------
// 함수명   : db_select_boards_stats
// 기능     : boards stats count %
// 파라미터 : PDO  &$conn
//           Array      &arr_param 쿼리 작성용 배열
// 리턴     : int / false
// 제작     : 20231012 정훈
// -------------------------------

function db_select_boards_stats( &$conn, &$arr_param){
    $sql =
    " SELECT "
	."        ROUND( "
    ."            ( "
    ."                (SELECT COUNT(id) "
    ."                    FROM "
    ."                        boards "
    ."                    WHERE "
    ."                        write_date <= NOW() "
    ."                    AND "
    ."                        write_date >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 ".$arr_param["dat"]." ), '%Y%m%d000000') "
    ."                    AND "
    ."                        del_flg = '0' "
    ."                    AND "
    ."                        chk_flg = '1' "
    ."                ) "
	."                / "
    ."                (SELECT COUNT(id) "
    ."                    FROM "
    ."                        boards "
    ."                    WHERE "
    ."                        write_date <= NOW() "
    ."                    AND "
    ."                        write_date >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 ".$arr_param["dat"]." ), '%Y%m%d000000') "
    ."                    AND "
    ."                        del_flg = '0' "
    ."                    ) "
	."	        ) * 100 " 
    ."        ) AS per "
    ;
    
    $arr_ps = [];

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($arr_ps);
        $result = $stmt->fetchAll();
        return (int)$result[0]["per"]; // 정상 : 쿼리 결과 리턴
    } catch (Exception $e) {
        echo $e->getMessage(); // Exception 메세지 출력
        return false; // 예외 발생 : false 리턴
    }
}
// -------------------------------
// 함수명   : db_select_search_boards_stats
// 기능     : boards search stats count %
// 파라미터 : PDO  &$conn
//           Array      &arr_param 쿼리 작성용 배열
// 리턴     : int / false
// 제작     : 20231012 정훈
// -------------------------------

function db_select_search_boards_stats( &$conn, &$arr_param){
    $sql =
    " SELECT "
	."        ROUND( "
    ."            ( "
    ."                (SELECT COUNT(id) "
    ."                    FROM "
    ."                        boards "
    ."                    WHERE "
    ."                        write_date < :date_2 "
    ."                    AND "
    ."                        write_date >= :date_1 "
    ."                    AND "
    ."                        del_flg = '0' "
    ."                    AND "
    ."                        chk_flg = '1' "
    ."                ) "
	."                / "
    ."                (SELECT COUNT(id) "
    ."                    FROM "
    ."                        boards "
    ."                    WHERE "
    ."                        write_date < :date_2_1 "
    ."                    AND "
    ."                        write_date >= :date_1_1 "
    ."                    AND "
    ."                        del_flg = '0' "
    ."                    ) "
	."	        ) * 100 " 
    ."        ) AS per "
    ;
    
    $arr_ps = [
        ":date_1" => $arr_param["date_1"]
        ,":date_1_1" => $arr_param["date_1"]
        ,":date_2" => $arr_param["date_2"]
        ,":date_2_1" => $arr_param["date_2"]
    ];

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($arr_ps);
        $result = $stmt->fetchAll();
        return (int)$result[0]["per"]; // 정상 : 쿼리 결과 리턴
    } catch (Exception $e) {
        echo $e->getMessage(); // Exception 메세지 출력
        return false; // 예외 발생 : false 리턴
    }
}


// -------------------------------
// 함수명   : db_select_search_boards_stats_cnt
// 기능     : boards stats count 
// 파라미터 : PDO  &$conn
//           Array      &arr_param 쿼리 작성용 배열
// 리턴     : int / false
// 제작     : 20231013 정훈
// -------------------------------

function db_select_search_boards_stats_cnt( &$conn, &$arr_param){
    $sql =
    " SELECT "
    ."    COUNT(id) as cnt "
    ." FROM "
    ."     boards "
    ." WHERE "
    ."     write_date <= NOW() "
    ." AND "
    ."     write_date >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 ".$arr_param["dat"]." ), '%Y%m%d000000') "
    ." AND "
    ."     del_flg = '0' "
    ;

    $arr_ps = [];

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($arr_ps);
        $result = $stmt->fetchAll();
        return (int)$result[0]["cnt"]; // 정상 : 쿼리 결과 리턴
    } catch (Exception $e) {
        echo $e->getMessage(); // Exception 메세지 출력
        return false; // 예외 발생 : false 리턴
    }
}

// -------------------------------
// 함수명   : db_select_search_boards_clear_stats_cnt
// 기능     : boards clear stats count 
// 파라미터 : PDO  &$conn
//           Array      &arr_param 쿼리 작성용 배열
// 리턴     : int / false
// 제작     : 20231013 정훈
// -------------------------------

function db_select_search_boards_clear_stats_cnt( &$conn, &$arr_param){
    $sql =
    " SELECT "
    ."    COUNT(id) as cnt "
    ." FROM "
    ."     boards "
    ." WHERE "
    ."     write_date <= NOW() "
    ." AND "
    ."     write_date >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 ".$arr_param["dat"]." ), '%Y%m%d000000') "
    ." AND "
    ."     del_flg = '0' "
    ." AND "
    ."     chk_flg = '1' "
    ;

    $arr_ps = [];

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($arr_ps);
        $result = $stmt->fetchAll();
        return (int)$result[0]["cnt"]; // 정상 : 쿼리 결과 리턴
    } catch (Exception $e) {
        echo $e->getMessage(); // Exception 메세지 출력
        return false; // 예외 발생 : false 리턴
    }
}




// -------------------------------
// 함수명   : db_select_search_boards_pickstats_cnt
// 기능     : boards pickstats count 
// 파라미터 : PDO  &$conn
//           Array      &arr_param 쿼리 작성용 배열
// 리턴     : int / false
// 제작     : 20231013 정훈
// -------------------------------

function db_select_search_boards_pickstats_cnt( &$conn, &$arr_param){
    $sql =
    " SELECT "
    ."    COUNT(id) as pickcnt "
    ." FROM "
    ."      boards "
    ." WHERE "
    ."      write_date < :date_2 "
    ." AND "
    ."      write_date >= :date_1 "
    ." AND "
    ."      del_flg = '0' "
    ;

    $arr_ps = [
        ":date_1" => $arr_param["date_1"]
        ,":date_2" => $arr_param["date_2"]
    ];

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($arr_ps);
        $result = $stmt->fetchAll();
        return (int)$result[0]["pickcnt"]; // 정상 : 쿼리 결과 리턴
    } catch (Exception $e) {
        echo $e->getMessage(); // Exception 메세지 출력
        return false; // 예외 발생 : false 리턴
    }
}


// -------------------------------
// 함수명   : db_select_search_boards_clear_pickstats_cnt
// 기능     : boards clear pickstats count 
// 파라미터 : PDO  &$conn
//           Array      &arr_param 쿼리 작성용 배열
// 리턴     : int / false
// 제작     : 20231013 정훈
// -------------------------------

function db_select_search_boards_clear_pickstats_cnt( &$conn, &$arr_param){
    $sql =
    " SELECT "
    ."    COUNT(id) as pickcnt "
    ." FROM "
    ."      boards "
    ." WHERE "
    ."      write_date < :date_2 "
    ." AND "
    ."      write_date >= :date_1 "
    ." AND "
    ."      del_flg = '0' "
    ." AND "
    ."     chk_flg = '1' "
    ;
    $arr_ps = [
        ":date_1" => $arr_param["date_1"]
        ,":date_2" => $arr_param["date_2"]
    ];

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($arr_ps);
        $result = $stmt->fetchAll();
        return (int)$result[0]["pickcnt"]; // 정상 : 쿼리 결과 리턴
    } catch (Exception $e) {
        echo $e->getMessage(); // Exception 메세지 출력
        return false; // 예외 발생 : false 리턴
    }
}


// -------------------------------
// 함수명   : db_search_boards_content
// 기능     : search_boards_content
// 파라미터 : PDO       &$conn &$arr_apram
//           Array      &arr_param 쿼리 작성용 배열
// 리턴     : array / false
// 제작     : 20231013 민주,다윗
// -------------------------------

function db_search_boards_content(&$conn, &$arr_param)
{
    $sql =
    " SELECT "
    . "     content "
    . "     ,write_date "
    . "     ,chk_flg "
    . " FROM "
    . "     boards "
    . " WHERE "
    . "     content "
    . " LIKE "
    . " :content "
    . " AND "
    . "      del_flg = '0' "
    ." ORDER BY "
    ."      id DESC "
    ." LIMIT :list_cnt " 
    ." OFFSET :offset ";

    $arr_ps = [
        "content"  => $arr_param["content"],
        ":list_cnt" => $arr_param["list_cnt"],
        ":offset" => $arr_param["offset"]
    ];
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($arr_ps);
        $result = $stmt->fetchAll();
        return $result; // 정상 : 쿼리 결과 리턴
    } catch (Exception $e) {
        echo $e->getMessage(); // Exception 메세지 출력
        return false;
    }
}

// -------------------------------
// 함수명   : db_search_boards_cnt
// 기능     : 검색한 보드 카운트
// 파라미터 : PDO       &$conn
//           Array      &$arr_param
// 리턴     : int / false
// 제작     : 20231013 민주,다윗
// -------------------------------

function db_search_content_boards_cnt(&$conn, &$arr_param){
    $sql =
        " SELECT "
        . "      count(id) as cnt "
        . " FROM "
        . "      boards "
        . " WHERE "
        . "     content "
        . " LIKE "
        . " :content "
        . " AND "
        . "      del_flg = '0' "
        ;

        $arr_ps = [
            ":content"  => $arr_param["content"]
        ];

        
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($arr_ps);
        $result = $stmt->fetchAll();
        return (int)$result[0]["cnt"]; // 정상 : 쿼리 결과 리턴
    } catch (Exception $e) {
        echo $e->getMessage(); // Exception 메세지 출력
        return false; // 예외 발생 : false 리턴
    }
}









?>