<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="colorlib.com">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Querales-Transferencias</title>

  <!-- Font Icon -->
  <link rel="stylesheet" href="assets/fonts/material-icon/css/material-design-iconic-font.min.css">

  <!-- Main css -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/toastr.min.css">
  <link rel="stylesheet" href="assets/css/datatables.min.css">
  <link rel="stylesheet" href="views/css/transferencia.css">
</head>

<body>

  <div style="padding: 5px;">
    <div class="row">
      <div class="col-12 col-md-2"></div>
      <div class="col-12 col-md-8 card-body">
        <div class="card">
          <div class="card-action blue text-center">
            <h2 id="titulopagina" class="letrasblancas"> Mis transferencias</h2>
          </div>
        </div>
        <div class="col-12 col-md-2"></div>
      </div>
    </div>
    <div>
      <button class="btn btn-success" data-toggle="modal" data-target="#transferenciaModal">Nueva transferencia</button>
    </div>
    <br><br>

    <div class="container-fluid">
      <div class="nav-tabs-navigation">
        <div class="nav-tabs-wrapper">
          <ul class="nav nav-tabs" data-tabs="tabs">
            <li class="nav-item medio green">
              <a class="nav-link active letrasblancas" href="#realizadas" data-toggle="tab">
                Realizadas
              </a>
            </li>
            <li class="nav-item medio orange">
              <a class="nav-link letrasblancas" href="#pendientes" data-toggle="tab">
                Pendientes
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="tab-content">
        <div class="tab-pane active row" id="realizadas">
          <br>
          <div class="col-12 col-sm-12 col-lg-12 margen ">
            <div class="table-responsive">
              <table id="tableRealizadas" class="table table-hover text-center">
                <thead class="text-primary">
                  <th class="text-center">
                    Fecha
                  </th>
                  <!--<th>Descripcion</th>-->
                  <th class="text-center">
                    Nombre
                  </th>
                  <th class="text-center">
                    Cedula
                  </th>
                  <th class="text-center">
                    Monto
                  </th>
                  <th class="text-center">
                    Accion
                  </th>
                </thead>
                <tbody id="tody-realizadas">
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="tab-pane row" id="pendientes">
          <br>
          <div class="col-12 col-sm-12 col-lg-12 margen">
            <div class="table-responsive">
              <table id="tablePendientes" class="table table-hover text-center">
                <thead class="text-primary">
                  <th class="text-center">
                    Fecha
                  </th>
                  <!--<th>Descripcion</th>-->
                  <th class="text-center">
                    Nombre
                  </th>
                  <th class="text-center">
                    Cedula
                  </th>
                  <th class="text-center">
                    Monto
                  </th>
                  <th class="text-center">
                    Detalles
                  </th>
                </thead>
                <tbody id="tody-realizadas">
                </tbody>
              </table>
            </div>
          </div>
        </div>


      </div>




    </div>
  </div>

  <!--Modal de los detalles de una trasnferencia -->
  <div class="modal fade" id="transferenciaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header text-center blue">
          <div class="row completo">
            <div class="col-12 col-md-10">
              <h4 class="modal-title letrasblancas" id="transferenciaModal">Nueva Transferencia</h4>
            </div>
            <div class="col-12 col-md-2">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="letrasblancas" aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>
        </div>

        <!-- Modal body -->
        <div class="modal-body text-center">
            <form id="formEmpleado">
              <div class="row">
              <div class="col-md-12">
                  <div class="form-group row">
                    <div class="col-12 col-md-1"></div>
                    <label class="col-11 col-md-3 bmd-label-floating">Cedula</label>
                    <input name="cedula" type="text" placeholder="Cedula" class="col-11 col-md-7 form-control" onkeypress="soloNumeros(event)" placeholder="monto > 0">
                    <div class="col-1 col-md-1">
                      <input type="checkbox" id="titular" class="form-control" onchange="obtenerCliente()">
                      
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group row">
                    <div class="col-12 col-md-1"></div>
                    <label class="col-12 col-md-3 bmd-label-floating">Nombre: </label>
                    <input name="nombre" placeholder="Nombre" type="text" class="col-12 col-md-7 form-control" onkeypress="return soloLetras(event)">
                    <div class="col-12 col-md-1"></div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group row">
                    <div class="col-12 col-md-1"></div>
                    <label class="col-12 col-md-3 bmd-label-floating">Monto</label>
                    <input name="monto" type="number" min="0" max="10000000000000" class="col-12 col-md-7 form-control" onchange="validarNumero(this)">
                    <div class="col-12 col-md-1"></div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group row">
                    <div class="col-12 col-md-1"></div>
                    <label class="col-12 col-md-3 bmd-label-floating">Banco</label>
                    <select class="col-12 col-md-7 custom-select" id="banco" onchange="cargarCuentas(this)">
                      <option value="0" selected>Seleccione...</option>
                    </select>
                    <div class="col-12 col-md-1"></div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group row">
                    <div class="col-12 col-md-1"></div>
                    <label class="col-12 col-md-3 bmd-label-floating">Cuenta</label>
                    <select class="col-12 col-md-7 custom-select" id="cuenta">
                      <option value="0" selected>Seleccione...</option>
                    </select>
                    <div class="col-12 col-md-1"></div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group row">
                    <div class="col-12 col-md-1"></div>
                    <label class="col-12 col-md-3 bmd-label-floating">Estado: </label>
                    <select class="col-12 col-md-7 custom-select" id="estatus">
                      <option value="1" selected>Realizada</option>
                      <option value="2">Pendiente</option>
                    </select>
                    <div class="col-12 col-md-1"></div>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="registrarTransferencia()">Guardar</button>
        </div>

      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/jquery-ui.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/datatables.min.js"></script>
  <script src="assets/js/jquery.dataTables"></script>
  <script src="views/js/transferencia.js"></script>
  <script src="assets/js/toastr.min.js"></script>
</body>

</html>