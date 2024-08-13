! function(a) {
    "use strict";

    function b(a) {
        a.config({
            modules: [{
                name: "view.agregarEmpleado.content",
                files: [
                    DreProperties.BASE_HREF + "agregarEmpleado/src/js/agregarEmpleado.controller.js",
                    DreProperties.BASE_HREF + "agregarEmpleado/src/js/agregarEmpleado.factory.js",
                    DreProperties.BASE_HREF + "agregarEmpleado/src/js/agregarEmpleado.service.js",
                    DreProperties.BASE_HREF + "agregarEmpleado/src/agregarEmpleado.module.js"
                ]
            }, {
                name: "view.listarEmpleados.content",
                files: [
                    DreProperties.BASE_HREF + "listarEmpleados/src/js/listarEmpleados.controller.js",
                    DreProperties.BASE_HREF + "listarEmpleados/src/js/listarEmpleados.factory.js",
                    DreProperties.BASE_HREF + "listarEmpleados/src/js/listarEmpleados.service.js",
                    DreProperties.BASE_HREF + "listarEmpleados/src/listarEmpleados.module.js"
                ]
            }, {
                name: "view.Horarios.content",
                files: [
                    DreProperties.BASE_HREF + "horarios/src/js/horarios.controller.js",
                    DreProperties.BASE_HREF + "horarios/src/js/horarios.factory.js",
                    DreProperties.BASE_HREF + "horarios/src/js/horarios.service.js",
                    DreProperties.BASE_HREF + "horarios/src/horarios.module.js"
                ]
            }, {
                name: "view.asistencias.content",
                files: [
                    DreProperties.BASE_HREF + "asistencias/src/js/asistencias.controller.js",
                    DreProperties.BASE_HREF + "asistencias/src/js/asistencias.factory.js",
                    DreProperties.BASE_HREF + "asistencias/src/js/asistencias.service.js",
                    DreProperties.BASE_HREF + "asistencias/src/asistencias.module.js"
                ]
            }, {
                name: "view.puestos.content",
                files: [
                    DreProperties.BASE_HREF + "puestos/src/js/puestos.controller.js",
                    DreProperties.BASE_HREF + "puestos/src/js/puestos.factory.js",
                    DreProperties.BASE_HREF + "puestos/src/js/puestos.service.js",
                    DreProperties.BASE_HREF + "puestos/src/puestos.module.js"
                ]
            }, {
                name: "view.adelanto.content",
                files: [
                    DreProperties.BASE_HREF + "adelanto/src/js/adelanto.controller.js",
                    DreProperties.BASE_HREF + "adelanto/src/js/adelanto.factory.js",
                    DreProperties.BASE_HREF + "adelanto/src/js/adelanto.service.js",
                    DreProperties.BASE_HREF + "adelanto/src/adelanto.module.js"
                ]
            }, {
                name: "view.nsueldos.content",
                files: [
                    DreProperties.BASE_HREF + "nsueldos/src/js/nsueldos.controller.js",
                    DreProperties.BASE_HREF + "nsueldos/src/js/nsueldos.factory.js",
                    DreProperties.BASE_HREF + "nsueldos/src/js/nsueldos.service.js",
                    DreProperties.BASE_HREF + "nsueldos/src/nsueldos.module.js"
                ]
            }, {
                name: "view.inicio.content",
                files: [
                    DreProperties.BASE_HREF + "inicio/src/js/inicio.controller.js",
                    DreProperties.BASE_HREF + "inicio/src/js/inicio.factory.js",
                    DreProperties.BASE_HREF + "inicio/src/js/inicio.service.js",
                    DreProperties.BASE_HREF + "inicio/src/inicio.module.js"
                ]
            }, {
                name: "view.verDetalle.content",
                files: [
                    DreProperties.BASE_HREF + "verDetalle/src/js/verDetalle.controller.js",
                    DreProperties.BASE_HREF + "verDetalle/src/js/verDetalle.factory.js",
                    DreProperties.BASE_HREF + "verDetalle/src/js/verDetalle.service.js",
                    DreProperties.BASE_HREF + "verDetalle/src/verDetalle.module.js"
                ]
            }, {
                name: "view.ListaServicios.content",
                files: [
                    DreProperties.BASE_HREF + "ListaServicios/src/js/ListaServicios.controller.js",
                    DreProperties.BASE_HREF + "ListaServicios/src/js/ListaServicios.factory.js",
                    DreProperties.BASE_HREF + "ListaServicios/src/js/ListaServicios.service.js",
                    DreProperties.BASE_HREF + "ListaServicios/src/ListaServicios.module.js"
                ]
            }, {
                name: "view.Reemplazos.content",
                files: [
                    DreProperties.BASE_HREF + "Reemplazos/src/js/Reemplazos.controller.js",
                    DreProperties.BASE_HREF + "Reemplazos/src/js/Reemplazos.factory.js",
                    DreProperties.BASE_HREF + "Reemplazos/src/js/Reemplazos.service.js",
                    DreProperties.BASE_HREF + "Reemplazos/src/Reemplazos.module.js"
                ]
            }, {
                name: "view.exit.content",
                files: [
                    DreProperties.BASE_HREF + "exit/src/js/exit.controller.js",
                    DreProperties.BASE_HREF + "exit/src/exit.module.js"
                ]
            }, {
                name: "view.config.content",
                files: [
                    DreProperties.BASE_HREF + "config/src/js/config.controller.js",
                    DreProperties.BASE_HREF + "config/src/js/config.factory.js",
                    DreProperties.BASE_HREF + "config/src/js/config.service.js",
                    DreProperties.BASE_HREF + "config/src/config.module.js"
                ]
            }]
        });

    }
    a.module("ocLazyLoad.component", []).config(b);
    b.$inject = ["$ocLazyLoadProvider"];
}(angular);