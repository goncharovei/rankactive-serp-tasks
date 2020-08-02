@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">{{ trans('task.setting_task') }}</div>

                <div class="card-body">
                    <form id="js_task_form_add">
						<div class="form-group">
							<label for="exampleFormControlSelect1">{{ trans('task.list_of_search_engines') }}</label>
							<select name="se_id" class="form-control js-search-engines-remote-data" id="exampleFormControlSelect1" required></select>
						</div>
						<div class="form-group">
							<label for="exampleFormControlSelect2">{{ trans('task.list_of_locations') }}</label>
							<select name="loc_id" class="form-control js-locations-remote-data" id="exampleFormControlSelect2" required></select>
						</div>
						<div class="form-group">
							<label for="exampleInputText1">{{ trans('task.search_word_or_words') }}</label>
							<input name="key" type="text" class="form-control" id="exampleInputText1" required>
						</div>
						
						<button type="submit" class="btn btn-primary">{{ trans('task.submit') }}</button>
					</form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('header_style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />
@endsection
@section('footer_script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.15.0/lodash.min.js"></script>
<script type="text/javascript">
	window.task_form_locations_url = "{{ route('task_locations') }}";
	window.task_form_task_search_engines_url = "{{ route('task_search_engines') }}";
	window.task_form_add_url = "{{ route('task_add') }}";
</script>
<script type="text/javascript" src="{{ asset('js/task_form.js') }}"></script>
@endsection
