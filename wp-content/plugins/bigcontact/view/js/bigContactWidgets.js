/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

(function($){
    if(typeof bigRegion != 'undefined' && $('.bigContact-days').length != 0){
        var region = $.datepicker.regional[bigRegion],
        dayNames = region.dayNames,
        firstDay = region.firstDay;

        $('.big-mon').html(dayNames[(0+firstDay)%7]);
        $('.big-tue').html(dayNames[(1+firstDay)%7]);
        $('.big-wed').html(dayNames[(2+firstDay)%7]);
        $('.big-thu').html(dayNames[(3+firstDay)%7]);
        $('.big-fri').html(dayNames[(4+firstDay)%7]);
        $('.big-sat').html(dayNames[(5+firstDay)%7]);
        $('.big-sun').html(dayNames[(6+firstDay)%7]);
    }
})(jQuery);
