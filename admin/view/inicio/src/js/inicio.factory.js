! function(a) {
    "use strict";

    a.module("view.inicio.factory", [])
        .factory("$callinicio", ["$resource", function($resource) {
            return {
                callLaboralEm: $resource('api/get/call.callaboraEmple.php'),
                callGrafico1: $resource('api/get/call.graficos.php'),
                callGraficoGastos: $resource('api/get/call.graficosGastosMensuales.php')
                    // callPosPosicion: $resource('api/get/call.callposicion.php')
                    // callPosHorario: $resource('api/get/call.callposicion.php')
            }
        }])

}(angular)