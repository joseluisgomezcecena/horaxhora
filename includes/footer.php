</div>
        <!-- /.container-fluid -->

</div>
      <!-- End of Main Content -->

      <!-- Footer 
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <div class="order" style="display: none">
  
  </div>
  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="assets/js/sb-admin-2.min.js"></script>


  <!-- SweetAlert.js -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  
  <!-- Main js document for DOM and functions -->
  <script src="assets/js/main.js"></script>


  <script>
  $(document).ready(function(){

      //tabla hora x hora
      $(".tablahrxhr").on('change', function postinput(){
          $.ajax({
                type: 'POST',
                url: 'ajax/horaxhora/update.php',
                data: ({ 
                    "maquina" : $(this).data("maquina"),
                    "hr" : $(this).data("hr"), 
                    "value" : $(this).val()
                }),
            }).done(function(responseData) {
              console.log(responseData);
          }).fail(function() {
              console.log('Failed');
          });   
      });
      //termina ajax horax hora update

      
      function paintCols(){
        var id;
        var d = new Date(); // for now
        d.getHours(); // => 9
        d.getMinutes(); // =>  30
        d.getSeconds(); // => 51
        if(window.location.pathname == "/horaxhora/horaxhora.php" || window.location.pathname == "/horaxhora/reporteA.php")
        {
          if(d.getHours() < 12)
          {
            id = d.getHours() + "am";
          }
          else
          {
            id = d.getHours() + "pm";
          }

          if(d.getHours() - 1 < 12)
          {
            old_id = d.getHours() - 1 + "am"
          }
          else
          {
            old_id = d.getHours() - 1 + "pm"
          }
          //#858796
          document.getElementById(id).style.backgroundColor = "#00a6ff";
          document.getElementById(id).style.color = "white";
          document.getElementById(old_id).style.backgroundColor = "white";
          document.getElementById(old_id).style.color = "#858796";
        }
      }

      window.setInterval(function(){
        paintCols();
      }, 2000);

  });//termina document ready

  
   

  </script>

</body>

</html>
