/* Turkish initialisation for the jQuery UI date picker plugin. */
/* Written by Izzet Emre Erkan (kara@karalamalar.net). */
var bigRegion = 'tr';
jQuery.datepicker.regional['tr'] = {
    closeText: 'kapat',
    prevText: '&#x3c;geri',
    nextText: 'ileri&#x3e',
    currentText: 'bugün',
    monthNames: ['Ocak','Şubat','Mart','Nisan','Mayıs','Haziran',
    'Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık'],
    monthNamesShort: ['Oca','Şub','Mar','Nis','May','Haz',
    'Tem','Ağu','Eyl','Eki','Kas','Ara'],
    dayNames: ['Pazar','Pazartesi','Salı','Çarşamba','Perşembe','Cuma','Cumartesi'],
    dayNamesShort: ['Pz','Pt','Sa','Ça','Pe','Cu','Ct'],
    dayNamesMin: ['Pz','Pt','Sa','Ça','Pe','Cu','Ct'],
    weekHeader: 'Hf',
    dateFormat: 'dd.mm.yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
};
jQuery.datepicker.setDefaults(jQuery.datepicker.regional['tr']);

jQuery.timepicker.regional[bigRegion] = {
	timeText: 'Zaman',
	hourText: 'Saat',
	minuteText: 'Dakika'
};
jQuery.timepicker.setDefaults(jQuery.timepicker.regional[bigRegion]);
