<style>
    .current { color: brown; }
    .logged { font-size: 16px; color: darkgreen; }
    .logout { margin-left: 20px; margin-bottom: 15px; }
    .logout a { color: cornflowerblue; text-decoration: none; }
    .logout a:hover {color: brown; text-decoration: underline; }
</style>

<h1>飞行力学实验</h1>

<?php
session_start();
if (isset($_SESSION['log_name']) && $_SESSION['log_name'] <> '') {
    ?>
    <div class="logged">
        当前登录者：<?php echo $_SESSION['log_name']; ?>
        <?php if ($_SESSION['is_Admin']) { ?>
            <span style="color:crimson">欢迎管理员登录!</span>
        <?php } ?>
        <span class="logout"><a href="logout.php">注销登录</a></span>
    </div>
    <?php
}
$id = isset($_GET['id']) ? $_GET['id'] : 1;
?>

<h2>
    <a href="index.php?id=1" <?php if ($id == 1) { ?>class="current"<?php } ?>>首页</a>
    <a href="sing_up.php?id=2" <?php if ($id == 2) { ?>class="current"<?php } ?>>注册</a>
    <a href="login.php?id=3" <?php if ($id == 3) { ?>class="current"<?php } ?>>登录</a>
    <a href="download.php?id=4" <?php if ($id == 4) { ?>class="current"<?php } ?>>下载与提交</a>
    <a href="modify.php?id=5" <?php if ($id == 5) { ?>class="current"<?php } ?>>个人资料修改</a>
    <a href="admin.php?id=6" <?php if ($id == 6) { ?>class="current"<?php } ?>>后台管理</a>
</h2>
