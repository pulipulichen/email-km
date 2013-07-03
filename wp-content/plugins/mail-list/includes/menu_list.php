<?php

//menu options
function dc_ml_menu_list() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	//process data ****************************************************************************************
	
	//delete email
	
	if( isset( $_GET['delete_id']) ){
		
		global $wpdb;
		$delete_id=$_GET['delete_id'];
		
		//delete this email
		$table_name=$wpdb->prefix."mail_list_table";
		$safe_sql = $wpdb->prepare("DELETE FROM $table_name WHERE id = %d ", $delete_id);
		$wpdb->query($safe_sql);
			
	}
	
	?>

	<!-- output ********************************************************************************************** -->
	
	<div class="wrap">
		
		<?php screen_icon( 'options-general' ); ?>
		<h2>List</h2>	
		
		<!-- show the playlist table -->
		
		<?php
		
		//retrieve the total number of emals
		global $wpdb;
		$table_name=$wpdb->prefix."mail_list_table";
		$results = $wpdb->get_results("SELECT id FROM $table_name");		
		$total_emails = count( $results );
		
		//Initialize the pagination class
		$pag = new dc_ml_pagination();
		$pag->set_total_items( $total_emails );//Set the total number of items
		$pag->set_record_per_page( 20 ); //Set records per page
		$pag->set_target_page( "admin.php?page=dc_ml_menu_list" );//Set target page
		$pag->set_current_page();//set the current page number from $_GET
		
		?>
		
		<!-- Query the database -->
		<?php global $wpdb;
		$table_name=$wpdb->prefix."mail_list_table"; $dc_ml_query_limit = $pag->query_limit();
		$results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC $dc_ml_query_limit ", ARRAY_A); ?>
		
		<?php if( count($results) > 0 ) : ?>
			
			<!-- Display the pagination -->
            <div class="tablenav">
                <div class="tablenav-pages">
                    <span class="displaying-num"><?php echo $pag->total_items; ?> items</span>
                    <?php $pag->show(); ?>
                </div>
            </div>			
		
			<!-- list of playlist -->
			<table class="widefat">
				<thead>
					<tr>
						<th>ID</th>
						<th>Email</th>
						<th>Confirmed</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>Email</th>
						<th>Confirmed</th>
						<th>Delete</th>
					</tr>
				</tfoot>
				<tbody>
				
				<?php foreach($results as $result) : ?>
					<tr>
						<td><?php echo $result['id']; ?></td>
						<td><?php echo esc_html( stripslashes(  $result['email'] ) ); ?></td>
						<td><?php if( intval( $result['confirm'], 10 ) == 1 ){ echo Yes;} else{ echo 'No'; } ?></td>
						<td><?php echo '<a href="admin.php?page=dc_ml_menu_list&delete_id='. $result['id'] .'" >Delete</a>'; ?></td>									
					</tr>
				<?php endforeach; ?>

				</tbody>
			</table>	
			
		<?php else : ?>
		
			<!-- Show the no ideas message -->
			<?php echo '<p>No emails yet.</p>'; ?>
		
		<?php endif; ?>
				
		
	</div>
	
	<!-- display credits -->
	<?php danycode_credits('Mail List','http://www.danycode.com/mail-list/'); ?>
		
<?php

}

?>
