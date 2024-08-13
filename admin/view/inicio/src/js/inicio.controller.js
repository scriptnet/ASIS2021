! function(a) {
    "use strict";

    function b(a, b, c) {
        a.cargando1 = true;



        a.queryEmpleados = {
            dia: '',
        };
        a.calldataLaborar = function() {
            a.cargando3 = true;
            a.actualizar = false;

            c.callLaboralEm.get(a.queryEmpleados).$promise.then(function(data) {
                a.cargando1 = false;
                a.cargando3 = false;
                a.countEmpleados = data.CountosEmpleados;

                a.CountEmpleadosLaboran = data.EmpleadosLaboran.length;
                a.Laboran = data.data;
                a.mensaje = data.mess;
                a.stado = data.err;

            }, function(error) {
                a.actualizar = true;
                a.messajeErr = error.statusText;
                if (error.status == -1) {
                    a.messajeErr = "ERROR DE RED";
                }
            });

        }



        a.llamarDataLaboral = function() {
            var dia = b('date')(new Date(), 'EEEE');
            a.queryEmpleados.dia = dia;
            a.calldataLaborar();

        };
        a.llamarDataLaboral();


        // chart js tarde y puntuales

        a.labels = ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC'];
        a.series = ['A tiempo', 'Tardanzas'];
        a.seriesGastos = [
            // 'Gastos Servicios', 
            'Gastos Planilla'
        ];
        a.colors = ['#45b7cd', '#ff6384'];
        a.options = {
            legend: {
                display: true
            },
            title: {
                display: true,
                text: 'Tardanzas y Punualidades'
            }

            // scales: {
            //     yAxes: [{
            //         ticks: {
            //             min: 0,
            //             stepSize: 1
            //         }
            //     }]
            // }
        };
        a.optionsGastos = {
            legend: {
                display: true
            },
            title: {
                display: true,
                text: 'Gastos de Planilla'
            },


        };


        a.data = [
            [0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0]
        ];
        a.dataGastos = [
            [0, 0, 0, 0, 0, 0, 0],
            // [0, 0, 0, 0, 0, 0, 0]
        ];


        a.queryGraficos = {
            ano: b('date')(new Date(), 'yyyy'),
        };
        a.llamarGraficos = function() {

            a.promise = c.callGrafico1.get(a.queryGraficos, queryGraficos).$promise;



            a.cargando2 = true;
            a.actualizar = false;
            c.callGraficoGastos.get(a.queryGraficos).$promise.then(function(data) {
                a.cargando2 = false;
                a.dataGastos = [
                    // data.GastosServicios,
                    data.GastosPlanilla
                ];
                console.log(data);


            }, function(error) {
                a.actualizar = true;
                a.messajeErr = error.statusText;
                if (error.status == -1) {
                    a.messajeErr = "ERROR DE RED";
                }
            });

        }
        a.llamarGraficos();

        function queryGraficos(data) {
            a.data = [
                data.puntual,
                data.tarde
            ];
            // console.log(data);
        }




    }

    a.module("view.inicio.controller", [])
        .controller("inicioController", b)
        .filter("quitaLetra", function() {
            return function(palabra) {
                if (palabra) {
                    if (palabra.length > 1)
                        return palabra.substr(0, 1);
                    else
                        return palabra;
                }
            }
        }),
        b.$inject = ["$scope", "$filter", "$callinicio"]
}(angular)