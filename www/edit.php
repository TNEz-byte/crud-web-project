<?php
    include "db_conn.php";

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: index.php");
        exit();
    }

    $id = intval($_GET['id']);
    $error_msg = "";

    if (isset($_POST['submit'])) {
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name  = trim($_POST['last_name'] ?? '');
        $email      = trim($_POST['email'] ?? '');
        $gender     = trim($_POST['gender'] ?? '');

        if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($gender)) {
            $stmt = mysqli_prepare($conn, "UPDATE `crud_681310499` SET `first_name`=?, `last_name`=?, `email`=?, `gender`=? WHERE id=?");
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssssi", $first_name, $last_name, $email, $gender, $id);
                if (mysqli_stmt_execute($stmt)) {
                    header("Location: index.php?msg=" . urlencode("อัปเดตข้อมูลเรียบร้อยแล้ว"));
                    exit();
                } else {
                    $error_msg = "เกิดข้อผิดพลาดในการอัปเดต: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            } else {
                $error_msg = "เกิดข้อผิดพลาดกับฐานข้อมูล: " . mysqli_error($conn);
            }
        } else {
            $error_msg = "กรุณากรอกข้อมูลให้ครบถ้วนทุกช่อง และเลือกเพศ";
        }
    }

    // Fetch existing user data
    $stmt_fetch = mysqli_prepare($conn, "SELECT * FROM `crud_681310499` WHERE id = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt_fetch, "i", $id);
    mysqli_stmt_execute($stmt_fetch);
    $result = mysqli_stmt_get_result($stmt_fetch);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        header("Location: index.php?msg=" . urlencode("ไม่พบข้อมูลผู้ใช้งานที่ระบุ"));
        exit();
    }
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลผู้ใช้ | PHP CRUD Application</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Modern Stylesheet -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Top Navigation Bar -->
    <header class="app-navbar">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="index.php" class="brand-wrapper">
                <div class="brand-icon">
                    <i class="fa-solid fa-users-gear"></i>
                </div>
                <div>
                    <h1 class="brand-title">CRUD Web Project</h1>
                    <p class="brand-subtitle">ระบบจัดการข้อมูลผู้ใช้งาน</p>
                </div>
            </a>
            
            <a href="index.php" class="btn-secondary-soft py-2 px-3">
                <i class="fa-solid fa-arrow-left"></i>
                <span>กลับหน้าหลัก</span>
            </a>
        </div>
    </header>

    <main class="container my-5 flex-grow-1">
        <div class="form-card">
            
            <!-- Card Header -->
            <div class="text-center mb-4">
                <div class="form-header-badge">
                    <i class="fa-solid fa-user-pen"></i>
                </div>
                <h3 class="fw-bold mb-1">แก้ไขข้อมูลผู้ใช้งาน</h3>
                <p class="text-muted small">แก้ไขข้อมูลของรหัส #<?= htmlspecialchars($row['id']) ?> แล้วกดอัปเดต</p>
            </div>

            <!-- Error Notification -->
            <?php if (!empty($error_msg)): ?>
                <div class="custom-alert custom-alert-danger alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation fs-5"></i>
                        <div><?= htmlspecialchars($error_msg) ?></div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Input Form -->
            <form action="" method="POST" autocomplete="off">
                <!-- Name Row -->
                <div class="row g-3 mb-3">
                    <div class="col-12 col-sm-6">
                        <label class="form-label-custom">
                            <i class="fa-solid fa-user text-muted"></i> ชื่อจริง (First Name)
                        </label>
                        <div class="input-icon-group">
                            <i class="fa-regular fa-user input-icon"></i>
                            <input type="text" class="input-field-custom" name="first_name" 
                                   value="<?= htmlspecialchars($row['first_name']) ?>" 
                                   placeholder="กรอกชื่อจริง" required>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label-custom">
                            <i class="fa-solid fa-user text-muted"></i> นามสกุล (Last Name)
                        </label>
                        <div class="input-icon-group">
                            <i class="fa-regular fa-user input-icon"></i>
                            <input type="text" class="input-field-custom" name="last_name" 
                                   value="<?= htmlspecialchars($row['last_name']) ?>" 
                                   placeholder="กรอกนามสกุล" required>
                        </div>
                    </div>
                </div>

                <!-- Email Row -->
                <div class="mb-3">
                    <label class="form-label-custom">
                        <i class="fa-solid fa-envelope text-muted"></i> อีเมล (Email Address)
                    </label>
                    <div class="input-icon-group">
                        <i class="fa-regular fa-envelope input-icon"></i>
                        <input type="email" class="input-field-custom" name="email" 
                               value="<?= htmlspecialchars($row['email']) ?>" 
                               placeholder="name@example.com" required>
                    </div>
                </div>

                <!-- Gender Radio Cards -->
                <div class="mb-4">
                    <label class="form-label-custom mb-2">
                        <i class="fa-solid fa-venus-mars text-muted"></i> เพศ (Gender)
                    </label>
                    <div class="gender-radio-grid">
                        <label class="gender-radio-card male">
                            <input type="radio" name="gender" value="male" <?= (strtolower(trim($row['gender'])) === 'male') ? 'checked' : '' ?> required>
                            <div class="gender-card-content">
                                <i class="fa-solid fa-mars fs-5 text-primary"></i>
                                <span>ชาย (Male)</span>
                            </div>
                        </label>

                        <label class="gender-radio-card female">
                            <input type="radio" name="gender" value="female" <?= (strtolower(trim($row['gender'])) === 'female') ? 'checked' : '' ?> required>
                            <div class="gender-card-content">
                                <i class="fa-solid fa-venus fs-5 text-danger"></i>
                                <span>หญิง (Female)</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Form Action Buttons -->
                <div class="d-flex flex-column flex-sm-row gap-2 pt-2">
                    <button type="submit" name="submit" class="btn-primary-gradient flex-fill justify-content-center py-2">
                        <i class="fa-solid fa-arrows-rotate"></i>
                        <span>อัปเดตข้อมูล</span>
                    </button>
                    <a href="index.php" class="btn-secondary-soft flex-fill justify-content-center py-2">
                        <i class="fa-solid fa-xmark"></i>
                        <span>ยกเลิก</span>
                    </a>
                </div>
            </form>

        </div>
    </main>

    <!-- Footer -->
    <footer class="app-footer">
        <div class="container">
            <p class="mb-0">
                &copy; <?= date('Y') ?> <strong>CRUD Web Project</strong> &bull; พัฒนาด้วย PHP & MySQL
            </p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>