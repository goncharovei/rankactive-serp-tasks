@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ trans('task.tasks_list') }}</div>

                <div class="card-body">

					@if (!$items->isEmpty())

					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">{{ trans('task.keyword') }}</th>
									<th scope="col">{{ trans('task.is_there_result') }}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($items as $item)
								<tr>
									<th scope="row">{{ $item->id }}</th>
									<td><a href="">{{ $item->key }}</a></td>
									<td>{{  trans('task.' . ($item->is_processed ? 'yes' : 'no')) }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>	
					@else

					<p class="text-center">{{ trans('task.the_list_is_empty') }}</p>

					@endif
                </div>
				<div class="mt-3"> {!! $items->render() !!} </div>
            </div>
        </div>
    </div>
</div>

@endsection
