<?php
include_once "check_Admin.php";
include_once "connect.php";
include_once "update_score.php";

// 处理表单提交，更新权重
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $model_weight = $_POST["model_weight"];
    $report_weight = $_POST["report_weight"];
    $debug_weight = $_POST["debug_weight"];

    // 验证是否为有效数字
    if (!is_numeric($model_weight) || !is_numeric($report_weight) || !is_numeric($debug_weight)) {
        echo "请输入有效的数字。";
    } else {
        // 强制转换为浮点数
        $model_weight = (float)$model_weight;
        $report_weight = (float)$report_weight;
        $debug_weight = (float)$debug_weight;

        // 更新权重
        $sql = "UPDATE score_weights SET model_weight = ?, report_weight = ?, debug_weight = ? WHERE id = 1";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, "ddd", $model_weight, $report_weight, $debug_weight);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // 更新每个学生的总成绩
        $sql = "SELECT * FROM info";
        $result = mysqli_query($connect, $sql);
        while ($info = mysqli_fetch_array($result)) {
            $student_id = $info['id'];
            // 调用更新成绩的函数
            updateStudentScore($student_id, $connect);
        }
        echo "<script>alert('分数权重已更新，并重新计算了所有学生的总成绩！');location.href='admin.php?id=6'</script>";
    }
}


// 查询当前权重
$sql = "SELECT * FROM score_weights WHERE id = 1";
$result = mysqli_query($connect, $sql);
$weights = mysqli_fetch_array($result);
$model_weight = $weights['model_weight'];
$report_weight = $weights['report_weight'];
$debug_weight = $weights['debug_weight'];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>设置得分比重</title>
    <style>
        .main {
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }

        .form-group {
            margin: 15px 0;
        }

        label {
            display: inline-block;
            width: 200px;
            text-align: left;
        }

        input {
            width: 50px;
            margin-left:-50px;
        }

        button {
            margin-top: 20px;
        }

        .back_button {
            position: absolute;
            top: 20px;
            left: 210px;
        }

        .weights_display {
            margin-top: 20px;
            font-weight: bold;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

    </style>
</head>
<body>
<div class="main">
    <div class="back_button">
        <button onclick="window.history.back()">返回上一页</button>
    </div>
    <h2>设置得分比重</h2>
    <!-- 显示当前的得分权重 -->
    <div class="weights_display">
        <span>当前得分权重:</span>
        <span>模型: <?php echo $model_weight; ?></span>
        <span>报告: <?php echo $report_weight; ?></span>
        <span>调试: <?php echo $debug_weight; ?></span>
    </div>
    <form method="post" action="manage_scores.php">
        <div class="form-group">
            <label for="model_weight">设置模型得分权重:</label>
            <input type="number" step="0.01" id="model_weight" name="model_weight" " required>
        </div>

        <div class="form-group">
            <label for="report_weight">设置报告得分权重:</label>
            <input type="number" step="0.01" id="report_weight" name="report_weight" " required>
        </div>

        <div class="form-group">
            <label for="debug_weight">设置调试得分权重:</label>
            <input type="number" step="0.01" id="debug_weight" name="debug_weight" " required>
        </div>

        <button type="submit">保存并更新成绩</button>
    </form>
</div>
</body>
</html>
