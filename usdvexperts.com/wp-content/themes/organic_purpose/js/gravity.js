
(function($) {

    // Ready to apply get status
    var data = {
        action: 'us_ready_to_apply'
    };

    $(document).ready(function() {
        if ( $('body').hasClass('page-id-981') ) {

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: data,
                dataType: 'json',
                complete: function() {
                },
                success: function(response) {
                    $('.steps_container').html(response);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        }
    });



})(jQuery);