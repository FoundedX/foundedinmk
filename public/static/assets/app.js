$(function(){

    $(document).on('click', '.btn-delete-startup', function() {
        var confirmed = confirm('Are you sure?');
        var btn = $(this);
        var startup = btn.data('startup');

        if (confirmed) {

            $.ajax({
                type: 'get',
                url: btn.attr('href'),
                dataType: "json",
                success:function(data){

                    $("#action-message").html(data.message);

                    $("#action-status").removeClass()
                        .addClass('alert')
                        .addClass('alert-dismissable')
                        .addClass('alert-' + data.status)
                        .show();

                    btn.closest('tr').slideUp('slow');

                }
            });

        }

        return false;
    });

    $(document).on('click', '.btn-feature-startup', function() {
        var btn = $(this);
        var startup = btn.data('startup');

        $.ajax({
            type: 'get',
            url: btn.attr('href'),
            dataType: "json",
            success:function(data){

                //$("#action-message").html(data.message);
                //
                //$("#action-status").removeClass()
                //    .addClass('alert')
                //    .addClass('alert-dismissable')
                //    .addClass('alert-' + data.status)
                //    .show();

                btn = btn.children('i');

                if (btn.hasClass('glyphicon-star-empty')) {
                    btn.removeClass('glyphicon-star-empty');
                    btn.addClass('glyphicon-star');
                } else {
                    btn.removeClass('glyphicon-star');
                    btn.addClass('glyphicon-star-empty')
                }

            }
        });

        return false;
    });

    $(document).on('click', '.btn-approve-startup', function() {
        var confirmed = confirm('Are you sure? The submitter will be notified that the startup is approved.');
        var btn = $(this);

        if (confirmed) {

            $.ajax({
                type: 'get',
                url: btn.attr('href'),
                dataType: "json",
                success:function(data){

                    $("#action-message").html(data.message);

                    $("#action-status").removeClass()
                        .addClass('alert')
                        .addClass('alert-dismissable')
                        .addClass('alert-' + data.status)
                        .show();

                    btn.hide();
                    btn.siblings('.btn-decline-startup').hide();

                }
            });

        }

        return false;
    });

    $(document).on('click', '.btn-decline-startup', function() {
        var confirmed = confirm('Are you sure? The submitter will be notified that the startup is declined.');
        var btn = $(this);

        if (confirmed) {
            $.ajax({
                type: 'get',
                url: btn.attr('href'),
                dataType: "json",
                success:function(data){

                    $("#action-message").html(data.message);

                    $("#action-status").removeClass()
                        .addClass('alert')
                        .addClass('alert-dismissable')
                        .addClass('alert-' + data.status)
                        .show();

                    btn.closest('tr').slideUp('slow');

                }
            });
        }

        return false;
    });

    $("#logo").on("change", function()
    {
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) { // no file selected, or no FileReader support
            return;
        }

        if (/^image/.test( files[0].type)){
            var reader = new FileReader();
            reader.readAsDataURL(files[0]);

            reader.onloadend = function(){
                $("#img-preview-logo").css("background-image", "url("+this.result+")");
            }
        }
    });


});