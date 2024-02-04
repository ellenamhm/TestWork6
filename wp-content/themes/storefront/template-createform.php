<?php
/**

 * Template name: creat-form
 *
 */
;
get_header(); ?>

<div class="oredertext">
    <?php  

        $userAdmin = current_user_can('administrator');
        if ( is_user_logged_in() ||  $userAdmin) {    
         ; ?>
                
            <div class="modal_title">create product</div>
            

            <div id="result">
                <form class="woocommerce-form" method="post" id="form_newproduct">

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide elem-form">
                        <label class="form__elem-label" for="title_product">название продукта&nbsp;<span class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text input" name="title_product" id="title_product" value="" />
                    </p>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide elem-form">
                        <label class="form__elem-label" for="price_product">цена продукта</label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text input" name="price_product" id="price_product" value="" />
                    </p>

                    <?php 

                        $default = get_site_url() . '/wp-content/uploads/woocommerce-placeholder.png';
                        echo '
                        <div id="up_img_custom">
                            <p><img src="' . $default . '" width="150" /></p>
                            <p><div>
                                <input type="hidden" data-src="' . $default  . '" name="uploader_custom" id="uploader_custom" value="" />
                                <button type="submit" class="upload_image_button button">Загрузить</button>
                                <button type="submit" class="remove_image_button button">×</button>
                            </div></p>
                        </div>
                        '; 
                        $date_today = date("Y-m-d");
                    ?>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide elem-form">
                        <label class="form__elem-label" for="title_product"></label>
                        <input type="date" class="woocommerce-Input woocommerce-Input--text input-text input" name="date_product" id="date_product" value="<?php echo ($date_today);?>" />
                    </p>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide elem-form">
                        <label class="form__elem-label"></label>
                        <select class="select" name="select_product" id="select_product">
                            <option value="">Выберите...</option>
                            <option value="ra">rare</option>
                            <option value="fr">frequent</option>
                            <option value="un">unusua</option>
                        </select>
                    </p>

       

                    <p>
                        <div >
                            <?php //wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                            <button id="product_custom" class="woocommerce-button button" name="product_custom" value="Add product">Add product</button>
                        </div>
                    </p>
                </form>
            </div>
    <?php
     } else {
        echo'<div class="page_default">not page</div>';
     }
    ; ?>
  
</div>
<style type="text/css">
    .select{
        padding: 0.8rem 0.6180469716em;
        background-color: #f2f2f2;
        color: #43454b;
        border: 0;
        border-radius: 0;
        box-sizing: border-box;
        font-weight: 400;
        box-shadow: inset 0 1px 1px rgba(0,0,0,.125);
    }
/*    .select:hover,*/
     .select:focus{
        background-color: #ededed;
        outline: 2px  solid #7f54b3;
    }
    .woocommerce-Input.errorField{
        outline: 2px  solid #ff0000;
    }
    .page_default{
        padding: 14rem 0;
    }
</style>

<?php
get_footer();