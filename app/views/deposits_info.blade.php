@if (isset($deposits_info))
<h4>充值记录: </h4>
<table class="table table-bordered table-hover table-condensed table-responsive">
	<thead>
		<th>充值ID</th>
		<th>地址</th>
		<th>比特币数量</th>
		<th>日期</th>
		<th>状态</th>
	</thead>
	<tbody>
		@foreach ($deposits_info->result->deposit as $deposit)
		<tr>
			<td>
				{{ $deposit->id }}
			</td>
			<td style="word-break: break-all">
				{{ $deposit->address }}
			</td>
			<td>
				{{ $deposit->amount }}
			</td>
			<td>
				{{ gmdate("Y-m-d H:i:s", $deposit->date) }}
			</td>
			<td>
				{{ $deposit->status }}
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endif