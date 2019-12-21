<?php
/**
 * Home v1 Metabox
 *
 * Displays the home v1 meta box, tabbed, with several panels covering price, stock etc.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Tokoo_Meta_Box_Home_v1 Class.
 */
class Tokoo_Meta_Box_Home_v1 {

	/**
	 * Output the metabox.
	 *
	 * @param WP_Post $post
	 */
	public static function output( $post ) {
		global $post, $thepostid;

		wp_nonce_field( 'tokoo_save_data', 'tokoo_meta_nonce' );

		$thepostid 		= $post->ID;
		$template_file 	= get_post_meta( $thepostid, '_wp_page_template', true );

		if ( $template_file !== 'template-homepage-v1.php' ) {
			return;
		}

		self::output_home_v1( $post );
	}

	private static function output_home_v1( $post ) {

		$home_v1 = tokoo_get_home_v1_meta();

		?>
		<div class="panel-wrap meta-box-home">
			<ul class="home_data_tabs tk-tabs">
			<?php
				$product_data_tabs = apply_filters( 'tokoo_home_v1_data_tabs', array(
					'general' => array(
						'label'  => esc_html__( 'General', 'tokoo' ),
						'target' => 'general_block',
						'class'  => array(),
					),
                    'slider' => array(
                        'label'  => esc_html__( 'Slider', 'tokoo' ),
                        'target' => 'slider',
                        'class'  => array(),
                    ),
					'products_carousel' => array(
						'label'  => esc_html__( 'Products Carousel - 1', 'tokoo' ),
						'target' => 'products_carousel',
						'class'  => array(),
					),
					'products_carousel_2' => array(
						'label'  => esc_html__( 'Products Carousel - 2', 'tokoo' ),
						'target' => 'products_carousel_2',
						'class'  => array(),
					),
					'banner' => array(
						'label'  => esc_html__( 'Banner', 'tokoo' ),
						'target' => 'banner',
						'class'  => array(),
					),
					'cat_block' => array(
						'label'  => esc_html__( 'Categories Block', 'tokoo' ),
						'target' => 'cat_block',
						'class'  => array(),
					),
					'pb1_block' => array(
						'label'  => esc_html__( 'Products 1-8 Block', 'tokoo' ),
						'target' => 'pb1_block',
						'class'  => array(),
					),
					'fsc_block' => array(
						'label'  => esc_html__( 'Flash Sale Block', 'tokoo' ),
						'target' => 'fsc_block',
						'class'  => array(),
					),
					'pb2_block' => array(
						'label'  => esc_html__( 'Products 4-1-4 Block', 'tokoo' ),
						'target' => 'pb2_block',
						'class'  => array(),
					),
					'brands-carousel' => array(
						'label'  => esc_html__( 'Brands Carousel', 'tokoo' ),
						'target' => 'brands-carousel',
						'class'  => array(),
					),
				) );
				foreach ( $product_data_tabs as $key => $tab ) {
					?><li class="<?php echo esc_attr( $key ); ?>_options <?php echo esc_attr( $key ); ?>_tab <?php echo implode( ' ' , $tab['class'] ); ?>">
						<a href="#<?php echo esc_attr( $tab['target'] ); ?>"><?php echo esc_html( $tab['label'] ); ?></a>
					</li><?php
				}
			?>
			</ul>

			<?php do_action( 'tokoo_home_write_panel_tabs_before' ); ?>

			<div id="general_block" class="panel tokoo_options_panel">
				<div class="options_group">
                    <?php 
                        tokoo_wp_select( array(
                            'id'        => '_home_v1_header_style',
                            'label'     => esc_html__( 'Header Style', 'tokoo' ),
                            'name'      => '_home_v1[header_style]',
                            'options'   => array(
                                'v1'    => esc_html__( 'Header v1', 'tokoo' ),
                                'v2'    => esc_html__( 'Header v2', 'tokoo' ),
                                'v3'    => esc_html__( 'Header v3', 'tokoo' ),
                                'v4'    => esc_html__( 'Header v4', 'tokoo' ),
                            ),
                            'value'     => isset(  $home_v1['header_style'] ) ?  $home_v1['header_style'] : '',
                        ) );
                    ?>
                </div>

                <div class="options_group">
                    <?php 
                        tokoo_wp_select( array(
                            'id'        => '_home_v1_footer_style',
                            'label'     => esc_html__( 'Footer Style', 'tokoo' ),
                            'name'      => '_home_v1[footer_style]',
                            'options'   => array(
                                'v1'    => esc_html__( 'Footer v1', 'tokoo' ),
                                'v2'    => esc_html__( 'Footer v2', 'tokoo' ),
                            ),
                            'value'     => isset(  $home_v1['footer_style'] ) ?  $home_v1['footer_style'] : '',
                        ) );
                    ?>
                </div>

				<div class="options_group">
					<?php 
						$home_v1_blocks = array(
							'hpc'   => esc_html__( 'Page content', 'tokoo' ),
                            'sdr'   => esc_html__( 'Slider', 'tokoo' ),
							'pc'   	=> esc_html__( 'Products Carousel - 1', 'tokoo' ),
							'pc1'   => esc_html__( 'Products Carousel - 2', 'tokoo' ),
							'br'   	=> esc_html__( 'Banner', 'tokoo' ),
							'cat'   => esc_html__( 'Categories Block', 'tokoo' ),
							'pb1'   => esc_html__( 'Products 1-8 Block', 'tokoo' ),
							'fsc'   => esc_html__( 'Flash Sale Block', 'tokoo' ),
							'pb2'   => esc_html__( 'Products 4-1-4 Block', 'tokoo' ),
							'bc'   	=> esc_html__( 'Brands Carousel', 'tokoo' ),
						);
					?>
					<table class="general-blocks-table widefat striped">
						<thead>
							<tr>
								<th><?php echo esc_html__( 'Block', 'tokoo' ); ?></th>
								<th><?php echo esc_html__( 'Animation', 'tokoo' ); ?></th>
								<th><?php echo esc_html__( 'Priority', 'tokoo' ); ?></th>
								<th><?php echo esc_html__( 'Enabled ?', 'tokoo' ); ?></th>
							</tr>	
						</thead>
						<tbody>
							<?php foreach( $home_v1_blocks as $key => $home_v1_block ) : ?>
							<tr>
								<td><?php echo esc_html( $home_v1_block ); ?></td>
								<td><?php tokoo_wp_animation_dropdown( array(  'id' => '_home_v1_' . $key . '_animation', 'label'=> '', 'name' => '_home_v1[' . $key . '][animation]', 'value' => isset( $home_v1['' . $key . '']['animation'] ) ? $home_v1['' . $key . '']['animation'] : '', )); ?></td>
								<td><?php tokoo_wp_text_input( array(  'id' => '_home_v1_' . $key . '_priority', 'label'=> '', 'name' => '_home_v1[' . $key . '][priority]', 'value' => isset( $home_v1['' . $key . '']['priority'] ) ? $home_v1['' . $key . '']['priority'] : 10, ) ); ?></td>
								<td><?php tokoo_wp_checkbox( array( 'id' => '_home_v1_' . $key . '_is_enabled', 'label' => '', 'name' => '_home_v1[' . $key . '][is_enabled]', 'value'=> isset( $home_v1['' . $key . '']['is_enabled'] ) ? $home_v1['' . $key . '']['is_enabled'] : '', ) ); ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<?php do_action( 'tokoo_home_v1_after_general_block' ) ?>

			</div><!-- /#general_block -->

            <div id="slider" class="panel tokoo_options_panel">

                <?php tokoo_wp_legend( esc_html__( 'Slider', 'tokoo' ) ); ?>

                <div class="options_group">
                <?php 
                    tokoo_wp_text_input( array( 
                        'id'            => '_home_v1_sdr_shortcode', 
                        'label'         => esc_html__( 'Slider Shortcode', 'tokoo' ), 
                        'placeholder'   => esc_html__( 'Enter the shorcode for your slider here', 'tokoo' ),
                        'name'          => '_home_v1[sdr][shortcode]',
                        'value'         => isset( $home_v1['sdr']['shortcode'] ) ? $home_v1['sdr']['shortcode'] : '',
                    ) );
                ?>
                </div>

                <?php do_action( 'tokoo_home_v1_after_slider' ) ?>

            </div><!-- /#slider -->

			<div id="products_carousel" class="panel tokoo_options_panel">
				<div class="options_group">
				<?php
					tokoo_wp_checkbox( array(
						'id'			=> '_home_v1_pc_show_header',
						'label'			=> esc_html__( 'Show Header', 'tokoo' ),
						'name'			=> '_home_v1[pc][show_header]',
						'value'			=> isset( $home_v1['pc']['show_header'] ) ? $home_v1['pc']['show_header'] : 'true',
					) );

					tokoo_wp_text_input( array(
						'id'			=> '_home_v1_pc_section_title',
						'label'			=> esc_html__( 'Section Title', 'tokoo' ),
						'name'			=> '_home_v1[pc][section_title]',
						'value'			=> isset( $home_v1['pc']['section_title'] ) ? $home_v1['pc']['section_title'] : esc_html__( 'Deals of the day', 'tokoo' ),
					) );

					tokoo_wp_text_input( array(
						'id'			=> '_home_v1_pc_header_aside_action_text',
						'label'			=> esc_html__( 'Header Aside Action Text', 'tokoo' ),
						'name'			=> '_home_v1[pc][header_aside_action_text]',
						'value'			=> isset( $home_v1['pc']['header_aside_action_text'] ) ? $home_v1['pc']['header_aside_action_text'] : '',
					) );

                    tokoo_wp_text_input( array(
                        'id'            => '_home_v1_pc_header_aside_action_link',
                        'label'         => esc_html__( 'Header Aside Action Link', 'tokoo' ),
                        'name'          => '_home_v1[pc][header_aside_action_link]',
                        'value'         => isset( $home_v1['pc']['header_aside_action_link'] ) ? $home_v1['pc']['header_aside_action_link'] : '',
                    ) );

					tokoo_wp_wc_shortcode( array( 
						'id' 			=> '_home_v1_pc_shortcode_content',
						'label'			=> esc_html__( 'Products', 'tokoo' ),
						'default'		=> 'recent_products',
						'name'			=> '_home_v1[pc][shortcode_content]',
						'value'			=> isset( $home_v1['pc']['shortcode_content'] ) ? $home_v1['pc']['shortcode_content'] : '',
						'fields'        => array( 'per_page', 'orderby', 'order' ),
					) );

					tokoo_wp_slick_carousel_options( array( 
						'id' 			=> '_home_v1_pc_carousel_args',
						'label'			=> esc_html__( 'Carousel Args', 'tokoo' ),
						'name'			=> '_home_v1[pc][carousel_args]',
						'value'			=> isset( $home_v1['pc']['carousel_args'] ) ? $home_v1['pc']['carousel_args'] : '',
						'fields'        => array( 'slidesToShow', 'slidesToScroll', 'autoplay' ),
					) );
				?>
				</div>
			</div><!-- /#products_carousel -->

			<div id="products_carousel_2" class="panel tokoo_options_panel">
				<div class="options_group">
				<?php
					tokoo_wp_checkbox( array(
						'id'			=> '_home_v1_pc1_show_header',
						'label'			=> esc_html__( 'Show Header', 'tokoo' ),
						'name'			=> '_home_v1[pc1][show_header]',
						'value'			=> isset( $home_v1['pc1']['show_header'] ) ? $home_v1['pc1']['show_header'] : 'true',
					) );
					tokoo_wp_text_input( array(
						'id'			=> '_home_v1_pc1_section_title',
						'label'			=> esc_html__( 'Section Title', 'tokoo' ),
						'name'			=> '_home_v1[pc1][section_title]',
						'value'			=> isset( $home_v1['pc1']['section_title'] ) ? $home_v1['pc1']['section_title'] : esc_html__( 'Best Rated Products', 'tokoo' ),
					) );

					tokoo_wp_text_input( array(
                        'id'            => '_home_v1_pc1_header_aside_action_text',
                        'label'         => esc_html__( 'Header Aside Action Text', 'tokoo' ),
                        'name'          => '_home_v1[pc1][header_aside_action_text]',
                        'value'         => isset( $home_v1['pc1']['header_aside_action_text'] ) ? $home_v1['pc1']['header_aside_action_text'] : '',
                    ) );

                    tokoo_wp_text_input( array(
                        'id'            => '_home_v1_pc1_header_aside_action_link',
                        'label'         => esc_html__( 'Header Aside Action Link', 'tokoo' ),
                        'name'          => '_home_v1[pc1][header_aside_action_link]',
                        'value'         => isset( $home_v1['pc1']['header_aside_action_link'] ) ? $home_v1['pc1']['header_aside_action_link'] : '',
                    ) );

					tokoo_wp_wc_shortcode( array( 
						'id' 			=> '_home_v1_pc1_shortcode_content',
						'label'			=> esc_html__( 'Products', 'tokoo' ),
						'default'		=> 'recent_products',
						'name'			=> '_home_v1[pc1][shortcode_content]',
						'value'			=> isset( $home_v1['pc1']['shortcode_content'] ) ? $home_v1['pc1']['shortcode_content'] : '',
						'fields'        => array( 'per_page', 'orderby', 'order' ),
					) );

					tokoo_wp_slick_carousel_options( array( 
						'id' 			=> '_home_v1_pc1_carousel_args',
						'label'			=> esc_html__( 'Carousel Args', 'tokoo' ),
						'name'			=> '_home_v1[pc1][carousel_args]',
						'value'			=> isset( $home_v1['pc1']['carousel_args'] ) ? $home_v1['pc1']['carousel_args'] : '',
						'fields'        => array( 'slidesToShow', 'slidesToScroll', 'autoplay' ),
					) );
				?>
				</div>
			</div><!-- /#products_carousel_2 -->

			<div id="banner" class="panel tokoo_options_panel">
                <div class="options_group">
                <?php
                    tokoo_wp_upload_image( array(
                        'id'            => '_home_v1_br_image',
                        'label'         => esc_html__( 'Banner Image', 'tokoo' ),
                        'name'          => '_home_v1[br][image]',
                        'value'         => isset( $home_v1['br']['image'] ) ? $home_v1['br']['image'] : '',
                    ) );

                    tokoo_wp_text_input( array(
                        'id'            => '_home_v1_br_link',
                        'label'         => esc_html__( 'Link', 'tokoo' ),
                        'name'          => '_home_v1[br][link]',
                        'value'         => isset( $home_v1['br']['link'] ) ? $home_v1['br']['link'] : '#',
                    ) );
                    tokoo_wp_text_input( array(
                        'id'            => '_home_v1_br_el_class',
                        'label'         => esc_html__( 'Extra Class', 'tokoo' ),
                        'name'          => '_home_v1[br][el_class]',
                        'value'         => isset( $home_v1['br']['el_class'] ) ? $home_v1['br']['el_class'] : '',
                    ) );
                ?>
                </div>
            </div><!-- /#banner -->

            <div id="cat_block" class="panel tokoo_options_panel">

                <div class="options_group">
                <?php

                    tokoo_wp_text_input( array(
                        'id'            => '_home_v1_cat_section_title',
                        'label'         => esc_html__( 'Section Title', 'tokoo' ),
                        'name'          => '_home_v1[cat][section_title]',
                        'value'         => isset( $home_v1['cat']['section_title'] ) ? $home_v1['cat']['section_title'] : esc_html__( 'Shop by Categories', 'tokoo' ),
                    ) );

                    tokoo_wp_text_input( array(
                        'id'            => '_home_v1_cat_slugs',
                        'label'         => esc_html__( 'Category Slug', 'tokoo' ),
                        'name'          => '_home_v1[cat][slugs]',
                        'value'         => isset( $home_v1['cat']['slug'] ) ? $home_v1['cat']['slug'] : isset( $home_v1['cat']['slugs'] ) ? $home_v1['cat']['slugs'] : '',
                        'placeholder'   => esc_html__( 'Enter category slugs separated by comma', 'tokoo' ),
                    ) );

                    tokoo_wp_text_input( array(
                        'id'            => '_home_v1_cat_number',
                        'label'         => esc_html__( 'Limit', 'tokoo' ),
                        'placeholder'   => esc_html__( 'Enter the limit', 'tokoo' ),
                        'name'          => '_home_v1[cat][number]',
                        'value'         => isset( $home_v1['cat']['number'] ) ? $home_v1['cat']['number'] : '12',
                    ) );

                    tokoo_wp_select( array( 
                        'id'            => '_home_v1_cat_columns', 
                        'label'         =>  esc_html__( 'Columns', 'tokoo' ),
                        'name'          => '_home_v1[cat][columns]',
                        'options'       => array(
                            '1'          => esc_html__( '1', 'tokoo' ),
                            '2'          => esc_html__( '2', 'tokoo' ),
                            '3'          => esc_html__( '3', 'tokoo' ),
                            '4'          => esc_html__( '4', 'tokoo' ),
                            '5'          => esc_html__( '5', 'tokoo' ),
                            '6'          => esc_html__( '6', 'tokoo' ),
                            
                        ),
                        'value'         => isset( $home_v1['cat']['columns'] ) ? $home_v1['cat']['columns'] : '4',
                    ) );

                    tokoo_wp_checkbox( array(
                        'id'            => '_home_v1_cat_hide_empty',
                        'label'         => esc_html__( 'Hide Empty', 'tokoo' ),
                        'name'          => '_home_v1[cat][hide_empty]',
                        'value'         => isset( $home_v1['cat']['hide_empty'] ) ? $home_v1['cat']['hide_empty'] : '',
                    ) );
                ?>
                </div>
            </div><!-- /#cat_block -->

            <div id="pb1_block" class="panel tokoo_options_panel">
				<div class="options_group">
				<?php

                    tokoo_wp_text_input( array(
						'id'			=> '_home_v1_pb1_section_title',
						'label'			=> esc_html__( 'Section Title', 'tokoo' ),
						'name'			=> '_home_v1[pb1][section_title]',
						'value'			=> isset( $home_v1['pb1']['section_title'] ) ? $home_v1['pb1']['section_title'] : esc_html__( 'Best Seller Products on Gaming Categories', 'tokoo' )
					) );

                    tokoo_wp_checkbox( array( 
                        'id'            => '_home_v1_pb1_show_cat_title', 
                        'label'         =>  esc_html__( 'Show Categories Tab', 'tokoo' ),
                        'name'          => '_home_v1[pb1][show_cat_title]',
                        'value'         => isset( $home_v1['pb1']['show_cat_title'] ) ? $home_v1['pb1']['show_cat_title'] : 'true',
                    ) );

                    tokoo_wp_text_input( array(
                        'id'            => '_home_v1_pb1_tab_title',
                        'label'         => esc_html__( 'Tab Title', 'tokoo' ),
                        'name'          => '_home_v1[pb1][tab_title]',
                        'value'         => isset( $home_v1['pb1']['tab_title'] ) ? $home_v1['pb1']['tab_title'] : esc_html__( 'Gaming', 'tokoo' )
                    ) );

					tokoo_wp_text_input( array( 
                        'id'            => '_home_v1_pb1_number', 
                        'label'         => esc_html__( 'Category number', 'tokoo' ),
                        'name'          => '_home_v1[pb1][number]',
                        'value'         => isset( $home_v1['pb1']['number'] ) ? $home_v1['pb1']['number'] : '',
                    ) );

                    tokoo_wp_text_input( array( 
                        'id'            => '_home_v1_pb1_slugs', 
                        'label'         => esc_html__( 'Category Slugs', 'tokoo' ),
                        'name'          => '_home_v1[pb1][slugs]',
                        'value'         => isset( $home_v1['pb1']['slug'] ) ? $home_v1['pb1']['slug'] : isset( $home_v1['pb1']['slugs'] ) ? $home_v1['pb1']['slugs'] : '',
                    ) );

					tokoo_wp_wc_shortcode( array( 
						'id' 			=> '_home_v1_pb1_shortcode_content',
						'label'			=> esc_html__( 'Products', 'tokoo' ),
						'name'			=> '_home_v1[pb1][shortcode_content]',
						'value'			=> isset( $home_v1['pb1']['shortcode_content'] ) ? $home_v1['pb1']['shortcode_content'] : '',
						'fields'        => array( 'orderby', 'order' ),
					) );
				?>
				</div>
			</div>

			<div id="pb2_block" class="panel tokoo_options_panel">
				<div class="options_group">
				<?php
					tokoo_wp_checkbox( array(
						'id'			=> '_home_v1_pb2_show_header',
						'label'			=> esc_html__( 'Show Header', 'tokoo' ),
						'name'			=> '_home_v1[pb2][show_header]',
						'value'			=> isset( $home_v1['pb2']['show_header'] ) ? $home_v1['pb2']['show_header'] : 'true',
					) );
					tokoo_wp_text_input( array(
						'id'			=> '_home_v1_pb2_section_title',
						'label'			=> esc_html__( 'Section Title', 'tokoo' ),
						'name'			=> '_home_v1[pb2][section_title]',
						'value'			=> isset( $home_v1['pb2']['section_title'] ) ? $home_v1['pb2']['section_title'] : esc_html__( 'New Arrivals', 'tokoo' ),
					) );

					tokoo_wp_text_input( array(
                        'id'            => '_home_v1_pb2_header_aside_action_text',
                        'label'         => esc_html__( 'Header Aside Action Text', 'tokoo' ),
                        'name'          => '_home_v1[pb2][header_aside_action_text]',
                        'value'         => isset( $home_v1['pb2']['header_aside_action_text'] ) ? $home_v1['pb2']['header_aside_action_text'] : '',
                    ) );

                    tokoo_wp_text_input( array(
                        'id'            => '_home_v1_pb2_header_aside_action_link',
                        'label'         => esc_html__( 'Header Aside Action Link', 'tokoo' ),
                        'name'          => '_home_v1[pb2][header_aside_action_link]',
                        'value'         => isset( $home_v1['pb2']['header_aside_action_link'] ) ? $home_v1['pb2']['header_aside_action_link'] : '',
                    ) );

					tokoo_wp_wc_shortcode( array( 
						'id' 			=> '_home_v1_pb2_shortcode_content',
						'label'			=> esc_html__( 'Products', 'tokoo' ),
						'default'		=> 'recent_products',
						'name'			=> '_home_v1[pb2][shortcode_content]',
						'value'			=> isset( $home_v1['pb2']['shortcode_content'] ) ? $home_v1['pb2']['shortcode_content'] : '',
						'fields'        => array( 'orderby', 'order' ),
					) );
				?>
				</div>
			</div>

			<div id="fsc_block" class="panel tokoo_options_panel">
				
				<div class="options_group">
				<?php 
					tokoo_wp_checkbox( array( 
						'id'			=> '_home_v1_fsc_show_header', 
						'label' 		=>  esc_html__( 'Show Header', 'tokoo' ),
						'name'			=> '_home_v1[fsc][show_header]',
						'value'			=> isset( $home_v1['fsc']['show_header'] ) ? $home_v1['fsc']['show_header'] : 'true',
					) );
					tokoo_wp_textarea_input( array( 
						'id'			=> '_home_v1_fsc_section_title', 
						'label' 		=>  esc_html__( 'Section title', 'tokoo' ),
						'name'			=> '_home_v1[fsc][section_title]',
						'value'			=> isset( $home_v1['fsc']['section_title'] ) ? $home_v1['fsc']['section_title'] : '',
					) );

					tokoo_wp_checkbox( array(
						'id'			=> '_home_v1_fsc_header_timer', 
						'label' 		=>  esc_html__( 'Show Timer', 'tokoo' ),
						'name'			=> '_home_v1[fsc][header_timer]',
						'value'			=> isset( $home_v1['fsc']['header_timer'] ) ? $home_v1['fsc']['header_timer'] : '',
					) );

					tokoo_wp_upload_image( array( 
						'id'			=> '_home_v1_fsc_bg_img', 
						'label' 		=>  esc_html__( 'Background Image', 'tokoo' ),
						'name'			=> '_home_v1[fsc][bg_img]',
						'value'			=> isset( $home_v1['fsc']['bg_img'] ) ? $home_v1['fsc']['bg_img'] : '',
					) );

					tokoo_wp_text_input( array( 
						'id'			=> '_home_v1_fsc_timer_value', 
						'label' 		=>  esc_html__( 'Timer Value', 'tokoo' ),
						'name'			=> '_home_v1[fsc][timer_value]',
						'value'			=> isset( $home_v1['fsc']['timer_value'] ) ? $home_v1['fsc']['timer_value'] : '+8 hours',
					) );

					tokoo_wp_text_input( array( 
						'id'			=> '_home_v1_fsc_timer_title', 
						'label' 		=>  esc_html__( 'Timer Title', 'tokoo' ),
						'name'			=> '_home_v1[fsc][timer_title]',
						'value'			=> isset( $home_v1['fsc']['timer_title'] ) ? $home_v1['fsc']['timer_title'] : '',
					) );

					tokoo_wp_wc_shortcode( array( 
						'id' 			=> '_home_v1_fsc_shortcode_content',
						'label'			=> esc_html__( 'Shortcode Content', 'tokoo' ),
						'default'		=> 'sale_products',
						'name'			=> '_home_v1[fsc][shortcode_content]',
						'value'			=> isset( $home_v1['fsc']['shortcode_content'] ) ? $home_v1['fsc']['shortcode_content'] : '',
						'fields'        => array( 'per_page', 'orderby', 'order' ),
					) );

					tokoo_wp_slick_carousel_options( array( 
						'id' 			=> '_home_v1_fsc_carousel_args',
						'label'			=> esc_html__( 'Carousel Args', 'tokoo' ),
						'name'			=> '_home_v1[fsc][carousel_args]',
						'value'			=> isset( $home_v1['fsc']['carousel_args'] ) ? $home_v1['fsc']['carousel_args'] : '',
						'fields'		=> array( 'rows', 'slidesPerRow', 'slidesToShow', 'slidesToScroll', 'autoplay' )
					) );

				?>
				</div>				

				<?php do_action( 'tokoo_home_v1_after_fsc_block' ) ?>

			</div><!-- /#fsc_block -->


			<div id="brands-carousel" class="panel tokoo_options_panel">

                <div class="options_group">
                <?php 

                	tokoo_wp_text_input( array(
						'id'			=> '_home_v1_bc_section_title',
						'label'			=> esc_html__( 'Section Title', 'tokoo' ),
						'name'			=> '_home_v1[bc][section_title]',
						'value'			=> isset( $home_v1['bc']['section_title'] ) ? $home_v1['bc']['section_title'] : esc_html__( 'Our Offical Brand', 'tokoo' ),
					) );
                    
                    tokoo_wp_select( array( 
                        'id'            => '_home_v1_bc_orderby', 
                        'label'         =>  esc_html__( 'Order By', 'tokoo' ),
                        'name'          => '_home_v1[bc][orderby]',
                        'options'       => array(
                            'name'           => esc_html__( 'Name', 'tokoo' ),
                            'slug'           => esc_html__( 'Slug', 'tokoo' ),
                            'term_group'     => esc_html__( 'Term Group', 'tokoo' ),
                            'term_id'        => esc_html__( 'Term Id', 'tokoo' ),
                            'id'             => esc_html__( 'Id', 'tokoo' ),
                            'description'    => esc_html__( 'Description', 'tokoo' ),
                            'parent'         => esc_html__( 'Parent', 'tokoo' ),
                        ),
                        'value'              => isset( $home_v1['bc']['orderby'] ) ? $home_v1['bc']['orderby'] : 'id',
                    ) );
                    
                    tokoo_wp_select( array( 
                        'id'            => '_home_v1_bc_order', 
                        'label'         =>  esc_html__( 'Order', 'tokoo' ),
                        'name'          => '_home_v1[bc][order]',
                        'options'       => array(
                            'ASC'           => esc_html__( 'ASC', 'tokoo' ),
                            'DESC'          => esc_html__( 'DESC', 'tokoo' ),
                        ),
                        'value'         => isset( $home_v1['bc']['order'] ) ? $home_v1['bc']['order'] : 'ASC',
                    ) );

                    tokoo_wp_text_input( array( 
                        'id'            => '_home_v1_bc_number', 
                        'label'         =>  esc_html__( 'Limit', 'tokoo' ),
                        'name'          => '_home_v1[bc][number]',
                        'value'         => isset( $home_v1['bc']['number'] ) ? $home_v1['bc']['number'] : '4',
                    ) );

                    tokoo_wp_checkbox( array(
                        'id'            => '_home_v1_bc_hide_empty', 
                        'label'         =>  esc_html__( 'Hide Empty?', 'tokoo' ),
                        'name'          => '_home_v1[bc][hide_empty]',
                        'value'         => isset( $home_v1['bc']['hide_empty'] ) ? $home_v1['bc']['hide_empty'] : '',
                    ) );

                    tokoo_wp_slick_carousel_options( array( 
                        'id'            => '_home_v1_bc_carousel_args',
                        'label'         => esc_html__( 'Carousel Args', 'tokoo' ),
                        'name'          => '_home_v1[bc][carousel_args]',
                        'value'         => isset( $home_v1['bc']['carousel_args'] ) ? $home_v1['bc']['carousel_args'] : '',
                        'fields'        => array( 'slidesToShow', 'slidesToScroll', 'autoplay' ),
                    ) );
                ?>
                </div>

                <?php do_action( 'tokoo_home_v1_after_brands_carousel' ) ?>

            </div> <!-- /#brands_carousel -->
		</div>
		<?php
	}

	public static function save( $post_id, $post ) {
		if ( isset( $_POST['_home_v1'] ) ) {
			$clean_home_v1_options = tokoo_clean_kses_post_allow_iframe( $_POST['_home_v1'] );
			update_post_meta( $post_id, '_home_v1_options',  serialize( $clean_home_v1_options ) );
		}	
	}
}
