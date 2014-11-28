/* Welsh/UK initialisation for the jQuery UI date picker plugin. */
/* Written by William Griffiths. */
var bigRegion = 'cy-GB';
jQuery.datepicker.regional['cy-GB'] = {
    closeText: 'Done',
    prevText: 'Prev',
    nextText: 'Next',
    currentText: 'Today',
    monthNames: ['Ionawr','Chwefror','Mawrth','Ebrill','Mai','Mehefin',
    'Gorffennaf','Awst','Medi','Hydref','Tachwedd','Rhagfyr'],
    monthNamesShort: ['Ion', 'Chw', 'Maw', 'Ebr', 'Mai', 'Meh',
    'Gor', 'Aws', 'Med', 'Hyd', 'Tac', 'Rha'],
    dayNames: ['Dydd Sul', 'Dydd Llun', 'Dydd Mawrth', 'Dydd Mercher', 'Dydd Iau', 'Dydd Gwener', 'Dydd Sadwrn'],
    dayNamesShort: ['Sul', 'Llu', 'Maw', 'Mer', 'Iau', 'Gwe', 'Sad'],
    dayNamesMin: ['Su','Ll','Ma','Me','Ia','Gw','Sa'],
    weekHeader: 'Wy',
    dateFormat: 'dd/mm/yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
};
jQuery.datepicker.setDefaults(jQuery.datepicker.regional['cy-GB']);

jQuery.timepicker.regional['cy-GB'] = {
	timeText: 'Amser',
	hourText: 'Awr',
	minuteText: 'Munud'
};
jQuery.timepicker.setDefaults(jQuery.timepicker.regional['cy-GB']);
