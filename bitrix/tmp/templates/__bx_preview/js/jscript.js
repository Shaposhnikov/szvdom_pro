var top_show = 150; // В каком положении полосы прокрутки начинать показ кнопки "Наверх"
var delay = 1000; // Задержка прокрутки


$(document).ready(function () {
    $('.bx_filter_parameters_box.REGION input:checkbox').each(function () {
        if ($(this).is(':checked')) {
            $("label[for='" + $(this).attr("id") + "'].remote_control_lable").addClass('checked');
            var data = {"alwaysOn": true};
            $("#area_" + $(this).attr("id")).data('maphilight', data).trigger('alwaysOn.maphilight');
            var chec = indexOf($("label[for='" + $(this).attr("id") + "'].remote_control_lable").data('xml'), ',');
            if (chec == -1) {
                var ar = $("label[for='" + $(this).attr("id") + "'].remote_control_lable").data('xml');
            } else {
                var ar = $("label[for='" + $(this).attr("id") + "'].remote_control_lable").data('xml').split(',');
            }
            $(".remoteControlMetro .metroMap label").each(function () {
                $(this).data('region', 'Y');
                if ($(this).data('fund') != "disabled") {
                    var xml = $(this).data('xml'),
                        forHtml = $(this).attr('for');
                    if (chec == -1) {
                        if (xml == ar) {
                            $(this).removeClass('disabled');
                            $(this).addClass('active');
                            $(this).data('already', 'Y');
                            $("#" + forHtml).attr("disabled", false);
                        } else {
                            if ($(this).data('already') != "Y") {
                                $(this).removeClass('active');
                                $(this).addClass('disabled');
                                $("#" + forHtml).attr("disabled", true);
                            }
                        }
                    } else {
                        for (var ii = 0; ii < ar.length; ii++) {
                            if (xml == ar[ii]) {
                                $(this).removeClass('disabled');
                                $(this).addClass('active');
                                $(this).data('already', 'Y');
                                $("#" + forHtml).attr("disabled", false);
                            } else {
                                if ($(this).data('already') != "Y") {
                                    $(this).removeClass('active');
                                    $(this).addClass('disabled');
                                    $("#" + forHtml).attr("disabled", true);
                                }
                            }
                        }
                    }
                }

            });
        } else {
            $("label[for='" + $(this).attr("id") + "'].remote_control_lable").removeClass('checked');
            var childrens = $(".remoteControlMetro .metroMap label").each(function () {
                $(this).data('region', 'N');
                var prev = $(this).data('fund'),
                    forHtml = $(this).attr('for');
                $(this).removeClass('disabled');
                $(this).removeClass('active');
                $(this).addClass(prev);
                $("#" + forHtml).attr("disabled", false);
            });
        }
        $(this).bind("click", function () {
            if ($(this).is(':checked')) {
                $("label[for='" + $(this).attr("id") + "'].remote_control_lable").addClass('checked');
                var data = {"alwaysOn": true};
                $("#area_" + $(this).attr("id")).data('maphilight', data).trigger('alwaysOn.maphilight');
                var chec = indexOf($("label[for='" + $(this).attr("id") + "'].remote_control_lable").data('xml'), ',');
                if (chec == -1) {
                    var ar = $("label[for='" + $(this).attr("id") + "'].remote_control_lable").data('xml');
                } else {
                    var ar = $("label[for='" + $(this).attr("id") + "'].remote_control_lable").data('xml').split(',');
                }

                $(".remoteControlMetro .metroMap label").each(function () {
                    $(this).data('region', 'Y');
                    if ($(this).data('fund') != "disabled") {
                        var xml = $(this).data('xml'),
                            forHtml = $(this).attr('for');
                        if (chec == -1) {
                            if (xml == ar) {
                                $(this).removeClass('disabled');
                                $(this).addClass('active');
                                $(this).data('already', 'Y');
                                $("#" + forHtml).attr("disabled", false);
                            } else {
                                if ($(this).data('already') != "Y") {
                                    $(this).removeClass('active');
                                    $(this).addClass('disabled');
                                    $("#" + forHtml).attr("disabled", true);
                                }
                            }
                        } else {
                            for (var ii = 0; ii < ar.length; ii++) {
                                if (xml == ar[ii]) {
                                    $(this).removeClass('disabled');
                                    $(this).addClass('active');
                                    $(this).data('already', 'Y');
                                    $("#" + forHtml).attr("disabled", false);
                                } else {
                                    if ($(this).data('already') != "Y") {
                                        $(this).removeClass('active');
                                        $(this).addClass('disabled');
                                        $("#" + forHtml).attr("disabled", true);
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                $("label[for='" + $(this).attr("id") + "'].remote_control_lable").removeClass('checked');
                var data = {"alwaysOn": false};
                $("#area_" + $(this).attr("id")).data('maphilight', data).trigger('alwaysOn.maphilight');
                $(".remoteControlMetro .metroMap label").each(function () {
                    $(this).data('region', 'N');
                    var prev = $(this).data('fund'),
                        forHtml = $(this).attr('for');
                    $(this).removeClass('disabled');
                    $(this).removeClass('active');
                    $(this).addClass(prev);
                    $("#" + forHtml).attr("disabled", false);
                });
            }
        })
    });
    $(window).scroll(function () { // При прокрутке попадаем в эту функцию
        /* В зависимости от положения полосы прокрукти и значения top_show, скрываем или открываем кнопку "Наверх" */
        if ($(this).scrollTop() > top_show) $('#top').fadeIn();
        else $('#top').fadeOut();
    });
    $(".valid_number").bind("keyup paste", function(){
        setTimeout(jQuery.proxy(function() {
            this.val(this.val().replace(/[^0-9]/g, ''));
        }, $(this)), 0);
    });
    function changeRightColumnPopUp(value) {
        var parent = document.getElementById('rightColumnPopUp'),
            elems = parent.getElementsByClassName('searchBlockPopUp');
        parent.removeAttribute('style');
        var disp = document.getElementsByClassName('leftColumnPopUp'),
            nextS = disp[0].getElementsByTagName('ul'),
            displayS = nextS[0].getElementsByTagName('li');
        for (var j = 0; j < displayS.length; j++) {
            var atrrrData = displayS[j].getAttribute('data-rel');
            if (atrrrData == value) {
                displayS[j].className = "activeTab";
            } else {
                displayS[j].className = "notActiveTab";
            }
        }
        for (var i = 0; i < elems.length; i++) {
            var atrrData = elems[i].getAttribute('data-rel');
            if (atrrData == value) {
                elems[i].style.display = 'block';
            } else {
                elems[i].style.display = 'none';
            }
        }
        var all = 0;
        $('.leftColumnPopUp ul').children().each(function(){
        	var he = $(this).height();
        	all += parseInt(he);
        });
/*        var right = $('#rightColumnPopUp').outerHeight(),
            left = all+60; 
        
        if (right < left) {
            $('#rightColumnPopUp').height(left);
        } else {
            $('#rightColumnPopUp').height(right);
        }*/
        //$('#rightColumnPopUp').height(all+60);
		$('#rightColumnPopUp').height('720');
    }

    $('.changeIt').click(function () {
        changeRightColumnPopUp($(this).data('rel'));
    });

    $('.closeElementPopUp').click(function () {
        $('.feedbackWrap').fadeOut(500);
        $('.popUpWindowOverlay').fadeOut(500);
        $(".otv_vopr_feedback").fadeOut(500);
    });

    $('.showItNew').click(function (e) {
        $('.popUpWindowOverlay').fadeIn(500);
        $(".otv_vopr_feedback").fadeIn(500);
    });

    $('.showIt').click(function (e) {
        var who = $(this).data('who');
        if (who == "popUpSelect") {
            tp = $(this).data('type');
            changeRightColumnPopUp(tp);
/*            if (tp !== "По метро") {
                $('.popUpSelectInner #rightColumnPopUp').css('height', '749px');
            } else {
                $('.popUpSelectInner #rightColumnPopUp').css('height', '1150px');
            }*/
        }
        if (void 0 !== $(this).data('formsend')){
            var inpt = $('.' + who).find(".purposeMetr");
            inpt.val($(this).data('formsend'));
        }
        var thisCall =  $('.' + who).find('.calltouchId');
        thisCall.val(window.call_value);
        $('.' + who).fadeIn(500);
        $('.popUpWindowOverlay').css('display', 'block');
        
        
        
        $('.' + who).css('margin-top',$('.' + who).outerHeight()/2*(-1));
        
        /*
        var DH = $(document).height(), WH = $(window).height(), ST = $(window).scrollTop(), PH = $(this).outerHeight();
        
        if (WH < PH) {
            if (ST + WH > DH - 10) {
                $('.feedbackWrap').css({bottom: '10px', top: ''});
            } else {
                $('.feedbackWrap').css('top', 50 + ST);
            }
        } else {
            
        	formula = (WH - $('.' + who).outerHeight()) / 2 + ST;
            
            if (WH == DH) {
             $('.feedbackWrap').css('top', 50 + ST);
             } else {
             $('.feedbackWrap').css('top', formula); 
             }
            /*if (who == "popUpSelect") {
        		
				$('.feedbackWrap').css('top', formula);
        	}else{
        		$('.feedbackWrap').css('top', 50 + ST);
        	}*/
       /*}*/
    });


    
    function indexOf(str, target) {
        for (var i = 0, l = str.length; i < l; i++) {
            if (str[i] === target) {
                return i;
            }
        }
        return -1;
    }


    $('.popupImage').click(function () {
        var src = $(this).data('src'),
            alt = $(this).data('alt');
        $('.popupFullScreen').fadeIn();
        $('.popupFullScreen .innerPopup').html('<img src="' + src + '" alt="' + alt + '" title="' + alt + '" width="500"  />');
        $('.popUpWindowOverlayImage').css('display', 'block');
        var DH = $(document).height(), WH = $(window).height(), ST = $(window).scrollTop(), PH = $(this).outerHeight();
        if (WH < PH) {
            if (ST + WH > DH - 10) {
                $('.popupFullScreen').css({bottom: '10px', top: ''});
            } else {
                $('.popupFullScreen').css('top', 50 + ST);
            }
        } else {
            $('.popupFullScreen').css('top', 50 + ST);
        }
    });

    $('.filterHide').click(function(){
        $('.filterBlock').fadeIn(300);
        $(this).css('display','none');
        $('.bx_filter').css('display','block');
    });


    $('.popupImage2').click(function () {
        var src = $(this).data('src'),
            alt = $(this).data('alt');
        $('.popupFullScreen2').fadeIn();
        $('.popupFullScreen2 .innerPopup').html('<img src="' + src + '" alt="' + alt + '" title="' + alt + '"   />');
        $('.popupFullScreen2 .innerLabel').html('<p>' + alt + '</p>');
        $('.popUpWindowOverlayImage').css('display', 'block');
        var DH = $(document).height(), WH = $(window).height(), ST = $(window).scrollTop(), PH = $(this).outerHeight();
        if (WH < PH) {
            if (ST + WH > DH - 10) {
                $('.popupFullScreen2').css({bottom: '10px', top: ''});
            } else {
                $('.popupFullScreen2').css('top', 50 + ST);
            }
        } else {

            $('.popupFullScreen2').css('top', ST + 200);
        }
    });

    $('#top').click(function () { // При клике по кнопке "Наверх" попадаем в эту функцию
        /* Плавная прокрутка наверх */
        $('body, html').animate({
            scrollTop: 0
        }, delay);
    });
    $('.bx_filter_parameters_box.SUBWAYS input:checkbox').each(function () {
        if ($(this).is(':checked')) {
            $("label[for='" + $(this).attr("id") + "'].remote_control_lable").addClass('checked')
        } else {
            $("label[for='" + $(this).attr("id") + "'].remote_control_lable").removeClass('checked')
        }
        $(this).bind("click", function () {
            if ($(this).is(':checked')) {
                $("label[for='" + $(this).attr("id") + "'].remote_control_lable").addClass('checked');
                if ($("label[for='" + $(this).attr("id") + "'].remote_control_lable").data('region') != "Y") {
                    var subw = $("label[for='" + $(this).attr("id") + "'].remote_control_lable").data("xml");
                    $(".remoteControlRegion .spb_region_list label").each(function () {
                        $(this).data('subway', 'Y');
                        var inp = $(this).attr('for');
                        if ($(this).data('xml')) {
                            $('#' + inp).attr("disabled", true);
                            var chec = indexOf($(this).data('xml'), ',');
                            if (chec == -1) {
                                if (subw == $(this).data('xml')) {
                                    $(this).addClass('checked');
                                    var data2 = {"alwaysOn": true};
                                    $("#area_" + inp).data('maphilight', data2).trigger('alwaysOn.maphilight');
                                    $(this).data('already', 'Y');
                                } else {
                                    if ($(this).data('already') != "Y") {
                                        $(this).removeClass('checked');
                                        var data2 = {"alwaysOn": false};
                                        $("#area_" + inp).data('maphilight', data2).trigger('alwaysOn.maphilight');
                                    }
                                }
                            } else {
                                var ar = $(this).data('xml').split(',');
                                for (var ii = 0; ii < ar.length; ii++) {
                                    if (ar[ii] == subw) {
                                        $(this).addClass('checked');
                                        var data2 = {"alwaysOn": true};
                                        $("#area_" + inp).data('maphilight', data2).trigger('alwaysOn.maphilight');
                                        $(this).data('already', 'Y');
                                    } else {
                                        if ($(this).data('already') != "Y") {
                                            $(this).removeClass('checked');
                                            var data2 = {"alwaysOn": false};
                                            $("#area_" + inp).data('maphilight', data2).trigger('alwaysOn.maphilight');
                                        }
                                    }
                                }
                            }
                        } else {
                            $('#' + inp).attr("disabled", true);
                            $(this).removeClass('checked');
                            var data2 = {"alwaysOn": false};
                            $("#area_" + inp).data('maphilight', data2).trigger('alwaysOn.maphilight');
                        }
                    });
                }
            } else {
                $("label[for='" + $(this).attr("id") + "'].remote_control_lable").removeClass('checked');
                if ($("label[for='" + $(this).attr("id") + "'].remote_control_lable").data('region') != "Y") {
                    $(".remoteControlRegion .spb_region_list label").each(function () {
                        $(this).data('subway', 'N');
                        var inp = $(this).attr('for');
                        $('#' + inp).attr("disabled", false);
                        $(this).removeClass('checked');
                        var data2 = {"alwaysOn": false};
                        $("#area_" + inp).data('maphilight', data2).trigger('alwaysOn.maphilight');
                    });
                }
            }
        })
    });
    $('.uncheckall.region').click(function () {
        var sub;
        $('.bx_filter_parameters_box.REGION input:checkbox').each(function () {
            $(this).trigger('click').attr('checked', false);
            $("label[for='" + $(this).attr("id") + "'].remote_control_lable").removeClass('checked');
            if ($("label[for='" + $(this).attr("id") + "'].remote_control_lable").data('subway') != "Y"){
                var data = {"alwaysOn": false};
                $("#area_" + $(this).attr("id")).data('maphilight', data).trigger('alwaysOn.maphilight');
                $(this).data('region', 'N');
                var inp = $(this).attr('for');
                $('#' + inp).attr("disabled", false);
                sub = false;
            }else{
                sub = true;
            }
        });
        if (sub == false){
            $(".remoteControlMetro .metroMap label").each(function () {
                $(this).data('already', 'N');
                $(this).data('region', 'N');
            });
        }
        setTimeout(function () {
            regionChecked()
        }, 500)
    });
    $('.uncheckall.metro').click(function () {
        var reg;
        $('.bx_filter_parameters_box.SUBWAYS input:checkbox').each(function () {
            $(this).trigger('click').attr('checked', false);
            $("label[for='" + $(this).attr("id") + "'].remote_control_lable").removeClass('checked');
            if ($("label[for='" + $(this).attr("id") + "'].remote_control_lable").data('region') != "Y"){
                var prev = $(this).data('fund'),
                    forHtml = $(this).attr('for');
                $(this).removeClass('disabled');
                $(this).removeClass('active');
                $(this).addClass(prev);
                $("#" + forHtml).attr("disabled", false);
                reg = false;
            }else{
                reg = true;
            }
        });
        if (reg == false){
            $(".remoteControlRegion .spb_region_list label").each(function () {
                $(this).data('subway', 'N');
                var inp = $(this).attr('for');
                $('#' + inp).attr("disabled", false);
                $(this).removeClass('checked');
                var data2 = {"alwaysOn": false};
                $("#area_" + inp).data('maphilight', data2).trigger('alwaysOn.maphilight');
            });
        }
        setTimeout(function () {
            metroChecked()
        }, 500)
    });
    $('.image_map').maphilight({fillColor: 'e42626', fillOpacity: 1, strokeColor: 'ffffff', strokeOpacity: 1, strokeWidth: 3});
    $('.region_map').click(function (e) {
        e.preventDefault();
        var area_id = $(this).attr('id');
        label_id = area_id.replace("area_", "");
        if ($('#' + label_id).length > 0 && $('#' + label_id).attr("disabled") != "disabled") {
            var data = $(this).mouseout().data('maphilight') || {};
            data.alwaysOn = !data.alwaysOn;
            $(this).data('maphilight', data).trigger('alwaysOn.maphilight');
            if (data.alwaysOn) {
                $("label[for='" + label_id + "'].remote_control_lable").trigger('click').addClass('checked');

                var chec = indexOf($("label[for='" + label_id + "'].remote_control_lable").data('xml'), ',');
                if (chec == -1) {
                    var ar = $("label[for='" + label_id + "'].remote_control_lable").data('xml');
                } else {
                    var ar = $("label[for='" + label_id + "'].remote_control_lable").data('xml').split(',');
                }

                $(".remoteControlMetro .metroMap label").each(function () {
                    $(this).data('region', 'Y');
                    if ($(this).data('fund') != "disabled") {

                        var xml = $(this).data('xml'),
                            forHtml = $(this).attr('for');
                        if (chec == -1) {
                            if (xml == ar) {
                                $(this).removeClass('disabled');
                                $(this).addClass('active');
                                $(this).data('already', 'Y');
                                $("#" + forHtml).attr("disabled", false);
                            } else {
                                if ($(this).data('already') != "Y") {
                                    $(this).removeClass('active');
                                    $(this).addClass('disabled');
                                    $("#" + forHtml).attr("disabled", true);
                                }
                            }
                        } else {
                            console.log("GOTCHA");
                            for (var ii = 0; ii < ar.length; ii++) {
                                if (xml == ar[ii]) {
                                    $(this).removeClass('disabled');
                                    $(this).addClass('active');
                                    $(this).data('already', 'Y');
                                    $("#" + forHtml).attr("disabled", false);
                                } else {
                                    if ($(this).data('already') != "Y") {
                                        $(this).removeClass('active');
                                        $(this).addClass('disabled');
                                        $("#" + forHtml).attr("disabled", true);
                                    }
                                }
                            }
                        }
                    }

                });
            } else {
                $("label[for='" + label_id + "'].remote_control_lable").trigger('click').removeClass('checked');
                $(".remoteControlMetro .metroMap label").each(function () {
                    $(this).data('region', 'N');
                    var prev = $(this).data('fund'),
                        forHtml = $(this).attr('for');
                    $(this).removeClass('disabled');
                    $(this).removeClass('active');
                    $(this).addClass(prev);
                    $("#" + forHtml).attr("disabled", false);
                });
            }
            setTimeout(function () {
                regionChecked()
            }, 500)
        }
    });
    $('.summCharTable tr').not('.titleTable').mouseenter(function () {
        $(this).children().css({'color': '#FFFFFF', 'background': '#276cb2', 'borderColor': '#276cb2'});
        $(this).children().children('a').css('color', '#68d8ed')
    }).mouseleave(function () {
        $(this).children().css({'color': '#464646', 'background': '#FFFFFF', 'borderColor': '#FFFFFF', 'borderBottom': '1px solid #e6e6e6'});
        $(this).children().children('a').css('color', '#276cb2');
        $(this).parent().children('tr:last').children().css('borderBottom', '1px solid #ffffff')
    });
    $('.region_map').mouseenter(function () {
        var area_id = $(this).attr('id');
        label_id = area_id.replace("area_", "");
        if (!$("label[for='" + label_id + "'].remote_control_lable").hasClass('checked')) {
            $("label[for='" + label_id + "'].remote_control_lable").addClass('hover')
        }
    }).mouseleave(function () {
        var area_id = $(this).attr('id');
        label_id = area_id.replace("area_", "");
        if (!$("label[for='" + label_id + "'].remote_control_lable").hasClass('checked')) {
            $("label[for='" + label_id + "'].remote_control_lable").removeClass('hover')
        }
    });
    $('.spb_region_list label').mouseenter(function () {
        if (!$(this).hasClass('checked')) {
            var label_id = $(this).attr('for');
            var data = {"alwaysOn": true};
            $("#area_" + label_id).data('maphilight', data).trigger('alwaysOn.maphilight')
        }
    }).mouseleave(function () {
        if (!$(this).hasClass('checked')) {
            var label_id = $(this).attr('for');
            var data = {"alwaysOn": false};
            $("#area_" + label_id).data('maphilight', data).trigger('alwaysOn.maphilight')
        }
    });
    $('.openRemoteControlPopup.Metro, .metroBtn').click(function () {
        $('.remoteControlBox').css('display', 'none');
        $('.remoteControlMetro').css('display', 'block');
        $('.metroBtn').addClass('active_tab');
        $('.regionBtn').removeClass('active_tab');
        $('.objListBtn').removeClass('active_tab');
        if ($(this).hasClass('openRemoteControlPopup')) {
            showRemoteControl();
            remoteControlHeight()
        } else {
            remoteControlHeight()
        }
    });
    $('.openRemoteControlPopup.Region, .regionBtn').click(function () {
        $('.remoteControlBox').css('display', 'none');
        $('.remoteControlRegion').css('display', 'block');
        $('.regionBtn').addClass('active_tab');
        $('.metroBtn').removeClass('active_tab');
        $('.objListBtn').removeClass('active_tab');
        if ($(this).hasClass('openRemoteControlPopup')) {
            showRemoteControl();
            remoteControlHeight()
        } else {
            remoteControlHeight()
        }
    });
    $('.openRemoteControlPopup.ObjList, .objListBtn').click(function () {
        $('.remoteControlBox').css('display', 'none');
        $('.remoteControlObjList').css('display', 'block');
        $('.objListBtn').addClass('active_tab');
        $('.regionBtn').removeClass('active_tab');
        $('.metroBtn').removeClass('active_tab');
        if ($(this).hasClass('openRemoteControlPopup')) {
            showRemoteControl();
            remoteControlHeight()
        } else {
            remoteControlHeight()
        }
    });
    $('.remoteControlMetro label').mouseup(function () {
        setTimeout(function () {
            metroChecked()
        }, 500)
    });
    metroChecked();
    function metroChecked() {
        var checked = $('.bx_filter_parameters_box.SUBWAYS input:checked').length;
        if (checked === 0) {
            $('.openRemoteControlPopup.Metro').text("Выберите метро").removeClass('choosen')
        } else {
            $('.openRemoteControlPopup.Metro').text("Выбрано " + (checked === 1 ? "метро" : "метро") + " (" + checked + ")").addClass('choosen')
        }
    }

    $('.remoteControlRegion label').mouseup(function () {
        setTimeout(function () {
            regionChecked()
        }, 500)
    });
    regionChecked();
    function regionChecked() {
        var checked = $('.bx_filter_parameters_box.REGION input:checked').length;
        if (checked === 0) {
            $('.openRemoteControlPopup.Region').text("Выберите район").removeClass('choosen')
        } else {
            $('.openRemoteControlPopup.Region').text("Выбрано " + (checked === 1 ? "район" : "районов") + " (" + checked + ")").addClass('choosen')
        }
    }

    function remoteControlHeight() {
        var DH = $(document).height(), WH = $(window).height(), ST = $(window).scrollTop(), PH = $('.remoteControlPopup').outerHeight();
        if (WH < PH) {
            if (ST + WH > DH - 10) {
                $('.remoteControlPopup').css({bottom: '10px', top: ''})
            } else {
                $('.remoteControlPopup').css('top', 10 + ST)
            }
        } else {
            if (WH == DH) {
                $('.remoteControlPopup').css('top', 10 + ST)
            } else {
                $('.remoteControlPopup').css('top', (WH - PH) / 2 + ST)
            }
        }
    }


    function showRemoteControl() {
        $('.remoteControlPopup').fadeIn(500);
        $('.remoteControlPopupBg').fadeIn(100);
        $('.remoteControlPopupClose, .remoteControlPopupBg').bind('click', function () {
            $('.remoteControlPopup').fadeOut(500, function () {
                $('.remoteControlPopupBg').fadeOut(500);
                $('.remoteControlPopup').fadeOut(500)
            });
            return false
        })
    }
   function sendCallTouch(name){
        $.ajax({
            url: "/include/sendCallTouch.php",
            dataType: "html",  
            type: 'POST',
            data: $(name).serialize(),
            success: function(data) {
            }
        });
    }

    function getCookie(name) {
        var pairs = document.cookie.split("; "),
            count = pairs.length, parts;
        while ( count-- ) {
            parts = pairs[count].split("=");
            if ( parts[0] === name )
                return parts[1];
        }
        return false;
    }
    function createCookie(name, value, days){
        if (days) {
            var date = new Date();
            date.setTime(date.getTime()+(days*24*60*60*1000));
            var expires = "; expires="+date.toGMTString();
        }
        else var expires = "";
        document.cookie = name+"="+value+expires+"; path=/";
    }
    setTimeout(function(){sessionStorage.grab = 1},30000);
    $(document).mouseleave(function (e) {
        if (e.pageY - $(window).scrollTop() < 0 && $('body').hasClass('grab') && sessionStorage.grab != 1 && getCookie('nograbers') != 1)  {
            if( $('.graber_bg').length == 0 ){
                GraberPopup();
                sessionStorage.grab = 1;
                createCookie('nograbers', 1, 30);
            }
        }
    });

    $(document).mousemove(function (e){
        var mouse_position = e.pageY - $(window).scrollTop();
        if (mouse_position.between(50,70, true) == true){
            $('body').addClass('grab');
        }
    });


    Number.prototype.between  = function (a, b, inclusive) {
        var min = Math.min.apply(Math, [a,b]),
            max = Math.max.apply(Math, [a,b]);
        return inclusive ? this >= min && this <= max : this > min && this < max;
    };

    function GraberPopup(){


       $('.superForm').fadeIn(500);
        $('.popUpWindowOverlay').css('display', 'block');
        var DH = $(document).height(), WH = $(window).height(), ST = $(window).scrollTop(), PH = $(this).outerHeight();
        if (WH < PH) {
            if (ST + WH > DH - 10) {
                $('.feedbackWrap').css({bottom: '10px', top: ''});
            } else {
                $('.feedbackWrap').css('top', 50 + ST);
            }
        } else {
            $('.feedbackWrap').css('top', 50 + ST);
        }
        /*
        $('body').prepend('<div class="graber_bg"><div class="graber_popup"><div class="graber_description"><h3>Не нашли то что искали?</h3><p>Оставьте свой номер, мы обязательно вам перезвоним и <br/>поможем с покупкой недвижимости!</p></div><div class="graber_form"><form method="POST"><div class="name_box inline"><p><b>Имя:</b></p><input class="graber_name" type="text" placeholder="Ваше имя..." /></div><div class="phone_box inline"><p><b>Номер телефона:</b></p><input class="graber_phone" type="text" placeholder="+7 ххх..." maxlength="12" /></div><div class="send_box"><div class="graber_send inline" onclick="yaCounter21785827.reachGoal(&quot;graber_send&quot;); return true;"><div class="graber_send_radius"><div class="graber_send_text">Жду звонка</div></div></div></div></form></div><div class="close_graber_popup" onclick="yaCounter21785827.reachGoal(&quot;graber_close&quot;); return true;">Спасибо, я всё нашёл(а)</div></div></div>');
        $(".graber_bg").fadeIn(1000);
        $(".graber_popup").fadeIn(1000);

        $('.close_graber_popup').bind('click', function (){
            $('.graber_popup').fadeOut(1000, function(){
                $('.graber_bg').remove();
            });
            return false;
        });

        $('.graber_send').bind('click', function(){

            var graber_phone = $('.graber_phone').val();
            var graber_name = $('.graber_name').val();

            var phoneformat = /^[0-9|+]+$/;
            if ((graber_phone == '') || (!graber_phone.match(phoneformat)) || (graber_phone.length < 10)){
                $('.graber_phone').removeClass('yes no').css('border', '1px solid #ff0000').addClass('no');
            }else{
                $('.graber_phone').removeClass('yes no').css('border', '1px solid #00ff12').addClass('yes');
            }

            if (graber_name == ''){
                $('.graber_name').removeClass('yes no').css('border', '1px solid #ff0000').addClass('no');
            }else{
                $('.graber_name').removeClass('yes no').css('border', '1px solid #00ff12').addClass('yes');
            }

            if($('.graber_phone').hasClass('yes') && $('.graber_name').hasClass('yes')){

                var dataString = { ajax: "graber", graber_phone: graber_phone, graber_name: graber_name, call_value: window.call_value };

                $.ajax({
                    type: "POST",
                    url: "/send.php",
                    data: dataString,
                    dataType: 'text',
                    async: false,
                    success: function(data) {
                        $('.graber_form form').remove();
                        $(".graber_form").append('<p class="graber_success">'+ data +'</p>').queue(function(){yaCounter21785827.reachGoal('graber_mail_send'); return true;});
                        $('.close_graber_popup').delay(1500).queue(function(){$('.close_graber_popup').trigger('click');});
                    }

                });

            }

            return false;
        });*/

    }





    $('.bx_filter_parameters_box.BANKS, .bx_filter_parameters_box.BUILDINGTYPE, .bx_filter_parameters_box.ENDINGPERIOD, .bx_filter_parameters_box.BUILDER, .bx_filter_parameters_box.EX_EXTRAS, .bx_filter_parameters_box.END_DATE, .bx_filter_parameters_box.BUILDING').click(function () {
        $(this).toggleClass('drop');
        $('.bx_filter_parameters_box').not($(this)).removeClass('drop');
    });
    $('.bx_filter_param_label').click(function(){
    	    var labelID = $(this).attr('for');
    	    if ($('#'+labelID).prop("checked") == true){
    	    	$(this).addClass('checkLab');
    	    }else if ($('#'+labelID).prop("checked") == false){
    	    	$(this).removeClass('checkLab');
    	    }
    });

$( "#toggleWork" ).click(function() {
    $( "#toggleWork" ).toggleClass( "showUP", 1000 );
    $( ".how_table" ).toggle(500);

    if($(this).hasClass('showUP')){
        $(this).html('развернуть<i class="bottom"></i>');
        $(this).css('width','91px');
    } else {
        $(this).html('cвернуть<i></i>');
        $(this).css('width','75px');
    }
});

});