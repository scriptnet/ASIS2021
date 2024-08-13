! function(a) {
    "use strict";

    a.module("view.Reemplazos.factory", [])
        .factory("$CallDatosRem", ["$resource", function($resource) {
            return {
                callPuestos: $resource('api/get/call.callPuestosEmp.php'),
                callPosPosicionRem: $resource('api/get/call.callposicion.php'),
                callReemplazos1a: $resource('api/get/call.reemplazos.php')
                    // callPosHorario: $resource('api/get/call.callposicion.php')
            }
        }])

}(angular)