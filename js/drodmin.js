$(document).ready(function() {
	$.material.init();
	$(".fancyb").fancybox();


	$( ".ckfile" ).click(function() {
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

		
	});


});