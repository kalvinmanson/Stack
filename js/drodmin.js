$(document).ready(function() {
	$.material.init();
	$(".fancyb").fancybox();


	/*$( ".ckfile" ).click(function() {
		var id = $(this).attr('id');
	  	CKFinder.popup( {
	         chooseFiles: true,
	         onInit: function( finder ) {
	             finder.on( 'files:choose', function( evt ) {
	                 var file = evt.data.files.first();
	                 $( "#"+id ).val(file.getUrl());
	             } );
	         }
	     } );

		
	});*/

	$( ".ckfile" ).click(function() {
		var id = $(this).attr('id');
		openKCFinder(id);
		function openKCFinder(field) {
		    window.KCFinder = {
		        callBack: function(url) {
		            $( "#"+id ).val(url);
		            window.KCFinder = null;
		        }
		    };
		    window.open('/drodmin/editor/kcfinder/browse.php?type=files&dir=files/public', 'kcfinder_textbox',
		        'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
		        'resizable=1, scrollbars=0, width=800, height=600'
		    );
		}
	});


});