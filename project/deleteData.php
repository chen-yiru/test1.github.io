<?php
$car = $_POST["vehicle"];
$datetime = $_POST["date"];
$users = $_POST["name"];
$returned_datetime = $_POST["returned_date"];

require_once 'sql.php';


// 檢查是否有傳遞 cancel_id 參數，代表使用者按下了取消預約按鈕
if (isset($_POST["cancel_id"])) {
    $id = $_POST["cancel_id"];

    // 刪除該 id 對應的預約資料
    $delete_sql = "DELETE FROM `users` WHERE `id` = $id;";
    if (mysqli_query($link, $delete_sql)) {
        echo "預約已取消。";
    } else {
        echo "取消預約失敗：" . mysqli_error($link);
    }

    // 關閉資料庫連線
    mysqli_close($link);
}
?>

<meta http-equiv="refresh" content="3,url=test.php">

