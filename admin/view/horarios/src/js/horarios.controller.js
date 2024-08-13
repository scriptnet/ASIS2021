! function(a) {
    "use strict";

    function b(a, b, c, d) {

        a.avisoSelect = true;
        a.MostrarHorario = true;
        a.horariov1 = false;
        // a.borrarHora = new Date("December 17, 1995 03:24:00");

        // function formatAMPM(date) {
        //     var hours = date.getHours();
        //     var minutes = date.getMinutes();
        //     var ampm = hours >= 12 ? 'pm' : 'am';
        //     hours = hours % 12;
        //     hours = hours ? hours : 12; // the hour '0' should be '12'
        //     minutes = minutes < 10 ? '0' + minutes : minutes;
        //     var strTime = hours + ':' + minutes + ' ' + ampm;
        //     return strTime;
        // }

        // llamamos A LOS EMPLEADOS
        a.queryEmpleados = {
            filter: '',
            limit: '50',
            page: 1
        };
        a.calldataEmpleados = function() {
            a.actualizar = false;
            a.cargando1 = true;
            b.callEmpleados.get(a.queryEmpleados).$promise.then(function(data) {
                a.empleados = data.tbl_empleado;
                a.paginacion = data;
                a.cargando1 = false;

            }, function(error) {
                a.actualizar = true;
                a.messajeErr = error.statusText;
                if (error.status == -1) {
                    a.messajeErr = "ERROR DE RED";
                }
            });
        }
        a.calldataEmpleados();


        // buscador
        a.borrar = "Username";
        a.$watch('queryEmpleados.filter', function(newValue, oldValue) {



            if (newValue !== oldValue) {
                a.queryEmpleados.page = 1;
                a.calldataEmpleados();
            }

        });



        // listamos los DIAS
        a.diasListar = function() {
            a.diasSemana = [
                { "id": "1", "nombre": "LUNES" },
                { "id": "2", "nombre": "MARTES" },
                { "id": "3", "nombre": "MIERCOLES" },
                { "id": "4", "nombre": "JUEVES" },
                { "id": "5", "nombre": "VIERNES" },
                { "id": "6", "nombre": "SÁBADO" },
                { "id": "7", "nombre": "DOMINGO" },

            ]
        }
        a.diasListar();



        a.DiaStado = 1;

        // llamamos el horario del empleado/ cuando se selecciona al titulado se mostrara su horario
        a.llamarHorario = function(idEmpleado, dia) {
            // console.log(idEmpleado);
            a.DiaStado = dia;
            a.avisoSelect = false;
            // llamamos el horario
            if (idEmpleado) {
                a.codigoEm = idEmpleado.E_DNI;
                a.datos = idEmpleado;
            } else {
                a.codigoEm = a.codigoEm;
                a.datos = a.datos;
            }
            a.queryHorario = {
                cod: a.codigoEm,
                dia: dia
            };
            a.promise = b.callHorarioDia.get(a.queryHorario, respuestaHorario).$promise;

            function respuestaHorario(data) {
                a.horarios = data.tbl_detallediaempleado;
                // console.log(a.horario);
            }
            // datos del empleado
            a.datos = a.datos;
        }

        a.definirHora = function() {
            a.mytime1 = new Date();
            a.mytime2 = new Date();
            a.hstep = 1;
            a.mstep = 15;
            a.ismeridian = true;

            a.defhora = {
                "hora1": a.mytime1,
                "hora2": a.mytime2
            };
            $("#modal_Hora").modal();
        }

        a.enviarHoraNueva = function(datos) {

            var time1 = d('date')(new Date(datos.hora1), 'HH:mm');
            var time2 = d('date')(new Date(datos.hora2), 'HH:mm');
            a.tratarDatos = {
                "hora1": time1,
                "hora2": time2,
                "codEmpleado": a.datos.E_DNI,
                "idDia": a.DiaStado
            }
            c.savehora(a.tratarDatos).then(function(data) {
                $("#modal_Hora").modal('hide');
                var reloadCodEmpleado = a.codigoEm;
                var reloadDiaStado = a.DiaStado;
                a.llamarHorario(false, reloadDiaStado);
            });
            // console.log(time);
        }

        // llamar puestos 

        a.llamarPuestos = function(idEmpleado) {

            a.datos = idEmpleado;

            a.MostrarHorario = true;
            a.avisoSelect = false;
            a.showpuesto = true;
            a.actualizar2 = false;
            a.cargando2 = true;
            a.queryPuestosD = {
                cod: idEmpleado.E_DNI
            };
            b.callPuestosEmp.get(a.queryPuestosD).$promise.then(function(data) {
                a.puestosD = data.data;
                a.errorVacio = data.err;
                if (a.errorVacio) {
                    a.mensajeVacio = "No hay puestos";
                }
                a.cargando2 = false;


            }, function(error) {
                a.actualizar2 = true;
                a.messajeErr = error.statusText;
                if (error.status == -1) {
                    a.messajeErr = "ERROR DE RED";
                }
            });


        }

        // llamar horario v2

        a.codigoEm = ''
        a.llamarHorarioV2 = function(puesto) {

                // guardamos la info del empleado
                a.MostrarHorario = false;
                a.showpuesto = false;
                a.dataPuesto = puesto;
                // a.datos = idEmpleado;

                // capturamos el codigo del empelado
                a.codigoEm = a.datos.E_DNI;


                // LLAMAMOSLA DATA

                a.queryHorario = {
                    cod: a.codigoEm,
                    puesto: puesto.id_Posicion
                };

                a.actualizar2 = false;
                a.cargando2 = true;
                b.callHorarioV2.get(a.queryHorario).$promise.then(function(data) {

                    a.cargando2 = false;

                    a.lunes = data.lunes;
                    a.martes = data.martes;
                    a.miercoles = data.miercoles;
                    a.jueves = data.jueves;
                    a.viernes = data.viernes;
                    a.sabado = data.sabado;
                    a.domingo = data.domingo;
                }, function(error) {
                    a.actualizar2 = true;

                    a.messajeErr = error.statusText;
                    if (error.status == -1) {
                        a.messajeErr = "ERROR DE RED";
                    }
                });


            }
            // DEFINIMOS NUEVA HORA V2
        a.definirHoraV2 = function(dia) {
            a.mytime1 = new Date();
            a.mytime2 = new Date();
            a.hstep = 1;
            a.mstep = 15;
            a.ismeridian = true;
            // definimos el dia que fue seleccionado
            a.diaSelec = dia;
            a.defhora = {
                "hora1": a.mytime1,
                "hora2": a.mytime2
            };
            a.horaEstadoMess = "";
            $("#modal_Hora").modal();

        }

        // guardamos nueva hora v2
        a.enviarHoraNuevaV2 = function(datos) {


            // validamos si la hora 1 es menor a la hora 2

            var hora1UNIX = moment(datos.hora1).unix();
            var hora2UNIX = moment(datos.hora2).unix();
            if (hora1UNIX == hora2UNIX || hora1UNIX > hora2UNIX) {
                a.horaEstadoMess = "No permitido";
            } else {
                // enviamos la data
                a.horaEstadoMess = "";
                var time1 = d('date')(new Date(datos.hora1), 'HH:mm');
                var time2 = d('date')(new Date(datos.hora2), 'HH:mm');


                a.tratarDatos = {
                    "hora1": time1,
                    "hora2": time2,
                    "codEmpleado": a.codigoEm,
                    "idDia": a.diaSelec,
                    "puesto": a.dataPuesto.id_Posicion,
                }


                c.savehora(a.tratarDatos).then(function(data) {

                    if (data.data.err) {
                        a.horaEstadoMess = data.data.Mensaje;
                    } else {
                        $("#modal_Hora").modal('hide');
                        a.horaEstadoMess = "";
                        a.llamarHorarioV2(a.dataPuesto);
                    }
                    // $("#modal_Hora").modal('hide');
                    // // var reloadCodEmpleado = a.codigoEm;
                    // // var reloadDiaStado = a.DiaStado;
                    // a.llamarHorarioV2(a.dataPuesto);
                });
            }



        }

        a.desactivar = function(id) {

            var idHorario = { "id": id };

            $("#Desactivar_Modal").modal();

            a.confirma = function() {
                c.desactivarHora(idHorario).then(function(data) {
                    $("#Desactivar_Modal").modal('hide');
                    // var reloadCodEmpleado = a.codigoEm;
                    // var reloadDiaStado = a.DiaStado;
                    a.llamarHorarioV2(a.dataPuesto);
                });
            }
        }
    }

    a.module("view.Horarios.controller", [])
        .controller("HorariosController", b),
        b.$inject = ["$scope", "$callEmpleadosHorarios", "HorariosService", "$filter"]
}(angular)