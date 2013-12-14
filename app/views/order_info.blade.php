@if (isset($order_info))
<h4>挂单状态: </h4>
<div style="overflow:auto; height:400px;">
<table class="table table-bordered table-hover table-condensed table-responsive">
	<thead>
		<th>挂单ID</th>
		<th>类型</th>
		<th>价格(元)</th>
		<th>数量(后)</th>
		<th>数量(前)</th>
		<th>日期</th>
		<th>状态</th>
	</thead>
	<tbody>
		@foreach ($order_info->result->order as $order)
		<tr>
			<td>
				{{ $order->id }}
			</td>
			<td>
				@if( $order->type == "ask")
					卖
				@else
					买
				@endif
			</td>
			<td>
				{{ $order->price }}
			</td>
			<td>
				{{ $order->amount }}
			</td>
			<td>
				{{ $order->amount_original }}
			</td>
			<td>
				{{ gmdate("Y-m-d H:i:s", $order->date) }}
			</td>
			<td>
				{{ $order->status }}
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
@endif