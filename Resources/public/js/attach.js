(function ($) {
    $(document).ready(function () {

        $('[data-media-delete]').click(function () {
            var container;

            container = $(this).parents('div[data-media-id]');

            container.find('input[type="hidden"][value="' + $(this).data('mediaDelete') + '"]').remove();
            $(this).parent().remove();
        });

        $("[data-media-modal]").click(function () {
            var modal, modalDialog, modalContent, href, mediaId, multiple, selected;

            mediaId = $(this).data('mediaId');
            multiple = $(this).data('mediaMultiple');

            modal = $('<div />').addClass("modal").addClass("fade");
            modalDialog = $('<div />').addClass("modal-dialog");
            modalContent = $('<div />').addClass('modal-content');

            if ($(this).data('modal-class')) {
                $(modal).addClass($(this).data('modal-class'));
            }

            modalDialog.append(modalContent);
            modal.append(modalDialog);

            console.log(multiple);

            $(modal).modal('show');

            modalContent.html($("<div />").addClass("modal-loading").text("loading..."));

            href = $(this).attr('href');

            selected = "";

            $("div[data-media-id='" + mediaId + "'] input[type='hidden']").each(function () {
                selected += $(this).val() + "-";
            });

            selected = selected.slice(0, selected.length - 2);

            if (!selected || selected == "") {
                selected = "none";
            }

            console.log("A" + selected + "A");

            href = href.replace("-selected-", selected);

            //TODO: This should be somehow rewritten as there is potential problem if someone will click two times before he will see modal. As i know is not big probability, but it's.
            $.ajax(href, {
                success: function (response) {
                    modalContent.html(response);

                    $(".data-grid", modalContent).data('mediaId', mediaId);

                    $("[data-media-choosable]").click(function () {
                        var mId, mainElement, imageContainer, img;

                        mId = $(this).parents(".data-grid").data('mediaId');

                        mainElement = $("div[data-media-id='" + mId + "']");

                        imageContainer = mainElement.find(".attached-media");

                        img = $('<div />').addClass('attached-img').append(
                            $('<img />').attr('src', $(this).data('mediaUrl') + "?mid=" + mId)
                        );

                        if (multiple) {
                            imageContainer.find('.attached-img').last().after(img);
                        } else {
                            imageContainer.html(img);
                        }

                        if (multiple) {
                            var input;

                            input = $('<input />');

                            input.attr('name', mainElement.data('mediaInputName'));
                            input.attr('value', $(this).data('mediaChoosable'));
                            input.attr('type', 'hidden');

                            mainElement.find(".input-group").append(input);

                            img.append($('<i />').addClass('icon-remove-sign').attr('data-media-delete', $(this).data('mediaChoosable')));
                        } else {
                            $("#" + mId).val($(this).data("mediaChoosable"));
                        }

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