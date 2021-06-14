<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Olpres SMK 11 Maret - Register</title>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="<?= base_url("assets/") ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url("assets/") ?>css/sb-admin-2.min.css" rel="stylesheet">
  <link href="<?= base_url("assets/") ?>css/custom.css" rel="stylesheet">
  <link href="<?= base_url("assets/") ?>vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
  <script src="<?= base_url("assets/") ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url("assets/") ?>vendor/sweetalert2/sweetalert2.min.js"></script>
  <script>
    function sweet(icon, title, text) {
      Swal.fire({
        icon: icon,
        title: title,
        text: text
      })
    }
  </script>
</head>
<body class="bg-gradient-primary">
  <?= $this->session->flashdata("pesan"); ?>
  <div class="container">
    <div class="row">
      <div class="col-md-7 mx-auto">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>
              <?= form_open("register", "class='user'"); ?>
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <input type="text" name="user_username" class="form-control" placeholder="Username" value="<?= set_value("user_username") ?>">
                  <?= form_error("user_username", "<small class='text-danger'>", "</small>") ?>
                </div>
                <div class="col-sm-6">
                  <input type="text" name="user_nama" value="<?= set_value("user_nama"); ?>" class="form-control" placeholder="Full Name">
                  <?= form_error("user_nama", "<small class='text-danger'>", "</small>") ?>
                </div>
              </div>
              <div class="form-group">
                <select name="user_gender" class="form-control">
                  <option disabled selected>-- Pilih Jenis Kelamin --</option>
                  <option <?= set_value("user_gender") == "Laki-laki" ? "selected" : "";  ?> value="Laki-laki">Laki-laki</option>
                  <option <?= set_value("user_gender") == "Perempuan" ? "selected" : "";  ?> value="Perempuan">Perempuan</option>
                </select>
                <?= form_error("user_gender", "<small class='text-danger'>", "</small>") ?>
              </div>
              <div class="form-group">
                <input type="email" name="user_email" value="<?= set_value("user_email"); ?>" class="form-control" placeholder="Email Address">
                <?= form_error("user_email", "<small class='text-danger'>", "</small>") ?>
              </div>
              <div class="form-group">
                <select name="kelas_id" class="form-control" onchange="selectKelas()">
                  <option selected disabled>-- Pilih Kelas --</option>
                  <?php $kelas_id = set_value("kelas_id");
                  foreach ($list_kelas as $item) {
                    if ($kelas_id == $item->kelas_id) {
                      echo "<option selected value='$item->kelas_id'>$item->kelas</option>";
                    } else {
                      echo "<option value='$item->kelas_id'>$item->kelas</option>";
                    }
                  }
                  ?>
                </select>
                <?= form_error("kelas_id", "<small class='text-danger'>", "</small>") ?>
              </div>
              <div class="form-group">
                <select name="angkatan_id" class="form-control">
                  <option selected disabled>-- Pilih Angkatan --</option>
                  <?php $angkatan_id = set_value("angkatan_id");
                  foreach ($list_angkatan as $item) {
                    if ($angkatan_id == $item->angkatan_id) {
                      echo "<option selected value='$item->angkatan_id'>$item->angkatan</option>";
                    } else {
                      echo "<option value='$item->angkatan_id'>$item->angkatan</option>";
                    }
                  }
                  ?>
                </select>
                <?= form_error("angkatan_id", "<small class='text-danger'>", "</small>") ?>
              </div>
              <div class="form-group">
                <select name="cabang_id" class="form-control">
                  <option selected disabled>-- Pilih Cabang --</option>
                  <?php $cabang_id = set_value("cabang_id");
                  foreach ($list_cabang as $item) {
                    if ($cabang_id == $item->cabang_id) {
                      echo "<option selected value='$item->cabang_id'>$item->cabang</option>";
                    } else {
                      echo "<option value='$item->cabang_id'>$item->cabang</option>";
                    }
                  }
                  ?>
                </select>
                <?= form_error("cabang_id", "<small class='text-danger'>", "</small>") ?>
              </div>
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <input type="password" name="password" class="form-control" placeholder="Password">
                  <?= form_error("password", "<small class='text-danger'>", "</small>") ?>
                </div>
                <div class="col-sm-6">
                  <input type="password" name="password_verif" class="form-control" placeholder="Repeat Password">
                  <?= form_error("password_verif", "<small class='text-danger'>", "</small>") ?>
                </div>
              </div>
              <div class="form-group">
                <input type="text" name="code_reference" class="form-control" placeholder="Masukan kode refrensi register...">
                <?= form_error("code_reference", "<small class='text-danger'>", "</small>") ?>
              </div>
              <button type="submit" class="btn btn-outline-primary btn-user btn-block">
                Register Account
              </button>
              <hr>
              <?= form_close(); ?>
              <hr>
              <div class="text-center">
                <a class="small" href="<?= base_url() ?>">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url("assets/") ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>