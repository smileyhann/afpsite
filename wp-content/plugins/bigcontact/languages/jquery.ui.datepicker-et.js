/* Estonian initialisation for the jQuery UI date picker plugin. */
/* Written by Mart Sõmermaa (mrts.pydev at Zgmail com). */
var bigRegion = 'et';
jQuery.datepicker.regional['et'] = {
    closeText: 'Sulge',
    prevText: 'Eelnev',
    nextText: 'Järgnev',
    currentText: 'Täna',
    monthNames: ['Jaanuar','Veebruar','Märts','Aprill','Mai','Juuni',
    'Juuli','August','September','Oktoober','November','Detsember'],
    monthNamesShort: ['Jaan', 'Veebr', 'Märts', 'Apr', 'Mai', 'Juuni',
    'Juuli', 'Aug', 'Sept', 'Okt', 'Nov', 'Dets'],
    dayNames: ['Pühapäev', 'Esmaspäev', 'Teisipäev', 'Kolmapäev', 'Neljapäev', 'Reede', 'Laupäev'],
    dayNamesShort: ['Pühap', 'Esmasp', 'Teisip', 'Kolmap', 'Neljap', 'Reede', 'Laup'],
    dayNamesMin: ['P','E','T','K','N','R','L'],
    weekHeader: 'näd',
    dateFormat: 'dd.mm.yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
};
jQuery.datepicker.setDefaults(jQuery.datepicker.regional['et']);

jQuery.timepicker.regional['et'] = {
	timeText: 'Aeg',
	hourText: 'Tund',
	minuteText: 'Minut'
};
jQuery.timepicker.setDefaults(jQuery.timepicker.regional['et']);
