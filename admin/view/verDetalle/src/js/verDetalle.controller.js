! function(a) {
    "use strict";

    function b(a, b, c) {
        a.cargando1 = true;

        console.log(b.params);
        a.nombres = b.params.Nombres;
        a.apellidos = b.params.Apellidos;
        a.dni = b.params.codEmpleado;
        a.tarifa = b.params.tarifa;
        a.horasHombre = b.params.hhombe;
        a.tardeHombre = b.params.tardeHombre;
        a.adelantosA = b.params.adelantosA;
        a.DescuentoTarde = b.params.DescuentoTarde;
        a.totalNeto = b.params.totalNeto;
        a.SueldoBruto = b.params.SueldoBruto;
        a.puesto = b.params.puesto;

        a.FECHAS = b.params.fechitas;
    }

    a.module("view.verDetalle.controller", [])
        .controller("verDetalleController", b),
        b.$inject = ["$scope", "$state"]
}(angular)