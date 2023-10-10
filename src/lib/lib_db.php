<?php


















//  ---------------------------------------------
//  함수명 db_delete_boards_id
//  기능 : 특정 id의 레코드 삭제처리	
//   2023-10-10홍다윗
// -----------------------------------------------


function db_delete_boards_id(&$conn, &$arr_param) {
	$sql =
	" UPDATE boards"
	." SET "
	." 		del_date = now() "
	." 		,delete_flg = '1' "
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


?>
