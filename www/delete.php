<?php
    include "db_conn.php";

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = intval($_GET['id']);
        $stmt = mysqli_prepare($conn, "DELETE FROM `crud_681310499` WHERE id = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: index.php?msg=" . urlencode("ลบข้อมูลสมาชิกเรียบร้อยแล้ว"));
                exit();
            } else {
                echo "Failed: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Failed: " . mysqli_error($conn);
        }
    } else {
        header("Location: index.php");
        exit();
    }
?>