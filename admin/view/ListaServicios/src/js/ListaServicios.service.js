! function(a) {
    "use strict";

    function b(a, b) {
        // console.log(c);
        function h(data) {

            var h = b.defer(),
                i = h.promise;
            return a({
                method: "POST",
                url: "api/post/post.servicio.php",
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

        function g(id) {

            var h = b.defer(),
                i = h.promise;
            return a({
                method: "DELETE",
                url: "api/delete/delete.servicio.php?id=" + id,
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
            SaveServicio: h,
            DeleteServicio: g
        }

    }

    a.module("view.ListaServicios.service", [])
        .service("ListaServiciosService", b),
        b.$inject = ["$http", "$q"]
}(angular)