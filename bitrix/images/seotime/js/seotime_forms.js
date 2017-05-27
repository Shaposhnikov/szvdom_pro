var forms_seotime = {
    0: {'goal': 'common',	'caption': 'Общая цель'},
    1: {'goal': 'conslut',	'caption': 'Получить консультацию'},
    2: {'goal': 'details',	'caption': 'Узнать подробности'},
    3: {'goal': 'preview',	'caption': 'Запись на просмотр'},
    4: {'goal': 'price',	'caption': 'Узнать цену'},
    5: {'goal': 'mortgage',	'caption': 'Расчитать ипотеку'},
    6: {'goal': 'offer',	'caption': 'Лучшее предложение'}
};

$(document).ready(function(){
    $('html').bind('click keyup', function(e){
        var visible_forms = $('.modalDialog:visible').filter(function(){ return $(this).css('opacity') > 0; });
        if ( visible_forms.length ) {
            var close = e.type == 'keyup' ? e.keyCode == 27 : true;
            if (close) window.location.hash = 'close';
        }
    });

    $('.modalDialog').on('click', 'div', function(e){ e.stopPropagation(); });


    $('html').on('focus', '.modalDialog .popup-form input', function(){
        $(this).css('border','none');
    });

    $('html').on('submit', '.modalDialog .popup-form', function(e){
        e.preventDefault();
        var form_container = $(this).parent().parent(),
            form_id = parseInt(form_container.attr('id').substr(-2)),
            forms_seotime_keys = Object.keys(forms_seotime),
            invalid_data_count = 0,
            form_data;

        $(this).find('input[type!="submit"]').each(function(){
            var cur_name = $(this).attr('name'),
                cur_val = $(this).val();

            if (cur_val.length == 0) {
                invalid_data_count++;
                $(this).css('border','1px solid #f00');
            } else {
                // если данные есть, запишем их в соответствующие поля других форм (чтобы человеку, например, не надо было несколько раз указывать один и тот же номер)
                $('.modalDialog .popup-form input[name='+cur_name.replace(/(\[|\])/g, '\\$1')+']').val(cur_val);
            }
        });

        if ( invalid_data_count == 0 &&
            !isNaN(form_id) &&
            form_id > 0 &&
            forms_seotime_keys.indexOf(form_id.toString())
        ) {
            form_data = $(this).serialize();

            if ( form_id == 5 ) {
                form_data += '&price='+form_container.find('.price').text();
            }

            $.ajax({
                url: '/bitrix/images/seotime/js/seotime_forms.ajax.php',
                data: form_data + '&type=' + form_id,
                dataType: 'json',
                method: 'POST',
                success: function(response) {
                    form_container.children('div').html(response.message);
                    if ( response.code ) {
                         yaCounter21785827.reachGoal(forms_seotime[0].goal);
                         yaCounter21785827.reachGoal(forms_seotime[form_id].goal);
                    }
                }
            });
        }
    })
});