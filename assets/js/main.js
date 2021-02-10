
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
              edit_order          = document.getElementById("edit-order"),
              check_time          = document.querySelectorAll("#time-check"),
              div_time            = document.querySelectorAll("#time");


        //AddEventListeners
        tabla_ordenes.addEventListener("click", control_buttons)
        agregar_orden_btn.addEventListener("click", function() { $("#agregar-orden-modal").modal("show"); })
        confirmar_orden_btn.addEventListener("click", agregar_orden);
        start_order.addEventListener("click", comenzar_orden);
        edit_order.addEventListener("click", function(){editar_orden(this.getAttribute("data-id"))});
        
        for(let i = 0; i < check_time.length; i++)
        {
            check_time[i].addEventListener("change", function(){
                if(check_time[i].checked)
                    div_time[i].style.display = "block";
                else
                    div_time[i].style.display = "none";
            });
        }

        //Functions
        function control_buttons(e)
        {
            e.preventDefault();

            if(e.target.classList.contains("start-order"))
            {
                //comenzar_orden(e.target.getAttribute("data-id"));
                let id_orden = e.target.getAttribute("data-id"),
                    wo       = document.getElementById("wo"+id_orden).textContent,
                    url      = "_config/ajax-functions.php?f=searchOrder&r=start&id="+id_orden,
                    xmlhttps = new XMLHttpRequest();
                    
                xmlhttps.onreadystatechange = function()
                {
                    if(this.readyState == 4 && this.status == 200)
                    {
                        let data = JSON.parse(this.responseText);

                        document.getElementById("headcount").value = data.headcount;
                        document.getElementById("pph-std").value = data.pph;
                    }
                };
                xmlhttps.open("GET", url, true);
                xmlhttps.send();


                document.querySelector("#comenzar-orden-modal .modal-title").textContent = "Comenzar orden: " + wo;

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
                    select   = document.querySelector("#editar-orden-modal select")
                    url      = "_config/ajax-functions.php?f=searchOrder&r=edit&id="+id_orden,
                    xmlhttps = new XMLHttpRequest();
                    
                xmlhttps.onreadystatechange = function()
                {
                    if(this.readyState == 4 && this.status == 200)
                    {
                        let data = JSON.parse(this.responseText);

                        document.querySelector("#editar-orden-modal .modal-title").textContent = "Editar orden: " + data.workorder;
                        inputs[0].value = data.workorder;
                        inputs[1].value = data.item;
                        select.value    = data.maquina;
                        inputs[2].value = data.cantidad;
                        inputs[3].value = data.pph;
                        inputs[4].value = data.setup;
                        inputs[5].value = data.headcount1;
                        inputs[6].value = data.headcount2;
                        inputs[7].value = data.headcount3;
                    }
                };
                xmlhttps.open("GET", url, true);
                xmlhttps.send();
                edit_order.setAttribute("data-id", id_orden);
                edit_order.setAttribute("data-actual", 0);
                $("#editar-orden-modal").modal("show");
            }
        }
    }

    /**************************************** -------------- ACTUAL ORDERS PAGE -------------- ****************************************/
    if(window.location.pathname == "/horaxhora/ordenes_actuales.php")
    {
        const table_actuales = document.getElementById("tabla-ordenes-actuales"),
              edit_order     = document.getElementById("edit-order");

        table_actuales.addEventListener("click", control_buttons_actuales);
        edit_order.addEventListener("click", function(){editar_orden(this.getAttribute("data-id"))});

        function control_buttons_actuales(e)
        {
            e.preventDefault();

            if(e.target.classList.contains("complete-order"))
            {
                completar_orden(e.target.getAttribute("data-id"), e.target.parentElement.parentElement);
            }
            else if(e.target.classList.contains("pause-order"))
            {
                pausar_orden(e.target.getAttribute("data-id"), e.target.parentElement.parentElement);
            }
            else if(e.target.classList.contains("edit-order"))
            {
                let id_orden = e.target.getAttribute("data-id"),
                    columnas = e.target.parentElement.parentElement.querySelectorAll("td"),
                    inputs   = document.querySelectorAll("#editar-orden-modal input"),
                    select   = document.querySelector("#editar-orden-modal select")
                    url      = "_config/ajax-functions.php?f=searchOrder&r=edit&id="+id_orden,
                    xmlhttps = new XMLHttpRequest();
                    
                xmlhttps.onreadystatechange = function()
                {
                    if(this.readyState == 4 && this.status == 200)
                    {
                        let data = JSON.parse(this.responseText);

                        document.querySelector("#editar-orden-modal .modal-title").textContent = "Editar orden: " + data.workorder;
                        inputs[0].value = data.workorder;
                        inputs[1].value = data.item;
                        select.value    = data.maquina;
                        inputs[2].value = data.cantidad;
                        inputs[3].value = data.pph;
                        inputs[4].value = data.setup;
                        inputs[5].value = data.headcount1;
                        inputs[6].value = data.headcount2;
                        inputs[7].value = data.headcount3;

                        
                        inputs[0].readOnly = true;
                        inputs[1].readOnly = true;
                        inputs[2].readOnly = true;
                        inputs[3].readOnly = true;
                        inputs[4].readOnly = true;
                    }
                };
                xmlhttps.open("GET", url, true);
                xmlhttps.send();
                edit_order.setAttribute("data-id", id_orden);
                edit_order.setAttribute("data-actual", 1);
                $("#editar-orden-modal").modal("show");
            }
        }
    }

    /**************************************** -------------- INDEX PAGE -------------- ****************************************/
    if(window.location.pathname == "/horaxhora/index.php" || window.location.pathname == "/horaxhora/")
    {
        setTimeout(function(){
            if(document.querySelector("#titulo h6").textContent == "")
                $("#index").modal("show");
        }, 1000);


        const modal_plants  = document.querySelector("#index"),
              change_plants = document.getElementById("change-plants"),
              horaxhora     = document.getElementById("horaxhora"),
              cargar        = document.getElementById("cargar"),
              actual        = document.getElementById("actual"),
              completas     = document.getElementById("completas"),
              reporte       = document.getElementById("reporte");


        modal_plants.addEventListener("click", control_plants);
        change_plants.addEventListener("click", control_plants);


        function control_plants(e)
        {
            e.preventDefault();
            
            let plant = 1;
            if(e.target.classList.contains("plant-1"))
                plant = 1;
            else if(e.target.classList.contains("plant-2"))
                plant = 2;
            else if(e.target.classList.contains("plant-3"))
                plant = 3;

            horaxhora.setAttribute("href", "horaxhora.php?plant="+plant);
            cargar.setAttribute("href", "cargar_ordenes.php?plant="+plant);
            actual.setAttribute("href", "ordenes_actuales.php?plant="+plant);
            completas.setAttribute("href", "ordenes_completadas.php?plant="+plant);
            reporte.setAttribute("href", "reporteA.php?plant="+plant); 

            document.querySelector("#titulo h6").textContent = "Planta "+plant;
            $("#index").modal("hide");
        }
    }

    /**************************************** -------------- NO INDEX PAGE -------------- ****************************************/
    if(window.location.pathname != "/horaxhora/index.php" && window.location.pathname != "/horaxhora/")
    {
        const change_plants = document.getElementById("change-plants");
        change_plants.addEventListener("click", control_plants);

        function control_plants(e)
        {
            e.preventDefault();
            
            let plant = 0;
            
            if(e.target.classList.contains("plant-1"))
                plant = 1;
            else if(e.target.classList.contains("plant-2"))
                plant = 2;
            else if(e.target.classList.contains("plant-3"))
                plant = 3;
            if(plant > 0)
                window.location.assign("/horaxhora/?plant="+plant);
        }
    }
});

    /**************************************** -------------- FUNCTIONS -------------- ****************************************/


    function agregar_orden()
    {
        let work_order = document.getElementById("work-order"),
            item       = document.getElementById("item"),
            machine    = document.getElementById("machine"),
            quantity   = document.getElementById("quantity");

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
            let url      = "_config/ajax-functions.php?f=addOrder";
                xmlhttps = new XMLHttpRequest();

            let data = new FormData();
            data.append("workorder", work_order.value);
            data.append("item", item.value);
            data.append("machine", machine.value);
            data.append("quantity", quantity.value);

            console.log(data);
            xmlhttps.onreadystatechange = function()
            {
                if(xmlhttps.readyState == 4 && xmlhttps.status == 200)
                {
                    console.log(this.responseText);
                    let tbody_ordenes = document.querySelector("#tabla-ordenes tbody");

                    tbody_ordenes.innerHTML += this.responseText;
                    //row_ordenes.innerHTML = this.responseText;
                    //tbody_ordenes.insertBefore(row_ordenes, tbody_ordenes.firstChild);

                    work_order.value = "";
                    item.value = "";
                    machine.value = "";
                    quantity.value = "";
                    time.value = "";
                    //console.log(this.responseText);

                    $("#agregar-orden-modal").modal("hide");

                }
            };
            xmlhttps.open("POST", url, true);
            xmlhttps.send(data);
            //console.log(url);
        }
        else
        {
            swal ( "Debes llenar todos los datos.", "" ,  "error" ); //Alert of sweetalert.js
        }
    }
    function comenzar_orden()
    {
        let id   = document.getElementById("start-order").getAttribute("data-id"),
            hc   = document.getElementById("headcount").value,
            pph  = document.getElementById("pph-std").value,
            time = document.getElementById("time-input-start"),
            url  = "_config/ajax-functions.php?f=startOrder&id=" + id + "&pph=" + pph + "&hc=" + hc,
            xmlhttps = new XMLHttpRequest();

        if(time.value)
        {
            url += "&time="+time.value;
        }
        
        console.log(url)

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
        const edit_order     = document.getElementById("edit-order");

        let inputs   = document.querySelectorAll("#editar-orden-modal input"),
            select   = document.querySelector("#editar-orden-modal select"),
            actual   = edit_order.getAttribute("data-actual"); ;

        let url      = "_config/ajax-functions.php?f=editOrder&id=" + id,
            xmlhttps = new XMLHttpRequest();

        let data = new FormData();

        data.append("workorder", inputs[0].value);
        data.append("item", inputs[1].value);
        data.append("machine", select.value);
        data.append("quantity", inputs[2].value);
        data.append("pph", inputs[3].value);
        data.append("setup", inputs[4].value);
        data.append("headcount1", inputs[5].value);
        data.append("headcount2", inputs[6].value);
        data.append("headcount3", inputs[7].value);
        data.append("actual", actual);
        
        xmlhttps.onreadystatechange = function()
        {
        if(this.readyState == 4 && this.status == 200)
        {
            if(actual == 0)
            {
                let columnas = document.querySelectorAll("#row"+ id +" td");
                columnas[0].textContent = inputs[0].value;
                columnas[1].textContent = inputs[1].value;
                columnas[2].textContent = inputs[2].value;
                columnas[3].textContent = select.value;
                columnas[4].textContent = inputs[3].value;
                columnas[5].textContent = inputs[4].value;
            }

            $("#editar-orden-modal").modal("hide");
        }
        };
        xmlhttps.open("POST", url, true);
        xmlhttps.send(data);
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
    function completar_orden(id, item)
    {
        swal({
            title: "Completar Orden",
            text: "¿Desea completar la orden?",
            icon: "info",
            buttons: [true, "Completar"],
        })
        .then((willComplete) => {
            if (willComplete) {
                let url      = "_config/ajax-functions.php?f=completeOrder&id=" + id,
                    xmlhttps = new XMLHttpRequest();
                xmlhttps.onreadystatechange = function()
                {
                    if(xmlhttps.readyState == 4 && xmlhttps.status == 200)
                    {            
                        console.log(this.responseText);   
                        if(this.responseText.trim() !== '')
                        {
                            let data = JSON.parse(this.responseText);
                            item.remove();
                            swal({
                                title: "La orden se ha completado exitosamente!",
                                text: "¿Desea comenzar la siguiente orden orden ("+ data.workorder +")?",
                                icon: "success",
                                buttons: [true, "Comenzar"],
                            })   
                            .then((willNext) => {
                                if(willNext)
                                {
                                    document.getElementById("start-order").setAttribute("data-id", data.id);
                                    document.getElementById("headcount").value = data.headcount;
                                    document.getElementById("pph-std").value = data.pph;

                                    document.getElementById("start-order").addEventListener("click", comenzar_orden);

                                    $("#comenzar-orden-modal").modal("show");
                                }
                            });
                        }      
                        else
                        {
                            item.remove();
                            swal({
                                title: "La orden se ha completado exitosamente!",
                                icon: "success",
                            })  
                        }       
                        
                    }
                };
                xmlhttps.open("GET", url, true);
                xmlhttps.send();
            } else {
            }
        });
    }
    function pausar_orden(id, item)
    {
        swal({
            title: "Pausar Orden",
            text: 'Ingrese motivo de interrupción, si aplica.',
            content: "input",
            icon: "info",
            buttons: [true, "Pausar"],
        })
        .then((willPause) => {
            if (willPause != null) {
                let url      = "_config/ajax-functions.php?f=pauseOrder&id=" + id,
                    xmlhttps = new XMLHttpRequest(),
                    data     = new FormData();

                data.append("reason", willPause);
                xmlhttps.onreadystatechange = function()
                {
                    if(xmlhttps.readyState == 4 && xmlhttps.status == 200)
                    {
                        item.remove();
                        swal("La orden ha sido pausada con exito", {
                            icon: "success",
                        });   
                    }
                };
                xmlhttps.open("POST", url, true);
                xmlhttps.send(data);
            } else {
            }
        });
    }