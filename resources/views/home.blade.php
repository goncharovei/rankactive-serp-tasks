@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">{{ trans('task.setting_task') }}</div>

                <div class="card-body">
                    <form>
						<div class="form-group">
							<label for="exampleFormControlSelect1">{{ trans('task.list_of_search_engines') }}</label>
							<select class="form-control" id="exampleFormControlSelect1" required>
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
							</select>
						</div>
						<div class="form-group">
							<label for="exampleFormControlSelect2">{{ trans('task.list_of_locations') }}</label>
							<select class="form-control" id="exampleFormControlSelect2" required>
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
							</select>
						</div>
						<div class="form-group">
							<label for="exampleInputText1">{{ trans('task.search_word_or_words') }}</label>
							<input type="text" class="form-control" id="exampleInputText1" required>
						</div>
						
						<button type="submit" class="btn btn-primary">{{ trans('task.submit') }}</button>
					</form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
