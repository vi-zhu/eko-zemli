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

$(function() {
	var m_form = $("#f_invest");
	if (m_form.length > 0) {
		$("#sm_invest").slider({
			animate: "slow",
			range: "min",
			min: parseFloat($("#m_invest_min").val()),
			max: parseFloat($("#m_invest_max").val()),
			value: parseFloat($("#m_invest").val()),
			step: parseInt($("#m_step").val()),
			slide: function(event, obj) {
				$("#m_invest").val(obj.value).change();
				$("#im_invest").text(formatNum(obj.value));
			}
		});

		$("#m_invest").val($("#sm_invest").slider("value")).change();
		$("#im_invest").text(formatNum($("#sm_invest").slider("value")));

		$("#sm_period").slider({
			animate: "slow",
			range: "min",
			min: parseFloat($("#m_period_min").val()),
			max: parseFloat($("#m_period_max").val()),
			value: parseFloat($("#m_period").val()),
			step: 1,
			slide: function(event, obj) {
				$("#m_period").val(obj.value).change();
				$("#im_period").text(obj.value);
			}
		});

		$("#m_period").val($("#sm_period").slider("value")).change();
		$("#im_period").text(formatNum($("#sm_period").slider("value")));


		//pCalc();

		$("#f_invest").change(function() {
			pCalc();
		});
	}

	function pCalc() {
		var m_sum, m_invest, m_profit, m_period;

		m_invest = parseFloat($("#m_invest").val());
		m_profit = parseFloat($("#m_profit").val());
		m_period = parseFloat($("#m_period").val());

		m_sum = Math.round(m_invest * Math.pow((1 + (m_profit / 100)), m_period) - m_invest);

		$("#m_sum").val(m_sum);
		$("#im_sum").text(formatNum(m_sum));
	}
});