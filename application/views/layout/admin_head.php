<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?= $title; ?></title>
  <link href="<?= base_url("assets/") ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="<?= base_url("assets/") ?>css/sb-admin-2.min.css" rel="stylesheet">
  <link href="<?= base_url("assets/") ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url("assets/vendor/sweetalert2/sweetalert2.min.css") ?>">
  <script src="<?= base_url("assets/vendor/sweetalert2/sweetalert2.min.js") ?>"></script>
  <link rel="stylesheet" href="<?= base_url("assets/css/custom.css")?>">
  <script>
    function sweet(icon, title, text) {
      Swal.fire({
        icon: icon,
        title: title,
        text: text
      })
    }
  </script>
  <script src="<?= base_url("assets/") ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url("assets/") ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url("assets/") ?>vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url("assets/") ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
</head>

<body id="page-top">

<div class="lds-ring d-none" id="loadAjax"><div></div><div></div><div></div><div></div></div>

  <div id="wrapper">
    <?= $this->session->flashdata('pesan'); ?>