! function(a) {
    "use strict";

    function b(a, b, c) {


        // ==============================================
        // 
        // ==============================================
        a.cargando1 = true;

        // llamamos A LOS EMPLEADOS
        a.queryNsueldos = {
            filter: '',
            limit: '500',
            inicio: "",
            fin: "",

            page: 1
        };
        a.calldataAdelanto = function() {
            a.cargando2 = true;
            a.actualizar = false;
            b.callNsueldos.get(a.queryNsueldos).$promise.then(function(data) {

                console.log(data);

                a.planilla = data.totalPlanilla;
                a.planillaProyecta = data.planillaProyecta;

                a.servicios = data.Servicios;
                a.totalNetoServicios = data.TotalNetoServicio;

                // a.Sueldos = data.tbl_empleado;

                a.empleados = data.empleados;

                a.DatosPdf = [

                ];

                // for (var index2 = 0; index2 < a.Sueldos.length; index2++) {
                //     a.DatosPdf.push({
                //         "EMPLEADO": a.Sueldos[index2].Nombres + ' ' + a.Sueldos[index2].Apellidos,
                //         "SUELDOBRTUO": c('currency')(a.Sueldos[index2].total1, 'S/. '),
                //         "TARDEACUMULADA": a.Sueldos[index2].tardeEnHoras + ' HORAS',
                //         "ADELANTO": c('currency')(a.Sueldos[index2].SoloAdelanto, 'S/. '),
                //         "DESCUENTO": c('currency')(a.Sueldos[index2].DescuentoTA, 'S/. '),
                //         "TOTALNETO": c('currency')(a.Sueldos[index2].TotalNeto, 'S/. ')

                //     });
                // }


                a.cargando1 = false;
                a.cargando2 = false;

            }, function(error) {
                a.actualizar = true;
                a.messajeErr = error.statusText;
                if (error.status == -1) {
                    a.messajeErr = "ERROR DE RED";
                }
            });
        }




        // datePicker
        a.datePicker = {
            date: {
                startDate: moment().subtract(1, "days"),
                endDate: moment()
            }
        };

        a.opts = {

            locale: {
                applyClass: 'btn-green',
                applyLabel: "Apply",
                fromLabel: "From",
                format: "DD-MM-YYYY",
                toLabel: "To",
                cancelLabel: 'Cancel',
                customRangeLabel: 'Custom range',

            },
            ranges: {
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()]
            },
            eventHandlers: {
                'show.daterangepicke': function(event, picker) { console.log(picker); }
            }
        };


        a.dateRangePicker = {
            date: { startDate: moment().startOf('month'), endDate: moment().endOf('month') },
            picker: null,
            options: {
                pickerClasses: 'custom-display', //angular-daterangepicker extra
                buttonClasses: 'btn',
                applyButtonClasses: 'btn-primary',
                cancelButtonClasses: 'btn-danger',
                locale: {
                    applyLabel: "Aplicar",
                    cancelLabel: 'Cancelar',
                    customRangeLabel: 'Rango Personalizado',
                    separator: ' - ',
                    format: "DD-MM-YYYY", //will give you 2017-01-06
                    //format: "D-MMM-YY", //will give you 6-Jan-17
                    //format: "D-MMMM-YY", //will give you 6-January-17
                },
                ranges: {
                    'Los últimos 7 días': [moment().subtract(6, 'days'), moment()],
                    'Los últimos 30 días': [moment().subtract(29, 'days'), moment()]
                },
                eventHandlers: {
                    // 'apply.daterangepicker': function(event, picker) { console.log(picker); }
                }
            }
        };

        function llamarRango(startDate, endDate) {
            a.inicioF = c('date')(new Date(startDate), 'yyyy/MM/dd');
            a.finF = c('date')(new Date(endDate), 'yyyy/MM/dd');

            a.inicioFpdf = c('date')(new Date(startDate), 'dd/MM/yyyy');
            a.finFpdf = c('date')(new Date(endDate), 'dd/MM/yyyy');

            a.queryNsueldos.inicio = a.inicioF;
            a.queryNsueldos.fin = a.finF;
            a.calldataAdelanto();
        }

        //Watch for date changes
        a.$watch('dateRangePicker.date', function(newDate) {
            console.log('New date set: ', newDate);

            llamarRango(newDate.startDate, newDate.endDate);

        }, false);


        a.$watch('queryNsueldos.filter', function(newValue, oldValue) {



            if (newValue !== oldValue) {
                a.queryNsueldos.page = 1;
                a.calldataAdelanto();
            }

        });



        // ========================================00
        // impimir
        //=========================================== 

        a.printS = function() {

            var lMargin = 15; //left margin in mm
            var rMargin = 15; //right margin in mm
            var pdfInMM = 210; // width of A4 in mm
            var pageCenter = pdfInMM / 2;
            var imgData = DreProperties.BACKGROUNDPDF;
            var doc = new jsPDF({
                orientation: 'portrait',
                unit: 'mm',
                format: 'a4',
                style: 'F',

            })
            doc.addImage(imgData, 'JPEG', 15, 80, 180, 130);
            //=====================================
            // COLOCAMOS TITULO EN EL CENTRO
            //====================================
            var paragraph = DreProperties.NOMBREEMPRESA;
            var lines = doc.splitTextToSize(paragraph, (pdfInMM - lMargin - rMargin));
            var dim = doc.getTextDimensions('Text');
            var lineHeight = dim.h
            for (var i = 0; i < lines.length; i++) {
                var lineTop = (lineHeight / 2) * i
                doc.text(lines[i], pageCenter, 60 + lineTop, 'center'); //see this line
            }

            var dni = a.inicioFpdf + " - " + a.finFpdf;
            var lines = doc.splitTextToSize(dni, (pdfInMM - lMargin - rMargin));
            var dim = doc.getTextDimensions('Text');
            var lineHeight = dim.h
            for (var i = 0; i < lines.length; i++) {
                var lineTop = (lineHeight / 2) * i
                doc.text(lines[i], pageCenter, 68 + lineTop, 'center'); //see this line
            }
            //=====================================
            // ALMACENAMOS EN UN UNA TABLA
            //====================================

            doc.autoTable({


                margin: { top: 100 },

                columnStyles: {
                    europe: { halign: 'left' },

                }, // European countries centered

                body: a.DatosPdf,
                columns: [

                    { header: 'EMPLEADO', dataKey: 'EMPLEADO' },
                    // { header: 'APELLIDOS', dataKey: 'Apellidos' },
                    { header: 'SUELDO BRUTO', dataKey: 'SUELDOBRTUO' },
                    { header: 'TARDANZA ACUMULADA', dataKey: 'TARDEACUMULADA' },
                    { header: 'ADELANTO EN EFECTIVO', dataKey: 'ADELANTO' },
                    { header: 'DESCUENTO', dataKey: 'DESCUENTO' },
                    { header: 'SALARIO NETO', dataKey: 'TOTALNETO' },


                ],
                foot: [{
                    'DESCUENTO': 'TOTAL:',
                    'TOTALNETO': c('currency')(a.planilla, 'S/. ')
                }],


                theme: 'plain',
                tableLineColor: [51, 102, 153],
                tableLineWidth: 0.5,
                styles: {
                    lineColor: [51, 102, 153],
                    lineWidth: 0.2
                },
                headStyles: {
                    fillColor: [51, 102, 153],
                    fontSize: 8,
                    textColor: [255, 255, 255],
                    halign: 'center'
                },
            });

            doc.save('SUELDO.pdf')
        };

    }


    function ac(a, b, c) {

        a.mess = "CAJAMARCA";

        this.groups = [], this.closeOthers = function(d) {
            var e = angular.isDefined(b.closeOthers) ? a.$eval(b.closeOthers) : c.closeOthers;
            e && angular.forEach(this.groups, function(a) {
                a !== d && (a.isOpen = !1)
            })
        }, this.addGroup = function(a) {
            var b = this;
            this.groups.push(a), a.$on("$destroy", function(c) {
                b.removeGroup(a)
            })
        }, this.removeGroup = function(a) {
            var b = this.groups.indexOf(a); - 1 !== b && this.groups.splice(b, 1)
        }
    }

    function ac1() {
        return {
            restrict: "EA",
            controller: "AccordionController",
            controllerAs: "accordion",
            transclude: !0,
            replace: !1,
            templateUrl: function(a, b) {
                return b.templateUrl || "view/accordion/accordionContent.html"
            }
        }
    }

    function ac2() {

        return {
            require: "^dreAccordion",
            restrict: "EA",
            transclude: !0,

            templateUrl: function(a, b) {
                return b.templateUrl || "view/accordion/accordion-group.html"
            },
            scope: {
                data: "<",
                index: "=?",
                heading: "@",
                isOpen: "=?",
                isDisabled: "=?",
                backgroundTab: "=?"
            },
            controller: function() {
                this.setHeading = function(a) {
                    this.heading = a
                }
            },
            link: function(a, b, c, d) {
                d.addGroup(a), a.openClass = c.openClass || "panel-open", a.panelClass = c.panelClass, a.$watch("isOpen", function(c) {
                    b.toggleClass(a.openClass, c), c && d.closeOthers(a)
                }), a.toggleOpen = function(b) {
                    a.isDisabled || b && 32 !== b.which || (a.isOpen = !a.isOpen)
                }
            }
        }
    }

    function ac3() {
        return {
            restrict: "EA",
            transclude: !0,
            template: "",
            replace: !0,
            require: "^dreAccordionGroup",
            link: function(a, b, c, d, e) {
                d.setHeading(e(a, angular.noop))
            }
        }
    }

    function ac4() {
        return {
            require: "^dreAccordionGroup",
            link: function(a, b, c, d) {
                a.$watch(function() {
                    return d[c.dreAccordionTransclude]
                }, function(a) {
                    a && (b.find("div").html(""), b.find("div").append(a))
                })
            }
        }
    }
    a.module("view.nsueldos.controller", [])
        .controller("listarNsueldosController", b)
        .controller("AccordionController", ac)
        .constant("accordionConfig", {
            closeOthers: !0
        })
        .directive("dreAccordion", ac1)
        .directive("dreAccordionGroup", ac2)
        .directive("dreAccordionHeading", ac3)
        .directive("dreAccordionTransclude", ac4),
        ac.$inject = ["$scope", "$attrs", "accordionConfig"],
        b.$inject = ["$scope", "$callnsueldos", "$filter"]
}(angular);