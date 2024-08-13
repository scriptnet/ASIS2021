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
                url: "api/post/save.entradaSalida.php",
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


        function e(data) {
            // console.log(data);
            var h = b.defer(),
                i = h.promise;
            return a({
                method: "PUT",
                url: "api/put/put.desactivarHorario.php",
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
            savehora: h,
            desactivarHora: e
        }

    }

    a.module("view.Horarios.service", [])
        .service("HorariosService", b),
        b.$inject = ["$http", "$q"]
}(angular)