<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/TODOLIST/src/");
define("FILE_HEADER", ROOT."header.php");
require_once(ROOT."lib/lib_db.php");


// try {

//     $conn = null;
//     if(!my_db_conn($conn)){
//         throw new Exception("DB Error : PDO instance");
//     }
//     $http_method = $_SETVER["REQUEST_METHOD"];
    
//     if($http_method === "GET"){
//         $id = isset($_GET["id"]) ? $_GET["id"] : "";
//         $arr_err_msg = [];
//         if($id === "") {
//             $arr_err_msg[] = "Paramiter Error : ID";
//         }
//         if(count($arr_err_msg) >= 1) {
//             throw new Exception(implode("<br>",$arr_err_msg));
//         }
//         $arr_param = [
//             "id" => $id
//         ];
//         $result = 
//     }
// }

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <link rel="stylesheet" href="/TODOLIST/src/css/style.css">
    <title>삭제페이지</title>
  
</head>
<body>
   
    <?php
         require_once(FILE_HEADER);
    ?>  
    <main>
        <table  style="text-align: center;" class="delete_table">
            <img src="/TODOLIST/src/img/delete_box.png" alt="delete" class="delete_img">
            <caption class="delete_caption" style="color:black"> 
                <p class="delete_p"style="color:red">- Warning -</p>
                <br>
                <br>
                한번 삭제한 리스트는 복구가 불가능 합니다.
                <br>
                <br>
                그래도 하시겠습니까?
                <br>
                <br>
            </caption>
            <tr>
               <td>자기전에 발 닦고 자기</td>
            </tr>
        
        </table>
    </main>
    <section class="delete_section">
        <form action="">
           
            <input type="hidden" name="" value="">
            <img src="/TODOLIST/src/img/delete_chk2.png" class="delete_btn_img"> 
            <button class="delete_btn" type="submit" value="">
            <span class="delete_span">확인</span>
            </button>
            <img src="/TODOLIST/src/img/delete_cancel2.png"  class="delete_btn_img2" alt="">
            <a class="delete_a" href=""><span class="delete_sapn2">취소</span></a>
        </form>
    </section>
</body>
</html>

<?php 
// echo $item["content"]; 
?>