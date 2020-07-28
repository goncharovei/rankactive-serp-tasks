@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ trans('task.result') }} {{ trans('task.for') }} <a href=""></a></div>

                <div class="card-body">

					@if (!$items->isEmpty())

					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">{{ trans('task.post_key') }}</th>
									<th scope="col">{{ trans('task.result_url') }}</th>
									<th scope="col">{{ trans('task.result_title') }}</th>
									<th scope="col">{{ trans('task.loc_id') }}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($items as $item)
								<tr>
									<th scope="row">{{ $item->id }}</th>
									<td>{{ $item->post_key }}</td>
									<td>{{ $item->result_url }}</td>
									<td>{{ $item->result_title }}</td>
									<td>{{ $item->loc_id }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>	
					@else

					<p class="text-center">{{ trans('task.the_list_is_empty') }}</p>

					@endif
					
                </div>
				
            </div>
        </div>
    </div>
</div>

@endsection
