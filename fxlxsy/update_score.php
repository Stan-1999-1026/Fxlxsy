    <?php
    include_once "connect.php";
    function updateStudentScore($student_id, $connect) {
        // 获取当前权重
        $sql = "SELECT * FROM score_weights WHERE id = 1";
        $result = mysqli_query($connect, $sql);
        if (!$result) {
            die("获取权重失败: " . mysqli_error($connect));
        }
        $weights = mysqli_fetch_array($result);
        $model_weight = $weights['model_weight'];
        $report_weight = $weights['report_weight'];
        $debug_weight = $weights['debug_weight'];

        // 获取该学生的信息
        $sql = "SELECT * FROM info WHERE StudentID = '$student_id'";
        $result = mysqli_query($connect, $sql);
        if (!$result) {
            die("查询学生信息失败: " . mysqli_error($connect));
        }
        $info = mysqli_fetch_array($result);

        if (!$info) {
            die("学生信息查询失败或找不到学生信息");
        }

        // 计算新的成绩
        $model_score = !empty($info['CompleteProgram']) ? 100 : 0;
        $report_score = !empty($info['Report']) ? 100 : 0;
        $debug_score = !empty($info['DebugScore']) ? $info['DebugScore'] : 0;

        // 计算总成绩
        $total_score = $model_weight * $model_score + $report_weight * $report_score + $debug_weight * $debug_score;

        // 更新总成绩
        $sql = "UPDATE info SET TotalScore=$total_score WHERE StudentID='$student_id'";
        if (!mysqli_query($connect, $sql)) {
            die("更新总成绩失败: " . mysqli_error($connect));
        }
    }