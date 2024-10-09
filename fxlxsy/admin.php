<?php
include_once "check_Admin.php";
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
        tr:hover{background-color:azure }
        .action_link{
            color: navy;
            text-decoration: none;
            margin-right: 15px;
        }
        .action_link:hover{
            color: brown;
            text-decoration: underline;
        }
        .action_link.gray{
            color: gray;
            cursor: default;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="main">
    <?php
    include_once "navigation.php";
    include_once "connect.php";
    include_once "page.php";
    $sql = "select count(id) as total from info";//使用聚合函数count得到记录总数
    $result = mysqli_query($connect, $sql);
    $info = mysqli_fetch_array($result);
    $total = $info["total"];//得到记录总数
    $per_page = 10;//设置每一页显示多少条数据
    $page = $_GET["page"] ?? 1;//读取当前页码
    //??被称为 “Null 合并运算符”。它用于在左侧操作数为 null 的情况下返回右侧操作数的值，否则返回左侧操作数的值。
    paging($total, $per_page);//引用分页函数
    $sql = "SELECT * FROM info order by id asc limit $firstCount,$per_page";//asc正序，desc倒序
    $result = mysqli_query($connect, $sql);
    ?>
    <h2>
        <a href="manage_models.php">设置实验项目</a>
        <a href="manage_scores.php">设置得分比重</a>
    </h2>
    <table border="1" cellspacing="0" cellpadding="10" style="border-collapse: collapse" align="center" width="100%">
        <tr>
            <td>序号</td>
            <td>姓名</td>
            <td>学号</td>
            <td>电话</td>
            <td>模型</td>
            <td>程序</td>
            <td>报告</td>
            <td>调试得分</td>
            <td>总成绩</td>
            <td>管理员</td>
            <td>操作</td>
        </tr>
        <?php
        $i = ($page - 1) * $per_page + 1;
        while ($info = mysqli_fetch_array($result)) {
            ?>
            <tr>
                <!--echo"$i"每个都是1，echo$i循环一次计数加1-->
                <td><?php echo $i; ?></td>
                <td><?php echo $info['StudentNM']; ?></td>
                <td><?php echo $info['StudentID']; ?></td>
                <td><?php echo $info['PhoneNB']; ?></td>
                <td><?php echo $info['ModelFile']; ?></td>
                <td>
                    <?php
                    if(!empty($info['CompleteProgram'])){
                        echo "<a href = 'student_complete_programs/{$info['CompleteProgram']}' download>{$info['StudentNM']}-{$info['StudentID']}.zip</a>";
                    }
                     ?></td>
                <td><?php
                    if(!empty($info['Report'])){
                        echo "<a href = 'student_reports/{$info['Report']}' download>{$info['StudentNM']}-{$info['StudentID']}.docx</a>";
                    }
                    ?></td>
                <td><?php echo $info['DebugScore']; ?></td>
                <td><?php echo $info['TotalScore']; ?></td>
                <td><?php echo $info['Admin'] ? '是' : '否'; ?></td>
                <td> <?php if($info['StudentNM']<>'admin'){?><a href="javascript:del(<?php echo $info['id']; ?>,'<?php echo $info['StudentNM']; ?>');" class="action_link" >删除用户</a>
                    <?php
                    }
                    else{
                        echo '<span class="action_link gray" >删除用户</span> ';
                    }
                    if ($info['Admin']) {
                        if ($info['StudentNM'] <> 'admin') {
                            //这里的？和=之间不能有空格（set_Admin.php ? action = 0 & id = ）否则会导致传参失败！
                            ?><a href="set_Admin.php?action=0&id=<?php echo $info['id']; ?>" class="action_link"> 取消管理员</a>
                            <?php
                        } else {
                            echo '<span class="action_link gray">取消管理员</span>';
                        }
                    } else {
                        if ($info['StudentNM'] <> 'admin') {
                            ?><a href="set_Admin.php?action=1&id=<?php echo $info['id']; ?>" class="action_link"> 设置管理员</a>
                            <?php
                        } else {
                            echo '<span class="action_link gray7">设置管理员</span>';
                        }
                    }
                    ?></td>
            </tr>
            <?php
            $i++;
        }
        ?>
    </table>
    <?php
    echo $pageNav;
    ?>
</div>
<script>
    function del(id,name){
        if(confirm('确定删除' + name + '?')){
            location.href = 'delete.php?id= ' + id + '&StudentNM=' + name;
        }
    }
</script>
</body>
</html>
