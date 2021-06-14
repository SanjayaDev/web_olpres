<style>
  .listSearch p {
    padding: 5px;
    cursor: pointer;
    margin-bottom: 0;
  }

  .listSearch p:hover {
    background-color: #337AB7;
    color: white;
  }
</style>
<div class="container-fluid">
  <?= $breadcrumb; ?>
  <div class="card">
    <div class="card-body">
      <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#kasModalAdd">Tambah Pembayaran Kas</button>
      <button class="btn btn-info btn-sm">Tandai Selesai Kas Hari Ini</button>
      <div class="table-responsive mt-5">
        <table class="table table-bordered table-hover w-100" id="tableKas">
          <thead>
            <tr>
              <th>No</th>
              <th>User</th>
              <th>Tanggal</th>
              <th>Bulan</th>
              <th>Pekan ke</th>
              <th>Pembayaran</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="kasModalAdd">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Data Kas</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <?= form_open("add_kas", "id='formAddKas'") ?>
        <div class="form-group">
          <label>Nama Siswa</label>
          <input type="text" class="form-control" placeholder="Cari nama siswa..." id="siswaName" autocomplete="off">
          <input type="hidden" name="user_id" id="userId">
          <div id="listSearch" class="listSearch border border-primary d-none"></div>
        </div>
        <div class="form-group">
          <label>Jumlah Pembayaran</label>
          <input type="number" class="form-control" name="price_kas" placeholder="Masukan jumlah nominal...">
        </div>
        <div class="form-group">
          <label>Untuk Pembayaran Bulan</label>
          <select name="month" class="form-control">
            <?php
            for ($i = 1; $i <= 12; $i++) {
              $i = $i < 10 ? "0$i" : $i;
              $date = month_ind(date("M", strtotime(date("Y-$i-d"))));
              if ($i == date("m")) {
                echo "<option selected value='$i'>$date</option>";
              } else {
                echo "<option value='$i'>$date</option>";
              }
            }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label>Untuk Pembayaran Pekan Ke-</label>
          <select name="week" class="form-control">
            <?php
            for ($i = 1; $i <= 4; $i++) {
              echo "<option value='$i'>$i</option>";
            }
            ?>
          </select>
        </div>
        <div class="form-group">
          <div class="form-check">
            <label class="form-check-label">
              <input type="checkbox" class="form-check-input" value="1" name="is_debt">Pembayaran Hutang Kas
            </label>
          </div>
        </div>
        <input type="submit" class="btn btn-success btn-sm" value="Simpan">
        <?= form_close(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="kasModalEdit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Data Kas</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <?= form_open("add_kas", "id='formEditKas'") ?>
        <div class="form-group">
          <label>Nama Siswa</label>
          <input type="text" class="form-control" placeholder="Cari nama siswa..." id="siswaNameEdit" autocomplete="off">
          <input type="hidden" name="user_id" id="userIdEdit">
          <input type="hidden" name="kas_id" id="kasId">
          <div id="listSearchEdit" class="listSearch border border-primary d-none"></div>
        </div>
        <div class="form-group">
          <label>Jumlah Pembayaran</label>
          <input type="number" class="form-control" name="price_kas" placeholder="Masukan jumlah nominal..." id="priceKasEdit">
        </div>
        <div class="form-group">
          <label>Untuk Pembayaran Bulan</label>
          <select name="month" class="form-control" id="monthEdit">
            <?php
            for ($i = 1; $i <= 12; $i++) {
              $i = $i < 10 ? "0$i" : $i;
              $date = month_ind(date("M", strtotime(date("Y-$i-d"))));
              echo "<option value='$i'>$date</option>";
            }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label>Untuk Pembayaran Pekan Ke-</label>
          <select name="week" class="form-control" id="weekEdit">
            <?php
            for ($i = 1; $i <= 4; $i++) {
              echo "<option value='$i'>$i</option>";
            }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label>Status Kas</label>
          <select name="kas_status_id" class="form-control" id="kasStatusId">
            <option value="1">Lunas</option>
            <option value="2">Belum Lunas</option>
          </select>
        </div>
        <input type="submit" class="btn btn-success btn-sm" value="Simpan Perubahan">
        <?= form_close(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  let table = $("#tableKas").DataTable({
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": "<?= base_url("get_kas") ?>",
      "type": "POST"
    },
    "columnDefs": [{
      "targets": [0],
      "orderable": false
    }]
  });

  function getKasDetail(kasId) {
    $.ajax({
      url: "<?= base_url("get_kas_detail?id=") ?>" + kasId,
      cache: false,
      type: "GET",
      dataType: "JSON",
      success: function(result) {
        $("#siswaNameEdit").val(result.userNama);
        $("#userIdEdit").val(result.userId);
        $("#kasId").val(result.id);
        $("#priceKasEdit").val(result.priceKas);
        $("#monthEdit").val(result.month);
        $("#weekEdit").val(result.week);
        $("#kasStatusId").val(result.kasStatusId);
      }
    });
  }

  $("#formAddKas").submit(function(e) {
    $("#loadAjax").removeClass("d-none");
    e.preventDefault();
    $.ajax({
      url: "<?= base_url("add_kas") ?>",
      type: "POST",
      cache: false,
      data: new FormData(this),
      processData: false,
      contentType: false,
      dataType: "JSON",
      success: function(result) {
        $("#loadAjax").addClass("d-none");
        $("#kasModalAdd").modal("hide");
        setTimeout(function() {
          if (result.success == 200) {
            sweet("success", "Sukses!", result.message);
            document.getElementById("formAddKas").reset();
            table.ajax.reload();
          } else if (result.success == 201) {
            sweet("error", "Gagal!", result.message);
          } else {
            window.location.href = result.link;
          }
        }, 200);
      }
    })
  })

  $("#formEditKas").submit(function(e) {
    $("#loadAjax").removeClass("d-none");
    e.preventDefault();
    $.ajax({
      url: "<?= base_url("edit_kas") ?>",
      type: "POST",
      cache: false,
      data: new FormData(this),
      processData: false,
      contentType: false,
      dataType: "JSON",
      success: function(result) {
        $("#loadAjax").addClass("d-none");
        $("#kasModalEdit").modal("hide");
        setTimeout(function() {
          if (result.success == 200) {
            sweet("success", "Sukses!", result.message);
            document.getElementById("formEditKas").reset();
            table.ajax.reload();
          } else if (result.success == 201) {
            sweet("error", "Gagal!", result.message);
          } else {
            window.location.href = result.link;
          }
        }, 200);
      }
    })
  })

  $("#siswaName").keyup(function() {
    $("#listSearch").removeClass("d-none");
    let input = $(this).val();
    $.ajax({
      url: "<?= base_url("search_user") ?>",
      type: "POST",
      dataType: "JSON",
      data: {
        keyword: input
      },
      cache: false,
      success: function(result) {
        $("#listSearch").html(result);
      }
    });
  });

  $("#siswaNameEdit").keyup(function() {
    $("#listSearchEdit").removeClass("d-none");
    let input = $(this).val();
    $.ajax({
      url: "<?= base_url("search_user_edit") ?>",
      type: "POST",
      dataType: "JSON",
      data: {
        keyword: input
      },
      cache: false,
      success: function(result) {
        $("#listSearchEdit").html(result);
      }
    });
  });

  $("#siswaName").on("blur", function() {
    setTimeout(function() {
      $("#listSearch").addClass("d-none");
      $("#listSearch").html("");
    }, 500);
  });

  $("#siswaNameEdit").on("blur", function() {
    setTimeout(function() {
      $("#listSearchEdit").addClass("d-none");
      $("#listSearchEdit").html("");
    }, 500);
  });

  function addUser(userId, user) {
    $("#siswaName").val(user);
    $("#userId").val(userId);
  }

  function addUserEdit(userId, user) {
    $("#siswaNameEdit").val(user);
    $("#userIdEdit").val(userId);
  }

  function deletePrompt(link) {
    Swal.fire({
      title: 'Anda yakin?',
      text: "Item ini akan dihapus secara permanent!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus ini!'
    }).then((result) => {
      if (result.value) {
        $("#loadAjax").removeClass("d-none");
        $.ajax({
          url: link,
          type: "GET",
          cache: false,
          success: function(result) {
            let hasil = JSON.parse(result);
            //  console.log(hasil);
            if (hasil.success == 200) {
              $("#loadAjax").addClass("d-none");
              table.ajax.reload();
              sweet("success", "Sukses!", hasil.message);
            } else {
              Swal.fire({
                title: "Gagal!",
                text: hasil.message,
                icon: "error"
              })
            }
          },
          error: function() {
            Swal.fire({
              title: "Gagal!",
              text: "404 Not Found",
              icon: "error"
            })
          }
        })
      }
    })
  }
</script>