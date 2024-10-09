<?php
header("Content-type: text/html; charset=utf-8");
session_start();
$StudentNM = $_SESSION['log_name'];
$StudentID = $_SESSION['log_id'];

if ($_FILES['completeProgram']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'student_complete_programs/';
    $fileName = $StudentNM . '_' . $StudentID . '.zip';
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['completeProgram']['tmp_name'], $filePath)) {
        include_once "connect.php";
        $sql = "UPDATE info SET CompleteProgram='$fileName' WHERE StudentNM='$StudentNM' AND StudentID='$StudentID'";
        if (!mysqli_query($connect, $sql)) {
            die("文件名更新失败: " . mysqli_error($connect));
        }
        include_once "update_score.php";
        updateStudentScore($StudentID, $connect);
        echo "<script>alert('程序上传成功！'); location.href='download.php'</script>";
    } else {
        echo "<script>alert('程序上传失败，请重试！'); history.back();</script>";
    }
} else {
    echo "<script>alert('程序上传失败，请重试！'); history.back();</script>";
}

