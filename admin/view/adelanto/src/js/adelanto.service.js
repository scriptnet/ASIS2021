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
                        data: data.data,
                        // puestos: data.data.puestos,
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

        function f(data) {

            var h = b.defer(),
                i = h.promise;
            return a({
                method: "PUT",
                url: "api/put/put.Adelanto.php",
                data: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }

            }).then(function successCallback(data) {
                    // console.log(data);
                    var f = {
                        data: data.data.resDni,
                        status: data.status,

                    };

                    h.resolve(f)
                },
                function errorCallback() {

                }), i
        }

        function g(id) {

            var h = b.defer(),
                i = h.promise;
            return a({
                method: "DELETE",
                url: "api/delete/delete.Adelanto.php?id=" + id,
                // data: JSON.stringify(data),
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
            saveDetalle: e,
            EditarAdelanto: f,
            EliminarAdelanto: g
        }

    }

    a.module("view.adelanto.service", [])
        .service("listarAdelantoService", b),
        b.$inject = ["$http", "$q"]
}(angular)