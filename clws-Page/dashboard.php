<?php 
    $url= get_site_url();
    if (!empty(get_option('token'))) { ?>
    <div class="clws_iframe">
	<iframe src="<?php echo esc_url(CLWS_IFRAME_URL)?>dashboard/ecommerce" width="100%" height="100%" frameborder="0"></iframe>
    </div>
    <?php } ?>
        


