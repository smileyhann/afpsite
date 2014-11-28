(function($) {
    if ($("#bigContact_map_canvas").length > 0) {
        if (typeof custom_big_contact_map === 'undefined' || custom_big_contact_map === false) {
            var bigContact_geocoder;
            var bigContact_map;
            bigContact_geocoder = new google.maps.Geocoder();
            var bigContact_myOptions = {
                zoom: 14,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            bigContact_map = new google.maps.Map(document.getElementById("bigContact_map_canvas"), bigContact_myOptions);
            bigContact_geocoder.geocode({
                address: map_address
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    bigContact_map.setCenter(results[0].geometry.location);
                    new google.maps.Marker({
                        map: bigContact_map,
                        position: results[0].geometry.location
                    });
                }
            });
        }
    }
    if (typeof bigDatePicker != 'undefined') {
        if (bigDatePicker == 'date') {
            $("#datepicker").datepicker({
                onSelect: function() {
                    var date = $(this).datepicker('getDate');
                    $('#bigContact-date').val($.datepicker.formatDate('DD-MM dd, yy', date));
                    $('#bigContact-appointment').attr('checked', true);
                }
            });
        } else if (bigDatePicker == 'datetime') {
            $("#datepicker").datetimepicker({
                dateFormat: bigDateFormat,
                timeFormat: bigTimeFormat,
                separator: ' @ ',
                ampm: bigAmpm,
                hourMin: 0,
                hourMax: 23,
                showHour: true,
                showMinute: bigShowMinute,
                onSelect: function(dateText, inst) {
                    var date = $(this).datetimepicker('getDate');
                    $('#bigContact-date').val(dateText);
                    $('#bigContact-appointment').attr('checked', true);
                }
            });
        }
    }

    $("#bigContact-form").submit(function(event) {
        /* stop form from submitting normally */
        event.preventDefault();

        /* get some values from elements on the page: */
        var $form = $(this),
                form_data = $form.serialize(),
                url = $form.attr('action');
        $("#bigContact-loading").show();

        /* Send the data using post and put the results in a div */
        $.ajax({
            type: "POST",
            url: url,
            data: form_data,
            dataType: "json",
            timeout: 5000,
            success: function(data) {
                $("#bigContact-results").hide();
                $("#bigContact-results").empty();
                $("#bigContact-results").removeClass("error success").addClass(data.status);
                $.each(data, function(index, value) {
                    if (index != 'status')
                        $("#bigContact-results").append('<p>' + value + '</p>');
                });
                $("#bigContact-loading").fadeOut('fast');
                if (data.status == "success") {
                    if (typeof (bigContact_conversion_tracking_callback) === 'function') {
                        bigContact_conversion_tracking_callback();
                    }
                    $("#bigContact-submit").attr("disabled", true);
                }
                $("#bigContact-results").slideDown('slow');
            },
            error: function(request, status, err) {
                console.log(request);
                console.log(err);
                $("#bigContact-results").hide();
                $("#bigContact-results").empty();
                $("#bigContact-results").removeClass("error success").addClass('error');
                if (status == "timeout")
                    $("#bigContact-results").append('<p>Cannot Send Email: Server Timed Out</p>');
                else
                    $("#bigContact-results").append('<p>Cannot Send Email: Internal Error</p>');
                $("#bigContact-loading").fadeOut('fast');
                $("#bigContact-results").slideDown('slow');
            }
        });
    });
})(jQuery);