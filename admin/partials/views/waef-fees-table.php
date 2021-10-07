<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Conditions table.
 *
 * Display table with all the user configured fees conditions.
 *
 * @author		multisquares
 * @package 	WooCommerce Advanced Extra Fees Lite
 * @version		1.0.0
 */

$methods = get_posts( array( 'posts_per_page' => '-1', 'post_type' => 'waef', 'post_status' => array( 'draft', 'publish'), 'orderby' => 'menu_order', 'order' => 'ASC' ) );
?>      
<form method="post" action="#">
<tr valign="top">
	<th scope="row" class="titledesc"><h1><?php
        _e( 'Advanced Extra Fees rates', 'woocommerce-advanced-extra-fees' ); ?>:</h1><br />
	</th>
	<td class="forminp" id="<?php echo esc_attr( $this->id ); ?>_shipping_methods">

		<table class='wp-list-table waef-table widefat'>
			<thead>
				<tr>
					<th style='width: 17px;'></th>
					<th style='padding-left: 10px;'><?php _e( 'Title', 'woocommerce-advanced-extra-fees' ); ?></th>
					<th style='padding-left: 10px;'><?php _e( 'Fees title', 'woocommerce-advanced-extra-fees' ); ?></th>
					<th style='padding-left: 10px; width: 100px;'><?php _e( 'Fees price', 'woocommerce-advanced-extra-fees' ); ?></th>
					<th style='width: 70px;'><?php _e( '# Groups', 'woocommerce-advanced-extra-fees' ); ?></th>
				</tr>
			</thead>
			<tbody><?php

				$i = 0;
				foreach ( $methods as $method ) :

					$method_details = get_post_meta( $method->ID, '_waef_shipping_method', true );
					$conditions     = get_post_meta( $method->ID, '_waef_conditions', true );
                                    
					$alt = ( $i++ ) % 2 == 0 ? 'alternate' : '';
					?><tr class='<?php echo $alt; ?>'>

						<td class='sort'>
							<input type='hidden' name='sort[]' value='<?php echo absint( $method->ID ); ?>' />
						</td>
						<td>
							<strong>
								<a href='<?php echo get_edit_post_link( $method->ID ); ?>' class='row-title' title='<?php _e( 'Edit Method', 'woocommerce-advanced-extra-fees' ); ?>'><?php
									echo _draft_or_post_title( $method->ID );
								?></a><?php
								echo _post_states( $method );
							?></strong>
							<div class='row-actions'>
								<span class='edit'>
									<a href='<?php echo get_edit_post_link( $method->ID ); ?>' title='<?php _e( 'Edit Method', 'woocommerce-advanced-extra-fees' ); ?>'>
										<?php _e( 'Edit', 'woocommerce-advanced-extra-fees' ); ?>
									</a>
									|
								</span>
								<span class='trash'>
									<a href='<?php echo get_delete_post_link( $method->ID ); ?>' title='<?php _e( 'Delete Method', 'woocommerce-advanced-extra-fees' ); ?>'>
										<?php _e( 'Delete', 'woocommerce-advanced-extra-fees' ); ?>
									</a>
								</span>
							</div>
						</td>
						<td><?php
							if ( empty( $method_details['fees_title'] ) ) :
								_e( 'Shipping', 'woocommerce-advanced-extra-fees' );
							else :
								echo wp_kses_post( $method_details['fees_title'] );
							endif;
						?></td>
						<td><?php echo isset( $method_details['fees_cost'] ) ? wp_kses_post(  preg_replace( '/[^0-9\%\.\,\-]/', '',$method_details['fees_cost'] ) ) : ''; ?></td>
						<td><?php echo absint( count( $conditions ) ); ?></td>						

					</tr><?php

				endforeach;

				if ( empty( $method ) ) :

					?><tr>
						<td colspan='6'><?php _e( 'There are no Advanced Extra Fees conditions. Yet...', 'woocommerce-advanced-extra-fees' ); ?></td>
					</tr><?php

				endif;

			?></tbody>
			<tfoot>
				<tr>
					<th colspan='6' style='padding-left: 10px;'>
						<a href='<?php echo admin_url( 'post-new.php?post_type=waef' ); ?>' class='add button'>
							<?php _e( 'Add New Fees', 'woocommerce-advanced-extra-fees' ); ?>
						</a>
					</th>
				</tr>
			</tfoot>
		</table>
	</td>
        <?php submit_button(); ?>
</tr>
</form>