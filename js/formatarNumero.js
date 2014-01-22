function prepararNumerosDecimais(locale) {
 $j.format.locale({
 number: {
 groupingSeparator: (locale == undefined ? '.' : locale.match("pt_BR") ? '.' : locale.match("en") ? ',' : '.'),
 decimalSeparator: (locale == undefined ? ',' : locale.match("pt_BR") ? ',' : locale.match("en") ? '.' : ',')
 }
 });
var DECIMAL = "decimal";
 $j('input:text[alt^="'+DECIMAL+'"]').each( function() {
 var escala = $j(this).attr('alt').split("-");
 var __decimalSeparator = (locale == undefined ? ',' : locale.match("pt_BR") ? ',' : locale.match("en") ? '.' : ',');
 if (escala.length == 3) {
 $j(this).format({type: DECIMAL, int: escala[1], precision: escala[2], decimal: __decimalSeparator});
 }
 });
}