$(document).ready(function(){
    $('.person-status').change(function(){
        var closestParameters = $(this).closest('.person-row').find('.person-parameters').first();
        if($(this).val() == 1 ) {
            closestParameters.show();
        } else {
            closestParameters.hide();
        }
    });
});