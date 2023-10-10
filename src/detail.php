<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/TODOLIST/src/");
define("FILE_HEADER", ROOT."header.php");
require_once(ROOT."lib/lib_db.php");

$status = isset($_POST["status"]) ? ($_POST["status"] == "on" ? "O" : "X") : "O";

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="/TODOLIST/src/css/style.css">
    <title>상세페이지</title>
</head>
<body>
    <?php require_once(FILE_HEADER); ?>
    
    <div class="detail-container">
        <br>
        <br>
        <br>
        <div class="detail-status-box">
            <p>수행여부: <?php echo $status; ?></p>
        </div>
        <br>
        <div class="detail-content">
            <p>수행한 내용</p>
        </div>
        <br>
        <div class="detail-todolistwrite">
            <p>자기전에 발 닦고 자기</p>
        </div>
        <br>
        <div class="detail-todolistdate">
            <p><?php echo date("Y-m-d"); ?></p>
        </div>
        <br>
        <br>
        <div class="detail-button-container">
            <a href="update.php" class="transparent-button" id="edit-button">수정</a>
            <a href="delete.php" class="transparent-button">삭제</a>
        </div>
    </div>
</body>
</html>
