<!DOCTYPE html>
<html>

<head>

    <title><?= $judul ?></title>
    <!--

DIGITAL TREND

https://templatemo.com/tm-538-digital-trend

-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/aos.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/owl.theme.default.min.css">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/templatemo-digital-trend.css">

    <!-- jQuery -->
    <script src="<?= base_url('assets/') ?>js/jquery.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/jquery.validate.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/sweetalert2.all.min.js"></script>
    <style>
        .error {
            color: red;
        }

        label,
        input {
            font-size: 12px;
            border: 0;
            margin-left: 3px;
            margin-bottom: 1px;
            display: block;
            width: 100%;
        }
    </style>
</head>

<body>

    <!-- MENU BAR -->
    <nav class="navbar navbar-expand-lg position-absolute">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                Lapor-in
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <?php if ($this->session->userdata('nama')) {
                        if ($this->session->userdata('role_id') == 1) {
                            echo '<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Beranda
                            </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="' . base_url('HomeController') . '">Pengaduan</a></li>
                                    <li><a class="dropdown-item" href="' . base_url('HomeController/tabel_pengaduan') . '">Tabel Pengaduan</a></li>
                                    <li><a class="dropdown-item" href="' . base_url('HomeController/tabel_laporan') . '">Tabel Laporan</a></li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    User
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="' . base_url('HomeController/data_user/1') . '">Admin</a></li>
                                    <li><a class="dropdown-item" href="' . base_url('HomeController/data_user/2') . '">Petugas</a></li>
                                    <li><a class="dropdown-item" href="' . base_url('HomeController/data_user/3') . '">Masyarakat</a></li>
                                </ul>
                            </li>
                        
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="user-data" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-userdata="' . $user['nama'] . '">
                                    ' . $user['nama'] . '
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="' . base_url('HomeController/detail_user/') . $user['id'] . '">Profile</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a id="btn-logout" class="dropdown-item" href="' . base_url('Authentication/logout') . '">Logout</a></li>
                                </ul>
                            </li>
                        ';
                        } elseif ($this->session->userdata('role_id') == 2) {
                            echo '<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Beranda
                            </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="' . base_url() . '">Pengaduan</a></li>
                                    <li><a class="dropdown-item" href="' . base_url('HomeController/tabel_pengaduan') . '">Tabel Pengaduan</a></li>
                                    <li><a class="dropdown-item" href="' . base_url('HomeController/tabel_laporan') . '">Tabel Laporan</a></li>
                                </ul>
                            </li>
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="user-data" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-userdata="' . $user['nama'] . '">
                                    ' . $user['nama'] . '
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="' . base_url('HomeController/detail_user/') . $user['id'] . '">Profile</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a id="btn-logout" class="dropdown-item" href="' . base_url('Authentication/logout') . '">Logout</a></li>
                                </ul>
                            </li>';
                        } else {
                            echo '<li class="nav-item">
                                <a href="' . base_url('HomeController') . '" class="nav-link">Beranda</a>
                            </li>
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="user-data" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-userdata="' . $user['nama'] . '">
                                    ' . $user['nama'] . '
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="' . base_url('HomeController/detail_user/') . $user['id'] . '">Profile</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a id="btn-logout" class="dropdown-item" href="' . base_url('Authentication/logout') . '">Logout</a></li>
                                </ul>
                            </li>';
                        }
                    } else {
                        echo '<li class="nav-item">
                            <a href="#" class="nav-link">Beranda</a>
                        </li>
                        
                        <li class="nav-item">
                            <a id="direct-login" href="' . base_url('Authentication') . '" class="nav-link contact">Masuk</a>
                        </li>';
                    } ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- <nav class="nav flex-column">
        <a class="nav-link active" aria-current="page" href="#">Active</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
    </nav> -->