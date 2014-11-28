/* Persian (Farsi) Translation for the jQuery UI date picker plugin. */
/* Javad Mowlanezhad -- jmowla@gmail.com */
/* Jalali calendar should supported soon! (Its implemented but I have to test it) */
var bigRegion = 'fa';
jQuery.datepicker.regional['fa'] = {
    closeText: 'بستن',
    prevText: '',
    nextText: '',
    currentText: 'امروز',
    monthNames: [
    'ژانویه',
    'فوریه',
    'مارس',
    'آوریل',
    'مه',
    'ژوئن',
    'جولای',
    'اوت',
    'سپتامبر',
    'اکتبر',
    'نوامبر',
    'دسامبر'
    ],
    monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'],
    dayNames: [
    'يکشنبه',
    'دوشنبه',
    'سه‌شنبه',
    'چهارشنبه',
    'پنجشنبه',
    'جمعه',
    'شنبه'
    ],
    dayNamesShort: [
    'ی',
    'د',
    'س',
    'چ',
    'پ',
    'ج',
    'ش'
    ],
    dayNamesMin: [
    'ی',
    'د',
    'س',
    'چ',
    'پ',
    'ج',
    'ش'
    ],
    weekHeader: 'هف',
    dateFormat: 'yy/mm/dd',
    firstDay: 6,
    isRTL: true,
    showMonthAfterYear: false,
    yearSuffix: ''
};
jQuery.datepicker.setDefaults(jQuery.datepicker.regional['fa']);

jQuery.timepicker.regional['fa'] = {
	timeText: 'ساعت',
	hourText: 'ساعت',
	minuteText: 'دقیقه'
};
jQuery.timepicker.setDefaults(jQuery.timepicker.regional['fa']);
