
     
    </div>
    <!-- End of Content Wrapper -->

  </div>

  
  

  <!-- Bootstrap core JavaScript-->
  <script src="../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../assets/js/sb-admin-2.min.js"></script>


  <!-- SweetAlert.js -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  
  <!-- Main js document for DOM and functions -->
  <script src="../assets/js/main.js"></script>


  <script>
  
  (function realtime() {
    $.ajax({
        url: 'screen.php', 
        success: function(data) {

        $("#table1").load(location.href+" #table1>*","");
        $("#table2").load(location.href+" #table2>*","");
	$("#time").load(location.href+" #time>*","");
        },
        complete: function() {
        // Siguiente peticion de ajax cuando la actual este terminada
        setTimeout(realtime, 60000);
        
        }
    });
})();

  </script>

</body>

</html>
