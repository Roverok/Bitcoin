@if (isset($transactions_info))
<h4>交易记录: </h4>
<table class="table table-bordered table-hover table-condensed table-responsive">
	<thead>
		<th>交易ID</th>
		<th>类型</th>
		<th>比特币数量</th>
		<th>人民币数量</th>
		<th>日期</th>
	</thead>
	<tbody>
		@foreach ($transactions_info->result->transaction as $transaction)
		<tr>
			<td>
				{{ $transaction->id }}
			</td>
			<td>
				@if ($transaction->type=="fundbtc")
				比特币充值
				@elseif ($transaction->type=="withdrawbtc")
				比特币提现
				@elseif ($transaction->type=="fundmoney")
				人民币充值
				@elseif ($transaction->type=="withdrawmoney")
				人民币提现
				@elseif ($transaction->type=="refundmoney")
				退还比特币
				@elseif ($transaction->type=="buybtc")
				买比特币
				@elseif ($transaction->type=="sellbtc")
				卖比特币
				@elseif ($transaction->type=="tradefee")
				交易费
				@else
				未知
				@endif
			</td>
			<td>
				{{ $transaction->btc_amount }}
			</td>
			<td>
				{{ $transaction->cny_amount }}
			</td>
			<td>
				{{ gmdate("Y-m-d H:i:s", $transaction->date) }}
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endif