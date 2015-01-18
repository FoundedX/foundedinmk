$(function() {

    $(document).on('click', '.btn-join-form', function () {
        $(this).hide();
        $("#join-form").slideDown('slow');

        return false;
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $(document).on('click', '.btn-submit-startup', function () {
        var btn = $(this);

        $.ajax({
            type: 'post',
            url: btn.attr('href'),
            dataType: "json",
            data: {
                name: $('#name').val(),
                year_founded: $('#year_founded').val(),
                website: $('#url').val(),
                twitter: $('#twitter').val(),
                logo_url: $('#logo_url').val(),
                contact_name: $('#contact_name').val(),
                contact_email: $('#contact_email').val()
            },
            success: function (data) {

                if (data.status == 'success') {
                    $("#join-form").slideUp('slow');
                    $("#join-msg").html("Thank you! Your startup was added to the list but needs to be approved before showing here.")
                } else {
                    //console.log(data);
                    $("#join-msg").html("<strong>Error:</strong> " + data.message);
                }

            }
        });

        return false;
    });

});