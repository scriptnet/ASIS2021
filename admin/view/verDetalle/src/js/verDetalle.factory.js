! function(a) {
    "use strict";

    a.module("view.verDetalle.factory", [])
        .factory("$callverDetalle", ["$resource", function($resource) {
            return {
                callEmpleados: $resource('api/get/call.callempleados.php'),
                callPosPosicion: $resource('api/get/call.callposicion.php')
                    // callPosHorario: $resource('api/get/call.callposicion.php')
            }
        }])

}(angular)