<?php
include_once 'check_login.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>飞行力学实验</title>
    <style>
        .main{width: 80%;margin: 0 auto;text-align: center}
        h2{font-size: 20px}
        h2 a{color: navy;text-decoration: none;margin-right:15px}
        h2 a:last-child{margin-right: 0}
        h2 a:hover{color:brown;text-decoration: underline}
        .current{color: brown}
        .red{color:red}
    </style>
</head>
<body>
<div class="main">
    <?php
    include_once 'navigation.php';
    ?>
    <form action="post_sing_up.php" method="post" onsubmit="return check()">
        <table align="center" border="1" style="border-collapse: collapse" cellpadding="10" cellspacing="0">
            <tr>
                <td align="right">姓名</td>
                <td align="left"><input name="StudentNM"><span class = "red" >*</span></td>
            </tr>
            <tr>
                <td align="right">学号</td>
                <td  align="left"><input name="StudentID" type="password"><span class = "red" >*</span></td>
            </tr>
            <tr>
                <td align="right">确认学号</td>
                <td  align="left"><input name="CStudentID" type="password"><span class = "red" >*</span></td>
            </tr>
            <tr>
                <td align="right">联系电话</td>
                <td  align="left"><input name="PhoneNB"><span class = "red" >*</span></td>
            </tr>
            <tr>
                <td align="right"><input type="reset" value="重置"></td>
                <td  align="left"><input type="submit" value="注册"></td>
            </tr>
        </table>
    </form>
</div>
<script>
    function check()
    {
        let StudentNM = document.getElementsByName('StudentNM')[0].value.trim();
        let StudentID = document.getElementsByName('StudentID')[0].value.trim();
        let CStudentID = document.getElementsByName('CStudentID')[0].value.trim();
        let PhoneNB = document.getElementsByName('PhoneNB')[0].value.trim();
        //姓名验证
        let StudentNMReg = /^[\u4e00-\u9fa5]{2,10}$/;
        if(!StudentNMReg.test(StudentNM))
        {
            alert('姓名必须填写，且只能为本人姓名否则做完实验没有记录');
            return false;
        }
        let StudentIDReg = /^[a-zA-Z0-9]{6,15}$/;
        if(!StudentIDReg.test(StudentID))
        {
            alert('学号必须填写，且只能为本人学号否则做完实验没有记录');
            return false;
        }
        else
        {
            if(StudentID!=CStudentID)
            {
                alert('学号和确认学号必须相同');
                return false;
            }
        }
        let PhoneNBReg = /^1[3-9]\d{9}$/;
        if(PhoneNB.length>0)
        {
            if(!PhoneNBReg.test(PhoneNB))
            {
                alert('电话号码格式不正确');
                return false;
            }
        }
    }
</script>
</body>
</html>