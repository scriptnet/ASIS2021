! function(a) {
    "use strict";

    a.module("view.listarEmpleados.factory", [])
        .factory("$callEmpleados", ["$resource", function($resource) {
            return {
                callEmpleados: $resource('api/get/call.callempleados.php'),
                callPosPosicion: $resource('api/get/call.callposicion.php')
                    // callPosHorario: $resource('api/get/call.callposicion.php')
            }
        }])

}(angular)