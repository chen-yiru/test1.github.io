<?php
date_default_timezone_set('Asia/Taipei');
$car = $_POST["vehicle"];
$datetime = $_POST["date"];
$users = $_POST["name"];
$returned_datetime = $_POST["returned_date"];

require_once 'sql.php';

// 取得按下按鈕時的本機時間
$local_time = date("Y-m-d H:i:00");

// 檢查是否有傳遞 cancel_id 參數，代表使用者按下了取消預約按鈕
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['return_id'])) {
    $reservation_id = $_POST['return_id'];

    // 取得按下按鈕時的本機時間
    $local_time = date("Y-m-d H:i:00");

    // 更新'user'列表中的'returned_datetime'欄位
    $update_query = "UPDATE `users` SET `returned_datetime` = '$local_time' WHERE `id` = '$reservation_id'";
    mysqli_query($link, $update_query);

    // 從'users'資料表中查詢預約詳細資料
    $fetch_query = "SELECT * FROM `users` WHERE `id` = '$reservation_id'";
    $result = mysqli_query($link, $fetch_query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $reservation_data = mysqli_fetch_assoc($result);

        // 將預約詳細資料插入到'returned'資料表中
        $returned_query = "INSERT INTO `returned` (`datetime`, `user`, `car`, `returned_datetime`)
                            VALUES ('{$reservation_data['datetime']}', '{$reservation_data['user']}',
                                    '{$reservation_data['car']}', '$local_time')";
        
        if (mysqli_query($link, $returned_query)) {
            // 插入成功
            echo ("歸還成功");
        } else {
            // 插入失敗，顯示錯誤訊息
            echo ("錯誤：" . mysqli_error($link));
        }
        // 從'users'資料表中刪除該預約
        $delete_query = "DELETE FROM `users` WHERE `id` = '$reservation_id'";
        mysqli_query($link, $delete_query);

        // 處理完成後重新導向回主頁面
        header("Location: test.php");
        exit();
    } else {
        // 處理當找不到預約ID的情況
        echo "找不到預約ID！";
    }
    
}
else{
    echo("Error");
}
?>
<meta http-equiv="refresh" content="3,url=test.php">

