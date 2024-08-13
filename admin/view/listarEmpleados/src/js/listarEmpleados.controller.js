! function(a) {
    "use strict";

    function b(a, b, c) {

        // llamamos A LOS EMPLEADOS
        a.queryEmpleados = {
            filter: '',
            limit: '100',
            page: 1
        };
        a.calldataEmpleados = function() {
            a.actualizar = false;
            a.cargando1 = true;
            b.callEmpleados.get(a.queryEmpleados).$promise.then(function(data) {
                a.empleados = data.tbl_empleado;
                a.paginacion = data;
                console.log(a.empleados);
                a.cargando1 = false;
            }, function(error) {
                a.actualizar = true;
                a.messajeErr = error.statusText;
                if (error.status == -1) {
                    a.messajeErr = "ERROR DE RED";
                }
            });
            a.promise2 = b.callPosPosicion.get(respuestaPos).$promise;
        }
        a.calldataEmpleados();


        function respuestaPos(data) {
            a.posiciondata = data.tbl_posicion;
            // console.log(a.posiciondata);
            // a.cargando1 = false;
        }


        // editarEmpleado

        a.editEmpleado = function(empleado) {


            a.posicion = empleado.POSICIONES;
            a.arrayPos = [];
            for (var index = 0; index < a.posicion.length; index++) {
                a.arrayPos.push(a.posicion[index].id_Posicion);


            }

            // a.posciArray = arrayPos;


            a.empleadoSelec = empleado;
            a.empleadoSelec.posciArray = a.arrayPos;
            // console.log(a.empleadoSelec.posciArray);
            $("#editarEmpleado").modal();
            $('#select1').selectpicker('val', a.empleadoSelec.posciArray);
            $('.selectpicker').selectpicker('refresh');

        }

        a.guardarEmpleado = function(data) {

            console.log(data);
            c.editEmpleado(data).then(function(params) {


                $("#editarEmpleado").modal('hide');
                a.calldataEmpleados();


            });

        }

        // buscador
        a.$watch('queryEmpleados.filter', function(newValue, oldValue) {



            if (newValue !== oldValue) {
                a.queryEmpleados.page = 1;
                a.calldataEmpleados();
            }

        });
    }

    a.module("view.listarEmpleados.controller", [])
        .controller("listarEmpleadosController", b),
        b.$inject = ["$scope", "$callEmpleados", "listarEmpleadosService"]
}(angular)