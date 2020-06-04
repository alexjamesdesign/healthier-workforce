<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input class="grid grid8_12 search-field" type="search" value="<?php echo get_search_query(); ?>" placeholder="Search" name="s" title="Search for..." />
	<button class="grid grid4_12 search-submit" type="submit"><span class="screen-reader-text"><i class="fa fa-search"></i></span></button>
</form>
