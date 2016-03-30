<?php

class CoursePress_View_Admin_Course_UnitBuilder {

	private static $options = array();

	public static function render() {

		$content = '';

		foreach ( self::view_templates() as $key => $template ) {
			$content .= $template;
		}

		// Cap checking here...
		$nonce = wp_create_nonce( 'unit_builder' );

		$content .= '<div id="unit-builder" data-nonce="' . $nonce . '"><div class="loading">' . esc_html__( 'Unit Builder is loading...', 'CP_TD' ) . '</div></div>';

		return $content;
	}


	public static function view_templates( $template = false ) {

		$course_id = isset( $_GET['id'] )? intval( $_GET['id'] ) : 0;

		$templates = array();

		$templates = array(
			'unit_builder_tab' => '
				<script type="text/template" id="unit-builder-tab-template">
					<li class="coursepress-ub-tab <%= unit_live_class %> <%= unit_active_class %>" data-tab="<%= unit_id %>" data-order="<%= unit_order %>" data-cid="<%= unit_cid %>"><span><%= unit_title %></span></li>
				</script>
			',
			'unit_builder_header' => '
				<script type="text/template" id="unit-builder-header-template">
				<div class="unit-detail" data-cid="<%- unit_cid %>">
					<h3><i class="fa fa-cog"></i>' . esc_html__( 'Unit Settings', 'CP_TD' ) . '<div class="unit-state">%TOGGLE_SWITCH%</h3>
					<label for="unit_name">Unit Title</label>
					<input id="unit_name" class="wide" type="text" value="<%= unit_title %>" name="post_title" spellcheck="true">
					<div class="unit-additional-info">
					<label class="unit-description">' . esc_html__( 'Unit Description', 'CP_TD' ) . '</label>
					<textarea name="unit_description" class="widefat" id="unit_description_1_1"><%= unit_content %></textarea>
					' . CoursePress_Helper_UI::browse_media_field(
				'unit_feature_image',
				'unit_feature_image',
				array(
					'placeholder' => __( 'Add Image URL or Browse for Image', 'CP_TD' ),
					'title' => __( 'Unit Feature Image', 'CP_TD' ),
					'value' => '<%= unit_feature_image %>', // Add _s template
				)
			) . '
					</div>
					<div class="unit-availability">
						<label for="unit_availability">'. esc_html__( 'Unit Availability', 'CP_TD' ) . '</label>
						<select id="unit_availability" class="narrow" name="meta_unit_availability">
							<option value="instant"<%= unit_availability == "instant" ? " selected=\"selected\"" : "" %>>'. __( 'Instantly available', 'CP_TD' ) . '</option>
							<option value="on_date"<%= unit_availability == "on_date" ? " selected=\"selected\"" : "" %>>'. __( 'Available on', 'CP_TD' ) . '</option>
							<option value="after_delay"<%= unit_availability == "after_delay" ? " selected=\"selected\"" : "" %>>'. __( 'Available after', 'CP_TD' ) . '</option>
						</select>
						<div id="div-on_date" class="div-inline ua-div" style="display:none;">
							<div class="date"><input id="dpinputavailability" class="dateinput" type="text" value="<%= unit_date_availability %>" name="meta_unit_date_availability" placeholder="'. __( 'instantly', 'CP_TD' ) . '" spellcheck="true" /></div>
						</div>
						<div id="div-after_delay" class="div-inline ua-div" style="display:none;">
							<input type="number" min="0" max="9999" name="meta_unit_delay_days" value="<%=unit_delay_days%>" placeholder="'. __( 'e.g. 7', 'CP_TD' ) . '" /> <span>'. __( 'Day(s)', 'CP_TD' ) . '</span>
						</div>
					</div>
					<div class="progress-next-unit">
						<label>'. esc_html__( 'Progress to next unit', 'CP_TD' ) . '</label>
						<label><input id="force_current_unit_completion" type="checkbox" value="on" name="meta_force_current_unit_completion" <%= unit_force_completion_checked %> /><span>'.
				sprintf( '%s <em>%s</em> %s',
					esc_html__( 'User needs to', 'CP_TD' ),
					esc_html__( 'answer', 'CP_TD' ),
					esc_html__( 'all mandatory assessments and view all pages in order to access the next unit', 'CP_TD' )
				) . '</span></label>
						<label><input id="force_current_unit_successful_completion" type="checkbox" value="on" name="meta_force_current_unit_successful_completion" <%= unit_force_successful_completion_checked %>><span>'.
			sprintf( '%s <em>%s</em> %s',
				esc_html__( 'User also needs to', 'CP_TD' ),
				esc_html__( 'pass', 'CP_TD' ),
				esc_html__( 'all mandatory assessments', 'CP_TD' )
			) . '</span></label>
					</div>
					<div class="progress-next-unit">
						<label>'. esc_html__( 'Minimum progress to next unit', 'CP_TD' ) . '</label>
						<label><input id="minimum_current_unit_completion" type="checkbox" value="on" name="meta_minimum_current_unit_completion" <%= unit_minimum_completion_checked %> /><span>'.
				sprintf( '%s <em>%s</em> %s',
					esc_html__( 'User needs to', 'CP_TD' ),
					esc_html__( 'answer', 'CP_TD' ),
					esc_html__( 'minimum mandatory assessments and view all pages in order to access the next unit', 'CP_TD' )
				) . '</span></label>
						<label><input id="minimum_current_unit_successful_completion" type="number" value="<%= unit_minimum_successful_completion %>" name="meta_minimum_current_unit_successful_completion" class="small-text" min="0" max="100" /><span> '.
				esc_html__( 'Minimum grading to pass to next unit.', 'CP_TD' ).'
					</div>
				</div>
				<div class="unit-buttons">%BUTTON_SAVE% %BUTTON_DELETE% </div>
				</script>
			',
			'unit_builder_content_placeholder' => '
				<script type="text/template" id="unit-builder-content-placeholder">
				<div class="loading">
				' . esc_html__( 'Loading modules...', 'CP_TD' ) . '
				</div>
				</script>
			',
			'unit_builder_content' => '
				<script type="text/template" id="unit-builder-content-template">
					<div class="section unit-builder-pager"></div>
					<div class="section unit-builder-pager-info"></div>
					<div class="section unit-builder-components"></div>
					<div class="section unit-builder-modules"></div>
					<div class="section unit-builder-footer"></div>
				</script>
			',
			'unit_builder_content_pager' => '
				<script type="text/template" id="unit-builder-pager-template">
					<label>' . esc_html__( 'Unit Sections', 'CP_TD' ) . '</label>
					<ul>
						<% for ( var i = 1; i <= unit_page_count; i++ ) { %>
							<li data-page="<%- i %>">
								<%- i %>
							</li>
						<% }; %>
						<li>+</li>
					</ul>
				</script>
			',
			'unit_builder_content_pager_info' => '
				<script type="text/template" id="unit-builder-pager-info-template">
					<div class="page-info-holder">
					<div class="unit-buttons"><div class="button unit-delete-page-button hidden"><i class="fa fa-trash-o"></i> ' . esc_html__( 'Delete Section', 'CP_TD' ) . '</div></div>
					<label>' . esc_html__( 'Section Title', 'CP_TD' ) . '</label>
					<p class="description">' . esc_html__( 'The label will be displayed on the Course Overview and Unit page', 'CP_TD' ) . '</p>
					<input type="text" value="<%= page_label_text %>" name="page_title" class="wide" />
					<label class="page-description">' . esc_html__( 'Section Description', 'CP_TD' ) . '</label>
					<textarea name="page_description" id="page_description_1_1"><%= page_description %></textarea>
					' . CoursePress_Helper_UI::browse_media_field(
				'page_feature_image',
				'page_feature_image',
				array(
					'placeholder' => __( 'Add Image URL or Browse for Image', 'CP_TD' ),
					'title' => __( 'Section Image', 'CP_TD' ),
					'value' => '<%= page_feature_image %>', // Add _s template
				)
			) . '
					<label><input type="checkbox" value="on" name="show_page_title" <%= page_label_checked %> /><span>' . esc_html__( 'Show section header as part of unit', 'CP_TD' ) . '</span></label>
					</div>
				</script>
			',
			'unit_builder_modules' => '
				<script type="text/template" id="unit-builder-modules-template">
					'. __( 'Modules! This template wont be used... its just here for testing.', 'CP_TD' ) . '
				</script>
			',
			'unit_builder_footer' => '',
		);

		/**
		 * show delete unit button?
		 */
		$content = '';
		if ( CoursePress_Data_Capabilities::can_delete_course_unit( $course_id ) ) {
			$content = sprintf(
				'<div class="button unit-delete-button"><i class="fa fa-trash-o"></i> %s</div>',
				esc_html__( 'Delete Unit', 'CP_TD' )
			);
		}
		$templates['unit_builder_header'] = preg_replace( '/%BUTTON_DELETE%/', $content, $templates['unit_builder_header'] );

		/**
		 * show save unit button?
		 */
		$content = '';
		if ( CoursePress_Data_Capabilities::can_update_course_unit( $course_id ) ) {
			$content = sprintf(
				'<div class="button unit-save-button">%s</div>',
				esc_html__( 'Save', 'CP_TD' )
			);
		}
		$templates['unit_builder_header'] = preg_replace( '/%BUTTON_SAVE%/', $content, $templates['unit_builder_header'] );

		/**
		 * show change status
		 */
		$content = '';
		if ( CoursePress_Data_Capabilities::can_change_course_status( $course_id ) ) {
			$content = CoursePress_Helper_UI::toggle_switch(
				'unit-live-toggle-2',
				'unit-live-toggle-2',
				array(
					'left' => __( 'Draft', 'CP_TD' ),
					'right' => __( 'Live', 'CP_TD' ),
				)
			);
		}
		$templates['unit_builder_header'] = preg_replace( '/%TOGGLE_SWITCH%/', $content, $templates['unit_builder_header'] );

		/**
		 * unit_builder_footer
		 */
		$templates['unit_builder_footer'] = '<script type="text/template" id="unit-builder-footer-template">';
		if ( CoursePress_Data_Capabilities::can_update_course_unit( $course_id ) ) {
			$templates['unit_builder_footer'] .= sprintf(
				'<div class="button unit-save-button">%s</div>',
				esc_html__( 'Save', 'CP_TD' )
			);
		}
		if ( CoursePress_Data_Capabilities::can_change_course_status( $course_id ) ) {
			$templates['unit_builder_footer'] .= CoursePress_Helper_UI::toggle_switch(
				'unit-live-toggle-2',
				'unit-live-toggle-2',
				array(
					'left' => __( 'Draft', 'CP_TD' ),
					'right' => __( 'Live', 'CP_TD' ),
				)
			);
		}
		$templates['unit_builder_footer'] .= '</script>';

		$templates['unit_builder_content_components'] = '
				<script type="text/template" id="unit-builder-components-template">
					<label class="bigger">' . esc_html__( 'Modules', 'CP_TD' ) . '</label>
					<p class="description">' . esc_html__( 'Click to add module elements to the unit', 'CP_TD' ) . '</p>';

		$ouputs = CoursePress_Helper_UI_Module::get_output_types();
		foreach ( $ouputs as $key => $output ) {
			$templates['unit_builder_content_components'] .= '
			<div class="output-element module-' . $key . '" data-type="' . $key . '">
				<a></a>
				<span class="element-label">' . $output['title'] . '</span>
			</div>
			';
		}

		$templates['unit_builder_content_components'] .= '<div class="elements-separator"></div>';

		$inputs = CoursePress_Helper_UI_Module::get_input_types();
		foreach ( $inputs as $key => $input ) {
			$templates['unit_builder_content_components'] .= '
			<div class="input-element module-' . $key . '" data-type="' . $key . '">
				<a id="text_module" class="add-element"></a>
				<span class="element-label">' . $input['title'] . '</span>
			</div>
			';
		}

		$templates['unit_builder_content_components'] .= '
				</script>
			';

		/**
		 * remove templates, depend of capabilities: Create new course units
		 */
		if ( CoursePress_Data_Capabilities::can_create_unit() ) {
			$templates['unit_builder'] = '
				<script type="text/template" id="unit-builder-template">
					<div class="tab-container vertical unit-builder-container">
						<div class="tab-tabs unit-builder-tabs">
						<div id="sticky-wrapper" class="sticky-wrapper sticky-wrapper-tabs">
							<div class="tabs"></div>
							<div class="sticky-buttons"><div class="button button-add-new-unit"><i class="fa fa-plus-square"></i> ' . esc_html__( 'Add New Unit', 'CP_TD' ) . '</div></div>
						</div>
					</div>
					<div class="tab-content tab-content-vertical unit-builder-content">
						<div class="section static unit-builder-header"></div>
						<div class="section static unit-builder-body"></div>
					</div>
					</div>
				</script>
			';
		} else {
			$templates['unit_builder'] = '
				<script type="text/template" id="unit-builder-template">
					<div class="tab-container vertical unit-builder-container">
						<div class="tab-tabs unit-builder-tabs">
						<div id="sticky-wrapper" class="sticky-wrapper sticky-wrapper-tabs">
							<div class="tabs"></div>
						</div>
					</div>
					<div class="tab-content tab-content-vertical unit-builder-content">
						<div class="section static unit-builder-header"></div>
						<div class="section static unit-builder-body"></div>
					</div>
					</div>
				</script>
			';
		}
		return $templates;
	}


	public static function unit_builder_ajax() {
		$json_data = array();
		$skip_empty = false;

		switch ( $_REQUEST['task'] ) {
			case 'units':
				$units = CoursePress_Data_Course::get_units( $_REQUEST['course_id'], 'any' );

				foreach ( $units as $unit ) {
					$meta = get_post_meta( $unit->ID );
					foreach ( $meta as $key => $value ) {
						$meta[ $key ] = is_array( $value )  ? maybe_unserialize( $value[0] ) : $value;
					}
					// Temp for reordering
					$unit->unit_order = isset( $meta['unit_order'] ) ? $meta['unit_order'] : 0;
					$unit->meta = $meta;
				}

				// Reorder units before returning it
				$units = CoursePress_Helper_Utility::sort_on_key( CoursePress_Helper_Utility::object_to_array( $units ), 'unit_order' );

				foreach ( $units as $unit ) {
					$json_data[] = $unit;
				}

				$skip_empty = empty( $units ) ? true : false;
				break;

			case 'modules':
				$modules = CoursePress_Data_Course::get_unit_modules( (int) $_REQUEST['unit_id'], 'any', false, false, array( 'page' => (int) $_REQUEST['page'] ) );

				foreach ( $modules as $module ) {
					$meta = get_post_meta( $module->ID );
					foreach ( $meta as $key => $value ) {
						$meta[ $key ] = is_array( $value )  ? maybe_unserialize( $value[0] ) : $value;
					}
					// Temp for reordering
					$module->module_order = isset( $meta['module_order'] ) ? $meta['module_order'] : 0;
					$module->meta = $meta;
				}

				// Reorder modules before returning it
				$modules = CoursePress_Helper_Utility::sort_on_key( CoursePress_Helper_Utility::object_to_array( $modules ), 'module_order' );

				foreach ( $modules as $module ) {
					$json_data[] = $module;
				}

				$skip_empty = empty( $modules ) ? true : false;
				break;

			case 'units_update':
				if ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_REQUEST['wp_nonce'] ) && wp_verify_nonce( $_REQUEST['wp_nonce'], 'unit_builder' ) ) {

					$data = json_decode( file_get_contents( 'php://input' ) );
					$data = CoursePress_Helper_Utility::object_to_array( $data );

					$units = array();

					foreach ( $data as $unit ) {
						unset( $unit['post_modified'] );
						unset( $unit['post_modified_gmt'] );
						unset( $unit['post_name'] );
						unset( $unit['guid'] );

						$new_unit = false;
						$unit_id = isset( $unit['ID'] ) ? (int) $unit['ID'] : 0;
						if ( 0 === $unit_id ) {
							unset( $unit['ID'] );
							$new_unit = true;
						}

						$update = isset( $unit['flag'] ) && 'dirty' === $unit['flag'];
						unset( $unit['flag'] );

						if ( $update ) {

							$course_id = (int) $_REQUEST['course_id'];
							$unit['post_type'] = CoursePress_Data_Unit::get_post_type_name();
							$unit['post_parent'] = $course_id;
							if ( $new_unit ) {
								$unit['post_status'] = 'draft';
							}

							$meta = ! empty( $unit['meta'] ) ? $unit['meta'] : array();
							unset( $unit['meta'] );

							$id = wp_insert_post( $unit );
							$units[] = $id;

							// Have pages been removed?
							// $pages =
							foreach ( $meta as $key => $value ) {
								update_post_meta( $id, $key, $value );
							}

							do_action( 'coursepress_unit_updated', $id );

							$json_data['unit_id'] = $id;
						} else {
							if ( ! empty( $unit_id ) ) {
								$units[] = $unit_id;
							}
						}
					}

					// Check for removed units and delete if needed.
					$saved_units = CoursePress_Data_Course::get_unit_ids( (int) $_REQUEST['course_id'], array( 'publish', 'draft' ), false );
					foreach ( $saved_units as $u_id ) {
						if ( ! in_array( $u_id, $units ) ) {
							wp_delete_post( $u_id );
							do_action( 'coursepress_unit_deleted', $u_id );
						}
					}

					$json_data['nonce'] = wp_create_nonce( 'unit_builder' );
				}
				break;

			case 'modules_update':
				if ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_REQUEST['wp_nonce'] ) && wp_verify_nonce( $_REQUEST['wp_nonce'], 'unit_builder' ) ) {

					$data = json_decode( file_get_contents( 'php://input' ) );
					$data = CoursePress_Helper_Utility::object_to_array( $data );

					$unit_id = (int) $_REQUEST['unit_id'];

					$modules = array();

					foreach ( $data as $module ) {
						if ( empty( $module ) ) {
							continue;
						}
						unset( $module['post_modified'] );
						unset( $module['post_modified_gmt'] );
						unset( $module['post_name'] );
						unset( $module['guid'] );

						$new_module = false;
						$module_id = isset( $module['ID'] ) ? (int) $module['ID'] : 0;

						if ( ! $module_id ) {
							$new_module = true;
							unset( $module['ID'] );
						}

						$update = isset( $module['flag'] ) && 'dirty' === $module['flag'];
						unset( $module['flag'] );

						$module['post_type'] = CoursePress_Data_Module::get_post_type_name();
						$module['post_parent'] = $unit_id;
						$module['post_status'] = 'publish';

						if ( ! empty( $module['meta'] ) && 'discussion' === $module['meta']['module_type'] ) {
							$data['comment_status'] = 'open';
						}

						if ( $update ) {
							$meta = ! empty( $module['meta'] ) ? $module['meta'] : array();
							unset( $module['meta'] );

							$id = wp_insert_post( $module );
							$modules[] = $id;
							foreach ( $meta as $key => $value ) {
								update_post_meta( $id, $key, $value );
							}

							do_action( 'coursepress_module_updated', $id );
						} else {
							if ( ! empty( $module_id ) ) {
								$modules[] = $module_id;
							}
						}
					}

					// Check for removed modules and delete if needed
					$saved_modules = CoursePress_Data_Course::get_unit_modules(
						(int) $_REQUEST['unit_id'],
						'any',
						true,
						false,
						array( 'page' => (int) $_REQUEST['page'] )
					);

					foreach ( $saved_modules as $mod_id ) {
						if ( ! in_array( $mod_id, $modules ) ) {
							wp_delete_post( $mod_id );
							do_action( 'coursepress_module_deleted', $mod_id );
						}
					}

					$json_data['nonce'] = wp_create_nonce( 'unit_builder' );

				}
				break;

			/*
			case 'unit_update':
				$data = json_decode( file_get_contents( 'php://input' ) );
				$data = CoursePress_Helper_Utility::object_to_array( $data );
				break;
			*/

			case 'unit_toggle':
				$unit_id = (int) $_REQUEST['unit_id'];

				if ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_REQUEST['wp_nonce'] ) && wp_verify_nonce( $_REQUEST['wp_nonce'], 'unit_builder' ) ) {

					$state = sanitize_text_field( $_REQUEST['state'] );

					$response = wp_update_post( array(
						'ID' => $unit_id,
						'post_status' => $state,
					) );

					do_action( 'coursepress_unit_updated', $unit_id );

					$json_data['nonce'] = wp_create_nonce( 'unit_builder' );
				}

				$post = get_post( $unit_id );
				$json_data['post_status'] = $post->post_status;

				break;

			case 'module_add':

				if ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_REQUEST['wp_nonce'] ) && wp_verify_nonce( $_REQUEST['wp_nonce'], 'unit_builder' ) ) {
					$data = json_decode( file_get_contents( 'php://input' ) );
					$data = CoursePress_Helper_Utility::object_to_array( $data );

					$new_module = false;
					$meta = ! empty( $data['meta'] ) ? $data['meta'] : array();
					unset( $data['meta'] );

					if ( ! (int) $data['ID'] ) {
						$new_module = true;
						unset( $data['ID'] );
					}

					$data['ping_status'] = 'closed';
					$data['comment_status'] = 'closed';
					$data['post_parent'] = (int) $_REQUEST['unit_id'];
					$data['post_type'] = CoursePress_Data_Module::get_post_type_name();
					$data['post_status'] = 'publish';

					$id = wp_insert_post( $data );

					foreach ( $meta as $key => $value ) {
						update_post_meta( $id, $key, $value );
					}

					do_action( 'coursepress_module_added', $id );

					$json_data['nonce'] = wp_create_nonce( 'unit_builder' );

				}
				break;
		}

		if ( ! empty( $json_data ) || $skip_empty ) {
			CoursePress_Helper_Utility::send_bb_json( $json_data );
		} else {
			$json_data['success'] = false;
			CoursePress_Helper_Utility::send_bb_json( $json_data );
		}
	}
}
