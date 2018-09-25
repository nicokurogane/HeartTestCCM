$(document).ready(function(){
    
    //Inicializamos al botton para que haga el scroll
    $("#sendDataTest").click(function(){
        $('html,body').animate({
             scrollTop: $("#divTestResults").offset().top
        },'slow');
    });
    
});