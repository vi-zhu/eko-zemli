function show_zayavka(txt) {
	var btn = $("#zayavkadiv").find("button");
	if(btn && btn != undefined) {
		window.addEventListener('b24:form:show', (event) => {
			let form = event.detail.object;
			if (form.identification.id == 22) {
				form.setValues({
					"DEAL_COMMENTS": txt
				});
			}
		});
		btn.click();
	}
}

$('.tab_trigger').click(function() {
	var id = $(this).attr('data-tab');
	var content = $('.tab_item[data-tab="'+ id +'"]');

	$('.tab_trigger.active').removeClass('active');
	$(this).addClass('active');

	$('#tab_toggle').removeClass('mi_toggle' + $('#tab_toggle').attr('data-tab'));
	$('#tab_toggle').addClass('mi_toggle' + id);
	$('#tab_toggle').attr('data-tab', id);

	$('.tab_item.active').hide();
	$('.tab_item.active').removeClass('active');
	content.addClass('active');
	content.fadeIn();
});

$('#tab_toggle').click(function() {
	var id = $(this).attr('data-tab');
	var new_id = 1;
	if(id == 1)  {
		new_id = 2;
	}
	$('.tab_trigger[data-tab="'+ new_id +'"]').click();
});


$(function() {
	var m_form = $("#f_mortgage");
	if (m_form.length > 0) {
		$("#sm_price").slider({
			animate: "slow",
			range: "min",
			min: parseFloat($("#m_price_min").val()),
			max: parseFloat($("#m_price_max").val()),
			value: parseFloat($("#m_price").val()),
			step: parseInt($("#m_step").val()),
			slide: function(event, obj) {
				$("#m_price").val(obj.value).change();
				$("#im_price").text(formatNum(obj.value));
			}
		});

		$("#m_price").val($("#sm_price").slider("value")).change();
		$("#im_price").text(formatNum($("#sm_price").slider("value")));

		$("#sm_percent").slider({
			animate: "slow",
			range: "min",
			min: parseFloat($("#m_percent_min").val()),
			max: parseFloat($("#m_percent_max").val()),
			value: parseFloat($("#m_percent").val()),
			step: 1,
			slide: function(event, obj) {
				$("#m_percent").val(obj.value).change();
				$("#im_percent").text(obj.value);
			}
		});

		$("#m_percent").val($("#sm_percent").slider("value")).change();
		$("#im_percent").text(formatNum($("#sm_percent").slider("value")));

		$("#sm_term").slider({
			animate: "slow",
			range: "min",
			min: parseFloat($("#m_term_min").val()),
			max: parseFloat($("#m_term_max").val()),
			value: parseFloat($("#m_term").val()),
			step: 1,
			slide: function(event, obj) {
				$("#m_term").val(obj.value).change();
				$("#im_term").text(obj.value);
			}
		});

		$("#m_term").val($("#sm_term").slider("value")).change();
		$("#im_term").text(formatNum($("#sm_term").slider("value")));


		mCalc();

		$("#f_mortgage").change(function() {
			mCalc();
		});
	}

	function mCalc() {
		var m_pay, m_credit, m_contribution, m_price, m_percent, m_rate, m_term, mpc, mpc_p, pa;

		m_price = parseFloat($("#m_price").val());
		m_percent = parseFloat($("#m_percent").val());
		m_rate = parseFloat($("#m_rate").val());
		m_term = parseFloat($("#m_term").val());

		m_contribution = Math.round((m_price * m_percent) / 100);
		m_credit = m_price - m_contribution;
		mpc = m_rate / 1200;
		pa = m_term * 12;
		mpc_p = Math.pow(1 + mpc, pa);
		m_pay = Math.round(m_credit * ((mpc * mpc_p) / (mpc_p - 1)));

		$("#m_contribution").val(m_contribution);
		$("#im_contribution").text(formatNum(m_contribution));

		$("#m_credit").val(m_credit);
		$("#im_credit").text(formatNum(m_credit));

		$("#m_pay").val(m_pay);
		$("#im_pay").text(formatNum(m_pay));
	}

	var i_form = $("#f_installment");
	if (i_form.length > 0) {
		$("#si_price").slider({
			animate: "slow",
			range: "min",
			min: parseFloat($("#i_price_min").val()),
			max: parseFloat($("#i_price_max").val()),
			value: parseFloat($("#i_price").val()),
			step: parseInt($("#i_step").val()),
			slide: function(event, obj) {
				$("#i_price").val(obj.value).change();
				$("#ii_price").text(formatNum(obj.value));
			}
		});

		$("#i_price").val($("#si_price").slider("value")).change();
		$("#ii_price").text(formatNum($("#si_price").slider("value")));

		$("#si_percent").slider({
			animate: "slow",
			range: "min",
			min: parseFloat($("#i_percent_min").val()),
			max: parseFloat($("#i_percent_max").val()),
			value: parseFloat($("#i_percent").val()),
			step: 1,
			slide: function(event, obj) {
				$("#i_percent").val(obj.value).change();
				$("#ii_percent").text(obj.value);
			}
		});

		$("#si_term").slider({
			animate: "slow",
			range: "min",
			min: parseFloat($("#i_term_min").val()),
			max: parseFloat($("#i_term_max").val()),
			value: parseFloat($("#i_term").val()),
			step: 1,
			slide: function(event, obj) {
				$("#i_term").val(obj.value).change();
				$("#ii_term").text(obj.value);
			}
		});

		$("#i_term").val($("#si_term").slider("value")).change();
		$("#ii_term").text(formatNum($("#si_term").slider("value")));

		iCalc();

		$("#f_installment").change(function() {
			iCalc();
		});
	}

	function iCalc() {
		var i_pay, i_credit, i_contribution, i_price, i_percent, i_term;

		i_price = parseFloat($("#i_price").val());
		i_percent = parseFloat($("#i_percent").val());
		i_term = parseFloat($("#i_term").val());

		i_contribution = Math.round((i_price * i_percent) / 100);
		i_credit = i_price - i_contribution;

		i_pay = Math.round(i_credit / i_term);

		$("#i_contribution").val(i_contribution);
		$("#ii_contribution").text(formatNum(i_contribution));

		$("#i_credit").val(i_credit);
		$("#ii_credit").text(formatNum(i_credit));

		$("#i_pay").val(i_pay);
		$("#ii_pay").text(formatNum(i_pay));
	}

});