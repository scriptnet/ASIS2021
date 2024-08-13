! function(a) {
    "use strict";

    a.module("view.marcarEmpleado.factory", [])
        .factory("$callReempA", ["$resource", function($resource) {
            return {
                callReemp: $resource('static/get/call.ReemplazosId.php')
                    // callPosPosicionRem: $resource('api/get/call.callposicion.php')
                    // callPosHorario: $resource('api/get/call.callposicion.php')
            }
        }])

}(angular)