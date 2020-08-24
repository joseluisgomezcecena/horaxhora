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
              console.log($(this));
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
          console.log(d.getHours());
          if(d.getHours() < 12)
          {
            id = d.getHours() + "am";
          }
          else if(d.getHours() == 12)
          {
            id = d.getHours() + "pm";
          }
          else
          {
            id = (d.getHours() - 12) + "pm";
          }
          console.log(id);
          document.getElementById(id).style.backgroundColor = "#00a6ff";
          document.getElementById(id).style.color = "white";

/*
          if((d.getHours()==9))
          {
            document.getElementById("9am").style.backgroundColor = "#00a6ff";
            document.getElementById("9am").style.color = "white";
          }
          if((d.getHours()==10))
          {
            document.getElementById("10am").style.backgroundColor = "#00a6ff";
            document.getElementById("10am").style.color = "white";
          }
          if((d.getHours()==11))
          {
            document.getElementById("11am").style.backgroundColor = "#00a6ff";
            document.getElementById("11am").style.color = "white";
          }
          if((d.getHours()==12))
          {
            document.getElementById("12pm").style.backgroundColor = "#00a6ff";
            document.getElementById("12pm").style.color = "white";
          }
          */
        }
      }

      window.setInterval(function(){
        paintCols();
      }, 2000);

  });//termina document ready

  
   

  </script>

</body>

</html>
