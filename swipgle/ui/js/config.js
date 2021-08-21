(function() {
    'use strict';
    $(document).ready(function() {
        // Config LoadingOverlay
        $.LoadingOverlaySetup({
            imageColor: LODER_COLOR,
        });
        $(document).on({
            // Show LoadingOverlay on ajax start
            ajaxStart: function() { $.LoadingOverlay("show"); },
            // Hide LoadingOverlay on ajax stop
            ajaxStop: function() { $.LoadingOverlay("hide"); },
        });

        // Ajax setup headers 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Csrf token
            }
        });
    });
})(jQuery);