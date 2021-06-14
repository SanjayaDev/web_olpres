<div class="container-fluid">
  <?= $breadcrumb; ?>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-4">
          <img src="<?= $user->user_image ?>" alt="User Photo Image" class="img-responsive">
        </div>
        <div class="col-md-8">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td>Nama</td>
                <td>: <?= $user->user_nama; ?></td>
              </tr>
              <tr>
                <td>Email</td>
                <td>: <?= $user->user_email; ?></td>
              </tr>
              <tr>
                <td>Username</td>
                <td>: <?= $user->user_username; ?></td>
              </tr>
              <tr>
                <td>Role</td>
                <td>: <?= $user->level_title; ?></td>
              </tr>
              <tr>
                <td>Divisi</td>
                <td>: <?= $user->division_name; ?></td>
              </tr>
              <tr>
                <td>Kelas</td>
                <td>: <?= $user->kelas; ?></td>
              </tr>
              <tr>
                <td>Cabang</td>
                <td>: <?= $user->cabang; ?></td>
              </tr>
              <tr>
                <td>Angkatan</td>
                <td>: <?= $user->angkatan; ?></td>
              </tr>
              <tr>
                <td>Status</td>
                <td>: <?= $user->is_active == 1 ? "Active" : "Non Active"; ?></td>
              </tr>
              <tr>
                <td>Terakhir Login</td>
                <td>: <?= $user->last_login != NULL ? date("d M Y H:i", strtotime($user->last_login)) : "Belum melakukan login"; ?></td>
              </tr>
            </table>
          </div>
          <a href="<?= base_url("user") ?>" class="btn btn-warning btn-sm">Kembali</a>
          <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#editUser">Edit</button>
        </div>
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
            <input type="hidden" name="user_id" value="<?= encrypt_url($user_id) ?>">
            <input type="text" name="user_nama" value="<?= $user->user_nama ?>" class="form-control" placeholder="Masukan nama user...">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="user_email" value="<?= $user->user_email ?>" class="form-control" placeholder="Masukan email...">
          </div>
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="user_username" value="<?= $user->user_username ?>" class="form-control" placeholder="Masukan username...">
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
                if ($user->cabang_id == $item->cabang_id) {
                  echo "<option selected value='$item->cabang_id'>$item->cabang</option>";
                } else {
                  echo "<option value='$item->cabang_id'>$item->cabang</option>";
                }
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Angkatan</label>
            <select name="angkatan_id" id="angkatanId" class="form-control">
              <?php
              foreach ($list_angkatan as $item) {
                if ($user->angkatan_id == $item->angkatan_id) {
                  echo "<option selected value='$item->angkatan_id'>$item->angkatan</option>";
                } else {
                  echo "<option value='$item->angkatan_id'>$item->angkatan</option>";
                }
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
                if ($user->role_id == $item->role_id) {
                  echo "<option selected value='$item->role_id'>$item->division_name - $item->level_title</option>";
                } else {
                  echo "<option value='$item->role_id'>$item->division_name - $item->level_title</option>";
                }
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
</script>