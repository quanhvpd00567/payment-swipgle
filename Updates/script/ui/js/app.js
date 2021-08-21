(function($, Dropzone) {
    "use strict";

    $(document).ready(function() {
        const errormsg = $(".print-error-msg");
        const errormsgSend = $(".print-error-msg-send");
        const zero_totalUpload = $('.zero-total-upload');
        const total_uploadProgress = $(".total-upload-progress");
        const total_uploadPercentage = $(".total-upload-percentage");
        const formFiles = $('.swipgle-form-files');
        const sendBtn = $('.sendFilesBtn');
        const generateBtn = $('.linkMethodBtn');
        const droparia = $('.swipgle-main-uploader');
        const start = $('.start-uploading');
        const addingPassword = $('#addingPassword');
        const addingDate = $('#addingDate');
        const linkaddingPassword = $('#linkaddingPassword');
        const linkaddingDate = $('#linkaddingDate');
        const startSection = $('.swipgle-start-transfer-section');
        const transferSection = $('.swipgle-transfer-section');

        // CLICK START IN HOME PAGE
        $(start).on('click', function() {
            startSection.addClass('swipgle-d-none');
            transferSection.removeClass('swipgle-d-none');
            transferSection.addClass('swipgle-d-block');
        });

        // ADDING PASSWORD IN SEND FILES
        $(addingPassword).on('click', function() {
            const password_input = $('.password_input');
            if ($(this).prop("checked") == true) {
                password_input.removeClass('d-none');
            } else if ($(this).prop("checked") == false) {
                password_input.addClass('d-none');
            }
        });

        // ADDING EXPIRY TIME IN SEND FILES
        $(addingDate).on('click', function() {
            const date_input = $('.date_input');
            if ($(this).prop("checked") == true) {
                date_input.removeClass('d-none');
            } else if ($(this).prop("checked") == false) {
                date_input.addClass('d-none');
            }
        });

        // ADDING PASSWORD IN GENERATE LINK
        $(linkaddingPassword).on('click', function() {
            const link_password_input = $('.link_password_input');
            if ($(this).prop("checked") == true) {
                link_password_input.removeClass('d-none');
            } else if ($(this).prop("checked") == false) {
                link_password_input.addClass('d-none');
            }
        });

        // ADDING EXPIRY TIME IN GENERATE LINK
        $(linkaddingDate).on('click', function() {
            const link_date_input = $('.link_date_input');
            if ($(this).prop("checked") == true) {
                link_date_input.removeClass('d-none');
            } else if ($(this).prop("checked") == false) {
                link_date_input.addClass('d-none');
            }
        });



        // ADDING DYNAMIC FIELDS
        var i = 1;
        $('#addNewEmail').on("click", function(e) {
            e.preventDefault();
            i++;
            $('#dynamic_field').append('<div class="form-group input-group send_emails form_plus' + i + '"> <input type="email" id="email_to" name="email_to[]" class="form-control" placeholder="Email to send to"> <button class="btn_remove btn btn-danger" type="button" id="' + i + '"> <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg> </button> </div>');
        });
        // REMOVE DYNAMIC FIELD
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            i--;
            $('.form_plus' + button_id).remove();
        });


        const url = BASE_URL + "/upload"; // UPLOAD URL
        const block = $('#swipgle-uploader-block');

        // FORMAT BYTES
        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }

        // DRAG OVER BLOCK
        function dragOverBlock(e) { block.addClass('onDrag'); }
        // DRAG LEAVE BLOCK
        function dragLeaveBlock(e) { block.removeClass('onDrag'); }

        // ON FILE ADD
        function onFileAdd(file) {
            const preview = $(file.previewElement);
            const removeIcon = preview.find('.remove-file');
            const startSection = $('.swipgle-start-transfer-section');
            const transferSection = $('.swipgle-transfer-section');
            sendBtn.prop("disabled", true);
            generateBtn.prop("disabled", true);
            startSection.addClass('swipgle-d-none');
            transferSection.removeClass('swipgle-d-none');
            transferSection.addClass('swipgle-d-block');
            droparia.addClass('d-none');
            preview.removeClass('d-none');
            removeIcon.addClass('fa-times');
            // SORT LONG NAMES
            $(".swipgle-short-name").each(function() {
                const fulltext = $(this).text();
                if (fulltext.length > 20) {
                    $(this).text(fulltext.substr(0, 23 - 3));
                    $(this).append('...');
                }
            });
        }

        // ON UPLOAD PROGRESS
        function onUploadprogress(file, progress, bytesSent) {
            if (file.previewElement) {
                var percentageElement = file.previewElement.querySelector("#swipgle-file-percentage");
                percentageElement.querySelector(".the-progress-text").textContent = progress.toFixed(0) + "%";
                percentageElement.querySelector(".swipgle-file-size").textContent = formatBytes(bytesSent);
            }
        }

        // ON TOTAL UPLOAD PROGRESS
        function onTotaluploadprogress(progress) {
            zero_totalUpload.addClass('d-none');
            total_uploadProgress.width(progress.toFixed(0) + '%');
            total_uploadPercentage.text(progress.toFixed(0) + '%');
        }

        // ON FILE ERROR
        function onFileError(file, message = null) {
            const preview = $(file.previewElement);
            const anchor = preview.find('.swipgle-errors');
            const error = preview.find('.swipgle-file-not-uploded');
            const progress = preview.find('.swipgle-upload-progress');
            anchor.html(message);
            anchor.removeClass('d-none');
            error.removeClass('d-none');
            progress.addClass('d-none');
        }

        var uploadedDocumentMap = {}

        // ON UPLOAD COMPLETE
        function onUploadComplete(file) {
            if (file.status == "success") {
                const response = JSON.parse(file.xhr.response);
                if (response.type == 'success') {
                    const preview = $(file.previewElement);
                    const progress = preview.find('.swipgle-upload-progress');
                    const uploaded = preview.find('.swipgle-file-uploded');
                    const removeIcon = preview.find('.remove-file');
                    progress.addClass('d-none');
                    uploaded.removeClass('d-none');
                    formFiles.append('<input type="hidden" name="files[]" value="' + response.name + '">');
                    uploadedDocumentMap[file.name] = response.name;
                    removeIcon.removeClass('fa-times');
                    removeIcon.addClass('fa-trash-alt');
                } else
                    onFileError(file, response.errors);
            }
        }

        // ON REMOVE FILE
        function onRemovedfile(file) {
            if (dropzone.files.length == 0) {
                droparia.removeClass('d-none');
                zero_totalUpload.removeClass('d-none');
                total_uploadProgress.width(0 + '%');
                total_uploadPercentage.text('');
            }
            file.previewElement.remove();
            var name = '';
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name;
            } else {
                name = uploadedDocumentMap[file.name];
            }
            formFiles.find('input[name="files[]"][value="' + name + '"]').remove();
            $.ajax({
                url: BASE_URL + "/uploads/delete/" + name,
                type: "delete",
                data: {
                    "name": name
                },
                success: function(response) {
                    if (response.error) {
                        swal("Opps !", response.error, {
                            icon: "error",
                            buttons: {
                                confirm: {
                                    className: 'btn btn-danger'
                                }
                            },
                        });
                    }
                }
            });
        }

        let previewNode = document.querySelector("#swipgle-drop-template");
        previewNode.id = "";
        let previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        const dropzone = new Dropzone(
            'div#swipgle-uploader-block', {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                timeout: 0,
                method: 'post',
                paramName: 'uploads',
                maxFiles: MAX_FILES,
                maxFilesize: MAX_FILE_SIZE,
                previewTemplate: previewTemplate,
                previewsContainer: "#swipgle-upload-previews",
                clickable: "#swipgle-upload-clickable",
                init: function() {
                    this.on("complete", function(file) {
                        if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                            sendBtn.prop("disabled", false);
                            generateBtn.prop("disabled", false);
                        }
                    });
                }
            }
        );

        dropzone.on('dragover', dragOverBlock);
        dropzone.on('dragleave', dragLeaveBlock);
        dropzone.on('addedfile', onFileAdd);
        dropzone.on('error', onFileError);
        dropzone.on('complete', onUploadComplete);
        dropzone.on('removedfile', onRemovedfile);
        dropzone.on('uploadprogress', onUploadprogress);
        dropzone.on('totaluploadprogress', onTotaluploadprogress);

        // START GENERATE LINKS
        $("body").on("click", "#linkMethodBtn", function(e) {
            e.preventDefault();
            const errormsg = $(".print-error-msg");
            const generateForm = $("#filesLinkMethod")[0];
            const generateBtn = $(".linkMethodBtn"); // generate button
            const formData = $('#filesLinkMethod').serializeArray();
            const generateBox = $('.swipgle-form-box');
            const success = $('.swipgle-success-generate');
            const myDropzone = Dropzone.forElement("div#swipgle-uploader-block");
            const link_input = $('#generated_link');
            const success_msg = $('.generated_success_mesage');
            const remaining_space = $('.remaining_space');
            generateBtn.prop("disabled", true); // Disable button when click
            $.ajax({
                url: BASE_URL + '/transfer/generate/link',
                type: "post",
                data: formData,
                dataType: 'json',
                success: function(data) {
                    generateBtn.prop("disabled", false); // active button when success
                    if ($.isEmptyObject(data.error)) {
                        errormsg.css('display', 'none');
                        generateForm.reset();
                        generateBox.addClass('d-none');
                        myDropzone.removeAllFiles(true);
                        droparia.removeClass('d-none');
                        zero_totalUpload.removeClass('d-none');
                        total_uploadProgress.width(0 + '%');
                        total_uploadPercentage.text('');
                        success_msg.html(data.msg);
                        link_input.attr('value', data.link);
                        remaining_space.load(document.URL + ' .remaining_space');
                        success.removeClass('d-none');
                    } else {
                        printErrorMsg(data.error);
                    }
                }
            });
        });

        // GENERATE NEW LINK BUTTON
        $('#generate_new_link').on('click', function() {
            const generateBox = $('.swipgle-form-box');
            const success = $('.swipgle-success-generate');
            const link_password_input = $('.link_password_input');
            const link_date_input = $('.link_date_input');
            link_password_input.addClass('d-none');
            link_date_input.addClass('d-none');
            generateBox.removeClass('d-none');
            generateBox.addClass('fade-in');
            success.addClass('d-none');
        });

        // COPY LINK ON CLICK
        $("#copy").on("click", function() {
            var copyText = document.getElementById("generated_link");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
        });

        // START TRANSFER FILES
        $("body").on("click", "#sendFilesBtn", function(e) {
            e.preventDefault();
            const errormsg = $(".print-error-msg-send");
            const transferForm = $("#sendFilesMethod")[0];
            const sendBtn = $('.sendFilesBtn');
            const formData = $('#sendFilesMethod').serializeArray();
            const success_msg = $('.transfered_success_mesage');
            const transferBox = $('.swipgle-transfer-box');
            const successTransfer = $('.swipgle-transfer-success');
            const myDropzone = Dropzone.forElement("div#swipgle-uploader-block");
            const remaining_space = $('.remaining_space');
            sendBtn.prop("disabled", true); // Disable button when click
            $.ajax({
                url: BASE_URL + '/transfer/files/send',
                type: "post",
                data: formData,
                dataType: 'json',
                success: function(data) {
                    sendBtn.prop("disabled", false); // active button when success
                    if ($.isEmptyObject(data.error)) {
                        errormsg.css('display', 'none');
                        transferForm.reset();
                        sendBtn.prop("disabled", false); // Disable button when click
                        success_msg.html(data.success);
                        myDropzone.removeAllFiles(true);
                        zero_totalUpload.removeClass('d-none');
                        total_uploadProgress.width(0 + '%');
                        total_uploadPercentage.text('');
                        transferBox.addClass('d-none');
                        remaining_space.load(document.URL + ' .remaining_space');
                        successTransfer.removeClass('d-none');
                    } else {
                        printErrorMsgSend(data.error);
                    }
                }
            });
        });

        // TRANSFER MORE FILES BTN
        $('#transfer_more_files').on('click', function() {
            const transferBox = $('.swipgle-transfer-box');
            const successTransfer = $('.swipgle-transfer-success');
            const password_input = $('.password_input');
            const date_input = $('.date_input');
            password_input.addClass('d-none');
            date_input.addClass('d-none');
            transferBox.removeClass('d-none');
            transferBox.addClass('fade-in');
            successTransfer.addClass('d-none');
        });

        // PRINT ERROR MESSAGES
        function printErrorMsg(msg) {
            errormsg.find("span").html('');
            errormsg.css('display', 'block');
            $.each(msg, function(key, value) {
                errormsg.find("span").append('<li>' + value + '</li>');
            });
        }

        // PRINT ERROR MESSAGES
        function printErrorMsgSend(msg) {
            errormsgSend.find("span").html('');
            errormsgSend.css('display', 'block');
            $.each(msg, function(key, value) {
                errormsgSend.find("span").append('<li>' + value + '</li>');
            });
        }
    });

})(jQuery, Dropzone);