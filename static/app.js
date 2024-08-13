! function(a) {

    var isDlgOpen;
    var ACTION_RESOLVE = 'undo';
    var UNDO_KEY = 'z';
    var DIALOG_KEY = 'd';

    function b(a, b, c, d, e, f, g) {

        a.STADO = false;
        a.STADOMENSAJE = "MARCAR";
        a.datacod = '';
        var ctrl = this;
        var message = '';

        ctrl.addNumber = function(number) {
            a.datacod = a.datacod + number;
        }
        ctrl.deletenumber = function() {
            a.datacod = a.datacod.slice(0, a.datacod.length - 1);
        }
        ctrl.clearnumbre = function() {
            a.datacod = '';
        }



        ctrl.showCustomToast = function(data) {
            a.STADOMENSAJE = "Esperando Respuesta";
            a.datacod = '';
            // enviamos y preparamos la data
            var time = f('date')(new Date(), 'HH:mm:ss');
            var dia = f('date')(new Date(), 'EEEE');
            var fecha = f('date')(new Date(), 'yyyy/MM/dd');

            var datajson = {
                "dia": dia,
                "horaMarcada": time,
                "codDni": data,
                "fechaNow": fecha,
                "idSelect": null,
                "puestoId": null
            };

            e.savemarcacion(datajson).then(function(data) {
                a.STADOMENSAJE = "MARCAR";
                a.messages = data.data.mensaje;
                a.typeModal = data.data.typeModal;
                if (a.typeModal == undefined) {
                    a.typeModal = 1;
                }
                a.DataReempl = data.data.dataRemp;


                c.show({
                    hideDelay: 3000,
                    position: 'top right',
                    controller: 'ToastCtrl',
                    controllerAs: 'ctrl',
                    bindToController: true,
                    locals: { toastMessage: a.messages, typeModal: a.typeModal, DataReempl: a.DataReempl },
                    templateUrl: 'notificacion.html'
                }).then(function(result) {
                    if (result === ACTION_RESOLVE) {
                        d.log('Undo action triggered by button.');
                    } else if (result === 'key') {
                        d.log('Undo action triggered by hot key: Control-' + UNDO_KEY + '.');
                    } else if (result === false) {
                        d.log('Custom toast dismissed by Escape key.');
                    } else {
                        d.log('Custom toast hidden automatically.');
                    }
                }).catch(function(error) {
                    d.error('Custom toast failure:', error);
                });


            });


        };


        a.key = '';

        g.$on('keypress', function(evt, obj, key) {

            if (event.which === 13) {
                if (a.datacod.length === 8) {

                    ctrl.showCustomToast(a.datacod);
                }


            }
            if (event.which === 8) {
                a.$apply(function() {
                    a.datacod = a.datacod.slice(0, a.datacod.length - 1);
                });

            }


            if (event.which > 95 && event.which < 106) {
                a.$apply(function() {
                    a.datacod += event.key;
                    a.datacod = a.datacod.trim();
                });

            }



        })

    }

    function c(a, b, c, d, e) {
        var ctrl = this;
        ctrl.keyListenerConfigured = false;
        ctrl.undoKey = UNDO_KEY;
        ctrl.dialogKey = DIALOG_KEY;

        ctrl.openMoreInfo = function(ev, reemplazoId) {



            a.queryReemplazos = {
                filter: reemplazoId.CodEmpl,
                limit: '500',
                page: 1
            };



            e.callReemp.get(a.queryReemplazos).$promise.then(function(data) {
                // si todo va bien abre modal
                // console.log(reemplazoId);

                b.show({
                        controller: 'DialogController',
                        controllerAs: 'REM',
                        parent: angular.element(document.body),
                        bindToController: true,
                        locals: { MarcReemplazo: reemplazoId, ReemplazoNom: data.ReemplazoNom, Reemplazados: data.Reemplazados },
                        targetEvent: ev,
                        clickOutsideToClose: true,
                        fullscreen: a.customFullscreen,
                        templateUrl: 'dialog-detalles.html'
                    })
                    .then(function(answer) {
                        ctrl.status = 'You said the information was "' + answer + '".';
                    }, function() {
                        ctrl.status = 'You cancelled the dialog.';
                    });


            }, function(error) {
                b.show(
                    b.alert()
                    .parent(angular.element(document.querySelector('#popupContainer')))
                    .clickOutsideToClose(true)
                    .title('Algo Salió mal')
                    .textContent('Comunicate con el ADMINISTRADOR')
                    .ariaLabel('Alert Dialog Demo')
                    .ok('CERRAR')
                    .targetEvent(ev)
                );
            })


        };


    }


    function d(a, b, c, e) {
        a.hide = function() {
            b.hide();
        };

        a.cancel = function() {
            b.cancel();
        };

        a.answer = function(answer) {
            b.hide(answer);
        };

        a.disabledStateB = false;

        a.SeleccionadoId = function(selectCod, MarcReemplazo, ToPuesto) {
            a.disabledStateB = true;
            var datajson = {
                "dia": MarcReemplazo.diaM,
                "horaMarcada": MarcReemplazo.horaMarcada,
                "codDni": MarcReemplazo.CodEmpl,
                "fechaNow": MarcReemplazo.FechaMarcada,
                "idSelect": selectCod,
                "puestoId": ToPuesto
            };

            // console.log(datajson);
            c.savemarcacion(datajson).then(function(data) {
                console.log(data);
                a.messages = data.data.mensaje;
                a.typeModal = data.data.typeModal;
                if (a.typeModal == undefined) {
                    a.typeModal = 1;
                }
                a.DataReempl = data.data.dataRemp;
                console.log(data);

                e.show({
                    hideDelay: 3000,
                    position: 'top right',
                    controller: 'ToastCtrl',
                    controllerAs: 'ctrl',
                    bindToController: true,
                    locals: { toastMessage: a.messages, typeModal: a.typeModal, DataReempl: a.DataReempl },
                    templateUrl: 'notificacion.html'
                }).then(function(result) {

                }).catch(function(error) {

                });


            });



            b.hide();


            // console.log(datajson);
        }
    }

    function e(a, b) {
        return {
            restrict: 'A',
            link: function() {
                // console.log('linked');
                // keypress
                a.bind('keydown', function(e) {
                    // console.log(e);
                    b.$broadcast('keypress', e, String.fromCharCode(e.which));
                });
            }
        }
    }


    a.module("scriptnet", ['ngMaterial', 'ngResource', 'ngMessages', 'ui.bootstrap', 'view.marcarEmpleado.service', 'view.marcarEmpleado.factory'])
        .directive('keypressEvents', e)
        .controller("horarioCtrl", b)
        .controller("ToastCtrl", c)
        .controller("DialogController", d);
    b.$inject = ["$scope", "$mdDialog", "$mdToast", "$log", "MarcarEmpleadoService", "$filter", "$rootScope"];
    c.$inject = ["$mdToast", "$mdDialog", "$document", "$scope", "$callReempA"];
    d.$inject = ["$scope", "$mdDialog", "MarcarEmpleadoService", "$mdToast"];
    e.$inject = ["$document", "$rootScope"];

}(angular)