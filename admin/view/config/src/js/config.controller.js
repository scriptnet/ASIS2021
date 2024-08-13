! function(a) {
    "use strict";

    function b(a) {
        // window.location = 'api/destroy.php';
        // console.log(a);
    }

    a.module("view.config.controller", [])
        .controller("ConfigController", b),
        b.$inject = ["$scope"]
}(angular)