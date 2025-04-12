( function( $ ) {

	function addBlacklistClass() { 
		$( "a" ).each( function() {
			if ( this.href.indexOf("/wp-admin/") !== -1 || 
				 this.href.indexOf("/wp-login.php") !== -1 || 
				 this.href.indexOf("/demande-rma/") !== -1 ) {
				$( this ).addClass( "no-smoothState" );
			}
        });
	}

	$( function() {

		addBlacklistClass();

		var settings = { 
			anchors: "a",
			blacklist: ".no-smoothState",
			cache: true,
			prefetchOn: false,
			locationHeader: "X-SmoothState-Location",
			scroll: true,
			onAfter: function( $container , $newcontainer ) {
				
				mysticky($);

			}
		};

		if (!$("body").hasClass("elementor-editor-active")) {
			console.log(	$( "#primary" ).smoothState( settings ).data("smoothState") );
		}

	});

})(jQuery);	