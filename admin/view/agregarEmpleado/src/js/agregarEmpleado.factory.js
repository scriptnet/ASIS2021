! function(a) {
    "use strict";

    a.module("view.agregarEmpleado.factory", [])
        .factory("$callPosHorario", ["$resource", function($resource) {
            return {
                callPosPosicion: $resource('api/get/call.callposicion.php'),
                callGetApiRec: $resource('api/get/reniecApi.php')
                    // callPosHorario: $resource('api/get/call.callposicion.php')
            }
        }])

}(angular)