<?php
    include "db_conn.php";

    // Fetch all user records
    $sql = "SELECT * FROM `crud_681310499` ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);

    $users = [];
    $total_users = 0;
    $male_count = 0;
    $female_count = 0;

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
            $total_users++;
            $gender_lower = strtolower(trim($row['gender']));
            if ($gender_lower === 'male') {
                $male_count++;
            } elseif ($gender_lower === 'female') {
                $female_count++;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการข้อมูลผู้ใช้งาน | PHP CRUD Application</title>
    
    <!-- Google Fonts & Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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
            
            <div class="d-flex align-items-center gap-3">
                <div class="nav-badge-status d-none d-sm-inline-flex">
                    <span class="status-dot"></span>
                    <span>MySQL Connected</span>
                </div>
                <a href="add_new.php" class="btn-primary-gradient">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>เพิ่มข้อมูลใหม่</span>
                </a>
            </div>
        </div>
    </header>

    <main class="container my-4 flex-grow-1">
        
        <!-- Flash Alert Message -->
        <?php if (isset($_GET['msg'])): ?>
            <?php 
                $msg = htmlspecialchars($_GET['msg']); 
                $is_deleted = (stripos($msg, 'delete') !== false) || (mb_stripos($msg, 'ลบ') !== false);
            ?>
            <div class="custom-alert <?= $is_deleted ? 'custom-alert-danger' : 'custom-alert-success' ?> alert-dismissible fade show" role="alert" id="flash-alert">
                <div class="d-flex align-items-center gap-3">
                    <i class="<?= $is_deleted ? 'fa-solid fa-trash-can' : 'fa-solid fa-circle-check' ?> fs-5"></i>
                    <div>
                        <strong><?= $is_deleted ? 'แจ้งเตือน:' : 'สำเร็จ!' ?></strong>
                        <?= $msg ?>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Stat Cards Row -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="stat-card d-flex align-items-center gap-3">
                    <div class="stat-icon-wrapper stat-icon-primary">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <div class="stat-value" id="stat-total"><?= $total_users ?></div>
                        <div class="stat-label">สมาชิกทั้งหมด (คน)</div>
                    </div>
                </div>
            </div>
            
            <div class="col-6 col-md-4">
                <div class="stat-card d-flex align-items-center gap-3">
                    <div class="stat-icon-wrapper stat-icon-blue">
                        <i class="fa-solid fa-mars"></i>
                    </div>
                    <div>
                        <div class="stat-value" id="stat-male"><?= $male_count ?></div>
                        <div class="stat-label">เพศชาย (Male)</div>
                    </div>
                </div>
            </div>
            
            <div class="col-6 col-md-4">
                <div class="stat-card d-flex align-items-center gap-3">
                    <div class="stat-icon-wrapper stat-icon-pink">
                        <i class="fa-solid fa-venus"></i>
                    </div>
                    <div>
                        <div class="stat-value" id="stat-female"><?= $female_count ?></div>
                        <div class="stat-label">เพศหญิง (Female)</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="content-card">
            <!-- Card Header with Search & Filter -->
            <div class="content-card-header d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fa-solid fa-table-list text-primary me-2"></i>รายชื่อผู้ใช้งาน
                    </h5>
                    <span class="badge bg-light text-secondary border px-2 py-1 rounded-pill" id="showing-count">
                        <?= count($users) ?> รายการ
                    </span>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <!-- Gender Filter Pills -->
                    <div class="filter-btn-group">
                        <button type="button" class="filter-btn active" data-filter="all">ทั้งหมด</button>
                        <button type="button" class="filter-btn" data-filter="male">ชาย</button>
                        <button type="button" class="filter-btn" data-filter="female">หญิง</button>
                    </div>

                    <!-- Search Input -->
                    <div class="search-wrapper">
                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                        <input type="text" id="searchInput" class="search-input" placeholder="ค้นหาชื่อ, อีเมล...">
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="table-responsive">
                <table class="custom-table" id="usersTable">
                    <thead>
                        <tr>
                            <th style="width: 70px;" class="text-center">ID</th>
                            <th>ชื่อ - นามสกุล</th>
                            <th>อีเมล (Email)</th>
                            <th class="text-center" style="width: 140px;">เพศ</th>
                            <th class="text-center" style="width: 120px;">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php if (count($users) > 0): ?>
                            <?php foreach ($users as $row): 
                                $gender = strtolower(trim($row['gender']));
                                $is_female = ($gender === 'female');
                                $fullName = htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
                                $initial = mb_substr($row['first_name'], 0, 1, 'UTF-8');
                            ?>
                                <tr class="user-row" data-gender="<?= htmlspecialchars($gender) ?>" data-search="<?= strtolower(htmlspecialchars($row['first_name'] . ' ' . $row['last_name'] . ' ' . $row['email'])) ?>">
                                    <td class="text-center text-muted fw-semibold">
                                        #<?= htmlspecialchars($row['id']) ?>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar-badge <?= $is_female ? 'avatar-female' : 'avatar-male' ?>">
                                                <?= htmlspecialchars($initial) ?>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark"><?= $fullName ?></div>
                                                <small class="text-muted d-sm-none"><?= htmlspecialchars($row['email']) ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="mailto:<?= htmlspecialchars($row['email']) ?>" class="text-decoration-none text-secondary">
                                            <i class="fa-regular fa-envelope me-1 text-muted"></i>
                                            <?= htmlspecialchars($row['email']) ?>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($is_female): ?>
                                            <span class="gender-badge female">
                                                <i class="fa-solid fa-venus"></i> หญิง
                                            </span>
                                        <?php else: ?>
                                            <span class="gender-badge male">
                                                <i class="fa-solid fa-mars"></i> ชาย
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-inline-flex gap-2">
                                            <a href="edit.php?id=<?= $row['id'] ?>" class="action-btn action-btn-edit" title="แก้ไขข้อมูล">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button type="button" class="action-btn action-btn-delete" title="ลบข้อมูล" 
                                                    onclick="confirmDelete(<?= $row['id'] ?>, '<?= addslashes($fullName) ?>')">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr id="initial-empty-row">
                                <td colspan="5">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fa-regular fa-folder-open"></i>
                                        </div>
                                        <h5 class="fw-bold text-secondary">ยังไม่มีข้อมูลในระบบ</h5>
                                        <p class="text-muted mb-3">เริ่มต้นเพิ่มข้อมูลสมาชิกคนแรกของคุณเลยตอนนี้</p>
                                        <a href="add_new.php" class="btn-primary-gradient">
                                            <i class="fa-solid fa-plus me-1"></i> เพิ่มข้อมูลแรก
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Search No Results Row -->
            <div id="no-search-results" class="empty-state d-none">
                <div class="empty-state-icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <h5 class="fw-bold text-secondary">ไม่พบข้อมูลที่ตรงกับการค้นหา</h5>
                <p class="text-muted">ลองตรวจสอบคำค้นหาหรือตัวกรองเพศอีกครั้ง</p>
            </div>
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
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Script for Search, Filter & Delete Confirmation -->
    <script>
        // Auto-dismiss alert after 4 seconds
        const flashAlert = document.getElementById('flash-alert');
        if (flashAlert) {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(flashAlert);
                bsAlert.close();
            }, 4000);
        }

        // SweetAlert2 Confirmation for Deletion
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'ยืนยันการลบข้อมูล?',
                html: `คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลของ <b>"${name}"</b>?<br><small class="text-muted">การกระทำนี้ไม่สามารถย้อนกลับได้</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: '<i class="fa-solid fa-trash-can me-1"></i> ลบข้อมูล',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-4 shadow-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `delete.php?id=${id}`;
                }
            });
        }

        // Live Table Search & Gender Filtering
        const searchInput = document.getElementById('searchInput');
        const filterBtns = document.querySelectorAll('.filter-btn');
        const rows = document.querySelectorAll('.user-row');
        const noResults = document.getElementById('no-search-results');
        const showingCount = document.getElementById('showing-count');

        let currentFilter = 'all';

        function filterTable() {
            const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
            let visibleCount = 0;

            rows.forEach(row => {
                const gender = row.getAttribute('data-gender');
                const searchContent = row.getAttribute('data-search');

                const matchesFilter = (currentFilter === 'all') || (gender === currentFilter);
                const matchesSearch = !query || searchContent.includes(query);

                if (matchesFilter && matchesSearch) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (showingCount) {
                showingCount.textContent = `${visibleCount} รายการ`;
            }

            if (noResults) {
                if (visibleCount === 0 && rows.length > 0) {
                    noResults.classList.remove('d-none');
                } else {
                    noResults.classList.add('d-none');
                }
            }
        }

        if (searchInput) {
            searchInput.addEventListener('input', filterTable);
        }

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                currentFilter = btn.getAttribute('data-filter');
                filterTable();
            });
        });
    </script>
</body>
</html>