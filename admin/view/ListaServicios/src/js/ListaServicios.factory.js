! function(a) {
    "use strict";

    a.module("view.ListaServicios.factory", [])
        .factory("$callListaServicios", ["$resource", function($resource) {
            return {
                callListaServicios: $resource('api/get/call.ListaServicios.php')
                    // callPosHorario: $resource('api/get/call.callposicion.php')
            }
        }])

}(angular)