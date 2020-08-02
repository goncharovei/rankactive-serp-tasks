<div class="js-alert-box alert alert-danger alert-dismissible fade show" role="alert">
	@foreach ($errors as $error)
	<div>{{ $error }}</div>
	@endforeach
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>