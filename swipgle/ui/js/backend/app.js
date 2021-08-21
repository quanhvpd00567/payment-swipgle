(function($) {
    "use strict";

    $(document).ready(function() {
        // Logo check and preview
        $("#logo").on('change', function() {
            var fileExtension = ['png', 'jpg', 'jpeg', 'svg'] // Allowed types
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                swal("Error!", "Only png, jpg, jpeg are allowed", {
                    icon: "error",
                    buttons: {
                        confirm: {
                            className: 'btn btn-danger'
                        }
                    },
                }).then(function() {
                    $('#logo').val(''); // Reset input
                });
            } else {
                var logo = true,
                    readLogoURL;
                if (logo) {
                    readLogoURL = function(input_logo) {
                        if (input_logo.files && input_logo.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                $('.logobox').removeClass('d-none'); // show box image
                                $('#preview_logo').attr('src', e.target.result); // Preview image
                            }
                            reader.readAsDataURL(input_logo.files[0]);
                        }
                    }
                }

                readLogoURL(this);
            }
        });


        // Favicon check and preview
        $("#favicon").on('change', function() {
            var fileExtension = ['ico', 'png', 'jpg', 'jpeg']; // Allowed types
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                swal("Error!", "Only ico, png, jpg, jpeg are allowed", {
                    icon: "error",
                    buttons: {
                        confirm: {
                            className: 'btn btn-danger'
                        }
                    },
                }).then(function() {
                    $('#favicon').val(''); // Reset input
                });
            } else {
                var favicon = true,
                    readFaviconURL;
                if (favicon) {
                    readFaviconURL = function(input_favicon) {
                        if (input_favicon.files && input_favicon.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                $('.favbox').removeClass('d-none'); // show box image
                                $('#preview_favicon').attr('src', e.target.result); // Preview image
                            }
                            reader.readAsDataURL(input_favicon.files[0]);
                        }
                    }
                }
                readFaviconURL(this);
            }
        });

        // Show datatable with order by desc
        $('#basic-datatables').DataTable({
            order: [
                [0, "desc"]
            ]
        });

        // Show datatable with order by desc
        $('#basic-datatables2').DataTable({
            order: [
                [0, "desc"]
            ]
        });


        // Show datatable with order by desc
        $('#basic-datatables3').DataTable({
            order: [
                [0, "desc"]
            ]
        });


        // Remove spaces from input
        $(".remove-spaces").keyup(function() {
            $(this).val($(this).val().replace(/\s/g, ""));
        });

        // Check new avatar image
        $("#avatar").change(function() {
            var fileExtension = ['jpeg', 'jpg', 'png']; // Allowed types
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                swal("Opps !", "This file type not allowed", {
                    icon: "error",
                    buttons: {
                        confirm: {
                            className: 'btn btn-danger'
                        }
                    },
                }).then(function() {
                    $('#avatar').val(''); // Reset avatar if there is an error
                });
            } else {
                var avatar = true,
                    readAvatarURL;
                if (avatar) {
                    readAvatarURL = function(input_avatar) {
                        if (input_avatar.files && input_avatar.files[0]) {
                            var reader = new FileReader(); // Read new file
                            reader.onload = function(e) {
                                $('#preview_avatar').attr('src', e.target.result); // preview new avatar 
                            }
                            reader.readAsDataURL(input_avatar.files[0]);
                        }
                    };
                }
                readAvatarURL(this);
            }
        });

        // price format
        $('#price').priceFormat({
            prefix: '',
            thousandsSeparator: '',
            clearOnEmpty: true
        });

    });


})(jQuery);