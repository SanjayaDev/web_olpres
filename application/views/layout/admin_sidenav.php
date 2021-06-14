<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
  </a>
  <hr class="sidebar-divider my-0">
  <div class="sidebar-heading">Super Admin</div>
  <li class="nav-item <?= $title == "Dashboard" ? "active" : ""; ?>">
    <a class="nav-link" href="<?= base_url("dashboard"); ?>">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>
  <li class="nav-item <?= $title == "Master data olpres" ? "active" : ""; ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-fw fa-database"></i>
      <span>Master Data</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Database:</h6>
        <a class="collapse-item" href="<?= base_url("user"); ?>">Anggota</a>
        <?php if ($this->session->admin_level >= 80) { ?>
          <a class="collapse-item" href="<?= base_url("master_data") ?>">Kelas, Cabang & Angkatan</a>
        <?php } ?>
      </div>
    </div>
  </li>
  <li class="nav-item <?= $title == "Absensi" ? "active" : ""; ?>">
    <a class="nav-link" href="<?= base_url("absen"); ?>">
      <i class="fab fa-fw fa-wpforms"></i>
      <span>Absensi</span></a>
  </li>
  <li class="nav-item <?= $title == "Data Kas" ? "active" : ""; ?>">
    <a class="nav-link" href="<?= base_url("data_kas"); ?>">
      <i class="fas fa-fw fa-money-check-alt"></i>
      <span>Data Kas</span></a>
  </li>
  <hr class="sidebar-divider d-none d-md-block">
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>