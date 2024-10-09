<?php
include_once 'check_Admin.php';
include_once 'connect.php';
$id = $_GET['id'];
$StudentNM = $_GET['StudentNM'];
if(is_numeric($id)){
    $sql = "delete from info where id=$id";
    $result = mysqli_query($connect, $sql);
    if($result){
        echo "<script>alert('删除用户{$StudentNM}成功！');location.href = 'admin.php';</script>";
    }
    else{
        echo "<script>alert('删除用户{$StudentNM}失败！');history.back();</script>";
    }
}
else{
    echo "<script>alert('参数错误！');history.back();</script>";
}