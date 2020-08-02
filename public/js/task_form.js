$(function () {
	$('.js-locations-remote-data').select2({
		theme: "bootstrap",
		data: [],
		minimumResultsForSearch: -1, //todo
		ajax: {
			url: window.task_form_locations_url,
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					q: params.term, //todo
					page: params.page || 1
				};
			},
			processResults: function (data, params) {
				return {
					results: data.items,
					pagination: {
						more: data.items.length > 0
					}
				};
			}
		}

	});
	
	$('.js-search-engines-remote-data').select2({
		theme: "bootstrap",
		data: [],
		minimumResultsForSearch: -1, //todo
		ajax: {
			url: window.task_form_task_search_engines_url,
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					q: params.term, //todo
					page: params.page || 1
				};
			},
			processResults: function (data, params) {
				return {
					results: data.items,
					pagination: {
						more: data.items.length > 0
					}
				};
			}
		}

	});
	
	$('#js_task_form_add').submit(function(e){
		taskAdd($(this));
		return e.preventDefault();
	});
	function taskAdd(form) {
		if (!form.length || !$('meta[name="csrf-token"]').length) {
			return;
		}

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.post(window.task_form_add_url, form.serialize(), function (response) {
			if (typeof response !== 'object' || !('success' in response)) {
				alert('Unexpected error');
				return;
			}

			if ($(".alert").length) {
				$(".js-alert-box").hide();
			}
			if ($("#js_content_box").length && response.message_box) {
				$("#js_content_box").before(response.message_box);
			}
			
			if (response.success) {
				form.reset();
			}

		}, "json");
	}
});