! function(a) {
    "use strict";

    a.module("view.asistencias.factory", [])
        .factory("$callasistencias", ["$resource", function($resource) {
            return {
                callAsistencia: $resource('api/get/call.asistencias.php')
                    // callPosHorario: $resource('api/get/call.callposicion.php')
            }
        }])

}(angular)