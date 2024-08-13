! function(a) {
    "use strict";

    function b(a, b, c) {

        a.cargando1 = true;

        a.queryAsistencia = {
            filter: '',
            limit: '500',
            inicio: "",
            fin: "",
            page: 1
        };

        a.llamarAsistencia = function() {
            a.cargando2 = true;
            a.actualizar = false;
            b.callAsistencia.get(a.queryAsistencia).$promise.then(function(data) {
                a.cargando1 = false;
                a.cargando2 = false;

                console.log(data);
                a.asistenciaAll = data.tbl_asistencia;
                a.AssRemplazo = data.Remplazaos;
                console.log(a.AssRemplazo);

                // PREPARAMOS PDF
                a.DatosPdf = [

                ];

                for (var index2 = 0; index2 < a.asistenciaAll.length; index2++) {
                    a.DatosPdf.push({
                        "EMPLEADO": a.asistenciaAll[index2].E_Nombres + ' ' + a.asistenciaAll[index2].E_Apellidos,
                        "H_Entrada": c('formatoHora')(a.asistenciaAll[index2].H_Entrada),
                        "H_Entrada_Marcada": c('formatoHora')(a.asistenciaAll[index2].A_Entrada_Marcada),
                        "H_Salida": c('formatoHora')(a.asistenciaAll[index2].H_Salida),
                        "H_Salida_Marcada": c('formatoHora')(a.asistenciaAll[index2].A_Salida_Marcada),
                        "H_Hombre": a.asistenciaAll[index2].H_Hombre,
                    });
                }
                a.DatosPdf2 = [

                ];

                for (var index3 = 0; index3 < a.AssRemplazo.length; index3++) {
                    a.DatosPdf2.push({
                        "EMPLEADO": a.AssRemplazo[index3].E_Nombres + ' ' + a.AssRemplazo[index3].E_Apellidos,
                        // "H_Entrada": c('formatoHora')(a.asistenciaAll[index2].H_Entrada),
                        "H_Entrada_Marcada": c('formatoHora')(a.AssRemplazo[index3].A_Entrada_Marcada),
                        // "H_Salida": c('formatoHora')(a.asistenciaAll[index2].H_Salida),
                        "H_Salida_Marcada": c('formatoHora')(a.AssRemplazo[index3].A_Salida_Marcada),
                        "H_Hombre": a.AssRemplazo[index3].H_Hombre,
                    });
                }
                // console.log(a.DatosPdf);

            }, function(error) {
                a.actualizar = true;
                a.messajeErr = error.statusText;
                if (error.status == -1) {
                    a.messajeErr = "ERROR DE RED";
                }
            });
        }


        a.dates = moment();




        // date picker
        a.dateRangePicker = {
            date: { startDate: moment().startOf('day'), endDate: moment().endOf('day') },
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

            a.queryAsistencia.inicio = a.inicioF;
            a.queryAsistencia.fin = a.finF;
            a.llamarAsistencia()
        }

        //Watch for date changes
        a.$watch('dateRangePicker.date', function(newDate) {
            // console.log('New date set: ', newDate);

            llamarRango(newDate.startDate, newDate.endDate);

        }, false);

        // buscador
        a.$watch('queryAsistencia.filter', function(newValue, oldValue) {



            if (newValue !== oldValue) {
                a.queryAsistencia.page = 1;
                a.llamarAsistencia();
            }

        });







        a.printSPlanilla = function() {
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
                    { header: 'H. ENTRADA', dataKey: 'H_Entrada' },
                    { header: 'H.E. MARCADA', dataKey: 'H_Entrada_Marcada' },
                    { header: 'H. SALIDA', dataKey: 'H_Salida' },
                    { header: 'H.S. MARCADA', dataKey: 'H_Salida_Marcada' },
                    { header: 'H. TRABAJADAS', dataKey: 'H_Hombre' },


                ],
                // foot: [{
                //     'DESCUENTO': 'TOTAL:',
                //     'TOTALNETO': c('currency')(a.planilla, 'S/. ')
                // }],


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

            doc.save('ASISTENCIA_PLANILLA.pdf')
        }



        a.printSRemplazos = function() {
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



                body: a.DatosPdf2,
                columns: [

                    { header: 'EMPLEADO', dataKey: 'EMPLEADO' },
                    // { header: 'APELLIDOS', dataKey: 'Apellidos' },
                    // { header: 'H. ENTRADA', dataKey: 'H_Entrada' },
                    { header: 'H.E. MARCADA', dataKey: 'H_Entrada_Marcada' },
                    // { header: 'H. SALIDA', dataKey: 'H_Salida' },
                    { header: 'H.S. MARCADA', dataKey: 'H_Salida_Marcada' },
                    { header: 'H. TRABAJADAS', dataKey: 'H_Hombre' },


                ],
                // foot: [{
                //     'DESCUENTO': 'TOTAL:',
                //     'TOTALNETO': c('currency')(a.planilla, 'S/. ')
                // }],


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

            doc.save('ASISTENCIA_REMPLAZOS.pdf')
        }


    }

    a.module("view.asistencias.controller", [])
        .controller("asistenciasController", b)
        .filter("clearNull", function($filter) {
            return function(date) {
                if (date == null) {
                    return "En espera";
                } else {
                    date = $filter('date')(new Date("December 17, 1995 " + date), ' h:mm a');

                    return date;
                }


            }
        }),
        b.$inject = ["$scope", "$callasistencias", "$filter"]
}(angular)