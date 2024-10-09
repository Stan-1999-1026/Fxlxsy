<?php
// 设置本页面字符编码
header("Content-type: text/html; charset=utf-8");

// 获取前端表单数据
$StudentNM = trim($_POST['StudentNM']);
$StudentID = trim($_POST['StudentID']);
$CStudentID = trim($_POST['CStudentID']);
$PhoneNB = $_POST['PhoneNB'];

//判断学号是否为空
if (!empty($StudentID))
{
    if(!preg_match("/^[a-zA-Z0-9_*]{6,15}$/", $StudentID))
    {
        echo "<script>alert('学号必须填写，且只能为本人学号否则做完实验没有记录'); history.back()</script>";
        exit; // 终止程序

    }
    // 校验学号和确认学号是否相同
    if ($StudentID !== $CStudentID)
    {
        echo "<script>alert('学号和确认学号不相同'); history.back()</script>";
        exit; // 终止程序
    }
}

// 校验电话号码格式
if (!empty($PhoneNB))
{
    if (!preg_match("/^1[3-9]\d{9}$/", $PhoneNB))
    {
        echo "<script>alert('电话号码格式不正确'); history.back()</script>";
        exit; // 终止程序
    }
}

// 连接数据库
include_once "connect.php";
// 构建更新 SQL 语句
$sql = "UPDATE info SET ";
$updateFields = [];
$url = '';// 初始化跳转 URL

if ($StudentID)
{
    $updateFields[] = "StudentID = '$StudentID'";
    $url = 'logout.php'; // 只要更新了 StudentID 就跳转到 logout.php
}
if ($PhoneNB)
{
    $updateFields[] = "PhoneNB = '$PhoneNB'";
    // 如果没有更新 StudentID，则跳转到 index.php
if (empty($url))
{
    $url = 'index.php';
}
}
if (count($updateFields) > 0)
{
    $sql .= implode(", ", $updateFields) . " WHERE StudentNM = '$StudentNM'";
    // 执行 SQL 语句
    $result = mysqli_query($connect, $sql);
if ($result)
{
    echo "<script>alert('个人资料修改成功!'); location.href = '$url';</script>";
}
else
{
    echo "<script>alert('个人资料修改失败!'); history.back();</script>";
}
}
else
{
    // 如果没有填写任何需要更新的字段
echo "<script>alert('请至少填写一个要更新的字段！'); history.back();</script>";
}




