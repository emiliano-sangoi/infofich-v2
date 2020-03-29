$(document).ready(function () {


    $('#tab-info-basica').on('shown.bs.tab', function (e) {
//        e.preventDefault();
        //e.target // newly activated tab        
        //e.relatedTarget // previous active tab
        //console.log(e.target, e.relatedTarget);
        console.log("Tab info basica ");

        getInfoBasicaForm(SECCIONES.info_basica, null);
    });





    $('#tab-equipo-docente').on('shown.bs.tab', function (e) {
        //e.target // newly activated tab        
        //e.relatedTarget // previous active tab
        //console.log(e.target, e.relatedTarget);
        console.log("Tab equipo docente ");
        getFormEquipoDocente(SECCIONES.equipo_docente, null);
    });
    
    
    $('#tab-aprobacion').on('shown.bs.tab', function (e) {
        //e.target // newly activated tab        
        //e.relatedTarget // previous active tab
        //console.log(e.target, e.relatedTarget);
        console.log("Tab requisitos de aprobacion ");
        getRequisitosAprobForm(SECCIONES.req_aprobacion, null);
    });






});