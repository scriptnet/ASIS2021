! function(a) {
    function b(a, b, c) {

        return {
            loadMyCtrl: ["$ocLazyLoad", "$rootScope", "$timeout", function(d, e, f) {
                var g = [].concat(a, b || []);
                return e[c] = !0, d.load(g).then(function() {
                    f(function() {
                        e[c] = !1
                    }, 1e3)
                })
            }]
        }
    }

    function c(a, c, d) {
        d.hashPrefix('scriptnet');
        c.otherwise('/index'),
            a.state("menu", {
                url: '/index',
                templateUrl: "view/inicio/templates/inicio.html",
                controller: "inicioController",
                resolve: b("view.inicio.content", [])
            }).state("agregar_empleado", {
                url: '/agregar_empleado',
                // params: {
                //     key: null
                // },
                templateUrl: "view/agregarEmpleado/templates/agregarEmpleado.html",
                controller: "agregarEmpleadoController",
                resolve: b("view.agregarEmpleado.content", [])

            }).state("listar_empleado", {
                url: '/listar_empleado',
                // params: {
                //     key: null
                // },
                templateUrl: "view/listarEmpleados/templates/listar_empleados.html",
                controller: "listarEmpleadosController",
                resolve: b("view.listarEmpleados.content", [])

            }).state("Horarios", {
                url: '/Horarios',
                // params: {
                //     key: null
                // },
                templateUrl: "view/horarios/templates/horarios.html",
                controller: "HorariosController",
                resolve: b("view.Horarios.content", [])

            }).state("asistencia", {
                url: '/asistencia',
                // params: {
                //     key: null
                // },
                templateUrl: "view/asistencias/templates/asistencias.html",
                controller: "asistenciasController",
                resolve: b("view.asistencias.content", [])

            }).state("puestos", {
                url: '/puestos',
                // params: {
                //     key: null
                // },
                templateUrl: "view/puestos/templates/puestos.html",
                controller: "listarpuestosController",
                resolve: b("view.puestos.content", [])

            }).state("adelanto", {
                url: '/adelanto',
                // params: {
                //     key: null
                // },
                templateUrl: "view/adelanto/templates/adelanto.html",
                controller: "listarAdelantoController",
                resolve: b("view.adelanto.content", [])

            }).state("nsueldos", {
                url: '/nsueldos',
                // params: {
                //     key: null
                // },
                templateUrl: "view/nsueldos/templates/nsueldos.html",
                controller: "listarNsueldosController",
                resolve: b("view.nsueldos.content", [])

            }).state("verDetalle", {
                url: '/verDetalle/:codEmpleado/:Nombres/:Apellidos/:tarifa/:hhombe/:tardeHombre/:adelantosA/:DescuentoTarde/:totalNeto/:SueldoBruto/:fechitas/:puesto',
                // params: {
                //     key: null
                // },
                templateUrl: "view/verDetalle/templates/verDetalle.html",
                controller: "verDetalleController",
                resolve: b("view.verDetalle.content", [])

            }).state("ListaServicios", {
                url: '/ListaServicios',
                // params: {
                //     key: null
                // },
                templateUrl: "view/ListaServicios/templates/ListaServicios.html",
                controller: "ListaServiciosController",
                resolve: b("view.ListaServicios.content", [])

            }).state("Reemplazos", {
                url: '/Reemplazos',
                // params: {
                //     key: null
                // },
                templateUrl: "view/Reemplazos/templates/Reemplazos.html",
                controller: "ReemplazosController",
                resolve: b("view.Reemplazos.content", [])

            }).state("exit", {
                url: '/salir',
                // params: {
                //     key: null
                // },
                template: "<label>Saliendo...</label>",
                controller: "ExitController",
                resolve: b("view.exit.content", [])

            })
            .state("config", {
                url: '/config',
                // params: {
                //     key: null
                // },
                templateUrl: "view/config/templates/config.html",
                controller: "ConfigController",
                resolve: b("view.config.content", [])

            })
    }

    a.module("routes", [])
        .config(c),
        c.$inject = ["$stateProvider", "$urlRouterProvider", "$locationProvider"]
}(angular)