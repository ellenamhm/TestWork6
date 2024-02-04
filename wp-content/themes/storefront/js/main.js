jQuery( function($){
    $(window).load( function() {
      if (document.getElementById('price_product')) {
        $('body').on('keydown', '#price_product', function() {
          var preg = $(this).val().replace(/[^.\d]+/g,"").replace( /^([^\.]*\.)|\./g, '$1' );
          $(this).val(preg);
        });
      }

    if (document.getElementById('title_product')) {
      $('body').on('input', '#title_product', function() {
        var fieldLength = $(this).val().length;
        if(fieldLength > 2 &&  fieldLength < 40){
          if(document.getElementById('title_product').classList.contains('errorField')){
            document.getElementById('title_product').classList.remove('errorField');
          };
        } else {
          if(!document.getElementById('title_product').classList.contains('errorField')){
              document.getElementById('title_product').classList.add('errorField')
          };
        }
      });
    }



if (document.getElementById('uploader_custom')) {
    $( 'body' ).on( 'click', '.upload_image_button' , function( event ){
      event.preventDefault();

      const button = $(this);
   
      const customUploader = wp.media({
        title: 'Выберите изображение',
        library : {
          type : 'image'
        },
        button: {
          text: 'Выбрать изображение' 
        },
        multiple: false
      });
   
      customUploader.on('select', function() {
        const image = customUploader.state().get('selection').first().toJSON();
        button.parent().parent('#up_img_custom').find('img').attr( 'src', image.url );
        console.log(button.parent().parent('#up_img_custom').find('img'));
        button.prev().val( image.id );
   
      });
      customUploader.open();
    });

    $( 'body' ).on( 'click', '.remove_image_button' , function( event){
      event.preventDefault();
      if ( true == confirm( "Уверены?" ) ) {
        deleteImg();
      }

    });
}
    function deleteImg(){
      const src = $('#up_img_custom').find('input[type=hidden]').attr('data-src');
      $('#up_img_custom').find('img').attr('src', src);
      $('#up_img_custom').find('input[type=hidden]').val('');
    }


      var ajaxurl = MyAjax.ajaxurl;
      let newProductForm = document.getElementById('form_newproduct');
      let btnForm = document.getElementById('product_custom');

      var loaderElem = function(){

        var searchParams = new URLSearchParams();
        searchParams.set("action", "addprod");
        searchParams.set("title_product", encodeURIComponent(document.getElementById('title_product').value));
        searchParams.set("price_product", encodeURIComponent(document.getElementById('price_product').value));
        searchParams.set("uploader_custom", encodeURIComponent(document.getElementById('uploader_custom').value));
        searchParams.set("date_product", encodeURIComponent(document.getElementById('date_product').value));
        searchParams.set("select_product", encodeURIComponent(document.getElementById('select_product').value));
        searchParams.toString();

        if(btnForm){
          if(!(btnForm.classList.contains('loading'))){
          btnForm.classList.add('loading');
          }
        }

        var data = new FormData();
        data.append('action', 'addprod')
        data.append('title_product', 'title_product')


        fetch(MyAjax.ajaxurl, {
            method : "POST",
            body: searchParams,
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },

        }).then(
            response => response.json() // .json(), etc.
        ).then((json) => {
          if (json.success) {
             if(btnForm){
              if(btnForm.classList.contains('loading')){
                btnForm.classList.remove('loading');
              }
              document.getElementById('form_newproduct').reset();
              alert('product added');
            }
          }
        })
        .catch((e) => console.log('post error'))
        }

      if(btnForm){
        btnForm.addEventListener('click', function(e) {
          e.preventDefault();
          if (document.getElementById('title_product').value == '') {
            document.getElementById('title_product').classList.add('errorField');
            return;
          } 
          loaderElem();
        });
     }

  });

});