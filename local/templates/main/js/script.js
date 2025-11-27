var yandex_metrika = 100716710;

(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();
   for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
   k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

function show_bron(txt) {
	var btn = $("#brondiv").find("button");
	if(btn && btn != undefined) {
		window.addEventListener('b24:form:show', (event) => {
			let form = event.detail.object;
			if ((form.identification.id == 10) || (form.identification.id == 26)) {
				form.setValues({
					"CONTACT_COMMENTS": txt
				});
			}
		});
		btn.click();
	}
}

function formatNum(num) {
	var n = num.toString();
	var separator = " ";
	return n.replace(/(\d{1,3}(?=(?:\d\d\d)+(?!\d)))/g, "$1" + separator);
}

$(document).ready(function() {
	var gal_pos = 0;
	var gal_sel_pos = 0;
	var startPoint;
	var endPoint;

	$(window).on("scroll", function() {
		if($(window).scrollTop() >= 20) {
			$(".top_row").addClass("fixtop");
		} else {
			$(".top_row").removeClass("fixtop");
		}
	});

	if (document.documentElement.clientWidth < 576) {
		$('.footer_menu .li1 > a').on('click', function(e) {
			var subitem = $(this).parent().find('.fsub1');
			if(subitem && subitem.length > 0) {
				e.preventDefault();
				subitem.slideToggle(300);
			}
		});
	}


	$('a.thumbnail').on('click', function(e) {
		e.preventDefault();
		var thumbnailURL = $(this).attr('href');
		var data = $(this).attr('data-fancybox-index');
		gal_sel_pos = data;
		$('a.thumbnail').removeClass("sel");
		$('#thumbnail'+gal_sel_pos).addClass("sel");
		$('#mainpicture').css('background-image','url('+thumbnailURL+')');
		$('#mainpicture_a').attr('data-fancybox-index', data);
	});

	$("#mainpicture_a").on('touchstart', function() {
		startPoint = event.changedTouches[0];
	});

	$("#mainpicture_a").on('touchend', function() {
		endPoint = event.changedTouches[0];
		var deltaX = endPoint.pageX - startPoint.pageX;
		if(deltaX > 20) {
			$('#gal_left').trigger('click');
		} else if (deltaX < -20) {
			$('#gal_right').trigger('click');
		}
	});

	$('#gal_left').on('click', function(e) {
		if(gal_pos > 0) {
			gal_pos--;
			$('.col_prv').each(function(i, obj) {
				if(i < gal_pos){
					$("#col_prv"+i).hide();
				} else {
					$("#col_prv"+i).show();
				}
		   		i++;
 			});
			if(gal_sel_pos > gal_pos) {
				gal_sel_pos--;
			} else {
				gal_sel_pos = gal_pos;
			}
			$('#thumbnail'+gal_sel_pos).trigger('click');
		} else if (gal_sel_pos > 0) {
			gal_sel_pos--;
			$('#thumbnail'+gal_sel_pos).trigger('click');
		}
	});

	$('#gal_right').on('click', function(e) {
		var block_count_all = $('.col_prv').length;
		var block_count = block_count_all;
		var width = document.documentElement.clientWidth;
		if(width < 576) {
			block_count = block_count_all - 3;
		} else if(width >=576 && width < 767) {
			block_count = block_count_all - 4;
		} else if(width >=767 && width < 992) {
			block_count = block_count_all - 3;
		} else if(width >=992 && width < 1200) {
			block_count = block_count_all - 4;
		} else if(width >=1200) {
			block_count = block_count_all - 6;
		}
		if(block_count - gal_pos > 0) {
			gal_pos++;
			$('.col_prv').each(function(i, obj) {
				if(i < gal_pos){
					$("#col_prv"+i).hide();
				} else {
					$("#col_prv"+i).show();
				}
		   		i++;
 			});
			gal_sel_pos++;
			$('#thumbnail'+gal_sel_pos).trigger('click');
		} else if (block_count_all - gal_sel_pos > 1) {
			gal_sel_pos++;
			$('#thumbnail'+gal_sel_pos).trigger('click');
		}
	});

	$('#btn_cookie_accept').on('click', function(e) {
		setCookie("allow_metrika", "yes");
		$('#cookie_cont').hide(300);
		load_metrica();
	});
	$('#btn_cookie_reject').on('click', function(e) {
		setCookie("allow_metrika", "no");
		$('#cookie_cont').hide(300);
	});

	$(window).on("load", function() {
		$("#blogo").html($("#logo").html());
		if($("#map_location")) {
			$("#map_location").fadeIn();
		}
	});

	$("body").on("click", ".burger", function() {
		if (!$(this).hasClass('cross')) {
			$("body").addClass("cross");
			$(this).addClass("cross");
		} else {
			$("body").removeClass("cross");
			$(this).removeClass("cross");
		}
	});

	$("#mainfilter").on("submit", function() {
		var _action = '/zemelnye-uchastki-v-moskovskoy-oblasti/filter/';

		var area = $('#fm_area').val();
		if(area !== undefined && area != null && area != '') {
			_action += 'area-is-'+area+'/';
		} 
		var square = $('#fm_square').val();
		if(square !== undefined && square != null && square != '') {
			var squares = square.split("_");
			if(squares.length == 2) {
				_action += 'ssquare';
				var square_min = Number(squares[0]);
				var square_max = Number(squares[1]);
				if(square_min > 0) {
					_action += '-from-'+square_min;
				}
				if(square_max > 0) {
					_action += '-to-'+square_max;
				}
				_action += '/';
			}
		} 
		var price = $('#fm_price').val();
		if(price !== undefined && price != null && price != '') {
			var prices = price.split("_");
			if(prices.length == 2) {
				_action += 'sprice';
				var price_min = Number(prices[0])*1000;
				var price_max = Number(prices[1])*1000;
				if(price_min > 0) {
					_action += '-from-'+price_min;
				}
				if(price_max > 0) {
					_action += '-to-'+price_max;
				}
				_action += '/';
			}
		} 

		if(_action == '') {
			_action = 'clear/';
		}
		_action = _action + 'apply/';

		var uid = $('#fm_uid').val();
		if(uid !== undefined && ''+uid != '') { 
			_action = _action + '?uid=' + uid;
		}

		$(this).attr('action', _action);
		return true;
	});
});

var aMaps = new Array();
var lMaps = new Array();

function map_ho(id, lat, lng, name) {
	var found = -1;
	aMaps.forEach(function(item, i, aMaps) {
		if(id == item.id) {
			found = i;
		}
	});
	if(found == -1) {
		found = aMaps.length;
		aMaps[found] = new Object();
		aMaps[found]["id"] = id;
		aMaps[found]["lat"] = lat;
		aMaps[found]["lng"] = lng;
		aMaps[found]["visible"] = false;
		aMaps[found]["div"] = false;
	}
	if(!aMaps[found]["div"]) {
		$('#itemrow'+id).append('<div id="maprow'+id+'" class="col-12 maprow" style="dispay: none;"></div>');
		aMaps[found]["div"] = true;
		aMaps[found]["map"] = new ymaps.Map('maprow'+id, {center: [lat, lng], zoom: 12, controls: ['zoomControl', 'fullscreenControl', 'typeSelector', 'routeButtonControl'], behaviors: ['drag', 'dblClickZoom', 'multiTouch']}, {suppressMapOpenBlock: true});
		aMaps[found]["map"].geoObjects.add(new ymaps.Placemark([lat, lng], {balloonContent: name}, {preset: 'islands#blueHomeCircleIcon'}));
		aMaps[found]["map"].controls.get('routeButtonControl').routePanel.state.set({ to: [lat, lng] });
	}
	aMaps[found]["visible"] = !aMaps[found]["visible"];
	if(aMaps[found]["visible"]) { $('#maprow'+id).show(); } else { $('#maprow'+id).hide(); }
}

function map_lo(id, lat, lng, num, points) {
	var found = -1;
	lMaps.forEach(function(item, i, lMaps) {
		if(id == item.id) {
			found = i;
		}
	});

	var LZS1 = 18;
	var LZS2 = 2;
	var LZS3 = 2;

	var myLayout = ymaps.templateLayoutFactory.createClass(
			'<div class="myplacemark">{{ properties.name }}</div>',
			{
				build: function () {
					myLayout.superclass.build.call(this);
					var map = this.getData().geoObject.getMap();
					if (!this.inited) {
						this.inited = true;
						var zoom = map.getZoom();
						map.events.add('boundschange', function () {
							var currentZoom = map.getZoom();
							if (currentZoom != zoom) {
								zoom = currentZoom;
								this.rebuild();
							}
						}, this);
					}
					var _zoom = map.getZoom()-12;
					var options = this.getData().options,
						size = (_zoom * _zoom)/LZS2 - LZS3,
						element = this.getParentElement().getElementsByClassName('myplacemark')[0];
					if(size < 0) {size = 0;}
					element.style.height = size + 'px';
					element.style.width = size*2 + 'px';
					element.style.marginTop = -size / 2 + 'px';
					element.style.marginLeft = -size + 'px';
					element.style.fontSize = element.style.lineHeight = size + 'px';
				}
			}
		);

	if(found == -1) {
		found = lMaps.length;
		lMaps[found] = new Object();
		lMaps[found]["id"] = id;
		lMaps[found]["lat"] = lat;
		lMaps[found]["lng"] = lng;
		lMaps[found]["num"] = num;
		lMaps[found]["points"] = points;
		lMaps[found]["visible"] = false;
		lMaps[found]["div"] = false;
	}
	if(!lMaps[found]["div"]) {
		$('#itemrow'+id).append('<div id="maprow'+id+'" class="col-12 maprow" style="dispay: none;"></div>');
		lMaps[found]["div"] = true;
		lMaps[found]["map"] = new ymaps.Map('maprow'+id, {center: [lat, lng], zoom: LZS1, controls: ['zoomControl', 'fullscreenControl', 'typeSelector', 'routeButtonControl'], type: 'yandex#hybrid', behaviors: ['drag', 'dblClickZoom', 'multiTouch']}, {suppressMapOpenBlock: true});
		lMaps[found]["map"].geoObjects.add(new ymaps.Polygon(points, {}, { fillColor: '#99FF33b8', strokeColor: '#00666666', strokeWidth: 1}));
		lMaps[found]["map"].geoObjects.add(new ymaps.Placemark([lat, lng], {name: num}, { iconLayout: myLayout }));
		lMaps[found]["map"].controls.get('routeButtonControl').routePanel.state.set({ to: [lat, lng] });
	}
	lMaps[found]["visible"] = !lMaps[found]["visible"];
	if(lMaps[found]["visible"]) { $('#maprow'+id).show(); } else { $('#maprow'+id).hide(); }
}

function load_metrica() {
	$('#yandex_img').src = 'https://mc.yandex.ru/watch/'+yandex_metrika;
	ym(yandex_metrika, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
}

function setCookie(c_name, value) {
	var exdays = 7300;
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value=escape(value) + ";path=/" + ((exdays==null) ? "" : ";expires="+exdate.toUTCString());
    document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name) {
    var i,x,y,ARRcookies=document.cookie.split(";");
    for (i=0;i<ARRcookies.length;i++) {
        x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
        y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
        x=x.replace(/^\s+|\s+$/g,"");
        if (x==c_name) {
            return unescape(y);
        }
    }
}

var allow_metrika = getCookie("allow_metrika");
if(allow_metrika == "yes") {
	load_metrica();
} else if((allow_metrika != "yes") && (allow_metrika != "no")) {
	$('#cookie_cont').show();
}

window.addEventListener('b24:form:send:success', function(e) {
	const fid = e.detail.object.identification.id;

	var msg = "Заявка с сайта " + window.location.hostname;
	if ((fid == 10) || (fid == 26)) {
		msg = "<b>"+ msg + "</b>";
	}
	msg += "\n\n"+ document.title + "\n\n";

	const values = e.detail.object.values();
	const CONTACT_NAME = "" + values.CONTACT_NAME;
	const CONTACT_PHONE = "" + values.CONTACT_PHONE;
	const DEAL_COMMENTS = "" + values.DEAL_COMMENTS;
	const CONTACT_COMMENTS = "" + values.CONTACT_COMMENTS;

	if(CONTACT_NAME != "" && CONTACT_NAME != "undefined") {
		msg += "Имя: " + CONTACT_NAME + "\n";
	}
	if(CONTACT_PHONE != "" && CONTACT_PHONE != "undefined") {
		msg += "Телефон: " + CONTACT_PHONE + "\n";
	}
	if(DEAL_COMMENTS != "" && DEAL_COMMENTS != "undefined") {
		msg += "Комментарий: " + DEAL_COMMENTS + "\n";
	}
	if(DEAL_COMMENTS != "" && CONTACT_COMMENTS != "undefined") {
		msg += "Комментарий: " + CONTACT_COMMENTS + "\n";
	}
	for (let key in values) {
		if(key.startsWith('DEAL_UF_CRM_DEAL_')) {
			let cvalue = values[key];
			let DEAL_VAR = "" + cvalue;
			if(DEAL_VAR != "" && DEAL_VAR != "undefined") {
				for (let i = 0; i < e.detail.object.pager.pages.length; i++) { 
					let page = e.detail.object.pager.pages[i];
					if(page.fields[0].name == key) {
						let _value = "";
						if(Array.isArray(cvalue)) {
							for(let k = 0; k < cvalue.length; k++) {
								for(let j = 0; j < page.fields[0].items.length; j++) {
									let item = page.fields[0].items[j];
									if(item.value == cvalue[k]) {
										_value += "" + item.label + "; "
										break;
									}
								}
							}
						} else {
							for(let j = 0; j < page.fields[0].items.length; j++) {
								let item = page.fields[0].items[j];
								if(item.value == cvalue) {
									_value += "" + item.label + "; "
									break;
								}
							} 
						}
						msg += "" + page.fields[0].label + ": " + _value + "\n";
						break;
					}
				}
			}
		}
    }

	var need_br = true;
	var queryParams = location.search.substring(1).split('&');  
    for (var i = 0; i < queryParams.length; i++) {  
        var param = queryParams[i].split('=');  
        if (param[0].startsWith('utm_')) {  
			if(need_br) {
				msg += "\n";
				need_br = false;
			}
			msg += "" + param[0] + ": " + decodeURIComponent(param[1]) + "\n"; 
        }  
    } 

	if (msg != "") {
		const url = "https://api.telegram.org/bot7376005992:AAHmHMuJXnTSNs7x3M27A05TnHkDWi7qKF0/sendMessage?chat_id=-4888575411&text=" + encodeURIComponent(msg) + "&parse_mode=html";  
		fetch(url)  
.then(response => response.json())   
.catch(error => { console.error('Ошибка отправки сообщения:', error); });  
	}
});