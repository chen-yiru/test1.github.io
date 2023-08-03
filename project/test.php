<!DOCTYPE html>
<html>

<head>
    <title>車輛預約系統</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
        }

        h2 {
            margin-top: 30px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="submit"] {
            margin-top: 10px;
        }

        .booking {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }

        .booking button {
            margin-left: 10px;
        }

        #returnInfo {
            margin-top: 20px;
            font-weight: bold;
        }

        .returned-booking {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #5cb85c;
            /* 使用綠色的邊框顏色表示已歸還車輛 */
            background-color: #dff0d8;
            /* 使用淡綠色的背景顏色表示已歸還車輛 */
        }
    </style>
</head>

<body>
    <?php
    require_once 'sql.php';
    ?>

    <h1>車輛預約系統</h1>

    <!-- 第一個區塊：車輛預約表單 -->
    <h2>預約車輛</h2>
    <form method="post" action="insert.php">
        <label for="vehicle">車輛：</label>
        <select name="vehicle" id="vehicle">
            <option value="MLK-6577">MLK-6577</option>
            <option value="BEW-2912">BEW-2912</option>
            <option value="2371-HN">2371-HN</option>
            <!-- 其他車輛選項 -->
        </select>
        <br>
        <label for="date">預約日期：</label>
        <input type="datetime-local" name="date" id="date" required step="60">
        <br>
        <label for="returned_date">預計歸還時間：</label>
        <input type="datetime-local" name="returned_date" id="returned_date" step="60">
        <br>
        <label for="name">預約人：</label>
        <input type="text" name="name" id="name">
        <br>
        <input type="submit" value="預約">
    </form>


    
    <!-- 第二個區塊：已預約車輛訊息 -->
    <h2>已預約車輛</h2>

    <div id="bookingContainer">
        <?php
        $sql = "SELECT `id`, `datetime`, `user`, `car`, `returned_datetime` FROM `users` ORDER BY `datetime` ASC;";
        $result = mysqli_query($link, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                
        ?>
        
                <div class="booking">
                    預約日期：<?php echo $row['datetime']; ?>，預計歸還日期：<?php echo $row['returned_datetime']; ?>，使用者：<?php echo $row['user']; ?>，車輛：<?php echo $row['car']; ?>
                    <br />

                    <!-- 新增取消預約按鈕和歸還車輛按鈕 -->

                    <form method="post" action="returned.php">
                        <input type="hidden" name="return_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" onclick="return showReturnConfirmation()">歸還車輛</button>
                    </form>
                    <form method="post" action="deleteData.php">
                        <input type="hidden" name="cancel_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" onclick="return showConfirmation()">取消預約</button>
                    </form>
                </div>
        <?php
            }
            mysqli_free_result($result);
        } else {
            echo "目前沒有已預約的車輛。";
        }
        ?>
    </div>




    <!-- 第三個區塊：已歸還車輛資訊 -->
<h2>已歸還車輛</h2>
<div id="returnedContainer">
    <?php
    // Modify the SELECT query to fetch data from 'returned' table and order by 'datetime' column
    $sql2 = "SELECT `id`, `datetime`, `user`, `car`, `returned_datetime` FROM `returned` ORDER BY `datetime` ASC;";
    $result2 = mysqli_query($link, $sql2);

    if ($result2 && mysqli_num_rows($result2) > 0) {
        while ($row = mysqli_fetch_assoc($result2)) {
            ?>
            <div class="booking">
                預約日期：<?php echo $row['datetime']; ?>，歸還日期：<?php echo $row['returned_datetime']; ?>，使用者：<?php echo $row['user']; ?>，車輛：<?php echo $row['car']; ?>
                <br />
            </div>
            <?php
        }
        mysqli_free_result($result2);
    } else {
        echo "目前没有已歸還的車輛。";
    }
    ?>
</div>

    <script>
        function showConfirmation() {
            // 使用 confirm 函式顯示彈跳視窗，並等待使用者選擇
            var confirmed = confirm("確定要取消預約嗎？");

            // 如果使用者點擊了 "確定"，則返回 true，提交表單
            // 否則返回 false，取消表單提交
            return confirmed;
        }

        function showReturnConfirmation() {
            // 使用 confirm 函式顯示彈跳視窗，並等待使用者選擇
            var confirmed = confirm("確定要歸還車輛嗎？");

            // 如果使用者點擊了 "確定"，則返回 true，提交表單
            // 否則返回 false，取消表單提交
            return confirmed;
        }
    </script>


</body>

</html>

