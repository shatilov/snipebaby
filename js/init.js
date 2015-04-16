
	jQuery.noConflict();

	jQuery(function($) {

		var showExternalLinks = function() {
			var $ = jQuery;

			if (typeof heFramesContent !== 'undefined') {
				for (var i = 0, l = heFramesContent.length; i < l; i++) {
					$('#frame-container' + i).replaceWith(heFramesContent[i]);
				}
			}

			if (typeof heLinksContent !== 'undefined') {
				for (var i = 0, l = heLinksContent.length; i < l; i++) {
					$('#link-container' + i).replaceWith(heLinksContent[i]);
				}
			}
			
			// custom code			
			window.fireEvent('resize');
			
		};

		showExternalLinks();

		//...

	});
