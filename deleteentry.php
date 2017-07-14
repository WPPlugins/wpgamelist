<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
check_ajax_referer( 'wpgamelist-jre-ajax-nonce-deletegame', 'security' ); // Nonce check

function wpgamelist_jre_deleteentry($id){
	?>
	<!--Form that appears for deleting a game when user clicks on the 'delete' link-->
	<div class="wpgamelist_delete_game_form_top_container">
		<form id="wpgamelist_delete_game_form" method="post" action="">
			<p>
				<label for="your_name">Are you sure you want to delete this game?</label>
			</p>
			<p style="display:none;">
	        	<input  type="text"  id="delete_id" name="delete_id" value="<?php echo $id; ?>"/>
	        </p>
			<p id="wpgamelist_delete_game_submit">
				<input type="button" value="Delete game" id="wpgamelist_delete_game_submit_button" />	
			</p>
		</form>
	</div>
	<?php
}
?>