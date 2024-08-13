! function(a) {
    "use strict";

    a.module("view.puestos.factory", [])
        .factory("$callpuestos", ["$resource", function($resource) {
            return {
                callPuestos: $resource('api/get/call.puestos.php')
                    // callPosHorario: $resource('api/get/call.callposicion.php')
            }
        }])

}(angular)