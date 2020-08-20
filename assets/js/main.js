
document.addEventListener("DOMContentLoaded", function() {
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
      });
    
    /**************************************** -------------- ADD ORDERS PAGE -------------- ****************************************/
    if(window.location.pathname == "/horaxhora/cargar_ordenes.php")
    {
        //Variables
        const agregar_orden_btn   = document.getElementById("agregar-orden"),
            confirmar_orden_btn = document.getElementById("confirmar-agregar-orden"),
            tabla_ordenes       = document.querySelector("#tabla-ordenes"),
            start_order         = document.getElementById("start-order"),
            edit_order          = document.getElementById("edit-order");


        //AddEventListeners
        tabla_ordenes.addEventListener("click", control_buttons)
        agregar_orden_btn.addEventListener("click", function() { $("#agregar-orden-modal").modal("show"); })
        confirmar_orden_btn.addEventListener("click", agregar_orden);
        start_order.addEventListener("click", comenzar_orden);
        edit_order.addEventListener("click", function(){editar_orden(this.getAttribute("data-id"))});


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


                document.querySelector("#comenzar-orden-modal .modal-title").textContent = "Comenzar orden: " + wo;
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
                let id_orden = e.target.getAttribute("data-id"),
                    columnas = e.target.parentElement.parentElement.querySelectorAll("td"),
                    inputs   = document.querySelectorAll("#editar-orden-modal input"),
                    select   = document.querySelector("#editar-orden-modal select");

                    document.querySelector("#editar-orden-modal .modal-title").textContent = "Editar orden: " + columnas[0].textContent;
                    inputs[0].value = columnas[0].textContent;
                    inputs[1].value = columnas[1].textContent;
                    inputs[2].value = columnas[2].textContent;
                    select.value    = columnas[3].textContent;
                    inputs[3].value = columnas[4].textContent;
                    inputs[4].value = columnas[5].textContent;
                    edit_order.setAttribute("data-id", id_orden);
                $("#editar-orden-modal").modal("show");
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
                let url      = "_config/ajax-functions.php?f=addOrder&workorder=" + work_order.value + "&item=" + item.value + "&machine=" + machine.value + "&quantity=" + quantity.value;
                    xmlhttps = new XMLHttpRequest();
                xmlhttps.onreadystatechange = function()
                {
                    if(xmlhttps.readyState == 4 && xmlhttps.status == 200)
                    {
                        let tbody_ordenes = document.querySelector("#tabla-ordenes tbody");

                        tbody_ordenes.innerHTML = this.responseText + tbody_ordenes.innerHTML;
                        //row_ordenes.innerHTML = this.responseText;
                        //tbody_ordenes.insertBefore(row_ordenes, tbody_ordenes.firstChild);

                        work_order.value = "";
                        item.value = "";
                        machine.value = "";
                        quantity.value = "";

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
            if(hc != "" && hc != 0 && pph != "" && pph != 0 ){
                xmlhttps.onreadystatechange = function()
                {
                    if(this.readyState == 4 && this.status == 200)
                    {
                        let item  = document.getElementById("row"+id);
                            orden = document.getElementById("wo"+id).textContent;
                        item.remove();
                        
                        swal("La orden " + orden +" ha comenzado", {
                            icon: "success",
                        });
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
            let inputs   = document.querySelectorAll("#editar-orden-modal input"),
                select   = document.querySelector("#editar-orden-modal select");

            let url      = "_config/ajax-functions.php?f=editOrder&workorder=" + inputs[0].value + "&item=" + inputs[1].value + "&machine=" + select.value + "&quantity=" + inputs[2].value + "&pph=" + inputs[3].value + "&setup=" + inputs[4].value + "&id=" + id,
                xmlhttps = new XMLHttpRequest();

            xmlhttps.onreadystatechange = function()
            {
            if(this.readyState == 4 && this.status == 200)
            {
                    let columnas = document.querySelectorAll("#row"+ id +" td");
                    columnas[0].textContent = inputs[0].value;
                    columnas[1].textContent = inputs[1].value;
                    columnas[2].textContent = inputs[2].value;
                    columnas[3].textContent = select.value;
                    columnas[4].textContent = inputs[3].value;
                    columnas[5].textContent = inputs[4].value;

                    $("#editar-orden-modal").modal("hide");
            }
            };
            xmlhttps.open("GET", url, true);
            xmlhttps.send();
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
                            item.remove();
                            swal("La orden ha sido eliminada", {
                                icon: "success",
                            });   
                        }
                    };
                    xmlhttps.open("GET", url, true);
                    xmlhttps.send();
                } else {
                }
            });
        }

    }
});