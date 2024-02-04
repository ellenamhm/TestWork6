jQuery( function($){

	$(window).load( function() {
		if (document.getElementById('update_custom')) {
		$( 'body' ).on( 'click', '#update_custom' , function( event ) {
			event.preventDefault();
			$('#publish').trigger('click');
		});
    }



	    $( 'body' ).on( 'click', '.upload_image_button' , function( event ){
			event.preventDefault();

			const button = $(this);
	 
			const customUploader = wp.media({
				title: 'Выберите изображение',
				library : {
					// uploadedTo : wp.media.view.settings.post.id, // если для метобокса и хотим прилепить к текущему посту
					type : 'image'
				},
				button: {
					text: 'Выбрать изображение' 
				},
				multiple: false
			});
	 
			customUploader.on('select', function() {
				const image = customUploader.state().get('selection').first().toJSON();
				button.parent().prev().attr( 'src', image.url );
				button.prev().val( image.id );
	 
			});
			customUploader.open();
		});

		$( 'body' ).on( 'click', '.remove_image_button' , function( event){
			event.preventDefault();
			if ( true == confirm( "Уверены?" ) ) {
				deleteImg();
				// const src = $(this).parent().find('input[type=hidden]').attr('data-src');
				// $(this).parent().prev().attr('src', src);
				// $(this).prev().prev().val('');
			}

		});

		$( 'body' ).on( 'click', '#remove_custom' , function( event){
			event.preventDefault();
			if ( true == confirm( "Уверены?" ) ) {
				deleteImg();
				var date = new Date();
				var currentDate = date.toISOString().substring(0,10);
				console.log(currentDate);
				$('#custom_date').val(currentDate);
				$('#custom_select').val('');
			}
		});

		function deleteImg(){
			const src = $('#up_img_custom').find('input[type=hidden]').attr('data-src');
			$('#up_img_custom').find('img').attr('src', src);
			$('#up_img_custom').find('input[type=hidden]').val('');
		}

	});

});

