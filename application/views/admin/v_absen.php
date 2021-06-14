<div class="container-fluid">
  <?= $breadcrumb; ?>
  <a href="<?= base_url("create_absen"); ?>"><button class="my-3 btn btn-success btn-sm">Buat Absen Hari Ini</button></a>
  <h4 class="my-1">Data absen dari tanggal <?= day_ind(date("D", strtotime($start_date))).", ".date("d M Y", strtotime($start_date)) . " - ". day_ind(date("D", strtotime($end_date))).", " . date("d M Y", strtotime($end_date)) ?></h4>
  <h5 class="mt-1 mb-3">Jumlah Siswa <?= $count_absen->total; ?></h5>
  <div class="row my-3">
    <div class="col-md-6 mb-3">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                Jumlah Siswa Masuk</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $count_absen->Masuk ?> Siswa</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-500"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                Jumlah Siswa Izin</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $count_absen->Izin ?> Siswa</div>
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
    <div class="col-md-6 mb-3">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                Jumlah Siswa Sakit</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $count_absen->Sakit ?> Siswa</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-500"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                Jumlah Siswa Alpha</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $count_absen->Alpha ?> Siswa</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-500"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card mb-3">
    <div class="card-body">
      <h5 class="text-center my-2">Filter absen berdasarkan tanggal</h5>
      <?= form_open() ?>
      <div class="row">
        <div class="col-md-4 mx-auto">
          <div class="form-group">
            <label>Tanggal Mulai</label>
            <input type="date" class="form-control" id="startDate" name="start_date" value="<?= date("Y-m-d", strtotime($start_date)) ?>">
          </div>
          <div class="form-group">
            <label>Tanggal Akhir</label>
            <input type="date" class="form-control" id="endDate" name="end_date" value="<?= date("Y-m-d", strtotime($end_date)) ?>">
          </div>
          <input type="submit" class="btn btn-primary d-block my-auto" value="Filter">
        </div>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
  <div class="card shadow">
    <div class="card-header">
      <ul class="nav nav-pills" role="tablist">
        <li class="nav-item border border-primary rounded m-1">
          <a class="nav-link active" data-toggle="pill" href="#Semua">Semua</a>
        </li>
        <li class="nav-item border border-primary rounded m-1">
          <a class="nav-link" data-toggle="pill" href="#Masuk">Masuk</a>
        </li>
        <li class="nav-item border border-primary rounded m-1">
          <a class="nav-link" data-toggle="pill" href="#Izin">Izin</a>
        </li>
        <li class="nav-item border border-primary rounded m-1">
          <a class="nav-link" data-toggle="pill" href="#Sakit">Sakit</a>
        </li>
        <li class="nav-item border border-primary rounded m-1">
          <a class="nav-link" data-toggle="pill" href="#TanpaKeterangan">Tanpa Keterangan</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="tab-content">
        <div id="Semua" class="container tab-pane active"><br>
          <h5>List Semua Absen</h5>
          <div class="table-responsive">
            <table class="table table-bordered table-hover w-100" id="tableAbsen">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Siswa</th>
                  <th>Kelas</th>
                  <th>Cabang</th>
                  <th>Absen Status</th>
                  <th>Tanggal Absen</th>
                  <th>Pekan Ke</th>
                  <th>Catatan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div id="Masuk" class="container tab-pane"><br>
          <h5>List Siswa Masuk</h5>
          <div class="table-responsive">
            <table class="table table-bordered table-hover w-100" id="absenMasuk">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Siswa</th>
                  <th>Kelas</th>
                  <th>Cabang</th>
                  <th>Absen Status</th>
                  <th>Tanggal Absen</th>
                  <th>Pekan Ke</th>
                  <th>Catatan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div id="Izin" class="container tab-pane"><br>
          <h5>List Siswa Izin</h5>
          <div class="table-responsive">
            <table class="table table-bordered table-hover w-100" id="absenIzin">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Siswa</th>
                  <th>Kelas</th>
                  <th>Cabang</th>
                  <th>Absen Status</th>
                  <th>Tanggal Absen</th>
                  <th>Pekan Ke</th>
                  <th>Catatan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div id="Sakit" class="container tab-pane"><br>
          <h5>List Siswa Sakit</h5>
          <div class="table-responsive">
            <table class="table table-bordered table-hover w-100" id="absenSakit">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Siswa</th>
                  <th>Kelas</th>
                  <th>Cabang</th>
                  <th>Absen Status</th>
                  <th>Tanggal Absen</th>
                  <th>Pekan Ke</th>
                  <th>Catatan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div id="TanpaKeterangan" class="container tab-pane"><br>
          <h5>List Siswa Tanpa Keterangan</h5>
          <div class="table-responsive">
            <table class="table table-bordered table-hover w-100" id="absenAlpha">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Siswa</th>
                  <th>Kelas</th>
                  <th>Cabang</th>
                  <th>Absen Status</th>
                  <th>Tanggal Absen</th>
                  <th>Pekan Ke</th>
                  <th>Catatan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-md-4">
          <h5>Setting Absen</h5>
          <button class="btn btn-success btn-sm my-3" onclick="generateCodeAbsen()">Generate Code Absen</button>
          <table class="table table-bordered table-striped">
            <tr>
              <th>Code</th>
              <th>Lakukan Absen</th>
              <th>Pekan</th>
            </tr>
            <tr>
              <td id="codeAbsen"><?= $code; ?></td>
              <td>
                <div div class="form-check">
                  <input class="form-check-input" type="checkbox" onclick="toggleIsAbsen()" id="isAbsen" <?= $is_absen == 1 ? "checked" : ""; ?>>
                  <label class="form-check-label" for="defaultCheck1">
                    Ya
                  </label>
                </div>
              </td>
              <td>
                <div class="form-group">
                  <select name="week" class="form-control" onchange="changeWeek()">
                    <option <?= $pekan == 1 ? "selected" : ""; ?> value="1">1</option>
                    <option <?= $pekan == 2 ? "selected" : ""; ?> value="2">2</option>
                    <option <?= $pekan == 3 ? "selected" : ""; ?> value="3">3</option>
                    <option <?= $pekan == 4 ? "selected" : ""; ?> value="4">4</option>
                    <option <?= $pekan == 5 ? "selected" : ""; ?> value="5">5</option>
                  </select>
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editAbsen">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Absen</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="formEditAbsen">
          <div class="form-group">
            <label>Siswa</label>
            <input type="text" class="form-control" id="siswa" disabled>
          </div>
          <div class="form-group">
            <label>Tanggal</label>
            <input type="text" class="form-control" id="tanggal" disabled>
          </div>
          <div class="form-group">
            <label>Pekan</label>
            <input type="text" class="form-control" id="pekan" disabled>
            <input type="hidden" name="absen_id" id="absenId">
          </div>
          <div class="form-group">
            <label>Absen Status</label>
            <select name="absen_status_id" id="absenStatus" class="form-control">
              <?php
              foreach ($list_absen_status as $item) {
                echo "<option value='$item->absen_status_id'>$item->absen_status</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Catatan Absen</label>
            <textarea name="absen_note" class="form-control" cols="30" rows="5" id="absenReason" placeholder="Masukan catatan jika ada..."></textarea>
          </div>
          <button type="submit" class="btn btn-success btn-sm">Update Data</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script>
  const start = document.getElementById("startDate").value;
  const end = document.getElementById("endDate").value;

  $("#tableAbsen").DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
      "url": "<?= base_url("get_absen") ?>?start_date=" + start + "&end_date=" + end,
      "type": "POST"
    },
    "columnDefs": [{
      "targets": [0],
      "orderable": false
    }]
  });

  $("#absenMasuk").DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
      "url": "<?= base_url("get_absen?value=1") ?>&start_date=" + start + "&end_date=" + end,
      "type": "POST"
    },
    "columnDefs": [{
      "targets": [0],
      "orderable": false
    }]
  });

  $("#absenIzin").DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
      "url": "<?= base_url("get_absen?value=2") ?>&start_date=" + start + "&end_date=" + end,
      "type": "POST"
    },
    "columnDefs": [{
      "targets": [0],
      "orderable": false
    }]
  });

  $("#absenSakit").DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
      "url": "<?= base_url("get_absen?value=3") ?>&start_date=" + start + "&end_date=" + end,
      "type": "POST"
    },
    "columnDefs": [{
      "targets": [0],
      "orderable": false
    }]
  });

  $("#absenAlpha").DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
      "url": "<?= base_url("get_absen?value=4") ?>&start_date=" + start + "&end_date=" + end,
      "type": "POST"
    },
    "columnDefs": [{
      "targets": [0],
      "orderable": false
    }]
  });

  $("#formEditAbsen").submit(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= base_url('update_absen') ?>",
      data: new FormData(this),
      type: "POST",
      cache: false,
      processData: false,
      contentType: false,
      success: function(result) {
        let hasil = JSON.parse(result);
        // console.log(result);
        if (hasil.success == 200) {
          window.location.href = window.location;
        } else if (hasil.success == 201) {
          sweet("error", "Gagal!", hasil.message);
        } else {
          window.location.href = hasil.link;
        }
      }
    });
  })

  function toggleIsAbsen() {
    let checkBox = $("#isAbsen").is(":checked");
    let type = "";
    if (checkBox) {
      type = 1;
    } else {
      type = 2;
    }
    $.ajax({
      url: "<?= base_url("switch_absen?type=") ?>" + type,
      cache: false,
      type: "GET",
      success: function(result) {
        let hasil = JSON.parse(result);
        if (hasil.success == 200) {
          sweet("success", "Sukses", hasil.message);
        } else if (hasil.success == 201) {
          sweet("error", "Gagal", hasil.message);
        } else {
          window.location.href = hasil.link;
        }
      }
    });
  }

  function changeWeek() {
    let week = $("[name='week']").val();
    $.ajax({
      url: "<?= base_url("change_week?week=") ?>" + week,
      cache: false,
      type: "GET",
      success: function(result) {
        let hasil = JSON.parse(result);
        if (hasil.success == 200) {
          sweet("success", "Sukses", hasil.message);
        } else if (hasil.success == 201) {
          sweet("error", "Gagal", hasil.message);
        } else {
          window.location.href = hasil.link;
        }
      }
    });
  }

  function generateCodeAbsen() {
    $.ajax({
      url: "<?= base_url("generate_absen_code") ?>",
      cache: false,
      type: "GET",
      success: function(result) {
        let hasil = JSON.parse(result);
        if (hasil.success == 200) {
          $("#codeAbsen").html(hasil.code);
          sweet("success", "Sukses", hasil.message);
        } else if (hasil.success == 201) {
          sweet("error", "Gagal", hasil.message);
        } else {
          // window.location.href = hasil.link;
        }
      }
    });
  }

  function getAbsen(absenId) {
    $.ajax({
      url: "<?= base_url("get_absen_detail?id=") ?>" + absenId,
      cache: false,
      type: "GET",
      success: function(result) {
        let hasil = JSON.parse(result);
        if (hasil.success == 200) {
          $("#siswa").val(hasil.siswa);
          $("#tanggal").val(hasil.tanggal);
          $("#pekan").val(hasil.pekan);
          $("#absenStatus").val(hasil.absen_status_id);
          $("#absenReason").val(hasil.reason);
          $("#absenId").val(hasil.absen_id);
        } else if (hasil.success == 201) {
          sweet("error", "Gagal!", hasil.message);
        } else {
          window.location.href = hasil.link;
        }
      }
    });
  }
</script>