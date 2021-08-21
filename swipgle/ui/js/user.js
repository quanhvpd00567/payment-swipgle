(function() {
    'use strict';

    $(document).ready(function() {
        // Check new avatar image
        $("#avatar").change(function() {
            var fileExtension = ['jpeg', 'jpg', 'png']; // Allowed types
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                swal("Opps !", "This file type not allowed", {
                    icon: "error",
                    allowOutsideClick: false,
                    closeOnClickOutside: false,
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
                    }
                }
                readAvatarURL(this);
            }
        });
        // Ajax Update User info
        $("body").on("click", "#saveInfoBtn", function(e) {
            e.preventDefault();
            var formData = new FormData($(this).parents('form')[0]); // Form data
            $(".btninfo").prop("disabled", true); // Disable button when click
            $(".spinner-border-info").removeClass('d-none'); // show spinner on button
            $.ajax({
                url: BASE_URL + '/user/settings/update/info',
                type: "post",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $(".btninfo").prop("disabled", false); // active button when success
                    $(".spinner-border-info").addClass('d-none'); // hide spinner when success
                    if ($.isEmptyObject(data.error)) {
                        $(".print-error-msg").css('display', 'none');
                        swal("Success!", data.success, {
                            icon: "success",
                            allowOutsideClick: false,
                            closeOnClickOutside: false,
                            buttons: {
                                confirm: {
                                    className: 'btn btn-success'
                                }
                            },
                        }).then(function() {
                            location.reload(); // Reald when click ok
                        });
                    } else {
                        printErrorMsg(data.error); // Print error messages 
                    }
                }
            });
        });
        // Ajax update user password
        $("body").on("click", "#savePassBtn", function(e) {
            e.preventDefault();
            $(".btnpass").prop("disabled", true); // Disable button when click
            $(".spinner-border-pass").removeClass('d-none'); // show spinner on button
            $.ajax({
                url: BASE_URL + '/user/settings/update/password',
                type: "post",
                data: {
                    'current-password': $('#currentpassword').val(),
                    'new-password': $('#newpassword').val(),
                    'new-password_confirmation': $('#newpasswordconfirm').val(),
                },
                dataType: 'json',
                success: function(data) {
                    $(".btnpass").prop("disabled", false); // active button when success
                    $(".spinner-border-pass").addClass('d-none'); // hide spinner when success
                    if ($.isEmptyObject(data.error)) {
                        $(".print-error-msg-sec").css('display', 'none');
                        $("#passwordForm")[0].reset();
                        swal("Success!", data.success, {
                            icon: "success",
                            allowOutsideClick: false,
                            closeOnClickOutside: false,
                            buttons: {
                                confirm: {
                                    className: 'btn btn-success'
                                }
                            },
                        })
                    } else {
                        printErrorMsgSec(data.error);
                    }
                }
            });
        });
        // Delete cache
        $("body").on("click", "#deleteCacheBtn", function(e) {
            e.preventDefault();
            swal({
                icon: "info",
                title: 'Are you sure?',
                text: "Do you want delete your cache",
                buttons: {
                    confirm: {
                        text: 'Yes, delete it',
                        className: 'btn btn-primary'
                    },
                    cancel: {
                        visible: true,
                        className: 'btn btn-secondary'
                    }
                }
            }).then((willDelete) => {
                if (willDelete) {
                    var id = $(this).data("id"); // transaction id
                    $.ajax({
                        url: BASE_URL + "/user/settings/cache/delete",
                        type: 'get',
                        dataType: "JSON",
                        success: function(response) {
                            if ($.isEmptyObject(response.error)) {
                                swal("Success!", response.success, {
                                    icon: "success",
                                    buttons: {
                                        confirm: {
                                            className: 'btn btn-success'
                                        }
                                    },
                                }).then(function() {
                                    location.reload(); // reload when click ok
                                });
                            } else {
                                swal("Opps !", response.error, {
                                    icon: "info",
                                    buttons: {
                                        confirm: {
                                            className: 'btn btn-info'
                                        }
                                    },
                                })
                            }
                        },
                    });
                } else {
                    swal.close();
                }
            });
        });
        // Ajax new payment
        $("body").on("click", "#proceedToCheckout", function(e) {
            e.preventDefault();
            $(".proceedToCheckout").prop("disabled", true); // Disable button when click
            $.ajax({
                url: BASE_URL + '/user/payments/create',
                type: "post",
                data: {
                    'space': $('#space').val(), // space
                    'method': $('#method').val(), // method
                },
                dataType: 'json',
                success: function(data) {
                    $(".proceedToCheckout").prop("disabled", false); // active button when success
                    if ($.isEmptyObject(data.error)) {
                        $(".print-error-msg").css('display', 'none');
                        window.location.href = data.success;
                    } else {
                        printErrorMsg(data.error);
                    }
                }
            });
        });
        // Ajax cancel transaction
        $("body").on("click", "#cancelTransaction", function(e) {
            e.preventDefault();
            swal({
                icon: "info",
                title: 'Are you sure?',
                text: "Do you want cancel this transaction",
                buttons: {
                    confirm: {
                        text: 'Yes, Cancel it',
                        className: 'btn btn-primary'
                    },
                    cancel: {
                        visible: true,
                        className: 'btn btn-secondary'
                    }
                }
            }).then((willDelete) => {
                if (willDelete) {
                    var id = $(this).data("id"); // transaction id
                    $.ajax({
                        url: BASE_URL + "/user/payments/cancel/" + id,
                        type: 'get',
                        dataType: "JSON",
                        data: {
                            "id": id
                        },
                        success: function(response) {
                            if ($.isEmptyObject(response.error)) {
                                swal("Success!", response.success, {
                                    icon: "success",
                                    buttons: {
                                        confirm: {
                                            className: 'btn btn-success'
                                        }
                                    },
                                }).then(function() {
                                    location.reload(); // reload when click ok
                                });
                            } else {
                                swal("Opps !", response.error, {
                                    icon: "error",
                                    buttons: {
                                        confirm: {
                                            className: 'btn btn-danger'
                                        }
                                    },
                                })
                            }
                        },
                    });
                } else {
                    swal.close();
                }
            });
        });
        // Print errors 
        function printErrorMsg(msg) {
            $(".print-error-msg").find("span").html('');
            $(".print-error-msg").css('display', 'block');
            $.each(msg, function(key, value) {
                $(".print-error-msg").find("span").append('<li>' + value + '</li>');
            });
        }
        // Print errors 
        function printErrorMsgSec(msg) {
            $(".print-error-msg-sec").find("span").html('');
            $(".print-error-msg-sec").css('display', 'block');
            $.each(msg, function(key, value) {
                $(".print-error-msg-sec").find("span").append('<li>' + value + '</li>');
            });
        }
    });
})(jQuery);