(function( $ ) {
	'use strict';

    $(function() {
    	var $webformPreviewSelector = $('#js-enormail-form-select');
    	var $webformPreview = $('#js-enormail-webform-preview');

    	if ($webformPreviewSelector.length > 0) {
            $webformPreviewSelector.change(function() {
                var formId = $(this).val();
            	$webformPreview.html('<iframe class="enormail-preview-frame" src="https://app.enormail.eu/subscribe/'+formId+'"></iframe>');
			});
		}

        $(".js-enormail-delete-form").click(function() {
            return confirm("Weet je het zeker? Dit kan niet ongedaan worden gemaakt.");
        });
	});

})( jQuery );
