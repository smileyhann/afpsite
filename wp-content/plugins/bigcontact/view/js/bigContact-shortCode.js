(function($){
    if($('#bigContact-send_to_editor').length > 0){
        if(!$("#bigContact-form").attr('checked')){
            $("#bigContact-appoint").attr("disabled", true);
        }
        $("#bigContact-form").on("click", function(){
            if(!$("#bigContact-form").attr('checked')){
                $("#bigContact-appoint").attr("checked", false);
                $("#bigContact-appoint").attr("disabled", true);
            } else {
                $("#bigContact-appoint").attr("disabled", false);
            }
        });
        $("#bigContact-send_to_editor").on('click', function(event){
            event.preventDefault();
            var bigContact_shortCode;
            var bigContact_options = "";
            if($("#bigContact-form").attr('checked'))
                bigContact_options += " form=on";
            if($("#bigContact-appoint").attr('checked'))
                bigContact_options += " appointment=on";
            if($("#bigContact-phones").attr('checked'))
                bigContact_options += " phones=on";
            if($("#bigContact-emails").attr('checked'))
                bigContact_options += " emails=on";
            if($("#bigContact-hours").attr('checked'))
                bigContact_options += " hours=on";
            if($("#bigContact-map").attr('checked'))
                bigContact_options += " map=on";
            if(bigContact_options.length > 0)
                bigContact_shortCode = "[bigContact" + bigContact_options + "]";
            else  bigContact_shortCode = "[bigContact form=on appointment=on phones=on emails=on hours=on map=on]";
            send_to_editor(bigContact_shortCode);
        });
    }
})(jQuery);