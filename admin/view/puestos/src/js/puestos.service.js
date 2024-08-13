! function(a) {
    "use strict";

    function b(a, b) {
        // console.log(c);
        function h(data) {

            var h = b.defer(),
                i = h.promise;
            return a({
                method: "POST",
                url: "api/post/save.puesto.php",
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
            savePuesto: h
        }

    }

    a.module("view.puestos.service", [])
        .service("puestosService", b),
        b.$inject = ["$http", "$q"]
}(angular)