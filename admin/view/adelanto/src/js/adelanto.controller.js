! function(a) {
    "use strict";

    function b(a, b, c, d) {



        // llamamos A LOS EMPLEADOS
        a.agregar = {
            dniCod: ""
        };

        a.queryAdelanto = {
            filter: '',
            limit: '5',
            page: 1
        };
        a.calldataAdelanto = function() {
            a.actualizar = false;
            a.cargando1 = true;
            b.callAdelanto.get(a.queryAdelanto).$promise.then(function(data) {
                a.adelantos = data.tbl_cashadelanto;
                a.cargando1 = false;
                a.paginacion = data;
            }, function(error) {
                a.actualizar = true;
                a.messajeErr = error.statusText;
                if (error.status == -1) {
                    a.messajeErr = "ERROR DE RED";
                }
            });
        }
        a.calldataAdelanto();


        a.nuevoAdelanto = function() {
            $("#nuevoAdelanto_Modal").modal();

        }

        a.buscarDni = function(id) {

            if (id.dniCod == "") {
                return;
            }


            c.callDni(id.dniCod)
                .then(function(res) {
                    if (res.data) {
                        console.log(res);
                        array(res.data);



                    }

                    // Cotizacion.agregar_detalle(producto);
                    // $scope.agregar.producto_id = "";
                    // $scope.agregar.cantidad = 1;
                });
        }




        a.detalles = [];


        function array(res) {

            a.detalles.push(res);


        }



        a.borrar_detalle = function(item) {

            var index = a.detalles.indexOf(item);
            a.detalles.splice(index, 1);

        }

        a.guardarDetalle = function() {


            c.saveDetalle(a.detalles)
                .then(function(res) {

                    $("#nuevoAdelanto_Modal").modal('hide');
                    a.calldataAdelanto();
                    // Cotizacion.agregar_detalle(producto);
                    // $scope.agregar.producto_id = "";
                    // $scope.agregar.cantidad = 1;
                });


        }



        // EDITAR ADELANTO
        a.editarAdelanto = function(data) {
            a.adelantoSelect = data;
            $("#editar_modal").modal();
        }

        a.guardarAdelanto = function(data) {
            c.EditarAdelanto(data).then(function(res) {
                $("#editar_modal").modal('hide');
                a.calldataAdelanto();
            })
        }

        a.EliminarAdelanto = function(id) {
            c.EliminarAdelanto(id).then(function(res) {
                a.calldataAdelanto();
            })
        }


        // llamar empleados


        a.llamarEmpleados = function() {

            return d
                .get('api/get/call.callempleados.php?filter=' + '&limit=500' + '&page=1')
                .then(function(data) {
                    a.contacts = data.data.tbl_empleado;
                    // console.log(a.contacts);
                    // Map the response object to the data object.
                    return data.data;
                });


        };
        a.llamarEmpleados();

        // ejecucion select




    }

    a.module("view.adelanto.controller", [])
        .controller("listarAdelantoController", b),
        b.$inject = ["$scope", "$callAdelanto", "listarAdelantoService", "$http"]
}(angular)