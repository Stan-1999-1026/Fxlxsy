<?php
header("Content-type: text/html; charset=utf-8");
session_start();

$StudentNM = trim($_POST['StudentNM']);
$StudentID = trim($_POST['StudentID']);
$PhoneNB = $_POST['PhoneNB'];
$clientIP = $_SERVER['REMOTE_ADDR']; // 获取客户端 IP

if (!strlen($StudentNM) || !strlen($StudentID)) {
    echo "<script>alert('请填写姓名和学号！'); history.back()</script>";
    exit;
}

include_once "connect.php";

// 查询用户信息
$sql = "SELECT * FROM info WHERE StudentNM = '$StudentNM' AND StudentID = '$StudentID'";
$result = mysqli_query($connect, $sql);
$number = mysqli_num_rows($result);

if ($number) {
    $row = mysqli_fetch_assoc($result);

    // 判断是否为管理员
    if ($row['Admin']) {
        $_SESSION['log_name'] = $StudentNM;
        $_SESSION['log_id'] = $StudentID;
        $_SESSION['PhoneNB'] = $PhoneNB;
        $_SESSION['is_Admin'] = 1;

        echo "<script>alert('欢迎管理员登录!'); location.href = 'admin.php?id=6'</script>";
    } else {
        // 处理非管理员用户，检查是否首次登录
        if (!$row['ModelFile']) {
            // 首次登录时没有分配模型，分配一个模型
            $modelDirectory = 'D:/fxlxsy/models'; // models 文件夹的路径
            $modelFiles = array_diff(scandir($modelDirectory), array('.', '..')); // 过滤掉 '.' 和 '..'

            // 只选择 .zip 文件
            $models = [];
            foreach ($modelFiles as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) == 'zip') {
                    $models[] = $file; // 将压缩包文件添加到模型数组
                }
            }

            // 检测 models 目录中是否有模型文件
            if (count($models) > 0) {
                // 从模型压缩包中随机分配一个
                $randomModel = $models[array_rand($models)];
                $modelFile = $randomModel;

                // 更新数据库，保存分配的模型
                $updateSql = "UPDATE info SET ModelFile = '$randomModel' WHERE StudentNM = '$StudentNM' AND StudentID = '$StudentID'";
                mysqli_query($connect, $updateSql);
            } else {
                echo "<script>alert('没有可用的模型文件！'); history.back()</script>";
                exit;
            }
        } else {
            // 非首次登录，使用已有模型
            $modelFile = $row['ModelFile'];
        }

        // 保存登录信息到 Session
        $_SESSION['log_name'] = $StudentNM;
        $_SESSION['log_id'] = $StudentID;
        $_SESSION['modelFile'] = $modelFile;
        $_SESSION['PhoneNB'] = $PhoneNB;
        $_SESSION['is_Admin'] = 0;

        echo "<script>alert('登录成功!'); location.href ='download.php?id=4'</script>";
    }
} else {
    echo "<script>alert('登录失败!请检查学号和姓名是否正确！'); history.back()</script>";
}

