<?php
include_once 'check_Admin.php';
$action = $_GET['action'];
$id = $_GET['id'];
if(is_numeric($action) && is_numeric($id)){
  if($action == 1 || $action == 0){
      //说明要设置或取消管理员
      $sql = "update info set Admin = $action where id = $id";
  }
  else{
      echo "<script>alert('参数错误！') ;history.back()</script>";
      exit;
  }
  include_once 'connect.php';
  $result = mysqli_query($connect, $sql);
  if($action){
      $msg = '设置管理员';
  }
  else{
      $msg = '取消管理员';
  }
  if($result){
      echo"<script>alert('{$msg}成功！');location.href = 'admin.php';</script>";
  }
  else{
      echo"<script>alert('{$msg}失败！');history.back();</script>";
  }
}
else{
    //说明action和（或）id不是数字
    echo "<script>alert('参数错误！') ;history.back()</script>";
}
