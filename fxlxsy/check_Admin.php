<?php
//首先判断是不是管理员
session_start();
//如果！（存在同时为真），&&：且
//if(!(isset($_SESSION['is_Admin']) && $_SESSION['is_Admin']))
//is_Admin不存在或者存在但值为0
if(!isset($_SESSION['is_Admin']) || !$_SESSION['is_Admin']){
    echo"<script>alert('请以管理员身份登录后访问该页面！');location.href='login.php?id=3'</script>";
    exit;
}
