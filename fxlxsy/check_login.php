<?php
session_start();
if(isset($_SESSION['log_name']) || $_SESSION['log_name']){
    echo"<script>alert('请先注销登录！');history.back()</script>";
    exit;
}
