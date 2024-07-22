<!-- ?php session_start(); ?> -->
<!-- PREVIOUSLY HAD SESSION START IN HERE, now moved to myfunctions.php  -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        Hoot Records Admin
    </title>
    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="assets/css/material-dashboard.min.css?v=3.0.0" rel="stylesheet" />
    <link href="../assets/css/tables.css" rel="stylesheet" />
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



    <!-- ALERTIFY JS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css" />




    <style>
        .form-control {
            border: 1px solid #b3a1a1 !important;
            padding: 8px 10px;
        }

        .form-select {
            border: 1px solid #b3a1a1 !important;
            padding: 8px 10px;
        }

        .navbar-toggler {
            border: none;
            background: none;
        }

        .navbar-toggler-icon {
            width: 30px;
            height: 30px;
            display: inline-block;
            position: relative;
        }

        .navbar-toggler-icon:before,
        .navbar-toggler-icon:after,
        .navbar-toggler-icon div {
            background-color: #fff;
            position: absolute;
            width: 100%;
            height: 3px;
            left: 0;
            transition: all 0.3s;
        }

        .navbar-toggler-icon:before {
            content: '';
            top: 0;
        }

        .navbar-toggler-icon:after {
            content: '';
            bottom: 0;
        }

        .navbar-toggler-icon div {
            top: 50%;
            margin-top: -1.5px;
        }
    </style>

</head>

<body class="g-sidenav-show  bg-gray-200">
    <?php include('sidebar.php'); ?>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <?php include('navbar.php'); ?>