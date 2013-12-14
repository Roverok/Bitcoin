@if (isset($account_info))
<h4>用户信息:</h4>
<table class="table table-bordered table-hover table-condensed table-responsive">
	<tbody>
		<tr>
			<td>用户名</td>
			<td>
				{{ $account_info->result->profile->username }}
			</td>
		</tr>
		<tr>
			<td>交易密码</td>
			<td>
				@if ($account_info->result->profile->trade_password_enabled)
					开启
				@else 
					关闭
				@endif
			</td>
		</tr>
		<tr>
			<td>双重加密</td>
			<td>
				@if ($account_info->result->profile->otp_enabled)
					开启
				@else 
					关闭
				@endif
			</td>
		</tr>
		<tr>
			<td>手续费</td>
			<td>
				{{ $account_info->result->profile->trade_fee }}
			</td>
		</tr>
		<tr>
			<td>比特币日交易限额</td>
			<td>
				{{ $account_info->result->profile->daily_btc_limit }}
			</td>
		</tr>
		<tr>
			<td>比特币充值地址</td>
			<td style="word-break: break-all">
				{{ $account_info->result->profile->btc_deposit_address }}
			</td>
		</tr>
		<tr>
			<td>比特币提现地址</td>
			<td style="word-break: break-all">
				{{ $account_info->result->profile->btc_withdrawal_address }}
			</td>
		</tr>
	</tbody>
</table>

<h4>帐户信息:</h4>
<table class="table table-bordered table-hover table-condensed table-responsive">
	<thead>
		<th>货币</th>
		<th>余额</th>
	</thead>
	<tbody>
		<tr>
			<td>
				{{ $account_info->result->balance->btc->currency }}
			</td>
			<td id="my_btc_amount">
				{{ $account_info->result->balance->btc->amount }}
			</td>
		</tr>
		<tr>
			<td>
				{{ $account_info->result->balance->cny->currency }}
			</td>
			<td id="my_cny_amount">
				{{ $account_info->result->balance->cny->amount }}
			</td>
		</tr>
	</tbody>
</table>

<h4>被冻结 :</h4>
<table class="table table-bordered table-hover table-condensed table-responsive">
	<thead>
		<th>货币</th>
		<th>余额</th>
	</thead>
	<tbody>
		<tr>
			<td>
				{{ $account_info->result->frozen->btc->currency }}
			</td>
			<td id="my_frozen_btc_amount">
				@if ($account_info->result->frozen->btc->amount=="")
				0
				@else
				{{ $account_info->result->frozen->btc->amount }}
				@endif
			</td>
		</tr>
		<tr>
			<td>
				{{ $account_info->result->frozen->cny->currency }}
			</td>
			<td id="my_frozen_cny_amount">
				@if ($account_info->result->frozen->cny->amount=="")
				0
				@else
				{{ $account_info->result->frozen->cny->amount }}
				@endif
			</td>
		</tr>
	</tbody>
</table>
@endif