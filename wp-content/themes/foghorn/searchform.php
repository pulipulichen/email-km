<?php
/**
 * The template for displaying search forms in Foghorn
 *
 * @package WordPress
 * @subpackage Foghorn
 * @since Foghorn 0.1
 * 
 * 改用Solr的搜尋框架
 * @author Pulipuli Chen <pulipuli.chen@gmail.com> 20180803
 */
?>
	<form method="get" id="searchform" action="<?php echo home_url( '/' ); ?>/laboratory-management/search-results/">
		<input type="text" class="field" name="search" id="s" placeholder="<?php esc_attr_e( 'Search', 'foghorn' ); ?>" />
		<input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'foghorn' ); ?>" />
	</form>
