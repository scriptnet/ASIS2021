! function(a) {
    "use strict";

    function b(a, b, c, d, e, f) {

        a.flagForm = true;
        a.cargando1 = true;
        a.myDate = new Date();

        a.NextStatus = true;
        a.statusHorario = false;
        a.MensajeHorario = "";

        // checkBox DIAS

        a.Dias = [
            { "id": "1", "Nombre": "Lunes" },
            { "id": "2", "Nombre": "Martes" },
            { "id": "3", "Nombre": "Miercoles" },
            { "id": "4", "Nombre": "Jueves" },
            { "id": "5", "Nombre": "Viernes" },
            { "id": "6", "Nombre": "Sábado" },
            { "id": "7", "Nombre": "Domingo" }
        ];
        a.selectedD = [];

        a.toggleD = function(itemD, listD) {
            var idxD = listD.indexOf(itemD);
            if (idxD > -1) {
                listD.splice(idxD, 1);
            } else {
                listD.push(itemD);
            }
        };
        a.existsD = function(itemD, listD) {
            return listD.indexOf(itemD) > -1;
        };

        a.horariosArray = function(status) {
            if (status) {
                if (a.selectedD[0]) {
                    a.statusHorario = false;
                    a.NextStatus = false;
                } else {
                    a.statusHorario = true;
                    a.MensajeHorario = "Selecciona un item.";
                    a.NextStatus = true;
                }

                // console.log(a.selectedD);
            } else {
                a.NextStatus = true;
                a.flagForm = true;
                a.selectedH = [];
            }


        }


        // CHECK BOX HORARIOS
        // llamamos las posiciones y horario

        // multipuessto 



        a.calldatausuarios = function() {
            a.promise = b.callPosPosicion.get(respuesta).$promise;
        }
        a.calldatausuarios();


        function respuesta(data) {
			console.log(data.tbl_posicion);
            a.posiciondata = data.tbl_posicion;


            a.cargando1 = false;

        }

        a.selectedH = [];

        a.toggleH = function(itemH, listH, DiaS) {


            a.flagForm = false;
            var idxH = listH.indexOf(itemH);
            if (idxH > -1) {
                listH.splice(idxH, 1);
            } else {
                // $("#modal_Hora").modal();
                listH.push(itemH);
            }
        };
        a.existsH = function(itemH, listH, DiaS) {
            // console.log(DiaS);
            return listH.indexOf(itemH) > -1;
        };

        // registramos la hora de salida y entrada

        a.mytime = new Date();
        a.hstep = 1;
        a.mstep = 15;
        a.ismeridian = true;

        // Enviamos Data del formulario
        a.enviarData = function(data) {
            // console.log(data);

            a.flagForm = true;

            var empleadoData = { "Nombres": data.Nombres, "Apellidos": data.Apellidos, "Direccion": data.Direccion, "date": data.date, "dni": data.dni, "cel": data.cel, "genero": data.genero, "posicion": data.posicion };

            c.save(empleadoData).then(function(data) {
                console.log(data);
                a.flagForm = false;
                a.mensajeRes = data.data.Mensaje;
                a.errorServer = data.data.err;

                if (a.errorServer) {

                } else {
                    f.go("listar_empleado");
                }

                // console.log(data);

            }, function(a) {
                // g.go("error")
            });
            // console.log(empleadoData);
        }


        a.data = {
                'date': '1990/01/01',
                'posicion': []
            }
            // console.log(a.data);

        a.apiRec = function(dni) {
            a.cargando2 = true;
            a.actualizar = false;
            var datos = {
                "number": dni
            }
            b.callGetApiRec.get(datos).$promise.then(function(data) {

                a.cargando2 = false;
                if (data.err == true) {
                    a.messApi = data.Mensaje;
                } else {
                    a.info = data.reniec[0];

                    a.data = {
                        'Nombres': a.info.NOMBRES,
                        'Apellidos': a.info.PATERNO + " " + a.info.MATERNO,
                        'date': dateFormaterApi(a.info.NACIMIENTO),
                        'dni': a.info.DNI,
                        'genero': a.info.GENERO
                    };
                }
                // console.log(a.info);
            }, function(error) {
                a.actualizar = true;
                a.messajeErr = error.statusText;
                if (error.status == -1) {
                    a.messajeErr = "ERROR DE RED";
                }
            });


        }

        function dateFormaterApi(date) {



            var array = date.split("");

            var resultados = array[0] + array[1] + array[2] + array[3] + "/" + array[4] + array[5] + "/" + array[6] + array[7];

            return resultados;
        }


        // a.selectedItemChange = selectedItemChange;

        // var BACKEND_URL = "api/get";
        // a.query = function(searchText) {
        //     return e
        //         .get(BACKEND_URL + '/call.AutoCompletEmpleados.php?filter=' + searchText)
        //         .then(function(data) {

        //             console.log(data.data.EMPLEADOS);
        //             var datas = data.data.EMPLEADOS;

        //             return datas;
        //         });
        // };

        // function selectedItemChange(item) {
        //     console.log(item);
        //     a.fromRem = item;

        //     // g.info('Item changed to ' + JSON.stringify(item));
        // }


        a.isDisabled = function(pos, select) {

            // a.Pos = pos;
            if (a.data.posicion !== undefined) {
                a.stadoEm = a.data.posicion.length && (select.PosCategoria !== a.data.posicion[0].PosCategoria);
                a.showInputRem = a.stadoEm;
                if (a.data.posicion.length == 0) {
                    a.showInputRem = true;
                }

                // console.log(a.data.posicion);
                return a.stadoEm;


            } else {
                a.fromRem = null;

            }

        }




    }

    a.module("view.agregarEmpleado.controller", [])
        .controller("agregarEmpleadoController", b),
        b.$inject = ["$scope", "$callPosHorario", "agregarEmpleadoService", "$element", "$http", "$state"]
}(angular)