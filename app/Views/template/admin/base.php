<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atrium Admin</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />

    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>" />
</head>

<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <?= $this->include('template/admin/sidebar') ?>

        <!-- Main Content -->
        <div class="admin-content">
            <!-- Header -->
            <?= $this->include('template/admin/header') ?>

            <!-- Page Content -->
            <?= $this->renderSection('content') ?>

            <!-- Footer -->
            <?= $this->include('template/admin/footer') ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<!-- Bootstrap 5 JS Bundle -->

</html>