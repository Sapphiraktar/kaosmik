<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <base href="<?= base_url(); ?>">
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title><?= $title ?? "Zoologik" ?></title>
    <meta name="description" content="<?= $description ?? "" ?>">
    <meta name="author" content="<?= $author ?? "" ?>">
    <meta name="keyword" content="<?= $keyword ?? "" ?>">

    <!-- TODO : FAVICON -->

    <!-- JQUERY -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@4.0.0/dist/jquery.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('/css/style.css'); ?>">

    <!-- JS -->
    <script src="<?= base_url('/js/script.js'); ?>"></script>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
          crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwxHj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          crossorigin="anonymous"
          referrerpolicy="no-referrer">

    <!-- SWAL2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- TOASTR -->
    <link rel="stylesheet" href="<?= base_url('css/toastr.min.css'); ?>">
    <script src="<?= base_url('js/toastr.min.js') ?>"></script>

    <!-- BOOTSTRAP TABLE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.js"></script>
    <!-- BOOTSTRAP PASSWORD -->
    <script src="https://unpkg.com/bootstrap-show-password@1.3.0/dist/bootstrap-show-password.min.js"></script>

</head>

<body>

<?php if (isset($menus)): ?>
    <?= view('template/menu', ['menus' => $menus]); ?>
<?php endif; ?>

<div class="container">

