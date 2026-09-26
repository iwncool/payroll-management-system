<?php
session_start();
require_once __DIR__ . '/config/db.php';

$pdo = dbConnection();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save_employee') {
        $id = (int) ($_POST['id'] ?? 0);
        $nip = trim($_POST['nip'] ?? '');
        $nama = trim($_POST['nama'] ?? '');
        $tanggal_bergabung = $_POST['tanggal_bergabung'] ?? '';
        $departemen = trim($_POST['departemen'] ?? '');
        $jabatan = trim($_POST['jabatan'] ?? '');
        $tunjangan = trim($_POST['tunjangan'] ?? '');
        $fasilitas = trim($_POST['fasilitas'] ?? '');
        $gaji = (float) ($_POST['gaji'] ?? 0);
        $is_processed = isset($_POST['is_processed']) ? 1 : 0;

        if ($nip === '' || $nama === '' || $tanggal_bergabung === '' || $departemen === '' || $jabatan === '') {
            $_SESSION['error'] = 'Semua field wajib diisi.';
        } else {
            if ($id > 0) {
                $stmt = $pdo->prepare('UPDATE employees SET nip = ?, nama = ?, tanggal_bergabung = ?, departemen = ?, jabatan = ?, tunjangan = ?, fasilitas = ?, gaji = ?, is_processed = ?, updated_at = NOW() WHERE id = ?');
                $stmt->execute([$nip, $nama, $tanggal_bergabung, $departemen, $jabatan, $tunjangan, $fasilitas, $gaji, $is_processed, $id]);
                $_SESSION['success'] = 'Data karyawan berhasil diperbarui.';
            } else {
                $stmt = $pdo->prepare('INSERT INTO employees (nip, nama, tanggal_bergabung, departemen, jabatan, tunjangan, fasilitas, gaji, is_processed, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())');
                $stmt->execute([$nip, $nama, $tanggal_bergabung, $departemen, $jabatan, $tunjangan, $fasilitas, $gaji, $is_processed]);
                $_SESSION['success'] = 'Data karyawan berhasil ditambahkan.';
            }
        }
        header('Location: employees.php');
        exit;
    }

    if ($action === 'delete_employee') {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id > 0) {
            $pdo->prepare('DELETE FROM employees WHERE id = ?')->execute([$id]);
            $_SESSION['success'] = 'Data karyawan berhasil dihapus.';
        }
        header('Location: employees.php');
        exit;
    }
}

$employees = $pdo->query('SELECT * FROM employees ORDER BY created_at DESC')->fetchAll(PDO::FETCH_ASSOC);
$user = getUserById($pdo, $_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data Karyawan</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="brand">Payroll System</div>
            <nav>
                <a href="dashboard.php">Dashboard</a>
                <a class="active" href="employees.php">Master Data Karyawan</a>
                <a href="processed_employees.php">Data Diterima</a>
                <a href="profile.php">Password & Keamanan</a>
                <a href="logout.php">Logout</a>
            </nav>
        </aside>

        <main class="content">
            <header class="topbar">
                <div>
                    <h1>Master Data Karyawan</h1>
                    <p>Kelola karyawan yang sedang dipersiapkan sebelum diproses dan diterima.</p>
                </div>
                <a class="btn btn-primary" href="employees.php?action=add">Tambah Karyawan</a>
            </header>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <?php
            $mode = $_GET['action'] ?? 'list';
            $editing = null;
            if ($mode === 'edit') {
                $id = (int) ($_GET['id'] ?? 0);
                if ($id > 0) {
                    $editing = $pdo->prepare('SELECT * FROM employees WHERE id = ?');
                    $editing->execute([$id]);
                    $editing = $editing->fetch(PDO::FETCH_ASSOC);
                }
            }
            ?>

            <?php if ($mode === 'add' || $mode === 'edit'): ?>
                <section class="panel form-panel">
                    <h2><?php echo $mode === 'add' ? 'Tambah Karyawan' : 'Edit Karyawan'; ?></h2>
                    <form method="POST" action="employees.php">
                        <input type="hidden" name="action" value="save_employee">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars((string) ($editing['id'] ?? 0)); ?>">

                        <div class="form-grid">
                            <div>
                                <label>NIP</label>
                                <input type="text" name="nip" value="<?php echo htmlspecialchars($editing['nip'] ?? ''); ?>" required>
                            </div>
                            <div>
                                <label>Nama</label>
                                <input type="text" name="nama" value="<?php echo htmlspecialchars($editing['nama'] ?? ''); ?>" required>
                            </div>
                            <div>
                                <label>Tanggal Bergabung</label>
                                <input type="date" name="tanggal_bergabung" value="<?php echo htmlspecialchars($editing['tanggal_bergabung'] ?? ''); ?>" required>
                            </div>
                            <div>
                                <label>Departemen</label>
                                <input type="text" name="departemen" value="<?php echo htmlspecialchars($editing['departemen'] ?? ''); ?>" required>
                            </div>
                            <div>
                                <label>Jabatan</label>
                                <input type="text" name="jabatan" value="<?php echo htmlspecialchars($editing['jabatan'] ?? ''); ?>" required>
                            </div>
                            <div>
                                <label>Tunjangan</label>
                                <input type="text" name="tunjangan" value="<?php echo htmlspecialchars($editing['tunjangan'] ?? ''); ?>">
                            </div>
                            <div>
                                <label>Fasilitas</label>
                                <input type="text" name="fasilitas" value="<?php echo htmlspecialchars($editing['fasilitas'] ?? ''); ?>">
                            </div>
                            <div>
                                <label>Gaji</label>
                                <input type="number" step="0.01" min="0" name="gaji" value="<?php echo htmlspecialchars((string) ($editing['gaji'] ?? 0)); ?>">
                            </div>
                            <div class="checkbox-wrap">
                                <label>
                                    <input type="checkbox" name="is_processed" value="1" <?php echo (!empty($editing['is_processed'])) ? 'checked' : ''; ?>>
                                    Sudah diterima / diproses
                                </label>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                            <a class="btn btn-secondary" href="employees.php">Batal</a>
                        </div>
                    </form>
                </section>
            <?php else: ?>
                <section class="panel table-panel">
                    <h2>Daftar Karyawan</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Tanggal Bergabung</th>
                                <th>Departemen</th>
                                <th>Jabatan</th>
                                <th>Tunjangan</th>
                                <th>Fasilitas</th>
                                <th>Gaji</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($employees)): ?>
                                <tr>
                                    <td colspan="10">Belum ada data karyawan.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($employees as $employee): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($employee['nip']); ?></td>
                                        <td><?php echo htmlspecialchars($employee['nama']); ?></td>
                                        <td><?php echo htmlspecialchars($employee['tanggal_bergabung']); ?></td>
                                        <td><?php echo htmlspecialchars($employee['departemen']); ?></td>
                                        <td><?php echo htmlspecialchars($employee['jabatan']); ?></td>
                                        <td><?php echo htmlspecialchars($employee['tunjangan']); ?></td>
                                        <td><?php echo htmlspecialchars($employee['fasilitas']); ?></td>
                                        <td>Rp <?php echo number_format((float) $employee['gaji'], 0, ',', '.'); ?></td>
                                        <td>
                                            <?php echo $employee['is_processed'] ? '<span class="badge success">Diterima</span>' : '<span class="badge pending">Belum</span>'; ?>
                                        </td>
                                        <td class="actions">
                                            <a class="btn btn-small btn-secondary" href="employees.php?action=edit&id=<?php echo $employee['id']; ?>">Edit</a>
                                            <form method="POST" action="employees.php" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                <input type="hidden" name="action" value="delete_employee">
                                                <input type="hidden" name="id" value="<?php echo $employee['id']; ?>">
                                                <button class="btn btn-small btn-danger" type="submit">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </section>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
