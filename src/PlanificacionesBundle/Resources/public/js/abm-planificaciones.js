$(document).ready(function () {


    $('#tab-info-basica').on('shown.bs.tab', function (e) {
//        e.preventDefault();
        //e.target // newly activated tab        
        //e.relatedTarget // previous active tab
        //console.log(e.target, e.relatedTarget);
        
        console.log("Tab info basica ");

        getInfoBasicaForm(SECCIONES.info_basica, null);
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
function actualizarAsignaturas(select){
    var carrera = $(select).val();
    console.log('selecciono ' + carrera);    
}