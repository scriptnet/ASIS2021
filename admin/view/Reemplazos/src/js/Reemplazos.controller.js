! function(a) {
    "use strict";

    function b(a, b, c, d) {

        // =============================================
        //  llamar puestos
        //==============================================

        a.calldatausuarios = function() {
            a.promise = c.callPosPosicionRem.get(respuesta).$promise;
        }
        a.calldatausuarios();


        function respuesta(data) {
            a.posiciondata = data.tbl_posicion;

        }
        a.queryReemplazos = {
            filter: '',
            limit: '200',
            page: 1
        };
        a.callReemplazos = function() {
            a.actualizar = false;
            a.cargando1 = true;
            c.callReemplazos1a.get(a.queryReemplazos).$promise.then(function(data) {
                // console.log(data.tbl_empleado);
                a.ReemplazosData = data.tbl_empleado;
                a.cargando1 = false;

            }, function(error) {

                a.actualizar = true;
                a.messajeErr = error.statusText;
                if (error.status == -1) {
                    a.messajeErr = "ERROR DE RED";
                }

            });

        }
        a.callReemplazos();




        // =============================================
        // buscar remplazo
        //==============================================

        a.selectedItemChange = selectedItemChange;
        a.selectedItemChangeFrom = selectedItemChangeFrom;

        var BACKEND_URL = "api/get";
        a.query = function(searchText) {
            return b
                .get(BACKEND_URL + '/call.AutoCompletEmpleados.php?filter=' + searchText)
                .then(function(data) {


                    var datas = data.data.EMPLEADOS;
                    if (datas == undefined) {
                        datas = [];
                    }
                    // console.log(datas);
                    return datas;
                });
        };

        // armamos el query
        a.ReempazoQuery = {
            'Nombres': '',
            'NombresFrom': '',
            'to': '',
            'from': '',
            'HorarioPuesto': '',
            'puestoNombre': ''
        };

        function selectedItemChange(item) {

            if (item != undefined) {
                a.LimpiarDetalles(true);
                a.pasos = {
                    'npaso': 'Paso 1',
                    'mess': 'Seleccionar su puesto'
                };

                a.ReempazoQuery.Nombres = item.E_Apellidos + ' ' + item.E_Nombres;
                a.ReempazoQuery.to = item.E_DNI;

                // console.log(item);
                // a.modalState(true);
                // llamamos los puestos
                a.actualizar2 = false;
                a.cargando2 = true;
                a.showpuesto = true;
                a.queryPuestosD = {
                    cod: item.E_DNI
                };
                c.callPuestos.get(a.queryPuestosD).$promise.then(function(data) {
                    // console.log(data);
                    a.puestosD = data.data;
                    a.errorVacio = data.err;
                    a.mensajeVacio = "";
                    if (a.errorVacio) {
                        a.mensajeVacio = "No hay puestos";
                    }

                    a.cargando2 = false;


                }, function(error) {
                    a.actualizar2 = true;
                    a.messajeErr = error.statusText;
                    if (error.status == -1) {
                        a.messajeErr = "ERROR DE RED";
                    }
                });


            }
        }

        a.llamarHorarioV2 = function(puesto) {
            // console.log(puesto);
            a.ReempazoQuery.HorarioPuesto = puesto.id_Posicion;
            a.ReempazoQuery.puestoNombre = puesto.P_Descripcion;
            a.pasos = {
                'npaso': 'Paso 2',
                'mess': 'Será reemplazado por:'
            };
            a.ReemplazoShow = true;
        }
        a.modalState = function(state) {
                a.ModalActive = state;
            }
            // a.modalState(true);


        a.FinalShow = false;

        function selectedItemChangeFrom(item) {

            if (item != undefined) {
                // console.log(item);
                a.ReempazoQuery.NombresFrom = item.E_Apellidos + ' ' + item.E_Nombres;
                a.ReempazoQuery.from = item.E_DNI;
                a.FinalShow = true;
                // console.log(a.ReempazoQuery);
            }
        }

        a.LimpiarDetalles = function(state) {
            a.globalContent = state;
            a.showpuesto = false;
            a.FinalShow = false;
            a.ReemplazoShow = false;
            a.ErrorSave = "";
        }
        a.LimpiarDetalles(true);

        // guardamos la data

        a.saveData = function(data) {

            d.SaveReemplazo(data).then(function(data) {

                if (data.data.err) {
                    a.ErrorSave = data.data.Mensaje;

                } else {
                    a.ErrorSave = "";
                    a.LimpiarDetalles();
                    a.callReemplazos();
                }

            });
        }

        a.DisabledRem = function(idReem) {
            d.DisabledReem(idReem).then(function(data) {
                if (data.data.err) {

                } else {


                    a.callReemplazos();

                }
            });


        }

    }

    a.module("view.Reemplazos.controller", [])
        .controller("ReemplazosController", b),
        b.$inject = ["$scope", "$http", "$CallDatosRem", "ReemplazosService"]
}(angular)