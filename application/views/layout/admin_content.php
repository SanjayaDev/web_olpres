<?php
require "admin_head.php";
require "admin_sidenav.php";
require "admin_header.php";
if (isset($content)) {
  $this->load->view($content);
}
require "admin_footer.php";