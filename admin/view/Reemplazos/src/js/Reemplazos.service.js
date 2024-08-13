! function(a) {
    "use strict";

    function b(a, b) {
        // console.log(c);
        function h(data) {

            var h = b.defer(),
                i = h.promise;
            return a({
                method: "POST",
                url: "api/post/post.reemplazosEm.php",
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

        function i(data) {

            var h = b.defer(),
                i = h.promise;
            return a({
                method: "PUT",
                url: "api/put/put.reemplazoDisabled.php",
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
            SaveReemplazo: h,
            DisabledReem: i
        }

    }

    a.module("view.Reemplazos.service", [])
        .service("ReemplazosService", b),
        b.$inject = ["$http", "$q"]
}(angular)