<?php
header("Content-type: text/html; charset=utf-8");
session_start();

$StudentNM = $_SESSION['log_name'];
$StudentID = $_SESSION['log_id'];

if ($_FILES['incompleteProgram']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'student_incomplete_programs/';
    $fileName = $StudentNM . '_' . $StudentID . '.zip';
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['incompleteProgram']['tmp_name'], $filePath)) {
        include_once "connect.php";
        $sql = "UPDATE info SET incompleteProgram='$fileName' WHERE StudentNM='$StudentNM' AND StudentID='$StudentID'";
        if (mysqli_query($connect, $sql)) {
            echo "<script>alert('文件上传成功！'); location.href='download.php'</script>";
        } else {
            echo "更新记录出错: " . mysqli_error($connect);
        }
    } else {
        echo "<script>alert('文件上传失败，请重试！'); history.back();</script>";
    }
} else {
    echo "<script>alert('文件上传失败，请重试！'); history.back();</script>";
}

