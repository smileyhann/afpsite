var geocoder;
var map;
(function($) {
    if (has_api_key.length > 0) {
        function codeAddress() {

            var address = $.trim($("#map_address").text());
            console.log($.trim($("#map_address").text()));
            geocoder.geocode({
                address: address
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var formatted_address = results[0].formatted_address;
                    $("#address").empty().append(formatted_address);
                    formatted_address = results[0].formatted_address;
                    $.post(save_url, {
                        id: "address",
                        value: formatted_address
                    },
                    function(data) {

                    }, 'json');
                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });
                } else {
                    alert("We were unable to load your address: " + status);
                }
            });
        }
    }

    if (typeof bigRegion != 'undefined') {
        console.log($.datepicker.regional[bigRegion].dayNames);
        var region = $.datepicker.regional[bigRegion],
                dayNames = region.dayNames,
                firstDay = region.firstDay;

        $('#big-mon').html(dayNames[(0 + firstDay) % 7]);
        $('#big-tue').html(dayNames[(1 + firstDay) % 7]);
        $('#big-wed').html(dayNames[(2 + firstDay) % 7]);
        $('#big-thu').html(dayNames[(3 + firstDay) % 7]);
        $('#big-fri').html(dayNames[(4 + firstDay) % 7]);
        $('#big-sat').html(dayNames[(5 + firstDay) % 7]);
        $('#big-sun').html(dayNames[(6 + firstDay) % 7]);
    }
    if (typeof bigDatePicker != 'undefined') {
        if (bigDatePicker == 'date') {
            $("#datepicker").datepicker({
                altField: "#Range",
                altFormat: 'yy-mm-dd'
            });
        } else if (bigDatePicker == 'datetime') {
            $("#datepicker").datetimepicker({
                dateFormat: bigDateFormat,
                timeFormat: bigTimeFormat,
                separator: ' @ ',
                ampm: bigAmpm,
                showHour: true,
                showMinute: bigShowMinute
            });
        }
    }
    $(".add-button, .remove-button").on('hover', function(event) {
        if (event.type == 'mouseenter') {
            $(this).addClass("ui-state-hover");
        } else {
            $(this).removeClass("ui-state-hover");
        }
    });

    $('.add-button').on('click', function(e) {
        e.preventDefault();
        if ($(this).parent().find('#phone-box').length > 0) {
            var element = $(this);
            $.ajax({
                type: "POST",
                url: save_url,
                data: ({
                    'id': 'add_new_phone'
                }),
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if (data.state == 'success')
                        element.parent().find('#phone-box').append("<li id=\"" + data.message + "\"><span id=\"p_label\" class=\"label-update halfSize\">Phone</span> <span id=\"phone_number\" class=\"label-update halfSize\">###-###-####</span></li>");
                }
            });

        } else if ($(this).parent().find('#email-box').length > 0) {
            var element = $(this);
            $.ajax({
                type: "POST",
                url: save_url,
                data: ({
                    'id': 'add_new_email'
                }),
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if (data.state == 'success')
                        element.parent().find('#email-box').append("<li id=\"" + data.message + "\"><span id=\"e_label\" class=\"label-update halfSize\">Email</span> <span id=\"email_address\" class=\"label-update halfSize\">example@domain.com</span></li>");
                }
            });
        }
    });

    $('.remove-button').on('click', function(e) {
        e.preventDefault();
        if ($(this).parent().find('#phone-box').length > 0) {
            var element = $(this), elementId = $(this).parent().find('li:last').attr('id');
            $.ajax({
                type: "POST",
                url: save_url,
                data: ({
                    'id': 'remove_phone',
                    'value': elementId
                }),
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if (data.state == 'success') {
                        element.parent().find('li:last').remove();
                    }
                }
            });
        } else if ($(this).parent().find('#email-box').length > 0) {
            var element = $(this), elementId = $(this).parent().find('li:last').attr('id');
            $.ajax({
                type: "POST",
                url: save_url,
                data: ({
                    'id': 'remove_email',
                    'value': elementId
                }),
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if (data.state == 'success') {
                        element.parent().find('li:last').remove();
                    }
                }
            });
        }
    });

    $('form').on('click', '.label-text', function() {
        $(this).editable(save_url, {
            indicator: '<img src="' + indicator_url + '" />',
            tooltip: 'Click to edit...',
            cssclass: 'jedit'
        });
    });

    $('form').on('click', '.label-update', function() {
        $(this).editable(save_url, {
            submitdata: {
                parent_id: $(this).parent().attr('id')
            },
            indicator: '<img src="' + indicator_url + '" />',
            tooltip: 'Click to edit...',
            cssclass: 'jinplace'
        });
    });

    $('form').on('click', '.label-inplace', function() {
        $(this).editable(save_url, {
            indicator: '<img src="' + indicator_url + '" />',
            tooltip: 'Click to edit...',
            cssclass: 'jinplace'
        });
    });

    $('.map-label').editable(save_url, {
        type: 'textarea',
        indicator: '<img src="' + indicator_url + '" />',
        tooltip: 'Click to edit...',
        cancel: 'Cancel',
        submit: 'OK',
        cssclass: 'jtextarea'
    });
    $('.map-address').editable(save_url, {
        indicator: '<img src="' + indicator_url + '" />',
        tooltip: 'Click to edit...',
        cssclass: 'jinplace',
        callback: function(value, settings) {
            if (has_api_key.length > 0) {
                codeAddress();
            }
        }
    });
    if (has_api_key.length > 0) {
        geocoder = new google.maps.Geocoder();
        var myOptions = {
            zoom: 8,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map_canvas"),
                myOptions);
        codeAddress();
    }
})(jQuery);