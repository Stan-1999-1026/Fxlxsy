<?php
// 设置本页面字符编码
header("Content-type: text/html; charset=utf-8");

// 获取前端表单数据
$StudentNM = trim($_POST['StudentNM']);
$StudentID = trim($_POST['StudentID']);
$CStudentID = trim($_POST['CStudentID']);
$PhoneNB = $_POST['PhoneNB'];

// 连接数据库
include_once "connect.php";

// 校验姓名和学号是否为空
if (!strlen($StudentNM) || !strlen($StudentID))
{
    echo "<script>alert('请填写姓名和学号'); history.back()</script>";
    exit; // 终止程序
}

// 校验学号和确认学号是否相同
if ($StudentID !== $CStudentID)
{
    echo "<script>alert('学号和确认学号不相同'); history.back()</script>";
    exit; // 终止程序
}
else
{
    if (!preg_match("/^[a-zA-Z0-9_*]{6,15}$/", $StudentID)) {
        echo "<script>alert('学号必须填写，且只能为本人学号否则做完实验没有记录'); history.back()</script>";
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

// 判断姓名和学号组合是否存在
$sql = "SELECT * FROM info WHERE StudentNM = '$StudentNM' AND StudentID = '$StudentID'";
$result = mysqli_query($connect, $sql); // 返回一个记录集
$number = mysqli_num_rows($result);
if ($number > 0)
{
    echo "<script>alert('此姓名和学号已被注册，请重新注册'); history.back()</script>";
    exit; // 终止程序
}

// 插入新记录
$sql = "INSERT INTO info (StudentNM,StudentID,PhoneNB) values ('$StudentNM','$StudentID','$PhoneNB')";
$result = mysqli_query($connect, $sql);
if ($result)
{
    echo "<script>alert('注册成功!'); location.href = 'login.php?id=3'</script>";
}
else
{
    echo "<script>alert('注册失败!'); history.back()</script>";
}

