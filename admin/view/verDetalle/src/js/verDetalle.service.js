! function(a) {
    "use strict";

    function b(a, b) {
        // console.log(c);
        function h(data) {

            var h = b.defer(),
                i = h.promise;
            return a({
                method: "PUT",
                url: "api/put/put.empleado.php",
                data: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(function successCallback(data) {
                    // console.log(data);
                    var f = {
                        data: data.data,
                        status: data.status,

                    };

                    h.resolve(f)
                },
                function errorCallback() {

                }), i
        }
        return {
            editEmpleado: h
        }

    }

    a.module("view.verDetalle.service", [])
        .service("verDetalleService", b),
        b.$inject = ["$http", "$q"]
}(angular)