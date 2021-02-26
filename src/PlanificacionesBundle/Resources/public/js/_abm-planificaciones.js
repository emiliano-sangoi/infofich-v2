$(document).ready(function () {

    var msg = "<p class='lead'>Para cargar los datos de esta sección debe completar los datos requeridos en la sección <em class='text-primary'>Informaci&oacute;n b&aacute;sica.</em></p>";

    // ================================================================================================
    // TABS:
    var tab_info_basica = $('#tab-info-basica');
    var tab_equipo_docente = $('#tab-equipo-docente');
    var tab_aprobacion = $('#tab-aprobacion');
    var tab_objetivos = $('#tab-objetivos');
    var tab_resultados = $('#tab-resultados');
    var tab_temario = $('#tab-temario');
    var tab_bibliografia = $('#tab-bibliografia');
    var tab_cronograma = $('#tab-cronograma');
    var tab_distribucion = $('#tab-distribucion');
    var tab_viajes = $('#tab-viajes-academicos');
    var tab_revisar = $('#tab-revisar');


    // ================================================================================================
    // INFO BASICA
    tab_info_basica.on('shown.bs.tab', function (e) {
        cargarFormInfoBasica();
    });

    // ================================================================================================
    // EQUIPO DOCENTE
    tab_equipo_docente.click(function (e) {
        e.preventDefault();
        if (typeof PLANIFICACION !== 'undefined') {
            tab_equipo_docente.on('shown.bs.tab', function (e) {
                getFormEquipoDocente();
            });
            tab_equipo_docente.tab('show');
        } else {
            crearAlert(msg, 'Equipo docente');
            return false;
        }
    });

    // ================================================================================================
    // REQUISITOS APROBACION
    tab_aprobacion.click(function (e) {
        e.preventDefault();
        if (typeof PLANIFICACION !== 'undefined') {
            tab_aprobacion.on('shown.bs.tab', function (e) {
                getRequisitosAprobForm(SECCIONES.req_aprobacion, null);
            });
            tab_aprobacion.tab('show');
        } else {
            crearAlert(msg, 'Requisitos de aprobación');
            return false;
        }
    });

    // ================================================================================================
    // RESULTADOS
    
    tab_resultados.click(function (e) {
        
        e.preventDefault();
        if (typeof PLANIFICACION !== 'undefined') {
            tab_resultados.on('shown.bs.tab', function (e) {                
                getResultadosForm(SECCIONES.resultados, null);
            });
            tab_resultados.tab('show');
        } else {
            crearAlert(msg, 'Resultados de aprendizajes de la planificación');
            return false;
        }
    });
    
    // ================================================================================================
    // OBJETIVOS
    
    tab_objetivos.click(function (e) {
        
        e.preventDefault();
        if (typeof PLANIFICACION !== 'undefined') {
            tab_objetivos.on('shown.bs.tab', function (e) {                
                getObjetivosForm(SECCIONES.objetivos, null);
            });
            tab_objetivos.tab('show');
        } else {
            crearAlert(msg, 'Objetivos de la planificación');
            return false;
        }
    });


    // ================================================================================================
    // TEMARIO
    tab_temario.click(function (e) {
        e.preventDefault();
        if (typeof PLANIFICACION !== 'undefined') {
            tab_temario.on('shown.bs.tab', function (e) {
                getTemarioForm();
            });
            tab_temario.tab('show');
        } else {
            crearAlert(msg, 'Temario');
            return false;
        }
    });

    // ================================================================================================
    // BIBLIOGRAFIA
    tab_bibliografia.click(function (e) {
        e.preventDefault();
        if (typeof PLANIFICACION !== 'undefined') {
            tab_bibliografia.on('shown.bs.tab', function (e) {
                getBibliografiaForm();
                //getBibliografiaForm(SECCIONES.bibliografia, null);
            });
            tab_bibliografia.tab('show');
        } else {
            crearAlert(msg, 'Bibliografía');
            return false;
        }
    });

    // ================================================================================================
    // CRONOGRAMA
    tab_cronograma.click(function (e) {
        e.preventDefault();
        if (typeof PLANIFICACION !== 'undefined') {
            tab_cronograma.on('shown.bs.tab', function (e) {
                getCronogramaForm(SECCIONES.cronograma, null);
            });
            tab_cronograma.tab('show');
        } else {
            crearAlert(msg, 'Cronograma');
            return false;
        }
    });

    // ================================================================================================
    // DISTRIBUCION
    tab_distribucion.click(function (e) {
        e.preventDefault();
        if (typeof PLANIFICACION !== 'undefined') {
            tab_distribucion.on('shown.bs.tab', function (e) {
                getDistribucionForm(SECCIONES.distribucion, null);
            });
            tab_distribucion.tab('show');
        } else {
            crearAlert(msg, 'Distribución horaria');
            return false;
        }
    });

    // ================================================================================================
    // DISTRIBUCION
    tab_viajes.click(function (e) {
        e.preventDefault();
        if (typeof PLANIFICACION !== 'undefined') {
            tab_viajes.on('shown.bs.tab', function (e) {
                getViajesAcademicosForm(SECCIONES.viajes_academicos, null);
            });
            tab_viajes.tab('show');
        } else {
            crearAlert(msg, 'Viajes académicos');
            return false;
        }
    });
    
    
     // ================================================================================================
    // REVISAR
    tab_revisar.click(function (e) {
        e.preventDefault();
        if (typeof PLANIFICACION !== 'undefined') {
            tab_revisar.on('shown.bs.tab', function (e) {
                console.log('implementame');
            });
            tab_revisar.tab('show');
        } else {
            crearAlert(msg, 'Revisar borrador');
            return false;
        }
    });



}
);
/**
 * Actualiza el listado de asignaturas al cambiar la carrera elegida.
 *
 * @param {type} select
 * @returns {undefined}
 */
function actualizarAsignaturas(select) {
    
    var carrera = $(select).val();
    //console.log('Carrera elegida: ' + carrera);
    //Actualizar input Plan de estudio:
    var planes = JSON.parse($(select).attr('data-planes-carrera'));    
    if (typeof planes === 'object' && typeof planes[carrera] === 'string') {
        $('#planificacionesbundle_planificacion_plan').attr('value', planes[carrera]);
    }
    
    //Define el ecomportamiento del select de asignatura sin disparar el evento:
    var select_asignatura = $('#planificacionesbundle_planificacion_asignatura');
    select_asignatura.addClass('disabled');
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
                response.forEach(function (val, index) {
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
                select_asignatura.removeClass('disabled');                
            }            
        }
    });
}

function activarTabCheck(target) {
    if (typeof target === 'object') {
        target.hide().addClass('fa-check-circle').css('color', 'green').fadeIn();
    }
}