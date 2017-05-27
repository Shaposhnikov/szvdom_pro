function JCSmartFilter(ajaxURL, viewMode)
{
	this.ajaxURL = ajaxURL;
	this.form = null;
	this.timer = null;
	this.viewMode = viewMode;
}

JCSmartFilter.prototype.keyup = function(input)
{
	if(!!this.timer)
	{
		clearTimeout(this.timer);
	}
	this.timer = setTimeout(BX.delegate(function(){
		this.reload(input);
	}, this), 1000);
};

JCSmartFilter.prototype.click = function(checkbox)
{
	if(!!this.timer)
	{
		clearTimeout(this.timer);
	}
	this.timer = setTimeout(BX.delegate(function(){
		this.reload(checkbox);
	}, this), 1000);
};

JCSmartFilter.prototype.reload = function(input)
{
	var values = [];

	this.position = BX.pos(input, true);
	this.form = BX.findParent(input, {'tag':'form'});
	if (this.form)
	{
		values[0] = {name: 'ajax', value: 'y'};
		this.gatherInputsValues(values, BX.findChildren(this.form, {'tag': new RegExp('^(input|select)$', 'i')}, true));

		this.curFilterinput = input;
		BX.ajax.loadJSON(
			this.ajaxURL,
			this.values2post(values),
			BX.delegate(this.postHandler, this)
		);
	}
};

JCSmartFilter.prototype.postHandler = function (result)
{
	var PID, arItem, i, ar, control, hrefFILTER, url, curProp, trackBar;
	var modef = BX('modef');
	var modef_num = BX('modef_num');
	var set_filter = BX('set_filter');
	var rcElResult = BX('rcElResult');
	if (!!result && !!result.ITEMS)
	{
		for(PID in result.ITEMS)
		{
			if (result.ITEMS.hasOwnProperty(PID))
			{
				arItem = result.ITEMS[PID];
				if (arItem.PROPERTY_TYPE === 'N' || arItem.PRICE)
				{
					trackBar = window['trackBar' + PID];
					if (!trackBar && arItem.ENCODED_ID)
						trackBar = window['trackBar' + arItem.ENCODED_ID];

					if (trackBar && arItem.VALUES)
					{
						if (arItem.VALUES.MIN && arItem.VALUES.MIN.FILTERED_VALUE)
						{
							trackBar.setMinFilteredValue(arItem.VALUES.MIN.FILTERED_VALUE);
						}

						if (arItem.VALUES.MAX && arItem.VALUES.MAX.FILTERED_VALUE)
						{
							trackBar.setMaxFilteredValue(arItem.VALUES.MAX.FILTERED_VALUE);
						}
					}
				}
				else if (arItem.VALUES)
				{
					for (i in arItem.VALUES)
					{
						if (arItem.VALUES.hasOwnProperty(i))
						{
							ar = arItem.VALUES[i];
							control = BX(ar.CONTROL_ID);
							if (!!control)
							{
								var label = document.querySelector('[data-role="label_'+ar.CONTROL_ID+'"]');
								var label_input = document.querySelector('[id="'+ar.CONTROL_ID+'"]');
								if (ar.DISABLED)
								{
									if (label){
										BX.addClass(label, 'disabled');
										//BX.addClass(label_input, 'disabled');aleks
										//label_input.disabled = true;
									}else{
										BX.addClass(control.parentNode, 'disabled');
									}
								}
								else
								{
									if (label){
										BX.removeClass(label, 'disabled');
										//BX.removeClass(label_input, 'disabled');
										//label_input.disabled = false;
									}else{
										BX.removeClass(control.parentNode, 'disabled');
									}
								}
							}
						}
					}
				}
			}
		}

		if (!!modef && !!modef_num)
		{
			modef_num.innerHTML = result.ELEMENT_COUNT;
			
			//rcElResult.innerHTML = result.ELEMENT_COUNT;
			BX.ready(function(){$('.rcElResult').html(result.ELEMENT_COUNT);}); 
			hrefFILTER = BX.findChildren(modef, {tag: 'A'}, true);

			if (result.FILTER_URL && hrefFILTER)
			{
				hrefFILTER[0].href = BX.util.htmlspecialcharsback(result.FILTER_URL);
			}

			if (result.FILTER_AJAX_URL && result.COMPONENT_CONTAINER_ID)
			{
				BX.bind(hrefFILTER[0], 'click', function(e)
				{
					var url = BX.util.htmlspecialcharsback(result.FILTER_AJAX_URL);
					BX.ajax.insertToNode(url, result.COMPONENT_CONTAINER_ID);
					return BX.PreventDefault(e);
				});
			}

			if (result.INSTANT_RELOAD && result.COMPONENT_CONTAINER_ID)
			{
				url = BX.util.htmlspecialcharsback(result.FILTER_AJAX_URL);
				BX.ajax.insertToNode(url, result.COMPONENT_CONTAINER_ID);
			}
			else
			{
				if (modef.style.display === 'none')
				{
					modef.style.display = 'inline-block';
				}
				if (this.viewMode == "vertical")
				{
					curProp = BX.findChild(BX.findParent(this.curFilterinput, {'class':'bx_filter_parameters_box'}), {'class':'bx_filter_container_modef'}, true, false);
					curProp.appendChild(modef);
				}
			}
		}
	}
};

JCSmartFilter.prototype.gatherInputsValues = function (values, elements)
{
	if(elements)
	{
		for(var i = 0; i < elements.length; i++)
		{
			var el = elements[i];
			if (el.disabled || !el.type)
				continue;

			switch(el.type.toLowerCase())
			{
				case 'text':
				case 'textarea':
				case 'password':
				case 'hidden':
				case 'select-one':
					if(el.value.length)
						values[values.length] = {name : el.name, value : el.value};
					break;
				case 'radio':
				case 'checkbox':
					if(el.checked)
						values[values.length] = {name : el.name, value : el.value};
					break;
				case 'select-multiple':
					for (var j = 0; j < el.options.length; j++)
					{
						if (el.options[j].selected)
							values[values.length] = {name : el.name, value : el.options[j].value};
					}
					break;
				default:
					break;
			}
		}
	}
};

JCSmartFilter.prototype.values2post = function (values)
{
	var post = new Array;
	var current = post;
	var i = 0;
	while(i < values.length)
	{
		var p = values[i].name.indexOf('[');
		if(p == -1)
		{
			current[values[i].name] = values[i].value;
			current = post;
			i++;
		}
		else
		{
			var name = values[i].name.substring(0, p);
			var rest = values[i].name.substring(p+1);
			if(!current[name])
				current[name] = new Array;

			var pp = rest.indexOf(']');
			if(pp == -1)
			{
				//Error - not balanced brackets
				current = post;
				i++;
			}
			else if(pp == 0)
			{
				//No index specified - so take the next integer
				current = current[name];
				values[i].name = '' + current.length;
			}
			else
			{
				//Now index name becomes and name and we go deeper into the array
				current = current[name];
				values[i].name = rest.substring(0, pp) + rest.substring(pp+1);
			}
		}
	}
	return post;
};

JCSmartFilter.prototype.hideFilterProps = function(element)
{
	var easing;
	var obj = element.parentNode;
	var filterBlock = BX.findChild(obj, {className:"bx_filter_block"}, true, false);

	if(BX.hasClass(obj, "active"))
	{
		easing = new BX.easing({
			duration : 300,
			start : { opacity: 1,  height: filterBlock.offsetHeight },
			finish : { opacity: 0, height:0 },
			transition : BX.easing.transitions.quart,
			step : function(state){
				filterBlock.style.opacity = state.opacity;
				filterBlock.style.height = state.height + "px";
			},
			complete : function() {
				filterBlock.setAttribute("style", "");
				BX.removeClass(obj, "active");
			}
		});
		easing.animate();
	}
	else
	{
		filterBlock.style.display = "block";
		filterBlock.style.opacity = 0;
		filterBlock.style.height = "auto";

		var obj_children_height = filterBlock.offsetHeight;
		filterBlock.style.height = 0;

		easing = new BX.easing({
			duration : 300,
			start : { opacity: 0,  height: 0 },
			finish : { opacity: 1, height: obj_children_height },
			transition : BX.easing.transitions.quart,
			step : function(state){
				filterBlock.style.opacity = state.opacity;
				filterBlock.style.height = state.height + "px";
			},
			complete : function() {
			}
		});
		easing.animate();
		BX.addClass(obj, "active");
	}
};

JCSmartFilter.prototype.showDropDownPopup = function(element, popupId)
{
	var contentNode = element.querySelector('[data-role="dropdownContent"]');
	BX.PopupWindowManager.create("smartFilterDropDown"+popupId, element, {
		autoHide: true,
		offsetLeft: 0,
		offsetTop: 3,
		overlay : false,
		draggable: {restrict:true},
		closeByEsc: true,
		content: contentNode
	}).show();
};

JCSmartFilter.prototype.selectDropDownItem = function(element, controlId)
{
	this.keyup(BX(controlId));

	var wrapContainer = BX.findParent(BX(controlId), {className:"bx_filter_select_container"}, false);

	var currentOption = wrapContainer.querySelector('[data-role="currentOption"]');
	currentOption.innerHTML = element.innerHTML;
	BX.PopupWindowManager.getCurrentPopup().close();
};

BX.namespace("BX.Iblock.SmartFilter");
BX.Iblock.SmartFilter = (function()
{
	var SmartFilter = function(arParams)
	{
		if (typeof arParams === 'object')
		{
			this.leftSlider = BX(arParams.leftSlider);
			this.rightSlider = BX(arParams.rightSlider);
			this.tracker = BX(arParams.tracker);
			this.trackerWrap = BX(arParams.trackerWrap);

			this.minInput = BX(arParams.minInputId);
			this.maxInput = BX(arParams.maxInputId);

			this.minPrice = parseFloat(arParams.minPrice);
			this.maxPrice = parseFloat(arParams.maxPrice);

			this.curMinPrice = parseFloat(arParams.curMinPrice);
			this.curMaxPrice = parseFloat(arParams.curMaxPrice);

			this.fltMinPrice = arParams.fltMinPrice ? parseFloat(arParams.fltMinPrice) : parseFloat(arParams.curMinPrice);
			this.fltMaxPrice = arParams.fltMaxPrice ? parseFloat(arParams.fltMaxPrice) : parseFloat(arParams.curMaxPrice);

			this.precision = arParams.precision || 0;

			this.priceDiff = this.maxPrice - this.minPrice;

			this.leftPercent = 0;
			this.rightPercent = 0;

			this.fltMinPercent = 0;
			this.fltMaxPercent = 0;

			this.colorUnavailableActive = BX(arParams.colorUnavailableActive);//gray
			this.colorAvailableActive = BX(arParams.colorAvailableActive);//blue
			this.colorAvailableInactive = BX(arParams.colorAvailableInactive);//light blue

			this.isTouch = false;

			this.init();

			if ('ontouchstart' in document.documentElement)
			{
				this.isTouch = true;

				BX.bind(this.leftSlider, "touchstart", BX.proxy(function(event){
					this.onMoveLeftSlider(event)
				}, this));

				BX.bind(this.rightSlider, "touchstart", BX.proxy(function(event){
					this.onMoveRightSlider(event)
				}, this));
			}
			else
			{
				BX.bind(this.leftSlider, "mousedown", BX.proxy(function(event){
					this.onMoveLeftSlider(event)
				}, this));

				BX.bind(this.rightSlider, "mousedown", BX.proxy(function(event){
					this.onMoveRightSlider(event)
				}, this));
			}

			BX.bind(this.minInput, "keyup", BX.proxy(function(event){
				this.onInputChange();
			}, this));

			BX.bind(this.maxInput, "keyup", BX.proxy(function(event){
				this.onInputChange();
			}, this));
		}
	};

	SmartFilter.prototype.init = function()
	{
		var priceDiff;

		if (this.curMinPrice > this.minPrice)
		{
			priceDiff = this.curMinPrice - this.minPrice;
			this.leftPercent = (priceDiff*100)/this.priceDiff;

			this.leftSlider.style.left = this.leftPercent + "%";
			this.colorUnavailableActive.style.left = this.leftPercent + "%";
		}

		this.setMinFilteredValue(this.fltMinPrice);

		if (this.curMaxPrice < this.maxPrice)
		{
			priceDiff = this.maxPrice - this.curMaxPrice;
			this.rightPercent = (priceDiff*100)/this.priceDiff;

			this.rightSlider.style.right = this.rightPercent + "%";
			this.colorUnavailableActive.style.right = this.rightPercent + "%";
		}

		this.setMaxFilteredValue(this.fltMaxPrice);
	};

	SmartFilter.prototype.setMinFilteredValue = function (fltMinPrice)
	{
		this.fltMinPrice = parseFloat(fltMinPrice);
		if (this.fltMinPrice >= this.minPrice)
		{
			var priceDiff = this.fltMinPrice - this.minPrice;
			this.fltMinPercent = (priceDiff*100)/this.priceDiff;

			if (this.leftPercent > this.fltMinPercent)
				this.colorAvailableActive.style.left = this.leftPercent + "%";
			else
				this.colorAvailableActive.style.left = this.fltMinPercent + "%";

			this.colorAvailableInactive.style.left = this.fltMinPercent + "%";
		}
		else
		{
			this.colorAvailableActive.style.left = "0%";
			this.colorAvailableInactive.style.left = "0%";
		}
	};

	SmartFilter.prototype.setMaxFilteredValue = function (fltMaxPrice)
	{
		this.fltMaxPrice = parseFloat(fltMaxPrice);
		if (this.fltMaxPrice <= this.maxPrice)
		{
			var priceDiff = this.maxPrice - this.fltMaxPrice;
			this.fltMaxPercent = (priceDiff*100)/this.priceDiff;

			if (this.rightPercent > this.fltMaxPercent)
				this.colorAvailableActive.style.right = this.rightPercent + "%";
			else
				this.colorAvailableActive.style.right = this.fltMaxPercent + "%";

			this.colorAvailableInactive.style.right = this.fltMaxPercent + "%";
		}
		else
		{
			this.colorAvailableActive.style.right = "0%";
			this.colorAvailableInactive.style.right = "0%";
		}
	};

	SmartFilter.prototype.getXCoord = function(elem)
	{
		var box = elem.getBoundingClientRect();
		var body = document.body;
		var docElem = document.documentElement;

		var scrollLeft = window.pageXOffset || docElem.scrollLeft || body.scrollLeft;
		var clientLeft = docElem.clientLeft || body.clientLeft || 0;
		var left = box.left + scrollLeft - clientLeft;

		return Math.round(left);
	};

	SmartFilter.prototype.getPageX = function(e)
	{
		e = e || window.event;
		var pageX = null;

		if (this.isTouch && event.targetTouches[0] != null)
		{
			pageX = e.targetTouches[0].pageX;
		}
		else if (e.pageX != null)
		{
			pageX = e.pageX;
		}
		else if (e.clientX != null)
		{
			var html = document.documentElement;
			var body = document.body;

			pageX = e.clientX + (html.scrollLeft || body && body.scrollLeft || 0);
			pageX -= html.clientLeft || 0;
		}

		return pageX;
	};

	SmartFilter.prototype.recountMinPrice = function()
	{
		var newMinPrice = (this.priceDiff*this.leftPercent)/100;
		newMinPrice = (this.minPrice + newMinPrice).toFixed(this.precision);

		if (newMinPrice != this.minPrice)
			this.minInput.value = newMinPrice;
		else
			this.minInput.value = "";
		smartFilter.keyup(this.minInput);
		
		var showMinID = this.minInput.id;
		var showMinPrice = (newMinPrice > 1000000 ? Number((newMinPrice/1000000).toFixed(1)) : newMinPrice);
		BX.ready(function(){$('#show_'+showMinID).html(showMinPrice);});
	};

	SmartFilter.prototype.recountMaxPrice = function()
	{
		var newMaxPrice = (this.priceDiff*this.rightPercent)/100;
		newMaxPrice = (this.maxPrice - newMaxPrice).toFixed(this.precision);

		if (newMaxPrice != this.maxPrice)
			this.maxInput.value = newMaxPrice;
		else
			this.maxInput.value = "";
		smartFilter.keyup(this.maxInput);
		
		var showMaxID = this.maxInput.id;
		var showMaxPrice = (newMaxPrice > 1000000 ? Number((newMaxPrice/1000000).toFixed(1)) : newMaxPrice);
		BX.ready(function(){$('#show_'+showMaxID).html(showMaxPrice);});
	};

	SmartFilter.prototype.onInputChange = function ()
	{
		var priceDiff;
		if (this.minInput.value)
		{
			var leftInputValue = this.minInput.value;
			if (leftInputValue < this.minPrice)
				leftInputValue = this.minPrice;

			if (leftInputValue > this.maxPrice)
				leftInputValue = this.maxPrice;

			priceDiff = leftInputValue - this.minPrice;
			this.leftPercent = (priceDiff*100)/this.priceDiff;

			this.makeLeftSliderMove(false);
		}

		if (this.maxInput.value)
		{
			var rightInputValue = this.maxInput.value;
			if (rightInputValue < this.minPrice)
				rightInputValue = this.minPrice;

			if (rightInputValue > this.maxPrice)
				rightInputValue = this.maxPrice;

			priceDiff = this.maxPrice - rightInputValue;
			this.rightPercent = (priceDiff*100)/this.priceDiff;

			this.makeRightSliderMove(false);
		}
	};

	SmartFilter.prototype.makeLeftSliderMove = function(recountPrice)
	{
		recountPrice = (recountPrice === false) ? false : true;

		this.leftSlider.style.left = this.leftPercent + "%";
		this.colorUnavailableActive.style.left = this.leftPercent + "%";

		var areBothSlidersMoving = false;
		if (this.leftPercent + this.rightPercent >= 100)
		{
			areBothSlidersMoving = true;
			this.rightPercent = 100 - this.leftPercent;
			this.rightSlider.style.right = this.rightPercent + "%";
			this.colorUnavailableActive.style.right = this.rightPercent + "%";
		}

		if (this.leftPercent >= this.fltMinPercent && this.leftPercent <= (100-this.fltMaxPercent))
		{
			this.colorAvailableActive.style.left = this.leftPercent + "%";
			if (areBothSlidersMoving)
			{
				this.colorAvailableActive.style.right = 100 - this.leftPercent + "%";
			}
		}
		else if(this.leftPercent <= this.fltMinPercent)
		{
			this.colorAvailableActive.style.left = this.fltMinPercent + "%";
			if (areBothSlidersMoving)
			{
				this.colorAvailableActive.style.right = 100 - this.fltMinPercent + "%";
			}
		}
		else if(this.leftPercent >= this.fltMaxPercent)
		{
			this.colorAvailableActive.style.left = 100-this.fltMaxPercent + "%";
			if (areBothSlidersMoving)
			{
				this.colorAvailableActive.style.right = this.fltMaxPercent + "%";
			}
		}

		if (recountPrice)
		{
			this.recountMinPrice();
			if (areBothSlidersMoving)
				this.recountMaxPrice();
		}
	};

	SmartFilter.prototype.countNewLeft = function(event)
	{
		pageX = this.getPageX(event);

		var trackerXCoord = this.getXCoord(this.trackerWrap);
		var rightEdge = this.trackerWrap.offsetWidth;

		var newLeft = pageX - trackerXCoord;

		if (newLeft < 0)
			newLeft = 0;
		else if (newLeft > rightEdge)
			newLeft = rightEdge;

		return newLeft;
	};

	SmartFilter.prototype.onMoveLeftSlider = function(e)
	{
		if (!this.isTouch)
		{
			this.leftSlider.ondragstart = function() {
				return false;
			};
		}

		if (!this.isTouch)
		{
			document.onmousemove = BX.proxy(function(event) {
				this.leftPercent = ((this.countNewLeft(event)*100)/this.trackerWrap.offsetWidth);
				this.makeLeftSliderMove();
			}, this);

			document.onmouseup = function() {
				document.onmousemove = document.onmouseup = null;
			};
		}
		else
		{
			document.ontouchmove = BX.proxy(function(event) {
				this.leftPercent = ((this.countNewLeft(event)*100)/this.trackerWrap.offsetWidth);
				this.makeLeftSliderMove();
			}, this);

			document.ontouchend = function() {
				document.ontouchmove = document.touchend = null;
			};
		}

		return false;
	};

	SmartFilter.prototype.makeRightSliderMove = function(recountPrice)
	{
		recountPrice = (recountPrice === false) ? false : true;

		this.rightSlider.style.right = this.rightPercent + "%";
		this.colorUnavailableActive.style.right = this.rightPercent + "%";

		var areBothSlidersMoving = false;
		if (this.leftPercent + this.rightPercent >= 100)
		{
			areBothSlidersMoving = true;
			this.leftPercent = 100 - this.rightPercent;
			this.leftSlider.style.left = this.leftPercent + "%";
			this.colorUnavailableActive.style.left = this.leftPercent + "%";
		}

		if ((100-this.rightPercent) >= this.fltMinPercent && this.rightPercent >= this.fltMaxPercent)
		{
			this.colorAvailableActive.style.right = this.rightPercent + "%";
			if (areBothSlidersMoving)
			{
				this.colorAvailableActive.style.left = 100 - this.rightPercent + "%";
			}
		}
		else if(this.rightPercent <= this.fltMaxPercent)
		{
			this.colorAvailableActive.style.right = this.fltMaxPercent + "%";
			if (areBothSlidersMoving)
			{
				this.colorAvailableActive.style.left = 100 - this.fltMaxPercent + "%";
			}
		}
		else if((100-this.rightPercent) <= this.fltMinPercent)
		{
			this.colorAvailableActive.style.right = 100-this.fltMinPercent + "%";
			if (areBothSlidersMoving)
			{
				this.colorAvailableActive.style.left = this.fltMinPercent + "%";
			}
		}

		if (recountPrice)
		{
			this.recountMaxPrice();
			if (areBothSlidersMoving)
				this.recountMinPrice();
		}
	};

	SmartFilter.prototype.onMoveRightSlider = function(e)
	{
		if (!this.isTouch)
		{
			this.rightSlider.ondragstart = function() {
				return false;
			};
		}

		if (!this.isTouch)
		{
			document.onmousemove = BX.proxy(function(event) {
				this.rightPercent = 100-(((this.countNewLeft(event))*100)/(this.trackerWrap.offsetWidth));
				this.makeRightSliderMove();
			}, this);

			document.onmouseup = function() {
				document.onmousemove = document.onmouseup = null;
			};
		}
		else
		{
			document.ontouchmove = BX.proxy(function(event) {
				this.rightPercent = 100-(((this.countNewLeft(event))*100)/(this.trackerWrap.offsetWidth));
				this.makeRightSliderMove();
			}, this);

			document.ontouchend = function() {
				document.ontouchmove = document.ontouchend = null;
			};
		}

		return false;
	};

	return SmartFilter;
})();
function popupElement(value){
    var img = new Image();
    img.src = "/include/images/"+value['flatplan'];
    var htmlInsert = '';
    htmlInsert += '<div class="titlePopUp"><div class="namePopUp">'+value['name']+' - '+value['corp']+'</div>';
	htmlInsert += "<div class='closeElementPopUp' onclick=\"$('#elementPopUp').fadeOut(500);$('#elementPopUpWindowOverlay').fadeOut(500);\"></div></div>";
	htmlInsert += "<div class='bodyPopUp'><p class='titleTablePopUp'>Характеристики</p><table class='tablePopUp'>";
    htmlInsert += '<tr><td>Количество комнат</td><td>'+value['rooms']+'</td></tr>';
    htmlInsert += '<tr><td>Общая площадь</td><td>'+value['stotal']+'</td></tr>';
    htmlInsert += '<tr><td>Площадь кухни</td><td>'+value['skitchen']+'</td></tr>';
    htmlInsert += '<tr><td>Площадь коридора</td><td>'+value['scorridor']+'</td></tr>';
    htmlInsert += '<tr><td>Описание жилой площади</td><td>'+value['sroom']+'</td></tr>';
    htmlInsert += '<tr><td>Общая площадь балкона(-нов)</td><td>'+value['sbalcony']+'</td></tr>';
    htmlInsert += '<tr><td>Площадь сан.узла</td><td>'+value['swatercloset']+'</td></tr>';
    htmlInsert += '<tr><td>Высота потолков</td><td>'+value['height']+'</td></tr>';
    htmlInsert += '<tr><td>Отделка</td><td>'+value['decoration']+'</td></tr>';
    htmlInsert += '<tr><td>Этаж</td><td>'+value['flatfloor']+'</td></tr>';
    //htmlInsert += '<tr><td>Стоимость квадратного метра</td><td>'+Math.round(value['baseflatcost']/value['stotal'])+'</td></tr>';
    htmlInsert += '</table>';
    htmlInsert += '</div>';
    htmlInsert += "<div class='pictureAndPrice'>";
    htmlInsert += "<p class='titleTablePopUp'>План квартиры</p>";
    htmlInsert += "<img src='/thumb/400x300xin/include/images/"+value['flatplan']+"' title='квартира в \""+value['name']+"\"' alt='квартира в \""+value['name']+"\"' />";
    if (value['baseflatcost'] !== ""){
        htmlInsert += "<p class='pricePopUp'>от <span>"+value['baseflatcost']+"</span> руб.</p>";
    }
    /*if (value['spec'] == "Y"){*/
    	htmlInsert += "<a class='psevdoorange' onclick='showPricePop2();' style='margin-top: 55px;float: right; width: 225px;font-size: 14px;'>Узнать цену со скидкой</a>";
    /*}else{
    	htmlInsert += "<a class='psevdoorange' onclick='showPricePop();' style='margin-top: 55px;float: right; width: 225px;font-size: 14px;'>Узнать цену со скидкой</a>";
    }*/
    
(function() {
  if (window.pluso)if (typeof window.pluso.start == "function") return;
  if (window.ifpluso==undefined) { window.ifpluso = 1;
    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
  }})();

    htmlInsert += '</div>';
    $("#elementPopUpWindow").html(htmlInsert);
    $("#elementPopUp").html($("#elementPopUp").html()+'<div class="pluso popplus" data-background="#ebebeb" data-options="medium,square,line,horizontal,counter,theme=04" data-services="vkontakte,odnoklassniki,facebook,google,moimir"></div>');
    $("#elementPopUp").fadeIn(500);
    $('#elementPopUpWindowOverlay').fadeIn(500);
    var DH = $(document).height(), WH = $(window).height(), ST = $(window).scrollTop(), PH = $("#elementPopUp").outerHeight();
    if (WH < PH) {
        if (ST + WH > DH - 10) {
            $('#elementPopUp').css({bottom: '10px', top: ''});
        } else {
            $('#elementPopUp').css('top', 50 + ST);
        }
    } else {
        /*if (WH == DH) {
         $('.feedbackWrap').css('top', 10 + ST);
         } else {
         $('.feedbackWrap').css('top', (WH - PH) / 2 + ST);
         }*/
        $('#elementPopUp').css('top', ST+WH/5);
        //$('#elementPopUp').css('position', 'relative');
    }
}

function showPricePop(){
    $('#elementPopUp').fadeOut(100);
    $('#elementPopUpWindowOverlay').fadeOut(100);
    $('.price_feedback').fadeIn(300);
    $('.popUpWindowOverlay').fadeIn(300);
    var thisCall =  $('.price_plan').find('.calltouchId');
    thisCall.val(window.call_value);
    var DH = $(document).height(), WH = $(window).height(), ST = $(window).scrollTop(), PH = $("#elementPopUp").outerHeight();
    if (WH < PH) {
        if (ST + WH > DH - 10) {
            $('.feedbackWrap').css({bottom: '10px', top: ''});
        } else {
            $('.feedbackWrap').css('top', 50 + ST);
        }
    } else {
        $('.feedbackWrap').css('top', 50 + ST);
    }
}
function showPricePop2(){
    $('#elementPopUp').fadeOut(100);
    $('#elementPopUpWindowOverlay').fadeOut(100);
    $('.price_plan').fadeIn(300);
    $('.popUpWindowOverlay').fadeIn(300);
    var thisCall =  $('.price_plan').find('.calltouchId');
    thisCall.val(window.call_value);
    var DH = $(document).height(), WH = $(window).height(), ST = $(window).scrollTop(), PH = $("#elementPopUp").outerHeight();
    if (WH < PH) {
        if (ST + WH > DH - 10) {
            $('.feedbackWrap').css({bottom: '10px', top: ''});
        } else {
            $('.feedbackWrap').css('top', 50 + ST);
        }
    } else {
        $('.feedbackWrap').css('top', 50 + ST);
    }
}
