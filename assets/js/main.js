document.addEventListener("DOMContentLoaded", function() {
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
      });
    
    /**************************************** -------------- ADD ORDERS PAGE -------------- ****************************************/
    
    //Variables
    const agregar_orden_btn   = document.getElementById("agregar-orden"),
          confirmar_orden_btn = document.getElementById("confirmar-agregar-orden"),
          tabla_ordenes       = document.querySelector("#tabla-ordenes"),
          start_order         = document.getElementById("start-order");


    //AddEventListeners
    tabla_ordenes.addEventListener("click", control_buttons)
    agregar_orden_btn.addEventListener("click", function() { $("#agregar-orden-modal").modal("show"); })
    confirmar_orden_btn.addEventListener("click", agregar_orden);
    start_order.addEventListener("click", comenzar_orden);


    //Functions
    function control_buttons(e)
    {
        e.preventDefault();

        if(e.target.classList.contains("start-order"))
        {
            //comenzar_orden(e.target.getAttribute("data-id"));
            let id_orden = e.target.getAttribute("data-id"),
                pph      = document.getElementById("pph"+id_orden).textContent,
                wo       = document.getElementById("wo"+id_orden).textContent;


            document.querySelector("#comenzar-orden-modal .modal-title").textContent += wo;
            if(pph != "" && pph != "0")
                document.getElementById("pph-std").value = pph;

            start_order.setAttribute("data-id", id_orden)
            $("#comenzar-orden-modal").modal("show");
        }
        else if(e.target.classList.contains("delete-order"))
        {
            eliminar_orden(e.target.getAttribute("data-id"), e.target.parentElement.parentElement);
        }
        else if(e.target.classList.contains("edit-order"))
        {
            
        }

    }
    function agregar_orden()
    {
        let work_order = document.getElementById("work-order"),
            item       = document.getElementById("item"),
            machine    = document.getElementById("machine"),
            quantity   = document.getElementById("quantity"),
            flag_empty = 0;

        //Validate that the inputs have values
        if(work_order.value == "")
            work_order.style.borderColor = "red";
        else
            work_order.style.borderColor = "#d1d3e2";
        if(item.value == "")
            item.style.borderColor = "red";
        else
            item.style.borderColor = "#d1d3e2";
        if(machine.value == "")
            machine.style.borderColor = "red";
        else
            machine.style.borderColor = "#d1d3e2";
        if(quantity.value == "")
            quantity.style.borderColor = "red";
        else
            quantity.style.borderColor = "#d1d3e2";


        if(work_order.value != "" && item != "" && machine.value != "" && quantity.value != "")
        {
            var url      = "_config/ajax-functions.php?f=addOrder&workorder=" + work_order.value + "&item=" + item.value + "&machine=" + machine.value + "&quantity=" + quantity.value;
                xmlhttps = new XMLHttpRequest();
            xmlhttps.onreadystatechange = function()
            {
                if(xmlhttps.readyState == 4 && xmlhttps.status == 200)
                {
                    console.log(this.responseText);
                    let tbody_ordenes = document.querySelector("#tabla-ordenes tbody"),
                        row_ordenes   = document.createElement("tr");

                    row_ordenes.innerHTML = this.responseText;
                    tbody_ordenes.insertBefore(row_ordenes, tbody_ordenes.firstChild);

                    $("#agregar-orden-modal").modal("hide");

                }
            };
            xmlhttps.open("GET", url, true);
            xmlhttps.send();
            //console.log(url);
        }
        else
        {
            swal ( "Debes llenar todos los datos.", "" ,  "error" ); //Alert of sweetalert.js
        }
    }
    function comenzar_orden()
    {
        let id   = start_order.getAttribute("data-id"),
            hc   = document.getElementById("headcount").value,
            pph  = document.getElementById("pph-std").value,
            url  = "_config/ajax-functions.php?f=startOrder&id=" + id + "&pph=" + pph + "&hc=" + hc,
            xmlhttps = new XMLHttpRequest();
        console.log(url);
        if(hc != "" && hc != 0 && pph != "" && pph != 0 ){
            xmlhttps.onreadystatechange = function()
            {
                if(xmlhttps.readyState == 4 && xmlhttps.status == 200)
                {
                
                    if(this.responseText == "start")
                    {
                        let item  = document.getElementById("row"+id);
                            orden = document.getElementById("wo"+id).textContent;
                        
                        item.remove();
                        
                        swal("La orden " + orden +" ha comenzado", {
                            icon: "success",
                        });
                    }
                }
            };
            xmlhttps.open("GET", url, true);
            xmlhttps.send();
        }
        else
        {
            swal ( "Debes llenar todos los datos.", "" ,  "error" ); //Alert of sweetalert.js
        }
    }
    function editar_orden(id)
    {

    }
    function eliminar_orden(id, item)
    {
        swal({
            title: "Atención!",
            text: "Una vez eliminada, no sera capaz de recuperarla.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                let url      = "_config/ajax-functions.php?f=deleteOrder&id=" + id,
                    xmlhttps = new XMLHttpRequest();
                xmlhttps.onreadystatechange = function()
                {
                    if(xmlhttps.readyState == 4 && xmlhttps.status == 200)
                    {
                    
                        if(this.responseText == "delete")
                        {
                            item.remove();
                            swal("La orden ha sido eliminada", {
                              icon: "success",
                            });
                        }
                    }
                };
                xmlhttps.open("GET", url, true);
                xmlhttps.send();
            } else {
            }
          });
    }
});