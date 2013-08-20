(function($, D) {
	$(D).ready(function() {
		$('#fileupload').fileupload({
			url: Routing.generate('HexMediaMediaUpload'),
			dataType: 'json',
			autoUpload: false,
			acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
			maxFileSize: 5000000, // 5 MB
			// Enable image resizing, except for Android and Opera,
			// which actually support image resizing, but fail to
			// send Blob objects via XHR requests:
			disableImageResize: /Android(?!.*Chrome)|Opera/
					.test(window.navigator && navigator.userAgent),
			previewMaxWidth: 100,
			previewMaxHeight: 100,
			previewCrop: true
		}).on('fileuploadadd', function(e, data) {
			data.context = $('<div/>').appendTo('#files');
			$.each(data.files, function(index, file) {
				var node = $('<p/>')
						.append($('<span/>').text(file.name));
				if (!index) {
					node
							.append('<br>');
				}
				node.appendTo(data.context);
			});
		}).on('fileuploadprocessalways', function(e, data) {
			var index = data.index,
					file = data.files[index],
					node = $(data.context.children()[index]);
			if (file.preview) {
				node
						.prepend('<br>')
						.prepend(file.preview);
			}
			if (file.error) {
				node
						.append('<br>')
						.append(file.error);
			}
			if (index + 1 === data.files.length) {
				data.context.find('button')
						.text('Upload')
						.prop('disabled', !!data.files.error);
			}
		}).on('fileuploadprogressall', function(e, data) {
			var progress = parseInt(data.loaded / data.total * 100, 10);
			$('#progress .bar').css(
					'width',
					progress + '%'
					);
		}).on('fileuploaddone', function(e, data) {
			$.each(data.result.files, function(index, file) {
				var link = $('<a>')
						.attr('target', '_blank')
						.prop('href', file.url);
				$(data.context.children()[index])
						.wrap(link);
			});
		}).on('fileuploadfail', function(e, data) {
			$.each(data.result.files, function(index, file) {
				var error = $('<span/>').text(file.error);
				$(data.context.children()[index])
						.append('<br>')
						.append(error);
			});
		});
	});
})(jQuery);