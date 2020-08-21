(function ($) {
	'use strict';

	let file_frame = wp.media.frames.file_frame = wp.media({
		title: 'Choose Thumbnail',
		library: {
			type: "image"
		},
		multiple: false
	}),
		$thumbnailWrapper = $('#thumbnail-field'),
		$addThumbnailBtn = $('.add-term-thumbnail', $thumbnailWrapper),
		$removeThumbnailBtn = $('.remove-term-thumbnail', $thumbnailWrapper),
		$thumbnail = $('.attachment', $thumbnailWrapper),
		$thumbnailID = $('#thumbnail', $thumbnailWrapper),
		$img = $('.thumbnail img', $thumbnailWrapper);

	$addThumbnailBtn.on('click', open);
	$thumbnail.on('click', open);

	function open(evt) {
		evt.preventDefault();

		file_frame.open();
	}

	file_frame.on('select', function () {
		let attachment = file_frame.state().get('selection').first().toJSON(),
			size = attachment.sizes.hasOwnProperty('thumbnail') ? 'thumbnail' : 'full';

		$img.attr('src', attachment.sizes[size].url);
		$thumbnailID.attr('value', attachment.id);
	});

	$removeThumbnailBtn.on('click', function () {
		$thumbnailID.attr('value', '');
	});

})(jQuery);