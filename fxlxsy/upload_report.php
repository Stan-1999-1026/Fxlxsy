<?php
header("Content-type: text/html; charset=utf-8");
session_start();
$StudentNM = $_SESSION['log_name'];
$StudentID = $_SESSION['log_id'];

if ($_FILES['report']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'student_reports/';
    $fileName = $StudentNM . '_' . $StudentID . '.docx';
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['report']['tmp_name'], $filePath)) {
        include_once "connect.php";
        $sql = "UPDATE info SET Report='$fileName' WHERE StudentNM='$StudentNM' AND StudentID='$StudentID'";
        mysqli_query($connect, $sql);

        include_once "update_score.php";
        updateStudentScore($StudentID, $connect);
        echo "<script>alert('报告提交成功！'); location.href='download.php'</script>";
    } else {
        echo "<script>alert('报告提交失败，请重试！'); history.back();</script>";
    }
} else {
    echo "<script>alert('报告提交失败，请重试！'); history.back();</script>";
}