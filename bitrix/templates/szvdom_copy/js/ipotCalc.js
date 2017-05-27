function checkNumberEntry(inputField, errorMsg) {
    var str = inputField;
    if (str.length == 0 || str == "0") {
        return false
    }
    return true
}

jQuery(document).ready(function () {
    $('.calcIpotBtn').bind('click', function () {
		if (calcPayment() == true){
			$(".new_ipoteka_calc .hidden_part").show();
		}
    });
    $('#firstPay').bind('keyup', function () {
        $('#percent').val(Math.round(($('#firstPay').val() / $('#flatPrice').val()) * 100))
    });
    $('#percent').bind('keyup', function () {
        $('#firstPay').val(Math.round(($('#flatPrice').val() * $('#percent').val()) / 100))
    });
    /*$('#flatPrice').bind('keyup', function () {
        var valueNoFormat = $(this).val(),
            value = 1*valueNoFormat.replace(/\s+/g, '');
        var   first = $(this).val()/1000,
            second = $(this).val()/10000,
            third = $(this).val()/100000,
            fourty = $(this).val()/1000000;
        console.log('***********************************************');
        console.log(first + ' - ' + second + ' - ' + third + ' - ' + fourty);
        var res = 0;
        if (fourty >= 1){

        }else if (third >= 1){

        }else if (second >= 1){

        }else if (first >= 1){
            var x1 = parseInt(first),
                z1 = (first - x1).toFixed(3);
            if (z1 != 0 ){
                res = x1+" "+z1*1000;
            }else{
                res = x1+" 000"
            }
            $(this).val(res);
        }

    });*/
    //str.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ')
});
function calcPayment() {
    jQuery('.ipotResult').html(' ');
    if (!checkNumberEntry($('#flatPrice').val(), "��������� ��������")) {
        $('#flatPrice').css({'border': 'solid 2px #f00'});
        return false
	}else{
	    $('#flatPrice').css({'border': '2px solid #e6eef6'});
	}
    if (!checkNumberEntry($('#firstPay').val(), "�������������� �����")) {
        $('#firstPay').css({'border': 'solid 2px #f00'});
        return false
    }else{
	    $('#firstPay').css({'border': '2px solid #e6eef6'});
	}
    if (!checkNumberEntry($('#yearPercent2').val(), "�������������� �����")) {
        $('#yearPercent2').css({'border': 'solid 2px #f00'});
        return false
    }else{
	    $('#yearPercent2').css({'border': '2px solid #e6eef6'});
	}

    var price = 1 * $('#flatPrice').val().replace(/\D/g, '');
    var cashDown = 1 * $('#firstPay').val().replace(/\D/g, '');
    var yearPercent2 =  1 * $('#yearPercent2').val().replace(/\D/g, '');

    if ($('#yearsCount').val() == '') {
        $('#yearsCount').css({'border': 'solid 2px #f00'});
        return false
    }
    var rate = (1 * $('#yearPercent2').val());
    var months = 12 * $('#yearsCount').val();
    var period = 12;
    var amtLoaned = price - cashDown;
    var adjRate = rate / (period * 100);
    var payment = 0;
    if (adjRate == 0) {
        payment = (amtLoaned) / months
    } else {
        b = Math.pow(1 + adjRate, months);

    payment = ((adjRate * (amtLoaned) * b) / (b - 1));

    payment = payment * ((100 - yearPercent2) / 100);

    }
    var intPayment = Math.round(payment);
    var strPayment = "" + (intPayment);
    finalPayment = number_format(strPayment, 0, '.', ' ');
    $('#flatPrice').css({'border': '2px solid #e6eef6'});
    $('#firstPay').css({'border': '2px solid #e6eef6'});
    $('#yearsCount').css({'border': '2px solid #e6eef6'});
    $('#result').val(finalPayment);
    finalPayment = finalPayment;
    $('#result_div').html(finalPayment);
	console.log ("calc done");
	$(".new_ipoteka_calc .hidden_part").show();
    return true
}

function number_format(number, decimals, dec_point, thousands_sep) {
    var i, j, kw, kd, km;
    if (isNaN(decimals = Math.abs(decimals))) {
        decimals = 2
    }
    if (dec_point == undefined) {
        dec_point = ","
    }
    if (thousands_sep == undefined) {
        thousands_sep = "."
    }
    i = parseInt(number = (+number || 0).toFixed(decimals)) + "";
    if ((j = i.length) > 3) {
        j = j % 3
    } else {
        j = 0
    }
    km = (j ? i.substr(0, j) + thousands_sep : "");
    kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
    kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");
    return km + kw + kd
}
function sendShortIpotOrder() {
    jQuery('.ipotResult').html(' ');
    jQuery('#calc input').css({'border': 'solid 1px #B0B2B5'});
    var f = document.theForm;
    if (!f.name.value) {
        jQuery('.ipotResult').html('������! ������� ���!');
        jQuery('#calc input[name=name]').css({'border': 'solid 1px #f00'});
        return
    }
    if (!f.phone.value) {
        jQuery('.ipotResult').html('������! ������� �������!');
        jQuery('#calc input[name=phone]').css({'border': 'solid 1px #f00'});
        return
    }
    if (f.captcha.value != '11') {
        jQuery('.ipotResult').html('������! ������� ���� ������!');
        jQuery('#calc input[name=captcha]').css({'border': 'solid 1px #f00'});
        return
    }
    var data = jQuery('#calc').serializeArray();
    jQuery.post("/?option=com_realty&task=ipotOrderShort", data, function (res) {
        if (res.status == 'ok') {
            jQuery('.ipotResult').html('����� ������� ����������!')
        } else if (res.status == 'badcaptcha') {
            jQuery('.ipotResult').html('����������� ���� ������!')
        } else {
            jQuery('.ipotResult').html('����������� ������!')
        }
    }, 'json')
}
jQuery(function () {
    jQuery('[name="pv"],[name="cashdown"]').keyup(function () {
        jQuery(this).val(number_format(jQuery(this).val().replace(/\D/g, ''), 0, '', ' '))
    })
});


function sendIpotekaMail(){

	$.post( "/include/ipotekaMailTableSend.php", { fio: $("#ipotekaMailTableFio").val(), phone: $("#ipotekaMailTablePhone").val(), flatPrice: $("#flatPrice").val(), yearsCount: $("#yearsCount").val(), firstPay: $("#firstPay").val(), yearPercent2: $("#yearPercent2").val(), result: $(".new_ipoteka_calc #result_div").html
()  }, function(){

		$(".ipotekaMailTable").html ("<h2>Ваше сообщение отправлено!</h2>");

	});

}



