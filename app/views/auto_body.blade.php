<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-6">
				<h4>设置: </h4>
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label for="allowance_up_input" class="col-sm-2 control-label">涨容差: </label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="allowance_up_input" placeholder="涨容差">
						</div>
					</div>
					<div class="form-group">
						<label for="allowance_down_input" class="col-sm-2 control-label">跌容差: </label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="allowance_down_input" placeholder="跌容差">
						</div>
					</div>
					<div class="form-group">
						<label for="handler_menge_input" class="col-sm-2 control-label">操作金额: </label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="handler_menge_input" placeholder="操作金额">
						</div>
					</div>
					<div class="form-group">
						<label for="frequency_input" class="col-sm-2 control-label">采样频率: </label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="frequency_input" placeholder="采样频率(秒)">
						</div>
					</div>
					<div class="form-group">
						<label for="thresholdvalue_input" class="col-sm-2 control-label">上下阀值: </label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="thresholdvalue_input" placeholder="上下阀值(元)">
						</div>
					</div>
					<div class="form-group">
						<label for="refresh_currency_frequency_input" class="col-sm-2 control-label">更新资金: </label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="refresh_currency_frequency_input" placeholder="更新资金(秒)">
						</div>
					</div>
				</form>

			</div>
			<div class="col-md-6">
				<h4>信息: </h4>
				<div class="row">
					<div class="col-md-6">
						<p id="market_value"></p>
						<p id="breakpoint_value"></p>
						<p id="market_status"></p>
						<p id="btc_rest"></p>
						<p id="cny_rest"></p>
						<p id="btc_frozen"></p>
						<p id="cny_frozen"></p>
						<p id="total_rest"></p>
						<p id="refrech_currency_status_value"></p>
					</div>
					<div class="col-md-6">
						<p id="allowance_up_value"></p>
						<p id="allowance_down_value"></p>
						<p id="handler_menge_value"></p>
						<p id="frequency_value"></p>
						<p id="thresholdvalue_value"></p>
						<p id="buy_status_value"></p>
						<p id="lock_status_value"></p>
						<p id="auto_status_value"></p>
					</div>			
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-1">
				<button id="apply_button" class="btn btn-primary">应用</button>
			</div>
			<div class="col-md-1">
				<button id="empty_log_button" class="btn btn-primary">清空</button>
			</div>
			<div class="col-md-1">
				<button id="buy_status_switch_button" class="btn btn-warning">买卖切换</button>
			</div>
			<div class="col-md-1">
				<button id="refresh_currency_button" class="btn btn-warning">刷新资金</button>
			</div>
			<div class="col-md-1">
				<button id="lock_status_switch_button" class="btn btn-warning">锁定开关</button>
			</div>
			<div class="col-md-1">
				<button id="cancel_order_button" class="btn btn-warning">取消定单</button>
			</div>
			<div class="col-md-1">
				<button id="open_refresh_currency_button" class="btn btn-warning">更新资金</button>
			</div>
			<div class="col-md-1">
				<button id="manual_buy_sell_button" class="btn btn-warning">手动买卖</button>
			</div>
		</div>
	</div>
</div>
<div id="manual_buy_sell_block">
	<hr/>
	<div class="row">
		<div class="col-md-6">
			<h4>手动买入比特币</h4>
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="manual_buy_amount_input" class="col-sm-2 control-label">数量: </label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="manual_buy_amount_input" placeholder="数量">
					</div>
				</div>
				<div class="form-group">
					<label for="manual_buy_price_input" class="col-sm-2 control-label">价格: </label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="manual_buy_price_input" placeholder="价格(0为市价)">
					</div>
				</div>
				<button id="manual_buy_button" class="btn btn-info">下单</button>
			</form>			
		</div>
		<div class="col-md-6">
			<h4>手动卖出比特币</h4>
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="manual_sell_amount_input" class="col-sm-2 control-label">数量: </label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="manual_sell_amount_input" placeholder="数量">
					</div>
				</div>
				<div class="form-group">
					<label for="manual_sell_price_input" class="col-sm-2 control-label">价格: </label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="manual_sell_price_input" placeholder="价格(0为市价)">
					</div>
				</div>
				<button id="manual_sell_button" class="btn btn-info">下单</button>
			</form>	
		</div>		
	</div>
</div>
<hr/>
<div class="row">
	<div class="col-md-4">
		<h4>全数据: </h4>
		<div id="market_value_all" style="overflow:auto; max-height: 300px;">
			<ul class="list-group">
			</ul>
		</div>
	</div>
	<div class="col-md-8">
		<h4>下单记录: </h4>
		<div id="order_logs" style="overflow:auto; max-height: 300px;">
			<ul class="list-group">
			</ul>
		</div>
	</div>
</div>
<hr/>
<div id="placeholder" style="width:1000px;height:400px">
</div>
<script>
$('#manual_buy_sell_block').hide();
$('#apply_button').click(function(){
	if($('#allowance_up_input').val()!=""){
		if (parseFloat($('#allowance_up_input').val())<1) {
			alert("涨容差不能小于1!");
		} else {		
			allowance_up=parseFloat($('#allowance_up_input').val());
		}
	}
	if($('#allowance_down_input').val()!=""){
		if (parseFloat($('#allowance_down_input').val())<1) {
			alert("跌容差不能小于1!");
		} else {		
			allowance_down=parseFloat($('#allowance_down_input').val());
		}
	}
	if($('#handler_menge_input').val()!=""){
		if (parseFloat($('#handler_menge_input').val())<0) {
			alert("操作金额不能小于0!");
		} else {
			handler_menge=parseFloat($('#handler_menge_input').val());
		}
	}
	if($('#frequency_input').val()!=""){
		if (parseFloat($('#frequency_input').val())<2) {
			alert("采样频率不能小于2秒!");
		} else {
			frequency = parseFloat($('#frequency_input').val())*1000;
			clearInterval(mainRefresh);
			mainRefresh = setInterval(getMarketDepth2, frequency);
		}
	}
	if($('#thresholdvalue_input').val()!="") {
		if (parseFloat($('#thresholdvalue_input').val())<30) {
			alert("上下阀值不能小于30!");
		} else if (parseFloat($('#thresholdvalue_input').val())>=2000) {
			alert("上下阀值不能大于2000!");
		}
		else {
			thresholdvalue = parseFloat($('#thresholdvalue_input').val());
		}		
	}
	if($('#refresh_currency_frequency_input').val()!=""){
		if (parseFloat($('#refresh_currency_frequency_input').val())<2) {
			alert("更新资金频率不能小于2秒!");
		} else {
			refresh_currency_value = parseFloat($('#refresh_currency_frequency_input').val())*1000;
		}
	}
	$('#allowance_up_value').text('涨容差: '+allowance_up);
	$('#allowance_down_value').text('跌容差: '+allowance_down);
	$('#handler_menge_value').text('操作金额: '+handler_menge);
	$('#frequency_value').text('采样频率: '+frequency+' ms');
	$('#thresholdvalue_value').text('上下阀值: '+thresholdvalue);
});
$('#empty_log_button').click(function(){
	resetLog();
	$('#order_logs ul').html("");
});
$('#buy_status_switch_button').click(function(){
	if(buy_status) {
		buy_status=0;
		$('#buy_status_value').text('买卖状态: 买');
	} else {
		buy_status=1;
		$('#buy_status_value').text('买卖状态: 卖');
	}
});
$('#refresh_currency_button').click(function(){
	refreshCurrency();
});
$('#lock_status_switch_button').click(function(){
	if(lock_status) {
		lock_status=0;
		$('#lock_status_value').text('下单锁定: 未锁定');
	} else {
		lock_status=1;
		$('#lock_status_value').text('下单锁定: 锁定');
	}
});
$('#cancel_order_button').click(function(){
	cancelOrder_manual();
});
$('#open_refresh_currency_button').click(function(){
	if($('#refresh_currency_frequency_input').val()!=""){
		if (parseFloat($('#refresh_currency_frequency_input').val())<2) {
			alert("更新资金频率不能小于2秒!");
		} else {
			refresh_currency_value = parseFloat($('#refresh_currency_frequency_input').val())*1000;
		}
	}
	if(refresh_currency_flag) {
		refresh_currency_flag=0;
		$('#refrech_currency_status_value').text('更新资金: 关闭');
		clearInterval(currencyRefresh);
	} else {
		refresh_currency_flag=1;
		$('#refrech_currency_status_value').text('更新资金: '+refresh_currency_value+'ms');
		clearInterval(currencyRefresh);
		currencyRefresh = setInterval(refreshCurrency, refresh_currency_value);
	}
});

$('#manual_buy_button').click(function(){
	$(this).prop("disabled",true);
	var amount = $('#manual_buy_amount_input').val();
	var price = $('#manual_buy_price_input').val();
	buyOrder_manual(price, amount);
});

$('#manual_sell_button').click(function(){
	$(this).prop("disabled",true);
	var amount = $('#manual_sell_amount_input').val();
	var price = $('#manual_sell_price_input').val();	
	sellOrder_manual(price, amount);
});

$('#manual_buy_sell_button').click(function(){
	if($('#manual_buy_sell_block').is(":visible")){
		$('#manual_buy_sell_block').fadeOut();
	} else {
		$('#manual_buy_sell_block').fadeIn();
	}
});

$("<div id='tooltip'></div>").css({
	position: "absolute",
	display: "none",
	border: "1px solid #fdd",
	padding: "2px",
	"background-color": "#fee",
	opacity: 0.80
}).appendTo("body");
$("#placeholder").bind("plothover", function (event, pos, item) {
	if (item) {
		var y = item.datapoint[1].toFixed(2);
		$("#tooltip").html(item.series.label+": " + y)
			.css({top: item.pageY+5, left: item.pageX+5})
			.fadeIn(200);
	} else {
		$("#tooltip").hide();
	}
});
</script>