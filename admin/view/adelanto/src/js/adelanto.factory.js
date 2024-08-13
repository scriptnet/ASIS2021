! function(a) {
    "use strict";

    a.module("view.adelanto.factory", [])
        .factory("$callAdelanto", ["$resource", function($resource) {
            return {
                callAdelanto: $resource('api/get/call.callAdelanto.php')
            }
        }])

}(angular)