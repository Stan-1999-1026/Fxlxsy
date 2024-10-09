<?php
include_once "check_Admin.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['models'])) {
        // 文件上传处理
        $uploadDir = 'models/';
        foreach ($_FILES['models']['name'] as $key => $name) {
            if ($_FILES['models']['error'][$key] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['models']['tmp_name'][$key];
                $filePath = $uploadDir. basename($name);
                move_uploaded_file($tmpName, $filePath);
            }
        }
    } elseif (isset($_POST['delete_files'])) {
        // 文件删除处理
        $filesToDelete = $_POST['delete_files'];
        foreach ($filesToDelete as $file) {
            $filePath = 'models/'. $file;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }
}

// 获取 models 文件夹中的所有文件
$files = array_diff(scandir('models'), ['.', '..']);

// 按文件名排序
natsort($files);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>设置实验项目</title>
    <style>
        .main {
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }

        .file-list {
            text-align: left;
            margin: 20px 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        .file-list label {
            display: inline-block;
            width: 130px; /* 控制每个文件复选框区域的宽度 */
            margin: 5px;
        }

        .action-buttons {
            margin-top: 20px;
        }

        .back_button {
            position: absolute;
            top: 20px;
            left: 210px;
        }
    </style>
    <script>
        function validateUpload() {
            var fileInput = document.querySelector('input[name="models[]"]');
            if (!fileInput.files.length) {
                alert('请选择文件！');
                return false;
            }
            return true;
        }

        function validateDelete() {
            var checkboxes = document.querySelectorAll('.file-list input[type="checkbox"]');
            var checked = false;
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    checked = true;
                    break;
                }
            }
            if (!checked) {
                alert('请选择要删除的文件！');
                return false;
            }
            return true;
        }

        function toggleSelectAll(checkbox) {
            var checkboxes = document.querySelectorAll('.file-list input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = checkbox.checked;
            }
        }

        function toggleAll() {
            var checkboxes = document.querySelectorAll('.file-list input[type="checkbox"]');
            var allChecked = true;
            for (var i = 0; i < checkboxes.length; i++) {
                if (!checkboxes[i].checked) {
                    allChecked = false;
                    break;
                }
            }
            document.getElementById('selectAllBtn').innerHTML = allChecked ? '取消全选' : '全选';
        }

        function selectOrDeselectAll() {
            var checkboxes = document.querySelectorAll('.file-list input[type="checkbox"]');
            var selectAllBtn = document.getElementById('selectAllBtn');
            var selectAll = (selectAllBtn.innerHTML === '全选');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = selectAll;
            }
            selectAllBtn.innerHTML = selectAll ? '取消全选' : '全选';
        }
    </script>
</head>
<body>
<div class="main">
    <div class="back_button">
        <button onclick="window.history.back()">返回上一页</button>
    </div>
    <h2>上传新的实验项目</h2>
    <form action="manage_models.php" method="post" enctype="multipart/form-data" onsubmit="return validateUpload();">
        <input type="file" name="models[]" multiple>
        <button type="submit">上传</button>
    </form>

    <h2>已上传的实验项目</h2>
    <form action="manage_models.php" method="post" onsubmit="return validateDelete();">
        <div class="file-list">
            <?php
            $files = array_diff(scandir('models'), ['.', '..']);
            natsort($files);
            $index = 0;
            foreach ($files as $file):
                ?>
                <label>
                    <input type="checkbox" name="delete_files[<?php echo $index;?>]" value="<?php echo $file;?>" onclick="toggleAll()">
                    <?php echo $file;?>
                </label>
                <?php
                $index++;
            endforeach; ?>
        </div>

        <div class="action-buttons">
            <button type="button" id="selectAllBtn" onclick="selectOrDeselectAll()">全选</button>
            <button type="submit">删除选中的文件</button>
        </div>
    </form>
</div>

</body>
</html>
