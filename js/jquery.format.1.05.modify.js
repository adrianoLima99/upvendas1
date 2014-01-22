/*
 * 
 * Copyright (c) 2011 Cloudgen Wong (<a
 * href="http://www.cloudgen.w0ng.hk">Cloudgen Wong</a>) Licensed under the MIT
 * License: http://www.opensource.org/licenses/mit-license.php
 * 
 */
// version 1.05
// fix the problem of jQuery 1.5 when using .val()
// fix the problem when precision has been set and the input start with decimal
// dot or comma ,e.g. precision set to 3 and input with ".1234"
var email = {
	tldn : new RegExp(
			"^[^\@]+\@[^\@]+\.(A[C-GL-OQ-UWXZ]|B[ABD-JM-OR-TVWYZ]|C[ACDF-IK-ORUVX-Z]|D[EJKMOZ]|E[CEGR-U]|F[I-KMOR]|G[ABD-IL-NP-UWY]|H[KMNRTU]|I[DEL-OQ-T]|J[EMOP]|K[EG-IMNPRWYZ]|L[A-CIKR-VY]|M[AC-EGHK-Z]|N[ACE-GILOPRUZ]|OM|P[AE-HKL-NR-TWY]|QA|R[EOSUW]|S[A-EG-ORT-VYZ]|T[CDF-HJ-PRTVWZ]|U[AGKMSYZ]|V[ACEGINU]|W[FS]|XN|Y[ETU]|Z[AMW]|AERO|ARPA|ASIA|BIZ|CAT|COM|COOP|EDU|GOV|INFO|INT|JOBS|MIL|MOBI|MUSEUM|NAME|NET|ORG|PRO|TEL|TRAVEL)$",
			"i")
};
(function($) {
	$.extend($.expr[":"], {
		regex : function(d, a, c) {
			var e = new RegExp(c[3], "g");
			var b = ("text" === d.type) ? d.value : d.innerHTML;
			return (b == "") ? true : (e.exec(b))
		}
	});
	$.fn.output = function(d) {
		if (typeof d == "undefined")
			return (this.is(":text")) ? this.val() : this.html();
		else
			return (this.is(":text")) ? this.val(d) : this.html(d);
	};
	formatter = {
		getRegex : function(p_settings) {
			var settings = $.extend({
				type : "decimal",
				int : 6,
				precision : 5,
				decimal : '.',
				allow_negative : true
			}, p_settings);
			var result = "";
			if (settings.type == "decimal") {
				var e = (settings.allow_negative) ? "-?" : "";
				if (settings.precision > 0)
					result = "^" + e + "\\d{1," + settings.int + "}\\" + settings.decimal + "\\d{1," + settings.precision + "}$";// ^"+e+"\\d{1,"+settings.int+"}+$|
				else
					result = "^" + e + "\\d{1," + settings.int + "}?$"
			} else if (settings.type == "phone-number") {
				result = "^\\d[\\d\\-]*\\d$"
			} else if (settings.type == "alphabet") {
				result = "^[A-Za-z]+$"
			}
			return result
		},
		isEmail : function(d) {
			var a = $(d).output();
			var c = false;
			var e = true;
			var e = new RegExp("[\s\~\!\#\$\%\^\&\*\+\=\(\)\[\]\{\}\<\>\\\/\;\:\,\?\|]+");
			if (a.match(e) != null) {
				return c
			}
			if (a.match(/((\.\.)|(\.\-)|(\.\@)|(\-\.)|(\-\-)|(\-\@)|(\@\.)|(\@\-)|(\@\@))+/) != null) {
				return c
			}
			if (a.indexOf("\'") != -1) {
				return c
			}
			if (a.indexOf("\"") != -1) {
				return c
			}
			if (email.tldn && a.match(email.tldn) == null) {
				return c
			}
			return e
		},
		formatString : function(target, p_settings) {
			var settings = $.extend({
				type : "decimal",
				int : 6,
				precision : 5,
				decimal : '.',
				allow_negative : true
			}, p_settings);
			var oldText = $(target).output();
			var newText = oldText;
			if (settings.type == "decimal") {
				if (newText != "") {
					var g;
					var h = (settings.allow_negative) ? "\\-" : "";
					var i = "\\" + settings.decimal;
					g = new RegExp("[^\\d" + h + i + "]+", "g");
					newText = newText.replace(g, "");
					var h = (settings.allow_negative) ? "\\-?" : "";
					if (settings.precision > 0)
						g = new RegExp("^(" + h + "\\d*" + i + "\\d{1," + settings.precision + "}).*");
					else
						g = new RegExp("^(" + h + "\\d+).*");
					newText = newText.replace(g, "$1")
				}
			} else if (settings.type == "phone-number") {
				newText = newText.replace(/[^\-\d]+/g, "").replace(/^\-+/, "").replace(/\-+/, "-")
			} else if (settings.type == "alphabet") {
				newText = newText.replace(/[^A-Za-z]+/g, "")
			}
			if (newText != oldText)
				$(target).output(newText)
		}
	};
	$.fn.format = function(p_settings, wrongFormatHandler) {
		var settings = $.extend({
			type : "decimal",
			int : 6,
			precision : 5,
			decimal : ".",
			allow_negative : true
		}, p_settings);
		var decimal = settings.decimal;
		wrongFormatHandler = typeof wrongFormatHandler == "function" ? wrongFormatHandler : function() {
		};
		this.keypress(function(d) {
			$(this).data("old-value", $(this).val());
			var a = d.charCode ? d.charCode : d.keyCode ? d.keyCode : 0;
			if (a == 13 && this.nodeName.toLowerCase() != "input") {
				return false
			}
			if ((d.ctrlKey && (a == 97 || a == 65 || a == 120 || a == 88 || a == 99 || a == 67 || a == 122 || a == 90 || a == 118 || a == 86 || a == 45)) || (a == 46 && d.which != null && d.which == 0))
				return true;
			if (a < 48 || a > 57) {
				if (settings.type == "decimal") {
					if (settings.allow_negative && a == 45 && this.value.length == 0)
						return true;
					if (settings.allow_negative && a == 45 && this.value.length > 0) {
						if ((this.selectionStart != undefined && this.selectionStart == 0)/* IE>8|MOZILLA|CHROME */ || (document.selection != undefined && getCursorPos(this) == 0)/* IE<=8 */) {
							if (this.value.charCodeAt(0) != a)
								return true;
							else if (this.selectionEnd && this.selectionEnd == this.value.length)
								return true;
							else
								return false;
						}
					}
					if (a == decimal.charCodeAt(0)) {
						if (settings.precision > 0 && this.value.indexOf(decimal) == -1)
							return true;
						else
							return false
					}
					if (a != 8 && a != 9 && a != 13 && a != 35 && a != 36 && a != 37 && a != 39) {
						return false
					}
					return true
				} else if (settings.type == "email") {
					if (a == 8 || a == 9 || a == 13 || (a > 34 && a < 38) || a == 39 || a == 45 || a == 46 || (a > 64 && a < 91) || (a > 96 && a < 123) || a == 95) {
						return true
					}
					if (a == 64 && this.value.indexOf("@") == -1)
						return true;
					return false
				} else if (settings.type == "phone-number") {
					if (a == 45 && this.value.length == 0)
						return false;
					if (a == 8 || a == 9 || a == 13 || (a > 34 && a < 38) || a == 39 || a == 45) {
						return true
					}
					return false
				} else if (settings.type == "alphabet") {
					if (a == 8 || a == 9 || a == 13 || (a > 34 && a < 38) || a == 39 || (a > 64 && a < 91) || (a > 96 && a < 123))
						return true
				} else
					return false
			} else {
				if (settings.type == "decimal") {
					if (this.value.indexOf(settings.decimal) == -1 && (this.value.length < settings.int || (this.value.charAt(0) == '-' && this.value.length + 1 < settings.int)))
						return true;
					else if (this.value.indexOf(settings.decimal) > -1) {
						var newValue = insertAtCursor(this, String.fromCharCode(a));
						if (newValue.indexOf(settings.decimal) == -1 && newValue.length < settings.int)
							return true;
						else
							return new RegExp(formatter.getRegex(settings)).test(newValue);
					} else
						return false;
				}
				if (settings.type == "alphabet") {
					return false
				} else
					return true
			}
		}).blur(function() {// TODO FALTA CORRIGIR O TABINDEX
			if (settings.type == "email") {
				if (!formatter.isEmail(this)) {
					wrongFormatHandler.apply(this)
				}
			} else {
				if (!$(this).is(":regex(" + formatter.getRegex(settings) + ")")) {
					if (settings.type == "decimal" && this.value.length == 1 && this.value.charCodeAt(0) == 45)
						this.value = '';
					wrongFormatHandler.apply(this)
				}
				else {
					if (settings.type == "decimal" && this.value.length>0) { // formata o número após sair do campo
						// jquery.format-1.2.js
						float = parseFloat(this.value.replace(",","."));
						var mask = "#,##0";
						if (settings.precision>0) {
							mask += '.';
							for (var index=0; index<settings.precision; index++)
								mask += '0';
						}
						this.value = $.format.number(float, mask);
					}
				}
			}
		}).focus(function() {
			$(this).select();
			// desformata o número ao entrar no campo
			var indexDot = this.value.indexOf('.');
			var indexComma = this.value.indexOf(',');
			if (indexDot>-1&&indexComma>-1&&indexComma>indexDot) this.value = this.value.replace(".","");
			if (indexDot>-1&&indexComma>-1&&indexComma<indexDot) this.value = this.value.replace(",","");
		});
		return this
	}
})(jQuery);

//--------------------------------------------------------------------------------
//TODO incluir estas funções abaixo dentro do jQuery

//This function returns the index of the cursor location in
//the value of the input text element
//It is important to make sure that the sWeirdString variable contains
//a set of characters that will not be encountered normally in your text
function getCursorPos(textElement) {
	// save off the current value to restore it later,
	// var sOldText = textElement.value;

	// create a range object and save off it's text
	var objRange = document.selection.createRange();
	var sOldRange = objRange.text;

	// set this string to a small string that will not normally be encountered
	var sWeirdString = '#%~';

	// insert the weirdstring where the cursor is at
	objRange.text = sOldRange + sWeirdString;
	objRange.moveStart('character', (0 - sOldRange.length - sWeirdString.length));

	// save off the new string with the weirdstring in it
	var sNewText = textElement.value;

	// set the actual text value back to how it was
	objRange.text = sOldRange;

	// look through the new string we saved off and find the location of
	// the weirdstring that was inserted and return that value
	for ( var index = 0; index <= sNewText.length; index++) {
		var sTemp = sNewText.substring(index, index + sWeirdString.length);
		if (sTemp == sWeirdString) {
			var cursorPos = (index - sOldRange.length);
			return cursorPos;
		}
	}
}
function insertAtPosition(myField, myValue, startPos, endPos) {
	var length = myField.value.charAt(0) == '-' ? myField.value.length + 1 : myField.value.length;
	if ((endPos - startPos) == length)
		return myValue;
	else
		return myField.value.substring(0, startPos) + myValue + myField.value.substring(endPos, length);
}
function insertAtCursor(myField, myValue) {
	// <=IE8 support
	if (document.selection) {
		myField.focus();
		var startPos = getCursorPos(myField);
		var endPos = startPos + document.selection.createRange().text.length;
		return insertAtPosition(myField, myValue, startPos, endPos);
	}
	// IE9/MOZILLA/NETSCAPE/CHROME support
	else if (myField.selectionStart || myField.selectionStart == '0') {
		return insertAtPosition(myField, myValue, myField.selectionStart, myField.selectionEnd);
	} else {
		return myField.value + myValue;
	}
}
//--------------------------------------------------------------------------------