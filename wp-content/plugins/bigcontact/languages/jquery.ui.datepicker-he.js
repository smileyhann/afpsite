/* Hebrew initialisation for the UI Datepicker extension. */
/* Written by Amir Hardon (ahardon at gmail dot com). */
var bigRegion = 'he';
jQuery.datepicker.regional['he'] = {
    closeText: 'סגור',
    prevText: '&#x3c;הקודם',
    nextText: 'הבא&#x3e;',
    currentText: 'היום',
    monthNames: ['ינואר','פברואר','מרץ','אפריל','מאי','יוני',
    'יולי','אוגוסט','ספטמבר','אוקטובר','נובמבר','דצמבר'],
    monthNamesShort: ['ינו','פבר','מרץ','אפר','מאי','יוני',
    'יולי','אוג','ספט','אוק','נוב','דצמ'],
    dayNames: ['ראשון','שני','שלישי','רביעי','חמישי','שישי','שבת'],
    dayNamesShort: ['א\'','ב\'','ג\'','ד\'','ה\'','ו\'','שבת'],
    dayNamesMin: ['א\'','ב\'','ג\'','ד\'','ה\'','ו\'','שבת'],
    weekHeader: 'Wk',
    dateFormat: 'dd/mm/yy',
    firstDay: 0,
    isRTL: true,
    showMonthAfterYear: false,
    yearSuffix: ''
};
jQuery.datepicker.setDefaults(jQuery.datepicker.regional['he']);

jQuery.timepicker.regional['he'] = {
	timeText: 'זמן',
	hourText: 'זמן',
	minuteText: 'דקה'
};
jQuery.timepicker.setDefaults(jQuery.timepicker.regional['he']);
