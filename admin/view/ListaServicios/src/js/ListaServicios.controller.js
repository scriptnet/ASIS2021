! function(a) {
    "use strict";

    function b(a, b, c, d) {
        a.cargando1 = true;
         a.servicios = {};
        // llamamos A LOS EMPLEADOS
        a.queryServicios = {
            filter: '',
            limit: '5',
            page: 1
        };
        a.callListaServicios = function() {
            a.promise = b.callListaServicios.get(a.queryServicios, respuesta).$promise;

        }
        a.callListaServicios();

        function respuesta(data) {
            // console.log(data);
             a.servicios = data.tbl_servicios;
    // console.log(a.servicios);
             a.cargando1 = false;
        }



        a.editServicio = function(datos) {

            a.title = "Editar Servicio";
            // console.log(datos);
            a.ServicioSelect = datos;
            var fechaA = datos.Ser_Fecha.split(/[- :]/);

            a.Ser_Fecha = new Date(fechaA[0], fechaA[1] - 1, fechaA[2]);

            // var aux = "2021-02-09 00:00:00".split(/[- :]/);
            // var vdate = new Date(aux[0], aux[1] - 1, aux[2], aux[3], aux[4], aux[5]);
            // console.log(fechaA);
            $("#editServicio").modal();

        }

        a.NuevoServicio = function() {
            a.Ser_Fecha = new Date();
            a.title = "Nuevo Servicio";
            a.ServicioSelect = {};
            $("#editServicio").modal();
        }


        a.format = 'dd/MM/yyyy';

        a.guardarServicio = function(data) {



            var CleanData = {
                "Serv_Descripcion": data.Serv_Descripcion,
                "Serv_Monto": data.Serv_Monto,
                "fecha": d('date')(new Date(a.Ser_Fecha), 'yyyy/MM/dd'),
                "id_Serv": data.id_Serv
            }
            console.log(CleanData);
            c.SaveServicio(CleanData).then(function(res) {
                a.callListaServicios();
                $("#editServicio").modal('hide');
            })
        }

        a.eliminarServicio = function(id) {

            c.DeleteServicio(id).then(function(res) {
                a.callListaServicios();

            })
        }




        // console.log(a.ServicioSelect.dates);

    }

    a.module("view.ListaServicios.controller", [])
        .controller("ListaServiciosController", b),
        b.$inject = ["$scope", "$callListaServicios", "ListaServiciosService", "$filter"]
}(angular)