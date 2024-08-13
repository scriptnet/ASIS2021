! function(a) {
    "use strict";

    function b(a, b) {
        // console.log(c);


        function h(data) {

            var h = b.defer(),
                i = h.promise;
            return a({
                method: "GET",
                url: "api/get/get.empleado.php?id=" + data

            }).then(function successCallback(data) {

                    var f = {
                        data: data.data.resDni,
                        status: data.status,

                    };

                    h.resolve(f)
                },
                function errorCallback() {

                }), i
        }

        function e(data) {

            var h = b.defer(),
                i = h.promise;
            return a({
                method: "POST",
                url: "api/post/save.detalleAdelanto.php",
                data: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }

            }).then(function successCallback(data) {
                    console.log(data);
                    var f = {
                        data: data.data.resDni,
                        status: data.status,

                    };

                    h.resolve(f)
                },
                function errorCallback() {

                }), i
        }
        return {
            callDni: h,
            saveDetalle: e
        }

    }

    a.module("view.nsueldos.service", [])
        .service("listarNsueldosService", b),
        b.$inject = ["$http", "$q"]
}(angular)