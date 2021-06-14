<div class="container-fluid">
  <?= $breadcrumb ?>
  <div class="card">
    <div class="card-header">
      <ul class="nav nav-pills" role="tablist">
        <li class="nav-item border border-primary rounded m-1">
          <a class="nav-link active" data-toggle="pill" href="#kelasTab">Kelas</a>
        </li>
        <li class="nav-item border border-primary rounded m-1">
          <a class="nav-link" data-toggle="pill" href="#angkatanTab">Angkatan</a>
        </li>
        <li class="nav-item border border-primary rounded m-1">
          <a class="nav-link" data-toggle="pill" href="#cabangTab">Cabang Eskul</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="tab-content">
        <div id="kelasTab" class="container tab-pane active"><br>
          <button class="btn btn-success btn-sm my-3" data-toggle="modal" data-target="#addKelas" onclick="add(1, 'Kelas')">Tambah kelas</button>
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kelas</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $index = 1;
                foreach ($list_kelas as $item) :
                  echo "<tr>";
                  echo "<td>$index</td>";
                  echo "<td>$item->kelas</td>";
                  echo "<td>";
                  echo "<button class='btn btn-outline-info btn-sm m-1' data-toggle='modal' data-target='#addKelas' onclick=\"getKelasDetail('" . encrypt_url($item->kelas_id) . "', 1)\"><i class='fas fa-edit'></i></button>";
                  echo "<button class='btn btn-outline-danger btn-sm m-1' onclick=\"promptDelete('" . base_url("delete_kelas?id=" . encrypt_url($item->kelas_id)) . "')\"><i class='fas fa-trash'></i></button>";
                  echo "</td>";
                  echo "</tr>";
                  $index++;
                endforeach;
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <div id="angkatanTab" class="container tab-pane"><br>
          <button class="btn btn-success btn-sm my-3" data-toggle="modal" data-target="#addAngkatan" onclick="add(2, 'Angkatan')">Tambah Angkatan</button>
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="table2">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Angkatan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $index = 1;
                foreach ($list_angkatan as $item) :
                  echo "<tr>";
                  echo "<td>$index</td>";
                  echo "<td>$item->angkatan</td>";
                  echo "<td>";
                  echo "<button class='btn btn-outline-info btn-sm m-1' data-toggle='modal' data-target='#addAngkatan' onclick=\"getAngkatanDetail('" . encrypt_url($item->angkatan_id) . "', 2)\"><i class='fas fa-edit'></i></button>";
                  echo "<button class='btn btn-outline-danger btn-sm m-1' onclick=\"promptDelete('" . base_url("delete_angkatan?id=" . encrypt_url($item->angkatan_id)) . "')\"><i class='fas fa-trash'></i></button>";
                  echo "</td>";
                  echo "</tr>";
                  $index++;
                endforeach;
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <div id="cabangTab" class="container tab-pane"><br>
          <button class="btn btn-success btn-sm my-3" data-toggle="modal" data-target="#addCabang" onclick="add(3, 'Cabang')">Tambah Cabang</button>
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="table3">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Cabang Eskul</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $index = 1;
                foreach ($list_cabang as $item) :
                  echo "<tr>";
                  echo "<td>$index</td>";
                  echo "<td>$item->cabang</td>";
                  echo "<td>";
                  echo "<button class='btn btn-outline-info btn-sm m-1' data-toggle='modal' data-target='#addCabang' onclick=\"getCabangDetail('" . encrypt_url($item->cabang_id) . "', 3)\"><i class='fas fa-edit'></i></button>";
                  echo "<button class='btn btn-outline-danger btn-sm m-1' onclick=\"promptDelete('" . base_url("delete_cabang?id=" . encrypt_url($item->cabang_id)) . "')\"><i class='fas fa-trash'></i></button>";
                  echo "</td>";
                  echo "</tr>";
                  $index++;
                endforeach;
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addKelas">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="title1"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="submitKelas">
          <div class="form-group">
            <label>Kategori Kelas</label>
            <select name="kategori_id" class="form-control">
              <?php
                foreach ($list_kelas_kategori as $item) {
                  echo "<option value='$item->kategori_id'>$item->kategori</option>";
                }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Kelas</label>
            <input type="hidden" name="kelas_id" id="kelasId">
            <input type="text" name="kelas" id="kelas" class="form-control" placeholder="Masukan kelas...">
          </div>
          <button type="submit" class="btn btn-success btn-sm" id="buttonSubmit1"></button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="closeModalKelas()">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addAngkatan">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="title2"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="submitAngkatan">
          <div class="form-group">
            <label>Angkatan</label>
            <input type="hidden" name="angkatan_id" id="angkatanId">
            <input type="text" name="angkatan" id="angkatan" class="form-control" placeholder="Masukan angkatan...">
          </div>
          <button type="submit" class="btn btn-success btn-sm" id="buttonSubmit2"></button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="closeModalAngkatan()">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addCabang">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="title3"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="submitCabang">
          <div class="form-group">
            <label>Cabang</label>
            <input type="hidden" name="cabang_id" id="cabangId">
            <input type="text" name="cabang" id="cabang" class="form-control" placeholder="Masukan cabang...">
          </div>
          <button type="submit" class="btn btn-success btn-sm" id="buttonSubmit3"></button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="closeModalCabang()">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  function closeModalKelas() {
    $("#kelasId").val("");
    $("#kelas").val("");
    $("[name='kategori_id']").val("1");
  }

  function closeModalCabang() {
    $("#cabangId").val("");
    $("#cabang").val("");
  }

  function getCabangDetail(id, index) {
    $("#buttonSubmit" + index).html("Simpan Perubahan");
    $(`#title${index}`).html(`Edit Cabang`);
    $.ajax({
      url: "<?= base_url("get_cabang?id=") ?>"+id,
      cache: false,
      type: "GET",
      success: function(result) {
        let hasil = JSON.parse(result);
        // console.log(hasil.cabang);
        if (hasil.success == 200) {
          // console.log("Masuk");
          $("#cabangId").val(hasil.cabang_id);
          $("#cabang").val(hasil.cabang);
          // console.log($("#cabang"));
        } else if (hasil.success == 201) {
          sweet("error", "Gagal!", hasil.message);
        } else {
          window.location.href = hasil.link;
        }
      },
      error: function() {
        sweet("error", "Gagal", "Error 404");
      }
    });
  }

  function add(index, title) {
    $("#buttonSubmit" + index).html("Simpan");
    $(`#title${index}`).html(`Tambah ${title}`);
  }

  $("#submitKelas").submit(function(e) {
    e.preventDefault();
    let link = "";
    if ($("#kelasId").val() == "") {
      link = "<?= base_url("add_kelas") ?>";
    } else {
      link = "<?= base_url("edit_kelas") ?>";
    }
    $.ajax({
      url: link,
      data: new FormData(this),
      type: "POST",
      processData: false,
      contentType: false,
      success: function(result) {
        let hasil = JSON.parse(result);
        $("#addKelas").modal("hide");
        if (hasil.success == 200) {
          window.location.href = window.location;
        } else if (hasil.success == 201) {
          sweet("error", "Gagal!", hasil.message);
        } else {
          window.location.href = hasil.link;
        }
      }
    })
  });

  function getAngkatanDetail(id, index) {
    $(`#title${index}`).html(`Edit Angkatan`);
    $("#buttonSubmit" + index).html("Simpan Perubahan");
    $.ajax({
      url: "<?= base_url("get_angkatan?id=") ?>" + id,
      cache: false,
      type: "GET",
      success: function(result) {
        let hasil = JSON.parse(result);
        if (hasil.success == 200) {
          $("#angkatanId").val(hasil.angkatan_id);
          $("#angkatan").val(hasil.angkatan);
        } else if (hasil.success == 201) {
          sweet("error", "Gagal!", hasil.message);
        } else {
          window.location.href = hasil.link;
        }
      }
    });
  }

  function getKelasDetail(id, index) {
    $(`#title${index}`).html(`Edit Kelas`);
    $("#buttonSubmit" + index).html("Simpan Perubahan");
    $.ajax({
      url: "<?= base_url("get_kelas_detail") ?>?id=" + id,
      type: "GET",
      cache: false,
      success: function(result) {
        let hasil = JSON.parse(result);
        $("[name='kelas']").val(hasil.data.kelas);
        $("[name='kategori_id']").val(hasil.data.kategori_id);
        $("#kelasId").val(hasil.id);
      }
    })
  }

  function closeModalAngkatan() {
    $("#angkatanId").val("");
    $("#angkatan").val();
  }

  $("#submitCabang").submit(function(e) {
    e.preventDefault();
    let link = "";
    if($("#cabangId").val() == "") {
      link = "<?= base_url("add_cabang") ?>";
    } else {
      link = "<?= base_url("edit_cabang") ?>";
    }
    $.ajax({
      url: link,
      cache: false,
      type: "POST",
      data: new FormData(this),
      processData: false,
      contentType: false,
      success: function(result) {
        let hasil = JSON.parse(result);
        if (hasil.success == 200) {
          window.location.href = window.location;
        } else if (hasil.success == 201) {
          sweet("error", "Gagal!", hasil.message);
        } else {
          window.location.href = hasil.link;
        }
      },
      error: function() {
        sweet("error", "Gagal", "Error 404");
      }
    });
  });

  $("#submitAngkatan").submit(function(e) {
    e.preventDefault();
    let link = "";
    if ($("#angkatanId").val() == "") {
      link = "<?= base_url("add_angkatan"); ?>";
    } else {
      link = "<?= base_url("edit_angkatan"); ?>";
    }
    $.ajax({
      url: link,
      cache: false,
      type: "POST",
      data: new FormData(this),
      processData: false,
      contentType: false,
      success: function(result) {
        let hasil = JSON.parse(result);
        if (hasil.success == 200) {
          window.location.href = window.location;
        } else if (hasil.success == 201) {
          sweet("error", "Gagal!", hasil.message);
        } else {
          window.location.href = hasil.link;
        }
      },
      error: function() {
        sweet("error", "Gagal", "Error 404!");
      }
    });
  });
</script>