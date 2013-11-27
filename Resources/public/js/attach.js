(function($) {
    $(document).ready(function() {

        $("[data-media-modal]").click(function() {
            var modal, modalDialog, modalContent, href, dataId;

            dataId = $(this).data('mediaId');

            modal = $('<div />').addClass("modal").addClass("fade");
            modalDialog = $('<div />').addClass("modal-dialog");
            modalContent = $('<div />').addClass('modal-content');

            if ($(this).data('modal-class')) {
                $(modal).addClass($(this).data('modal-class'));
            }

            modalDialog.append(modalContent);
            modal.append(modalDialog);

            $(modal).modal('show');

            modalContent.html($("<div />").addClass("modal-loading").text("loading..."));

            href = $(this).attr('href');

            $.ajax(href, {
                success: function (response) {
                    modalContent.html(response);
                    $(".data-grid", modalContent).data('mediaId', dataId);

                    $("[data-media-chose]").click(function() {
                        var dId = $(this).parents(".data-grid").data('mediaId');
                        $("#" + dId).val($(this).data("mediaChose"));
                        $("[data-media-image='" + dId + "']").attr('src', $(this).data('mediaUrl') + "?" + dId);
                        $(modal).modal("hide");
                    });
                },
                error: function () {
                    $(modal).modal("hide");
                }
            });

            return false;
        });
    })
})(jQuery);