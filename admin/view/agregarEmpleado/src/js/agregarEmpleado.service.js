! function(a) {
    "use strict";

    function b(a, b) {
        // console.log(c);
        function h(data) {

            var h = b.defer(),
                i = h.promise;
            return a({
                method: "POST",
                url: "api/post/save.empleado.php",
                data: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(function successCallback(data) {

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
            save: h
        }

    }

    a.module("view.agregarEmpleado.service", [])
        .service("agregarEmpleadoService", b),
        b.$inject = ["$http", "$q"]
}(angular)