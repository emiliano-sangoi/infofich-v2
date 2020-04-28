$(document).ready(function () {


    $('#tab-info-basica').on('shown.bs.tab', function (e) {
//        e.preventDefault();
        //e.target // newly activated tab        
        //e.relatedTarget // previous active tab
        //console.log(e.target, e.relatedTarget);

        console.log("Tab info basica ");

        getInfoBasicaForm(SECCIONES.info_basica, null);
        
        if(PLANIFICACIONES.id !== null){
            activarTabCheck( $('#tab-info-basica i') );            
        }
        
    });

    // 1 - Equipo Docente
    $('#tab-equipo-docente').on('shown.bs.tab', function (e) {
        //e.target // newly activated tab        
        //e.relatedTarget // previous active tab
        //console.log(e.target, e.relatedTarget);
        console.log("Tab equipo docente ");
        getFormEquipoDocente(SECCIONES.equipo_docente, null);
    });

    // 2 - Requisitos de aprobacion
    $('#tab-aprobacion').on('shown.bs.tab', function (e) {
        //e.target // newly activated tab        
        //e.relatedTarget // previous active tab
        //console.log(e.target, e.relatedTarget);
        console.log("Tab requisitos de aprobacion ");
        getRequisitosAprobForm(SECCIONES.req_aprobacion, null);
    });

    // 3 - Ojetivos
    $('#tab-objetivos').on('shown.bs.tab', function (e) {
        //e.target // newly activated tab        
        //e.relatedTarget // previous active tab
        //console.log(e.target, e.relatedTarget);
        console.log("Tab objetivos");
        getObjetivosForm(SECCIONES.objetivos, null);
    });

    // 4 - Temario
    $('#tab-temario').on('shown.bs.tab', function (e) {
        console.log("Tab temario");
        getTemarioForm(SECCIONES.temario, null);
    });

    // 5 - Bibliografia.
    $('#tab-bibliografia').on('shown.bs.tab', function (e) {
        console.log("Tab bibliografia");
        getBibliografiaForm(SECCIONES.bibliografia, null);
    });

    // 6 - Cronograma
    $('#tab-cronograma').on('shown.bs.tab', function (e) {
        console.log("Tab cronograma");
        getCronogramaForm(SECCIONES.cronograma, null);
    });


    // 7 - Distribucion
    $('#tab-distribucion').on('shown.bs.tab', function (e) {
        console.log("Tab distribucion");
        getDistribucionForm(SECCIONES.distribucion, null);
    });

    // 8 - Viajes Academicos
    $('#tab-viajes-academicos').on('shown.bs.tab', function (e) {
        console.log("Tab viajes academicos");
        getViajesAcademicosForm(SECCIONES.viajes_academicos, null);
    });




});

/**
 * Actualiza el listado de asignaturas al cambiar la carrera elegida.
 * 
 * @param {type} select
 * @returns {undefined}
 */
function actualizarAsignaturas(select) {
    var carrera = $(select).val();


    //Actualizar input Plan de estudio:
    var planes = JSON.parse($(select).attr('data-planes-carrera'));
    //console.log(typeof planes, typeof planes[carrera], planes, carrera, planes.length > 0 && typeof planes[carrera] === 'string');
    if (typeof planes === 'object' && typeof planes[carrera] === 'string') {
        $('#planificacionesbundle_planificacion_plan').attr('value', planes[carrera]);
    }


    //Define el ecomportamiento del select de asignatura sin disparar el evento:
    var select_asignatura = $('#planificacionesbundle_planificacion_asignatura');
    //select_asignatura.hide();
    select_asignatura.change(function (e) {
        var option = $(this).children("option:selected");
        var asignatura = JSON.parse(option.attr('data-json'));
        $('#planificacionesbundle_planificacion_codigoSiu').val(asignatura.codigoMateria);

        console.log(asignatura);
    });

    //setear la carrera en la url:
    var url = SECCIONES.get_asignaturas;
    url = url.replace('--CARRERA--', carrera);

    //llamada ajax
    $.ajax({
        dataType: "json",
        url: url,
        data: null,
        success: function (response) {

            if (response.length > 0) {
                select_asignatura.html('');

                response.forEach(function (val) {
                    var opt = $(document.createElement('option'));
                    opt.attr('value', val.codigoMateria);
                    opt.attr('data-json', JSON.stringify(val));
                    opt.text(val.nombreMateria);
                    select_asignatura.append(opt);
                });

                //Esto produce que se complete los datos de la asignatura.
                select_asignatura.select2({
                    allowClear: true,
                    containerCssClass: 'fix-select2-styles'
                });
                select_asignatura.trigger('change');
                select_asignatura.fadeIn();
            }
            //console.log(response);
        }
    });


    //console.log('selecciono ' + carrera);
    //console.log(url);
}

function activarTabCheck(target){
    if(typeof target === 'object'){
         target.hide().addClass('fa-check-circle').css('color', 'green').fadeIn();
    }   
}