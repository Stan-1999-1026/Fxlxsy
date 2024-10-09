<?php
session_start();
include_once 'check_not_login.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>飞行力学实验</title>
    <style>
        .main {
            width: 80%;
            margin: 0 auto;
            text-align: center
        }

        h2 {
            font-size: 20px
        }

        h2 a {
            color: navy;
            text-decoration: none;
            margin-right: 15px
        }

        h2 a:last-child {
            margin-right: 0
        }

        h2 a:hover {
            color: brown;
            text-decoration: underline
        }

        .current {
            color: brown
        }

        .red {
            color: red
        }

        .center {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="main">
    <?php
    include_once 'navigation.php';
    ?>
    <h2>点击链接下载模型</h2>
    <ul>
        <li>
            <?php
            session_start();
            $modelFile = isset($_SESSION['modelFile']) ? $_SESSION['modelFile'] : '';
            if ($modelFile) {
                echo "<div class='center'><a id='downloadLink' href='models/$modelFile' download>点击下载实验模型(zip)</a></div>";
            } else {
                echo "模型文件未找到！";
            }
            ?>
        </li>
    </ul>
    <h2 style="font-size: smaller; color: red;">
        模型下载后请将文件夹解压并命名为姓名加学号的形式如：李小明+183423020125</h2>

    <!-- 上传未完成程序 -->
    <h2>上传未完成的程序</h2>
    <form action="upload_incomplete.php" method="post" enctype="multipart/form-data">
        <input type="file" name="incompleteProgram" required>
        <input type="submit" value="上传">
    </form>

    <!-- 下载未完成程序 -->
    <h2>下载未完成的程序</h2>
    <?php
    $StudentNM = $_SESSION['log_name'];
    $StudentID = $_SESSION['log_id'];
    $incompleteFileName = $StudentNM . '_' . $StudentID . '.zip';
    ?>
    <a href="student_incomplete_programs/<?php echo $incompleteFileName; ?>" download>下载上次未完成的程序</a>

    <!-- 上传已完成程序 -->
    <h2>提交已完成的程序</h2>
    <form action="upload_complete.php" method="post" enctype="multipart/form-data">
        <input type="file" name="completeProgram" required>
        <input type="submit" value="提交">
    </form>
    <h2>提交实验报告</h2>
    <form action="upload_report.php" method="post" enctype="multipart/form-data">
        <input type="file" name="report" required>
        <input type="submit" value="提交">
    </form>
</div>
</body>
</html>
