<?php

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    echo "<script> window.location.href = '" . route('login') . "' </script>";
}

function assets($path)
{
    $baseURL = $_ENV['APP_URL'] . '/assets';
    $path = ltrim($path, '/');

    return $baseURL . '/' . $path;
}

function route($path)
{
    $baseURL = $_ENV['APP_URL'];
    $path = ltrim($path, '/');

    return $baseURL . '/' . $path;
}

function currentPath($path)
{
    $currentUri = $_SERVER['REQUEST_URI'];

    $rootFolder = trim($_ENV['APP_ROOT_FOLDER'] ?? '', '/');

    if ($rootFolder !== '') {
        $currentUri = str_replace("/$rootFolder/", '', $currentUri);
    }

    if (strpos($currentUri, $path) !== false) {
        return true;
    }
    return false;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title><?= isset($title) ? $title : 'Pages' ?> - Kasir 7</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="<?= assets('img/favicon.png') ?>" rel="icon" />
    <link href="<?= assets('img/apple-touch-icon.png') ?>" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="<?= assets('vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" />
    <link href="<?= assets('vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet" />
    <link href="<?= assets('vendor/boxicons/css/boxicons.min.css') ?>" rel="stylesheet" />
    <link href="<?= assets('vendor/quill/quill.snow.css') ?>" rel="stylesheet" />
    <link href="<?= assets('vendor/quill/quill.bubble.css') ?>" rel="stylesheet" />
    <link href="<?= assets('vendor/remixicon/remixicon.css') ?>" rel="stylesheet" />
    <link href="<?= assets('vendor/simple-datatables/style.css') ?>" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Select 2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Template Main CSS File -->
    <link href="<?= assets('css/style.css') ?>" rel="stylesheet" />
    <!-- <style>
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #fff;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            z-index: 9999;
        }
    </style> -->
</head>

<body>

    <!-- Preloader -->
    <div class="preloader">
        <div class="d-flex gap-3 justify-content-center align-items-end">
            <img src="<?= assets('img/logo.png') ?>" alt="" />
            <h3 class="fw-bold ">KASIR 7</h3>
        </div>
        <div class="mt-4 spinner-border text-primary" style="width: 40px; height: 40px;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>