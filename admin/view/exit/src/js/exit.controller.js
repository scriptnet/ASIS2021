! function(a) {
    "use strict";

    function b(a) {
        window.location = 'api/destroy.php';
        // console.log(a);
    }

    a.module("view.exit.controller", [])
        .controller("ExitController", b),
        b.$inject = ["$scope"]
}(angular)