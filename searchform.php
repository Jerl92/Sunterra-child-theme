<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
        <input type="text" value="<?php _e( '', 'supportdesk-child-theme' ) ?>" name="s" id="s" placeholder="<?php if (qtranxf_getLanguage() == 'en') { _e( 'Search RMA #, Serial #, Model...', 'supportdesk-child-theme' ); } else if (qtranxf_getLanguage() == 'fr') {  _e( 'Rechercher par RMA #, Numero de serie #, Model...', 'supportdesk-child-theme' ); } ?>" />
<?php if( is_home() || 'post' == get_post_type() || is_category() || is_tag() ) { ?><input type="hidden" name="post_type" value="post" /><?php } ?>
</form>