<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/TODOLIST/src/");
define("FILE_HEADER", ROOT."header.php");
require_once(ROOT."lib/lib_db.php");


try {

    $conn = null;
    if(!my_db_conn($conn)){
        throw new Exception("DB Error : PDO instance");
    }
    $http_method = $_SERVER["REQUEST_METHOD"];
    
    if($http_method === "GET"){
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        $page = isset($_GET["page"]) ? $_GET["page"] : "";
        
      
        $arr_param = [
            "id" => $id
        ];
        $result = db_select_boards_id($conn,$arr_param);

         if($result === false) {
             throw new Exception("DB Error : Select id");
         } else if(!(count($result) === 1)) {
             throw new Exception("DB Error : Select id count");
         }
         $item = $result[0];
         
    } else if($http_method === "POST") {
             $id = isset($_POST["id"]) ? $_POST["id"] : "";

             $conn->beginTransaction();
             $arr_param = [
                 "id" => $id    
                ];
              if(!db_delete_boards_id($conn, $arr_param)) {
                   throw new Exception("DB Error : Delete Boards id");
                 }
               $conn->commit();
               header("Location: list.php");
               exit;
                }
     } catch (Exception $e) {
         if($http_method === "POST") {
             $conn->rollBack();    
     }
         echo $e->getMessage();
         exit; 
     } finally {
         db_destroy_conn($conn);
 }


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
           
            <tr class = "delete_tr">
                <td class = "delete_td"><?php echo $item["content"] ?></td>
            </tr>
            <!-- <a href="" class="delete_content">" 자기전에 발 닦고 자기 "</a> -->
          
          
        </table>
    </main>
    <section class="delete_section">
        <form action="delete.php" method="post">
           
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <img src="/TODOLIST/src/img/delete_chk2.png" class="delete_btn_img"> 
            <button class="delete_btn" type="submit">
            <span class="delete_span">확인</span>
            </button>

        </form>
        
        <img src="/TODOLIST/src/img/delete_cancel2.png"  class="delete_btn_img2" alt="">
            <a class="delete_a" href="/TODOLIST/src/detail.php/?id=<?php echo $id; ?>&page=<?php echo $page; ?> ">
            <span class="delete_span">취소</span>
            </a>
    </section>
</body>
</html>

