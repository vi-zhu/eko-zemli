function changeText(elem, changeVal) {
    if ((elem.title) && (typeof (elem.title) != "undefined")) {
        elem.title = changeVal;
    }
}

;(function(window){

	if(window.vWishlist){
		return;
	}
	vWishlist = function(params){
		this.ID = params.ID;
		this.EXISTS = params.EXISTS;
		this.PARENT_TYPE = params.PARENT_TYPE;
		this.PARENT_ID = params.PARENT_ID;
		this.ELEMENT_ID = params.ELEMENT_ID;
		this.WISHLIST_ELEMENT_ID = params.WISHLIST_ELEMENT_ID;
		this.AJAX_URL = params.AJAX_URL;
		this.self = BX(this.ID);
		this.DELAY_LOAD = params.DELAY_LOAD;
		this.USE_BATCH = params.USE_BATCH;
	}
	
	vWishlist.prototype.onClick = function(){
		if(this.EXISTS) this.removeElement();
		else this.addElement();
	}
	
	vWishlist.prototype.addElement = function(){
		BX.ajax({
			timeout:   30,
			method:   'POST',
			dataType: 'json',
			url:       this.AJAX_URL,
			data:      "ACTION=ADD&PARAM1="+this.PARENT_TYPE+"&PARAM2="+this.PARENT_ID+"&PARAM3="+this.ELEMENT_ID,
			onsuccess: BX.delegate(this.addHandler, this)
		});
	}
	
	vWishlist.prototype.addHandler = function(result){
		if(result.result){
			this.WISHLIST_ELEMENT_ID = result.WID;
			this.EXISTS = true;
			
			BX.addClass(this.self, "exists");
			changeText(this.self, "Убрать из Избранного");
			var b=parseInt($("#qty").text())+1;
			$("#qty").text(b);
		}else{
			this.handleError(result);
		}
	}
	
	vWishlist.prototype.removeElement = function(){
		BX.ajax({
			timeout:   30,
			method:   'POST',
			dataType: 'json',
			url:       this.AJAX_URL,
			data:      "ACTION=DELETE&WID="+this.WISHLIST_ELEMENT_ID,
			onsuccess: BX.delegate(this.removeHandler, this)
		});
	}
	
	vWishlist.prototype.removeHandler = function(result){
		if(result.result){
			this.WISHLIST_ELEMENT_ID = 0;
			this.EXISTS = false;
			BX.removeClass(this.self, "exists");
			changeText(this.self, "Добавить в Избранное");
			var b=parseInt($("#qty").text())-1;
			$("#qty").text(b);
		}else{
			this.handleError(result);
		}
		
	}
	
	vWishlist.prototype.bindEvents = function(){
		BX.bind(this.self, 'click', BX.proxy(this.onClick, this));
		
		if(this.DELAY_LOAD){
			if(this.USE_BATCH) {
				window.bwll.addCallback(this.checkHandler, this);	
			} else {
				BX.ajax({
					timeout:   30,
					method:   'POST',
					dataType: 'json',
					url:       this.AJAX_URL,
					data:      "ACTION=CHECK&PARAM1="+this.PARENT_TYPE+"&PARAM2="+this.PARENT_ID+"&PARAM3="+this.ELEMENT_ID,
					onsuccess: BX.delegate(this.checkHandler, this)
				});	
			}
		}
	}
	
	vWishlist.prototype.checkHandler = function(result){
		if(result.result){
			this.WISHLIST_ELEMENT_ID = result.WID;
			this.EXISTS = true;
			BX.addClass(this.self, "exists");
			changeText(this.self, "Убрать из Избранного");
		}else{
			this.WISHLIST_ELEMENT_ID = 0;
			this.EXISTS = false;
			BX.removeClass("exists");
			changeText(this.self, "Добавить в Избранное");
		}
		

	}
	
	vWishlist.prototype.handleError = function(result){
		if(!result["result"]){
			console.log(result["err_code"]);
		}
	}
	
})(window);

;(function(){
	if(window.vWishListListener){
		return;
	}
	
	vWishListListener = function(params){
		this.registeredCallbacks = {};
		this.timeout = false;
		this.AJAX_URL = params.AJAX_URL;
	}
	
	vWishListListener.prototype.addCallback = function(callback, params) {
		var id = this.guid();
		this.registeredCallbacks[id] = {
			callback: callback,
			params: params,
			id: id
		};
		
		if(this.timeout) {
			clearTimeout(this.timeout);
			this.timeout = false;
		}
		
		this.setTimeoutAJAX();
	}
	vWishListListener.prototype.getParams = function() {
		var params = {
			'is_batch': 1,
			'queries': []
		};
		
		for(var i in this.registeredCallbacks) {
			var one = this.registeredCallbacks[i];
			params.queries.push({
				'qid': one.id,
				'params': {
					'ACTION': 'CHECK',
					'PARAM1': one.params.PARENT_TYPE,
					'PARAM2': one.params.PARENT_ID,
					'PARAM3': one.params.ELEMENT_ID
				}
			})
		}
		
		return params;
	};
	vWishListListener.prototype.setTimeoutAJAX = function() {
		var _this = this;
		this.timeout = setTimeout(function(){
			var params = _this.getParams();
			_this.executeAJAX(params);
		}, 200);
	}
	
	vWishListListener.prototype.executeAJAX = function(params) {
		var _this = this;
		BX.ajax({
			timeout:   30,
			method:   'POST',
			dataType: 'json',
			url:       this.AJAX_URL,
			data:      params,
			onsuccess: function(data) {
				for(var i in data.result) {
					var one = data.result[i];
					if(typeof _this.registeredCallbacks[i].callback == 'function')
						_this.registeredCallbacks[i].callback.call(_this.registeredCallbacks[i].params, one);
					delete _this.registeredCallbacks[i];
				}
				
				if(Object.keys(_this.registeredCallbacks).length > 0) {
					_this.setTimeoutAJAX();
				}
			}
		});
	}
	
	vWishListListener.prototype.guid = function() {
		function s4() {
			return Math.floor((1 + Math.random()) * 0x10000)
			  .toString(16)
			  .substring(1);
		}
		return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
			s4() + '-' + s4() + s4() + s4();
	}
})(window);

if (!Object.keys) {
    Object.keys = function (obj) {
        var keys = [],
            k;
        for (k in obj) {
            if (Object.prototype.hasOwnProperty.call(obj, k)) {
                keys.push(k);
            }
        }
        return keys;
    };
}