<div class="container-fluid">
  <?= $breadcrumb; ?>
  <button class="my-3 btn btn-success btn-sm" data-toggle="modal" data-target="#addUser">Tambah User</button>
  <div class="row my-3">
    <div class="col-md-3 mb-2">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Anggota kelas XII</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($count_user->XII) ? $count_user->XII : "0" ?> Anggota</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-500"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-2">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Anggota kelas XI</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($count_user->XI) ? $count_user->XI : "0" ?> Anggota</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-500"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-2">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Anggota kelas X</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($count_user->X) ? $count_user->X : "0" ?> Anggota</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-500"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-2">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Anggota cabang futsal</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($count_user->Futsal) ? $count_user->Futsal : "0" ?> Anggota</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-500"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row my-3">
    <div class="col-md-3 mb-2">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Anggota cabang Basket</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($count_user->Basket) ? $count_user->Basket : "0" ?> Anggota</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-500"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-2">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Anggota cabang badminton</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($count_user->Badminton) ? $count_user->Badminton : "0" ?> Anggota</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-500"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-2">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Anggota cabang voli</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($count_user->Voli) ? $count_user->Voli : "0" ?> Anggota</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-500"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-2">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Anggota cabang futsal</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($count_user->Futsal) ? $count_user->Futsal : "0" ?> Anggota</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-500"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <ul class="nav nav-pills" role="tablist">
        <li class="nav-item border border-primary rounded m-1">
          <a class="nav-link active" data-toggle="pill" href="#xii">XII</a>
        </li>
        <li class="nav-item border border-primary rounded m-1">
          <a class="nav-link" data-toggle="pill" href="#xi">XI</a>
        </li>
        <li class="nav-item border border-primary rounded m-1">
          <a class="nav-link" data-toggle="pill" href="#x">X</a>
        </li>
        <li class="nav-item border border-primary rounded m-1">
          <a class="nav-link" data-toggle="pill" href="#futsal">Futsal</a>
        </li>
        <li class="nav-item border border-primary rounded m-1">
          <a class="nav-link" data-toggle="pill" href="#basket">Basket</a>
        </li>
        <li class="nav-item border border-primary rounded m-1">
          <a class="nav-link" data-toggle="pill" href="#voli">Voli</a>
        </li>
        <li class="nav-item border border-primary rounded m-1">
          <a class="nav-link" data-toggle="pill" href="#badminton">Badminton</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="tab-content">
        <div id="xii" class="container tab-pane active"><br>
          <h5>List User Kelas XII</h5>
          <div class="table-responsive">
            <table class="table table-bordered table-hover mx-auto w-100" id="userXII">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Active</th>
                  <th>Division</th>
                  <th>Role</th>
                  <th>Kelas</th>
                  <th>Last Login</th>
                  <?php if ($this->session->admin_level >= 85 || $this->session->admin_level == 70 || $this->session->admin_level == 60) {
                    echo "<th>Action</th>";
                  } ?>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div id="xi" class="container tab-pane fade"><br>
          <h5>List User Kelas XI</h5>
          <div class="table-responsive">
            <table class="table table-bordered table-hover mx-auto w-100" id="userXI">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Active</th>
                  <th>Division</th>
                  <th>Role</th>
                  <th>Kelas</th>
                  <th>Last Login</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div id="x" class="container tab-pane fade"><br>
          <h5>List User Kelas X</h5>
          <div class="table-responsive">
            <table class="table table-bordered table-hover mx-auto w-100" id="userX">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Active</th>
                  <th>Division</th>
                  <th>Role</th>
                  <th>Kelas</th>
                  <th>Last Login</th>
                  <?php if ($this->session->admin_level >= 85 || $this->session->admin_level == 70 || $this->session->admin_level == 60) {
                    echo "<th>Action</th>";
                  } ?>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div id="futsal" class="container tab-pane fade"><br>
          <h5>List User Futsal</h5>
          <div class="table-responsive">
            <table class="table table-bordered table-hover mx-auto w-100" id="userFutsal">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Active</th>
                  <th>Division</th>
                  <th>Role</th>
                  <th>Kelas</th>
                  <th>Last Login</th>
                  <?php if ($this->session->admin_level >= 85 || $this->session->admin_level == 70 || $this->session->admin_level == 60) {
                    echo "<th>Action</th>";
                  } ?>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div id="basket" class="container tab-pane fade"><br>
          <h5>List User Basket</h5>
          <div class="table-responsive">
            <table class="table table-bordered table-hover mx-auto w-100" id="userBasket">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Active</th>
                  <th>Division</th>
                  <th>Role</th>
                  <th>Kelas</th>
                  <th>Last Login</th>
                  <?php if ($this->session->admin_level >= 85 || $this->session->admin_level == 70 || $this->session->admin_level == 60) {
                    echo "<th>Action</th>";
                  } ?>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div id="voli" class="container tab-pane fade"><br>
          <h5>List User Voli</h5>
          <div class="table-responsive">
            <table class="table table-bordered table-hover mx-auto w-100" id="userVoli">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Active</th>
                  <th>Division</th>
                  <th>Role</th>
                  <th>Kelas</th>
                  <th>Last Login</th>
                  <?php if ($this->session->admin_level >= 85 || $this->session->admin_level == 70 || $this->session->admin_level == 60) {
                    echo "<th>Action</th>";
                  } ?>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div id="badminton" class="container tab-pane fade"><br>
          <h5>List User Badminton</h5>
          <div class="table-responsive">
            <table class="table table-bordered table-hover mx-auto w-100" id="userBadminton">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Active</th>
                  <th>Division</th>
                  <th>Role</th>
                  <th>Kelas</th>
                  <th>Last Login</th>
                  <?php if ($this->session->admin_level >= 85 || $this->session->admin_level == 70 || $this->session->admin_level == 60) {
                    echo "<th>Action</th>";
                  } ?>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php if ($this->session->admin_level >= 85) { ?>
        <div class="row mt-5">
          <div class="col-md-4">
            <button class="btn btn-success btn-sm my-3" onclick="generateAbsenCode()">Generate Register Code</button>
            <table class="table table-bordered">
              <tr>
                <th>Code</th>
                <th>Is Register</th>
              </tr>
              <tr>
                <td id="codeRegister"><?= $code_register ?></td>
                <td>
                  <div div class="form-check">
                    <input class="form-check-input" type="checkbox" onclick="toggleIsRegister()" id="isRegister" <?= $is_register == 1 ? "checked" : ""; ?>>
                    <label class="form-check-label" for="defaultCheck1">
                      Ya
                    </label>
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>

<!-- The Modal -->
<div class="modal fade" id="addUser">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="submitUser">
          <div class="form-group">
            <label>Nama User</label>
            <input type="text" name="user_nama" class="form-control" placeholder="Masukan nama user...">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="user_email" class="form-control" placeholder="Masukan email...">
          </div>
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="user_username" class="form-control" placeholder="Masukan username...">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="user_password" class="form-control" placeholder="Masukan password...">
          </div>
          <div class="form-group">
            <label>Kelas</label>
            <select name="kelas_id" class="form-control">
              <?php
              foreach ($list_kelas as $item) {
                echo "<option value='$item->kelas_id'>$item->kelas</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Cabang</label>
            <select name="cabang_id" class="form-control">
              <?php
              foreach ($list_cabang as $item) {
                echo "<option value='$item->cabang_id'>$item->cabang</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Angkatan</label>
            <select name="angkatan_id" class="form-control">
              <?php
              foreach ($list_angkatan as $item) {
                echo "<option value='$item->angkatan_id'>$item->angkatan</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Active</label>
            <select name="is_active" class="form-control">
              <option value="1">Active</option>
              <option value="0">No Active</option>
            </select>
          </div>
          <div class="form-group">
            <label>Role</label>
            <select name="role_id" class="form-control">
              <?php
              foreach ($list_role as $item) {
                echo "<option value='$item->role_id'>$item->division_name - $item->level_title</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Image</label>
            <input type="file" name="user_image" class="form-control">
          </div>
          <button type="submit" class="btn btn-success btn-sm">Simpan</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editUser">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="submitEditUser">
          <div class="form-group">
            <label>Nama User</label>
            <input type="hidden" name="user_id" id="userId">
            <input type="text" name="user_nama" id="userNama" class="form-control" placeholder="Masukan nama user...">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="user_email" id="userEmail" class="form-control" placeholder="Masukan email...">
          </div>
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="user_username" id="username" class="form-control" placeholder="Masukan username...">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="user_password" id="password" class="form-control" placeholder="Masukan password...">
          </div>
          <div class="form-group">
            <label>Kelas</label>
            <select name="kelas_id" id="kelasId" class="form-control">
              <?php
              foreach ($list_kelas as $item) {
                echo "<option value='$item->kelas_id'>$item->kelas</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Cabang</label>
            <select name="cabang_id" id="cabangId" class="form-control">
              <?php
              foreach ($list_cabang as $item) {
                echo "<option value='$item->cabang_id'>$item->cabang</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Angkatan</label>
            <select name="angkatan_id" id="angkatanId" class="form-control">
              <?php
              foreach ($list_angkatan as $item) {
                echo "<option value='$item->angkatan_id'>$item->angkatan</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Active</label>
            <select name="is_active" id="isActive" class="form-control">
              <option value="1">Active</option>
              <option value="0">No Active</option>
            </select>
          </div>
          <div class="form-group">
            <label>Role</label>
            <select name="role_id" id="roleId" class="form-control">
              <?php
              foreach ($list_role as $item) {
                echo "<option value='$item->role_id'>$item->division_name - $item->level_title</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Image</label>
            <input type="file" name="user_image" class="form-control">
          </div>
          <div id="imageUser"></div>
          <button type="submit" class="btn btn-success btn-sm mt-4">Simpan Perubahan</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  <?php if ($this->session->admin_level >= 85) { ?>

    function generateAbsenCode() {
      $.ajax({
        url: "<?= base_url("generate_absen") ?>",
        cache: false,
        type: "GET",
        dataType: "JSON",
        success: function(result) {
          if (result.success == 200) {
            if (result.code != undefined) {
              $("#codeRegister").html(result.code);
            }
            sweet("success", "Sukses!", result.message);
          } else if (result.success == 201) {
            sweet("error", "Gagal!", result.message);
          } else {
            window.location.href = result.link;
          }
        }
      })
    }

    function toggleIsRegister() {
      let checkBox = $("#isRegister").is(":checked");
      let type = "";
      if (checkBox) {
        type = 1;
      } else {
        type = 2;
      }
      $.ajax({
        url: "<?= base_url("switch_register?type=") ?>" + type,
        cache: false,
        type: "GET",
        dataType: "JSON",
        success: function(result) {
          if (result.success == 200) {
            sweet("success", "Sukses!", result.message);
          } else if (result.success == 201) {
            sweet("error", "Gagal!", result.message);
          } else {
            window.location.href = result.link;
          }
        }
      })
    }
  <?php } ?>

  function getUserDetail(id) {
    $.ajax({
      url: "<?= base_url("get_user_detail?id=") ?>" + id,
      type: "GET",
      cache: false,
      success: function(result) {
        let hasil = JSON.parse(result);
        html = `<img src='${hasil.data.user_image}' class='img-responsive'>`;
        $("#userId").val(hasil.user_id);
        $("#userNama").val(hasil.data.user_nama);
        $("#userEmail").val(hasil.data.user_email);
        $("#username").val(hasil.data.user_username);
        $("#isActive").val(hasil.data.is_active);
        $("#roleId").val(hasil.data.role_id);
        $("#kelasId").val(hasil.data.kelas_id);
        $("#cabangId").val(hasil.data.cabang_id);
        $("#angkatanId").val(hasil.data.angkatan_id);
        $("#imageUser").html(html);
      }
    })
  }

  $(document).ready(function() {
    $("#userXII").DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= base_url("get_user?type=kelas&value=2") ?>",
        "type": "POST"
      },
      "columnDefs": [{
        "targets": [0],
        "orderable": false
      }]
    });

    $("#userXI").DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= base_url("get_user?type=kelas&value=3") ?>",
        "type": "POST"
      },
      "columnDefs": [{
        "targets": [0],
        "orderable": false
      }]
    });

    $("#userX").DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= base_url("get_user?type=kelas&value=4") ?>",
        "type": "POST"
      },
      "columnDefs": [{
        "targets": [0],
        "orderable": false
      }]
    });

    $("#userFutsal").DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= base_url("get_user?type=cabang&value=1") ?>",
        "type": "POST"
      },
      "columnDefs": [{
        "targets": [0],
        "orderable": false
      }]
    });

    $("#userBasket").DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= base_url("get_user?type=cabang&value=2") ?>",
        "type": "POST"
      },
      "columnDefs": [{
        "targets": [0],
        "orderable": false
      }]
    });

    $("#userVoli").DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= base_url("get_user?type=cabang&value=3") ?>",
        "type": "POST"
      },
      "columnDefs": [{
        "targets": [0],
        "orderable": false
      }]
    });

    $("#userBadminton").DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= base_url("get_user?type=cabang&value=4") ?>",
        "type": "POST"
      },
      "columnDefs": [{
        "targets": [0],
        "orderable": false
      }]
    });

    // getTable();

    $("#submitUser").submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= base_url("validate_user_add") ?>",
        type: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        success: function(result) {
          let hasil = JSON.parse(result);
          $("#addUser").modal("hide");
          if (hasil.success == 200) {
            window.location.href = window.location;
          } else if (hasil.success == 201) {
            sweet("error", "Gagal!", hasil.message);
          } else {
            window.location.href = hasil.link;
          }
        }
      })
    })

    $("#submitEditUser").submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= base_url("validate_user_edit") ?>",
        type: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        success: function(result) {
          let hasil = JSON.parse(result);
          $("#editUser").modal("hide");
          if (hasil.success == 200) {
            window.location.href = window.location;
          } else if (hasil.success == 201) {
            sweet("error", "Gagal!", hasil.message);
          } else {
            window.location.href = hasil.link;
          }
        }
      })
    })
  })
</script>