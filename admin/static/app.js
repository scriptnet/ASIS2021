! function(a) {

    "use strict";

    function d(b, c, d) {

        d.absUrl = 'sd';


        c.exitSession = function() {
            window.location = "";
        }


        d.isActive = function(viewLocation) {
            console.log(viewLocation);
            // return viewLocation === a.path();
        };





    }

    function navegar($scope, $location) {
        $scope.isActive = function(viewLocation) {
            return viewLocation === $location.path();
        };
    }


    a.module("scriptnet", ['module.third-parties', 'home'])
        .controller("scriptpanel", d)
        .component("navBar", {
            templateUrl: 'view/component/navbar.html',
            bindings: {
                user: '<'
            },
            controller: navegar
        })
        .component("secTion", {
            template: ' <section _ngcontent-c9 class="container list-schedule-transfer"></section',
            bindings: {
                user: '<'
            }
        }).filter("formatoHora", function($filter) {
            return function(date) {
                date = $filter('date')(new Date("December 17, 1995 " + date), ' h:mm a');

                return date;

            }
        }),
        d.$inject = ["$location", "$rootScope", "$scope"]




}(angular);

// directiva