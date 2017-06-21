var base_url = window.location.origin;

$(document).ready(function() {
mostrarUltimasHistorias();
});



function mostrarUltimasHistorias() {
  $.ajax({
    url:base_url+"/fluffy/controladores/cargarExperienciasController.php",
    type:"POST",
    data:'',
    success: function (result) {
      var parsed = JSON.parse(result);
      var jsonString = JSON.stringify(parsed);
      enviarExperienciasAHome(jsonString);
      }
  });
}

function enviarExperienciasAHome(experiencia){
    $.ajax({
      url:base_url+"/fluffy/vistas/pantallaLogueada.php",
      type:"POST",
      data:{experiencias:experiencia},
      success: function(data){
        var result = $('<div />').append(data).find('#holaMundo').html();
            $('#holaMundo').html(result);
        }
    });
}
