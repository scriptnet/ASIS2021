! function(a) {
    "use strict";

    function b(a, b) {
        // console.log(c);
        function h(data) {
            // console.log(data);
            var h = b.defer(),
                i = h.promise;
            return a({
                method: "POST",
                url: "static/post/save.marcarAsistencia.php",
                data: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(function successCallback(data) {
                    console.log(data);
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
            savemarcacion: h
        }

    }

    a.module("view.marcarEmpleado.service", [])
        .service("MarcarEmpleadoService", b),
        b.$inject = ["$http", "$q"]
}(angular)