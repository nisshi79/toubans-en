$(function () {
    $('[name="block_size_radio"]:radio').change( function() {
        if($('#block_size_day').prop('checked')){
            $('#avaliable_months_of_year').hide();
            $('#avaliable_days_of_week').fadeIn();
        } else if ($('#block_size_week').prop('checked')) {
            $('#avaliable_days_of_week').fadeOut();
            $('#avaliable_months_of_year').fadeOut();
        } else if ($('#block_size_month').prop('checked')) {
            $('#avaliable_days_of_week').hide();
            $('#avaliable_months_of_year').fadeIn();
        }
    });
    $('[name=notfication_timing_number_sign]').on('change', function() {
        var selectVal = $('[name=notfication_timing_number_sign]').val();
        if(selectVal == -1){
            $('#notfication_timing_avsolute_value').fadeIn();
        } else {
            $('#notfication_timing_avsolute_value').fadeOut();
        }
    });
});