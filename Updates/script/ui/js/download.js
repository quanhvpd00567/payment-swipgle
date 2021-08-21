(function($) {
    "use strict";

    $(document).ready(function() {
        // START DOWNLOADNG FILE
        $("body").on("click", "#downloadFile", function(e) {
            e.preventDefault();
            var id = $(this).data("id"); // transfer id
            var file = $(this).data("file"); // file name
            $.ajax({
                url: BASE_URL + "/download/request/" + id + "/" + file,
                type: 'get',
                dataType: "JSON",
                data: { "id": id, 'file_name': file },
                success: function(response) {
                    if ($.isEmptyObject(response.error)) {
                        window.location = response.download_link;
                    } else {
                        swal("Opps !", response.error, {
                            icon: "error",
                            buttons: {
                                confirm: {
                                    className: 'btn btn-danger'
                                }
                            },
                        }).then(function() {
                            location.reload();
                        });
                    }
                },
            });
        });
    });
})(jQuery);