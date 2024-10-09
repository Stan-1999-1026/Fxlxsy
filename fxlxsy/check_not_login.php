<?php
session_start();
if(!isset($_SESSION['log_name']) || !$_SESSION['log_name']){
    echo"<script>alert('请先登录！');location.href='login.php?id=3'</script>";
    exit;
}
