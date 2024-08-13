! function(a) {
    "use strict";


    a.module("view.Horarios.factory", [])
        .factory("$callEmpleadosHorarios", ["$resource", function($resource) {
            return {
                callEmpleados: $resource('api/get/call.callempleados.php'),
                // callHorarioDia: $resource('api/get/call.horarioDia.php'),
                callHorarioV2: $resource('api/get/call.horarioV2.php'),
                callPuestosEmp: $resource('api/get/call.callPuestosEmp.php')
                    // callPosHorario: $resource('api/get/call.callposicion.php')
            }
        }])

}(angular)