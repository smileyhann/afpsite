/* Hungarian initialisation for the jQuery UI date picker plugin. */
/* Written by Istvan Karaszi (jquery@spam.raszi.hu). */
var bigRegion = 'hu';
jQuery.datepicker.regional['hu'] = {
    closeText: 'bezár',
    prevText: 'vissza',
    nextText: 'előre',
    currentText: 'ma',
    monthNames: ['Január', 'Február', 'Március', 'Április', 'Május', 'Június',
    'Július', 'Augusztus', 'Szeptember', 'Október', 'November', 'December'],
    monthNamesShort: ['Jan', 'Feb', 'Már', 'Ápr', 'Máj', 'Jún',
    'Júl', 'Aug', 'Szep', 'Okt', 'Nov', 'Dec'],
    dayNames: ['Vasárnap', 'Hétfő', 'Kedd', 'Szerda', 'Csütörtök', 'Péntek', 'Szombat'],
    dayNamesShort: ['Vas', 'Hét', 'Ked', 'Sze', 'Csü', 'Pén', 'Szo'],
    dayNamesMin: ['V', 'H', 'K', 'Sze', 'Cs', 'P', 'Szo'],
    weekHeader: 'Hét',
    dateFormat: 'yy.mm.dd.',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: true,
    yearSuffix: ''
};
jQuery.datepicker.setDefaults(jQuery.datepicker.regional['hu']);

jQuery.timepicker.regional[bigRegion] = {
	timeText: 'idő',
	hourText: 'óra',
	minuteText: 'perc'
};
jQuery.timepicker.setDefaults(jQuery.timepicker.regional[bigRegion]);