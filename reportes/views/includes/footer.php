</div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

     

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
          <a class="btn btn-primary" href="index.php?logout">Logout</a>
        </div>
      </div>
    </div>
  </div>



<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Uploading</h5>

            </div>
            <div class="modal-body">
                <div class="text-center center-block" id="demo2"></div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>





  <!-- Bootstrap core JavaScript-->
  <script src="views/assets/vendor/jquery/jquery.min.js"></script>
  <script src="views/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="views/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="views/assets/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="views/assets/vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts
  <script src="views/assets/js/demo/chart-area-demo.js"></script>
  -->
<!--
  <script src="views/assets/js/demo/chart-pie-demo.js"></script>
-->
  <!-- Dropzone -->
  <script src="views/assets/vendor/dropzone/dropzone.js"></script>

  <!-- Particles -->
  <script src="views/assets/particles/particles.js"></script>
  <script src="views/assets/particles/particles_config.js"></script>

  <!-- Date Picker -->
  <script src="views/assets/vendor/datepicker/js/bootstrap-datepicker.js"></script>

  <script>
    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    });
  </script>

  <script>
      $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
  </script>

    <?php
    if($datatablesop == 1)
    {
        echo
        "
        <!-- Page level plugins -->
        <script src=\"views/assets/vendor/datatables/jquery.dataTables.min.js\"></script>
        <script src=\"views/assets/vendor/datatables/dataTables.bootstrap4.min.js\"></script>
        <script src=\"views/assets/vendor/datatables/buttons.js\"></script>

        <!-- Page level custom scripts -->
        <script src=\"views/assets/js/demo/datatables-demo.js\"></script>
        ";
    }
    else
    {
        echo
        "<script src=\"views/assets/datatables/jquery.dataTables.min.js\"></script>
        <script src=\"views/assets/datatables/dataTables.buttons.min.js\"></script>
        <script src=\"views/assets/datatables/jszip.min.js\"></script>
        <script src=\"views/assets/datatables/pdfmake.min.js\"></script>
        <script src=\"views/assets/datatables/vfs_fonts.js\"></script>
        <script src=\"views/assets/datatables/buttons.html5.min.js\"></script>";
    }
    ?>


<script>

    //funcion para hacer ajax request y desplegar datos en tiempo real

    (function realtime() {
        $.ajax({
            url: 'index.php',
            success: function(data) {

                $("#eficiencias").load(location.href+" #eficiencias>*","");//logged_in
                $("#andones").load(location.href+" #andones>*","");//logged_in
            },
            complete: function() {
                // Siguiente peticion de ajax cuando la actual este terminada
                setTimeout(realtime, 120000);

            }
        });
    })();





</script>




<script>

$(function()
{

// We can attach the `fileselect` event to all file inputs on the page
$(document).on('change', ':file', function() {
  var input = $(this),
      numFiles = input.get(0).files ? input.get(0).files.length : 1,
      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
  input.trigger('fileselect', [numFiles, label]);
});

// We can watch for our custom `fileselect` event like this
$(document).ready( function() {
    $(':file').on('fileselect', function(event, numFiles, label) {

        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;

        if( input.length ) {
            input.val(log);
        } else {
            //if( log ) alert(log);
        }

    });
});

});



function readURL(input) {
  if (input.files && input.files[0])
  {
          var reader = new FileReader();

          reader.onload = function (e)
          {
          $('#blah')
          .attr('src', e.target.result);
          };

    reader.readAsDataURL(input.files[0]);
  }
}


</script>

<script>

    //datatables para presentar datos en toda la applicación


    $(document).ready(function() {
        //tres

        $('#dataTable1').DataTable( {

            "scrollX": true,
            "bSort": false,
            "pageLength": 10,
            //"bFilter": false,


//idioma
/*
            language: {
                processing:     "Procesando...",
                search:         "Buscar&nbsp;:",
                lengthMenu:    "Mostrar _MENU_ elementos",
                info:           "Mostrando _START_ a _END_ de _TOTAL_ elementos",
                infoEmpty:      "Mostrando 0 a 0 de 0 elementos",
                infoFiltered:   "(Filtrando; de _MAX_ elementos en total)",
                infoPostFix:    "",
                loadingRecords: "Cargando datos...",
                zeroRecords:    "No se encontro ningun registro",
                emptyTable:     "No hay datos que mostrar",
                paginate: {
                    first:      "Primero",
                    previous:   "Regresar",
                    next:       "Avanzar",
                    last:       "Ultimo"
                },
                aria: {
                    //sortAscending:  ": activer pour trier la colonne par ordre croissant",
                    //sortDescending: ": activer pour trier la colonne par ordre décroissant"
                }
            },
*/
//idioma



            dom: 'Bfrtip',
            buttons: [
                /*
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
                */
                {
                    extend: 'excelHtml5',
                    title: 'Reporte Martech Medical West'
                },
                {
                    extend: 'csvHtml5',
                    title: 'Reporte Martech Medical West '
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Reporte Martech Medical West '
                },
                {
                    extend: 'copyHtml5',
                    title: 'Reporte Martech Medical West '
                }
            ]

        } );

        //tres



        
        $('#dataTable2').DataTable( {

            "scrollX": true,
            "bSort": false,
            "pageLength": 10,
            //"bFilter": false,


            //idioma
            /*
            language: {
                processing:     "Procesando...",
                search:         "Buscar&nbsp;:",
                lengthMenu:    "Mostrar _MENU_ elementos",
                info:           "Mostrando _START_ a _END_ de _TOTAL_ elementos",
                infoEmpty:      "Mostrando 0 a 0 de 0 elementos",
                infoFiltered:   "(Filtrando; de _MAX_ elementos en total)",
                infoPostFix:    "",
                loadingRecords: "Cargando datos...",
                zeroRecords:    "No se encontro ningun registro",
                emptyTable:     "No hay datos que mostrar",
                paginate: {
                    first:      "Primero",
                    previous:   "Regresar",
                    next:       "Avanzar",
                    last:       "Ultimo"
                },
                aria: {
                    //sortAscending:  ": activer pour trier la colonne par ordre croissant",
                    //sortDescending: ": activer pour trier la colonne par ordre décroissant"
                }
            },
            */
            //idioma



            dom: 'Bfrtip',
            buttons: [
                /*
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
                */
                {
                    extend: 'excelHtml5',
                    title: 'Reporte Martech Medical West'
                },
                {
                    extend: 'csvHtml5',
                    title: 'Reporte Martech Medical West '
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Reporte Martech Medical West '
                },
                {
                    extend: 'copyHtml5',
                    title: 'Reporte Martech Medical West '
                }
            ]

            } );




        } );

</script>



<script>
(function blink() {
  $('.blink_me').fadeOut(500).fadeIn(500, blink);
})()
</script>




<script>

    Dropzone.options.myDropzone= {
        url: 'config/upload.php',
        paramName: "file",
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 1,
        maxFiles: 1,
        maxFilesize: 100,
        //acceptedFiles: 'image/*',
        acceptedFiles: '.mp4',
        addRemoveLinks: true,
        init: function() {
            dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

            // for Dropzone to process the queue (instead of default form behavior):
            document.getElementById("submit-all").addEventListener("click", function(e) {
                // Make sure that the form isn't actually being sent.
                e.preventDefault();
                e.stopPropagation();
                dzClosure.processQueue();
            });

            //send all the form data along with the files:
            this.on("sendingmultiple", function(data, xhr, formData) {
                formData.append("firstname", jQuery("#firstname").val());
                formData.append("lastname", jQuery("#lastname").val());
            });
        }
    }


</script>

<script>
    function myFunction1() {
        $('#uploadModal').modal('show');
        document.getElementById("demo2").innerHTML = "<img class='center-block text-center' src='views/assets/img/preloader1.gif' width='350'><p class='text-center'><b>Compressing and uploading your file...</b></p>";
        document.getElementById("disp").style.display = "none";
    }
</script>

<script>
        $("#btn_AddToList").click(function(){
            //alert($('input[name=List1]').val());  Its Let you know the textbox's value
            $('input[name=List1]').val().appendTo('#List2');
        });
</script>



</body>

</html>
 
