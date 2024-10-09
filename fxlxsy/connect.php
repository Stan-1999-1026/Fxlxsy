<?php
//链接数据库服务器
//第一步，链接数据库服务器
$connect = mysqli_connect("localhost","root","root","student");
if(!$connect)
{
    die("连接数据库服务器失败");
}
//第二步，设置字符集
mysqli_query($connect,"set names utf8");
