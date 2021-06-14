 </div>
 <footer class="sticky-footer bg-white">
   <div class="container my-auto">
     <div class="copyright text-center my-auto">
       <span>Copyright &copy; Your Website 2020</span>
     </div>
   </div>
 </footer>
 </div>
 </div>
 <a class="scroll-to-top rounded" href="#page-top">
   <i class="fas fa-angle-up"></i>
 </a>

 <div class="modal fade" id="logoutModal">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Logout</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <h4>Anda yakin ingin logout?</h4>
      </div>
      <div class="modal-footer">
        <a href="<?= base_url() ?>" class="btn btn-danger btn-sm">Logout</a>
        <button type="button" class="btn btn-info btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


 <script src="<?= base_url("assets/") ?>js/sb-admin-2.min.js"></script>
 <script>
   $(document).ready(function() {
     $("#table").DataTable();
     $("#table2").DataTable();
     $("#table3").DataTable();
     $("[tooltip='true']").tooltip();
   })

   function promptDelete(link) {
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
        //  window.location.href = link;
        $.ajax({
          url: link,
          type: "GET",
          cache: false,
          success: function(result) {
            let hasil = JSON.parse(result);
            if (hasil.success == 200) {
              window.location.href = window.location;
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
 </body>

 </html>