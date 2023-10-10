<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/TODOLIST/src/");
define("FILE_HEADER", ROOT."header.php");
require_once(ROOT."lib/lib_db.php");


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
            <img src="/TODOLIST/src/img/delete_chk2.png">
            <button type="submit" value="확인"></button>
            
            <a class="delete_a" href=""><img src="" alt=""><img src="/TODOLIST/src/img/delete_cancel2.png" alt="">취소</a>
        </form>
    </section>
</body>
</html>

<?php 
// echo $item["content"]; 
?>