const host = "/querales/controllers/";
var transferencias = {};
var bancos = {};
// Retorna una copia de un objeto, para asignarla a otro objeto y manipularlo, sin alterar el original:
// function copyObjectValuesToAnotherObject(object = {}) {
//   var newObject = {};
//   for (var key in object) {
//     newObject[key] = object[key];
//   }
//   return newObject;
// }

$(document).ready(function () {

  cargarBancos()

  $.ajax({
    type: "POST",
    data: { mode: "loadAll" },
    url: host + "transferenciaController.php",
    success: function (data) {
      var res = JSON.parse(data);
      cargarTransferencias(res["Realizadas"],res["Pendientes"])
    }, error(err) {
      console.log(err);
    }
  })
});

function cargarTransferencias(realizadas,pendientes){
  if ($.fn.DataTable.isDataTable("#tableRealizadas")) {
    $("#tableRealizadas")
      .DataTable()
      .clear()
      .destroy();
  }
  if ($.fn.DataTable.isDataTable("#tablePendientes")) {
    $("#tablePendientes")
      .DataTable()
      .clear()
      .destroy();
  }
      $.each(realizadas, function (index, transf) {
        transferencias[transf.id] = transf;
        $("#tableRealizadas > tbody").append(
          `<tr id="fila-servicio${transf.id}">
              <td id="fecha${transf.id}">${transf.fecha}</td>
              <td id="nombre${transf.id}">${transf.nombre}</td>
              <td id="cedula${transf.id}">${transf.cedula}</td>
              <td id="monto${transf.id}">${transf.monto}</td>
              <td id="detalles${transf.id}">
              <button type="button" class="btn btn-link btn-primary col-4" title="See more"
              onclick="verDetallesOrden(${transf.id})" data-toggle="tooltip"
              data-placement="top">
              <i class="far fa-address-card"></i>
      </button>
      <button type="button" class="btn btn-link btn-danger col-4" title="Cancel order"
        onclick="cancelarOrden(${transf.id})" data-toggle="tooltip"
        data-placement="top">
        <i class="material-icons">cancel</i>
      </button>
      <button type="button" class="btn btn-link btn-success col-4" title="reschedule"
        onclick="reprogramarOrden(${transf.id})" data-toggle="tooltip"
        data-placement="top">
        <i class="material-icons">assignment</i>
      </button>
           </td>
            </tr>`
        );
      });

      $.each(pendientes, function (index, transf) {
        transferencias[transf.id] = transf;
        $("#tablePendientes > tbody").append(
          `<tr id="fila-servicio${transf.id}">
            <td id="fecha${transf.id}">${transf.fecha}</td>
            <td id="nombre${transf.id}">${transf.nombre}</td>
            <td id="cedula${transf.id}">${transf.cedula}</td>
            <td id="monto${transf.id}">${transf.monto}</td>
            <td id="detalles${transf.id}">
            <button type="button" class="btn btn-link btn-primary col-4" title="See more"
            onclick="verDetallesOrden(${transf.id})" data-toggle="tooltip"
            data-placement="top">
        <i class="material-icons">visibility</i>
    </button>
    <button type="button" class="btn btn-link btn-danger col-4" title="Cancel order"
      onclick="cancelarOrden(${transf.id})" data-toggle="tooltip"
      data-placement="top">
      <i class="material-icons">cancel</i>
    </button>
    <button type="button" class="btn btn-link btn-success col-4" title="reschedule"
      onclick="reprogramarOrden(${transf.id})" data-toggle="tooltip"
      data-placement="top">
      <i class="material-icons">assignment</i>
    </button>
         </td>
          </tr>`
        );
      });

      $("#tableRealizadas").DataTable({
        language: {
          decimal: "",
          emptyTable: "No data available in table",
          info: "Visible _START_ to _END_ de _TOTAL_ entradas",
          infoEmpty: "visible 0 a 0 de 0 entries",
          infoFiltered: "(filtrado para _MAX_ total entradas)",
          infoPostFix: "",
          thousands: ",",
          lengthMenu: "ver _MENU_ entradas",
          loadingRecords: "Cargando...",
          processing: "Procesando...",
          search: "Buscar:",
          zeroRecords: "No se encontraron resultados",
          paginate: {
            first: "Primero",
            last: "Ultimo",
            next: "Siguiente",
            previous: "Anterior"
          }
        },
        order: [[0, "asc"]],
        responsive: true
      });

      $("#tablePendientes").DataTable({
        language: {
          decimal: "",
          emptyTable: "No data available in table",
          info: "Visible _START_ to _END_ de _TOTAL_ entradas",
          infoEmpty: "visible 0 a 0 de 0 entries",
          infoFiltered: "(filtrado para _MAX_ total entradas)",
          infoPostFix: "",
          thousands: ",",
          lengthMenu: "ver _MENU_ entradas",
          loadingRecords: "Cargando...",
          processing: "Procesando...",
          search: "Buscar:",
          zeroRecords: "No se encontraron resultados",
          paginate: {
            first: "Primero",
            last: "Ultimo",
            next: "Siguiente",
            previous: "Anterior"
          }
        },
        order: [[0, "asc"]],
        responsive: true
      });
      $("#tableRealizadas_filter")
        .parent()
        .parent()
        .addClass("green");
      $("#tableRealizadas_length")
        .children()
        .addClass("letrasblancas");
      $("#tableRealizadas_filter")
        .children()
        .addClass("letrasblancas");

      $("#tablePendientes_filter")
        .parent()
        .parent()
        .addClass("orange");
      $("#tablePendientes_filter")
        .children()
        .addClass("letrasblancas");
      $("#tablePendientes_length")
        .children()
        .addClass("letrasblancas");
    
}
function cargarBancos() {
  $.ajax({
    type: "POST",
    data: { mode: "loadCuentas" },
    url: host + "transferenciaController.php",
    success: function (data) {
      var res = JSON.parse(data);
      $.each(res["bancos"], function (index, banco) {
        bancos[banco.id] = banco;
        $("#banco").append("<option value=" + banco.id + ">" + banco.nombre + "</option>")
      });
    }, error(err) {
      console.log(err);
    }
  })
}
function cargarCuentas(banco) {
  $("#cuenta").html("<option value='0' selected>Seleccione...</option>")
  $.each(bancos[banco.value].cuentas, function (index, cuenta) {
    $("#cuenta").append("<option value=" + cuenta.id + ">" + cuenta.nombre + "-" + cuenta.cuenta.substr(cuenta.cuenta.length - 4, cuenta.cuenta.length - 1) + "</option>")

  })
}

function registrarTransferencia() {

  var nombre = $("[name='nombre']").val();//extraer el valor de la caja de texto
  var cedula = $("[name='cedula']").val();
  var monto = $("[name='monto']").val();
  var banco = $("#banco").val();
  var cuenta = $("#cuenta").val();
  var estatus = $("#estatus").val();
  var validacion = true;
  var falta = ""

  if (nombre == "") {

    falta+= "Nombre del cliente";

    validacion = false;
  }
  if (cedula == "") {

    falta+= ",cedula valida";
    validacion = false;
  }
  if (monto == 0) {

    falta+= ", monto valido";
    validacion = false;
  }

  if (banco == undefined || banco == 0) {

    falta+= ", Banco valido";
    validacion = false;
  }
  if (cuenta == undefined || cuenta == 0) {


    falta+= " ,Cuenta valida"
    validacion = false;
  }

  if (validacion) {
    $.ajax({
      type: "POST",
      data: { mode: "insertarTransferencia", nombre: nombre, cedula: cedula, monto: monto, banco: banco, cuenta: cuenta, estatus: estatus },
      url: host + "transferenciaController.php",
      success: function (data) {
        var res = JSON.parse(data);
        toastr.success("Registro guardado exitosamente")
        limpiar()
        console.log(res)
        cargarTransferencias(res["Realizadas"],res["Pendientes"])
        $.ajax({
          type: "POST",
          data: { mode: "registrarporcedula", cedula: cedula },
          url: host + "transferenciaController.php",
          success: function (data) {
            var res = JSON.parse(data);
            console.log(res)
          }
        });
      }
    });
  } else {
    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": true,
      "positionClass": "toast-bottom-full-width",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "hideMethod": "fadeOut"
    }
    toastr.warning("<b>" + falta + "</b> ")
  }
}

function obtenerCliente(){
  var cedula = $("[name='cedula']").val();
  var check = $("#titular")[0].checked;
  if(!check || cedula ==""){
    $("[name='nombre']").val("");
  }else{
    $.ajax({
      type: "POST",
      data: { mode: "obtenercliente", cedula: cedula },
      url: host + "transferenciaController.php",
      success: function (data) {
        var res = JSON.parse(data);
        if(res!=null){
        $("[name='nombre']").val(res.nombres+res.apellidos);
      }
      }
    });
  }
}

function limpiar(){
  $("[name='nombre']").val("")
  var cedula = $("[name='cedula']").val("");
  var monto = $("[name='monto']").val("");
  var banco = $("#banco").val(0);
  var cuenta = $("#cuenta").val(0);
  var estatus = $("#estatus").val(1);
  
}
function soloLetras(e) {
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toLowerCase();
  letras = " abcdefghijklmnopqrstuvwxyz";
  especiales = "8-37-39-46";

  tecla_especial = false
  for (var i in especiales) {
    if (key == especiales[i]) {
      tecla_especial = true;
      break;
    }
  }

  if (letras.indexOf(tecla) == -1 && !tecla_especial) {
    return false;
  }
}

function soloNumeros(e) {
  var key = window.event ? e.which : e.keyCode;
  if (key < 48 || key > 57) {
      //Usando la definición del DOM level 2, "return" NO funciona.
      e.preventDefault();
      //  return false;
  }
   
}

function validarNumero(elemento) {
  var numero = parseFloat($(elemento).val());
  var minimo = parseFloat($(elemento).attr('min'));
  var maximo = parseFloat($(elemento).attr('max'));
  if (isNaN(numero) || numero < minimo) {
    $(elemento).val(minimo);
  } else if (numero > maximo) {
    $(elemento).val(maximo);
  }

}