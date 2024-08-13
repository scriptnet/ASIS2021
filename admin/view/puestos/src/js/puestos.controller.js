! function(a) {
    "use strict";

    function b(a, b, c) {




        a.puestoSele = {};
        // llamamos A LOS EMPLEADOS
        a.queryPuestos = {
            filter: '',
            limit: '100',
            page: 1
        };
        a.calldataPuestos = function() {
            a.actualizar = false;
            a.cargando1 = true;
            b.callPuestos.get(a.queryPuestos).$promise.then(function(data) {
                // console.log(data);
                a.pustosAll = data.tbl_posicion;
                a.paginacion = data;
                a.cargando1 = false;
            }, function(error) {
                a.actualizar = true;
                a.messajeErr = error.statusText;
                if (error.status == -1) {
                    a.messajeErr = "ERROR DE RED";
                }

            });
        }
        a.calldataPuestos();


        // agregar nuevo puesto
        a.nuevoPuesto = function(puesto) {

            if (puesto) {
                a.editText = "Editar Puesto";

                angular.copy(puesto, a.puestoSele);

                $("#nuevo_Modal").modal();
                $('#select2').selectpicker('val', puesto.PosCategoria);

                $('.selectpicker').selectpicker('refresh');
            } else {
                a.editText = "Nuevo Puesto";

                angular.copy(puesto, a.puestoSele);

                $("#nuevo_Modal").modal();
                $('select').selectpicker();
            }

        }

        a.guardarPuesto = function(data) {

            // console.log(data);
            c.savePuesto(data).then(function(res) {
                $("#nuevo_Modal").modal('hide');
                //Limpia el formulario
                a.puestoSele = {};
                // forma.autoValidateFormOptions.resetForm();
                a.calldataPuestos();
            });

        }



    }

    a.module("view.puestos.controller", [])
        .controller("listarpuestosController", b),
        b.$inject = ["$scope", "$callpuestos", "puestosService"]
}(angular)