<?php
$car = $_POST["vehicle"];
$datetime = $_POST["date"];
$users = $_POST["name"];
$returned_datetime = $_POST["returned_date"];
require_once 'sql.php';

/// 檢查是否已經有相同的車輛在預約日期時間範圍內
$sql_check = "SELECT * FROM users WHERE car = '$car' AND ('$datetime' <= returned_datetime) AND ('$returned_datetime' >= datetime)";
$result_check = mysqli_query($link, $sql_check);

if (mysqli_num_rows($result_check) > 0) {
    // 已有相同車輛在預約日期時間範圍內
    echo "該車輛在此日期時間範圍內已被預約，請選擇其他日期時間或車輛。";
} else {
    // 可以進行預約，插入新預約資訊

    // 查詢已有數據中的最大ID值
    $sql_max_id = "SELECT MAX(id) AS max_id FROM users";
    $result_max_id = mysqli_query($link, $sql_max_id);
    $data = mysqli_fetch_assoc($result_max_id);
    $max_id = $data['max_id'];

    // 計算新行ID的值（最大ID值加1）
    $new_id = $max_id + 1;

    // 插入新數據並設置行ID和預計歸還時間
    $sql_insert = "INSERT INTO `users` (`id`, `datetime`, `user`, `car`, `returned_datetime`) VALUES ('$new_id', '$datetime', '$users', '$car', '$returned_datetime')";
    $result_insert = mysqli_query($link, $sql_insert);

    if ($result_insert && mysqli_affected_rows($link) > 0) {
        echo "預約成功";
    } else {
        echo "預約失敗：" . mysqli_error($link);
    }
}

mysqli_close($link);

// 等待3秒後自動刷新頁面
echo '<meta http-equiv="refresh" content="3;url=test.php">';
?>
 

