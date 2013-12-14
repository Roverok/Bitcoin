@if (isset($market_info))
<div class="row">
<div class="col-md-6">
<h4>委买: <em id="em_bid_value">{{ $bid_value }}</em></h4>
<table class="table table-bordered table-hover table-condensed table-responsive">
	<thead>
		<th>价格(元)</th>
		<th>数量</th>
	</thead>
	<tbody>
		@foreach ($market_info->result->market_depth->bid as $bid)
		<tr>
			<td>
				{{ $bid->price }}
			</td>
			<td>
				{{ $bid->amount }}
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
<div class="col-md-6">
<h4>委卖: <em id="em_ask_value">{{ $ask_value }}</em></h4>
<table class="table table-bordered table-hover table-condensed table-responsive">
	<thead>
		<th>价格(元)</th>
		<th>数量</th>
	</thead>
	<tbody>
		@foreach ($market_info->result->market_depth->ask as $ask)
		<tr>
			<td>
				{{ $ask->price }}
			</td>
			<td>
				{{ $ask->amount }}
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
</div>
@endif