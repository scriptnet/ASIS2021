! function(a) {
    "use strict";

    a.module("view.nsueldos.factory", [])
        .factory("$callnsueldos", ["$resource", function($resource) {
            return {
                callNsueldos: $resource('api/get/call.nsueldos.php')
                    // callPosHorario: $resource('api/get/call.callposicion.php')
            }
        }])

}(angular)