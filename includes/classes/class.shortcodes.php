<?php
if ( !defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly

    /*
      CoursePress Shortcodes
     */

if ( !class_exists( 'CoursePress_Shortcodes' ) ) {

    class CoursePress_Shortcodes extends CoursePress {
        /* function CoursePress_Shortcodes() {
          $this->__construct();
          } */

        function __construct() {
            //register plugin shortcodes
            add_shortcode( 'course_instructors', array( &$this, 'course_instructors' ) );
            add_shortcode( 'course_instructor_avatar', array( &$this, 'course_instructor_avatar' ) );
            add_shortcode( 'instructor_profile_url', array( &$this, 'instructor_profile_url' ) );			
            add_shortcode( 'course_details', array( &$this, 'course_details' ) );
            add_shortcode( 'courses_student_dashboard', array( &$this, 'courses_student_dashboard' ) );
            add_shortcode( 'courses_student_settings', array( &$this, 'courses_student_settings' ) );
            add_shortcode( 'student_registration_form', array( &$this, 'student_registration_form' ) );
            add_shortcode( 'courses_urls', array( &$this, 'courses_urls' ) );
            add_shortcode( 'course_units', array( &$this, 'course_units' ) );
            add_shortcode( 'course_units_loop', array( &$this, 'course_units_loop' ) );
            add_shortcode( 'course_notifications_loop', array( &$this, 'course_notifications_loop' ) );
            add_shortcode( 'course_discussion_loop', array( &$this, 'course_discussion_loop' ) );
            add_shortcode( 'course_unit_single', array( &$this, 'course_unit_single' ) );
            add_shortcode( 'course_unit_details', array( &$this, 'course_unit_details' ) );
            add_shortcode( 'course_unit_archive_submenu', array( &$this, 'course_unit_archive_submenu' ) );
            add_shortcode( 'course_breadcrumbs', array( &$this, 'course_breadcrumbs' ) );
            add_shortcode( 'course_discussion', array( &$this, 'course_discussion' ) );
            add_shortcode( 'get_parent_course_id', array( &$this, 'get_parent_course_id' ) );
            add_shortcode( 'units_dropdown', array( &$this, 'units_dropdown' ) );

			add_shortcode( 'course', array( &$this, 'course' ) );
			// Sub-shortcodes
			add_shortcode( 'course_title', array( &$this, 'course_title' ) );
			add_shortcode( 'course_summary', array( &$this, 'course_summary' ) );
			add_shortcode( 'course_description', array( &$this, 'course_description' ) );
			add_shortcode( 'course_start', array( &$this, 'course_start' ) );			
			add_shortcode( 'course_end', array( &$this, 'course_end' ) );						
			add_shortcode( 'course_dates', array( &$this, 'course_dates' ) );		
			add_shortcode( 'course_enrollment_start', array( &$this, 'course_enrollment_start' ) );			
			add_shortcode( 'course_enrollment_end', array( &$this, 'course_enrollment_end' ) );						
			add_shortcode( 'course_enrollment_dates', array( &$this, 'course_enrollment_dates' ) );						
			add_shortcode( 'course_enrollment_type', array( &$this, 'course_enrollment_type' ) );				
			add_shortcode( 'course_class_size', array( &$this, 'course_class_size' ) );		
			add_shortcode( 'course_cost', array( &$this, 'course_cost' ) );
			add_shortcode( 'course_language', array( &$this, 'course_language' ) );			
			add_shortcode( 'course_category', array( &$this, 'course_category' ) );
			add_shortcode( 'course_list_image', array( &$this, 'course_list_image' ) );						
			add_shortcode( 'course_featured_video', array( &$this, 'course_featured_video' ) );					
            //add_shortcode( 'unit_discussion', array( &$this, 'unit_discussion' ) );


            $GLOBALS['units_breadcrumbs'] = '';
        }
		
		/**
	     *
		 * COURSE DETAILS SHORTCODES
		 * =========================
		 *
		 */
		
		/**
		 * Creates a [course] shortcode.
		 *
		 * This is just a wrapper shortcode for several other shortcodes.
		 *
		 * @since 1.0.0
		 */
		function course( $atts ) {
			
            extract( shortcode_atts( array(
                'course_id'       => get_the_ID(),
				'show'            => 'summary',
				'date_format'     => get_option( 'date_format' ),
				'label_tag'       => 'strong',
				'label_delimeter' => ':',
				'show_title'      => 'no',
            ), $atts, 'course' ) );
			
			$course = new Course( $course_id );
			$encoded = object_encode( $course );

			$sections = explode( ',', $show );
			
			$content = '';
			
			foreach( $sections as $section )
			{
				// [course_title]
				if ( 'title' == trim( $section ) && 'yes' == $show_title ) {
					$content .= do_shortcode('[course_title title_tag="h3"]');
				}

				// [course_summary]
				if ( 'summary' == trim( $section ) ) {
					$content .= do_shortcode('[course_summary course="' . $encoded . '"]');
				}
				
				// [course_description]
				if ( 'description' == trim( $section ) ) {				
					$content .= do_shortcode('[course_description course="' . $encoded . '"]');					
				}

				// [course_start]
				if ( 'start' == trim( $section ) ) {				
					$content .= do_shortcode('[course_start course="' . $encoded . '" date_format="' . $date_format . '" label_tag="' . $label_tag . '" label_delimeter="' . $label_delimeter . '"]');								
				}

				// [course_end]
				if ( 'end' == trim( $section ) ) {				
					$content .= do_shortcode('[course_end course="' . $encoded . '" date_format="' . $date_format . '" label_tag="' . $label_tag . '" label_delimeter="' . $label_delimeter . '"]');								
				}

				// [course_dates]
				if ( 'dates' == trim( $section ) ) {			
					$content .= do_shortcode('[course_dates course="' . $encoded . '" date_format="' . $date_format . '" label_tag="' . $label_tag . '" label_delimeter="' . $label_delimeter . '"]');
				}
				
				// [course_enrollment_start]
				if ( 'enrollment_start' == trim( $section ) ) {				
					$content .= do_shortcode('[course_enrollment_start course="' . $encoded . '" date_format="' . $date_format . '" label_tag="' . $label_tag . '" label_delimeter="' . $label_delimeter . '"]');
				}
				
				// [course_enrollment_end]
				if ( 'enrollment_end' == trim( $section ) ) {				
					$content .= do_shortcode('[course_enrollment_end course="' . $encoded . '" date_format="' . $date_format . '" label_tag="' . $label_tag . '" label_delimeter="' . $label_delimeter . '"]');
				}
				
				// [course_enrollment_dates]				
				if ( 'enrollment_dates' == trim( $section ) ) {			
					$content .= do_shortcode('[course_enrollment_dates course="' . $encoded . '" date_format="' . $date_format . '" label_tag="' . $label_tag . '" label_delimeter="' . $label_delimeter . '"]');					
				}				
				
				// [course_summary]
				if ( 'class_size' == trim( $section ) ) {
					$content .= do_shortcode('[course_class_size course="' . $encoded . '"]');
				}
				
				// [course_cost]
				if ( 'cost' == trim( $section ) ) {
					$content .= do_shortcode('[course_cost course="' . $encoded . '"]');
				}

				// [course_language]
				if ( 'language' == trim( $section ) ) {
					$content .= do_shortcode('[course_language course="' . $encoded . '"]');
				}				

				// [course_category]
				if ( 'category' == trim( $section ) ) {
					$content .= do_shortcode('[course_category course="' . $encoded . '"]');
				}				
				
				// [course_enrollment_type]
				if ( 'enrollment_type' == trim( $section ) ) {
					$content .= do_shortcode('[course_enrollment_type course="' . $encoded . '"]');
				}								
				
				// [course_instructors]
				if ( 'instructors' == trim( $section ) ) {
					$content .= do_shortcode('[course_instructors course="' . $encoded . '"]');
				}												
				
				// [course_list_image]
				if ( 'image' == trim( $section ) ) {
					$content .= do_shortcode('[course_list_image course="' . $encoded . '"]');
				}												

				// [course_featured_video]
				if ( 'video' == trim( $section ) ) {
					$content .= do_shortcode('[course_featured_video course="' . $encoded . '"]');
				}												
				
			}
			
			// return print_r( $course );
			return $content;
		}
		
		/**
		 * Shows the course title.
		 *
		 * @since 1.0.0
		 */
		function course_title( $atts ) {
            extract( shortcode_atts( array(
                'course_id'       => get_the_ID(),
				'title_tag'       => 'h3',
            ), $atts, 'course_title' ) );

			$title = get_the_title( $course_id );
			
			ob_start();
			?>
				<<?php echo $title_tag; ?> class="course-title course-title-<?php echo $course_id; ?>">
				<?php echo $title; ?>
				</<?php echo $title_tag; ?>>
			<?php
			$content = ob_get_clean();

			// Return the html in the buffer.
			return $content;
		}
		
		/**
		 * Shows the course summary/excerpt.
		 *
		 * @since 1.0.0
		 */
		function course_summary( $atts ) {
            extract( shortcode_atts( array(
                'course_id'       => get_the_ID(),
				'course'          => '',
            ), $atts, 'course_summary' ) );

			$course = empty( $course ) ? new Course( $course_id ) : object_decode( $course, 'Course' );
			
			ob_start();
			?>
				<div class="course-summary course-summary-<?php echo $course_id; ?>">
				<?php echo $course->details->post_excerpt; ?>
				</div>
			<?php
			$content = ob_get_clean();

			// Return the html in the buffer.
			return $content;
		}

		/**
		 * Shows the course description.
		 *
		 * @since 1.0.0
		 */		
		function course_description( $atts ) {
            extract( shortcode_atts( array(
                'course_id'       => get_the_ID(),
				'course'          => false,
            ), $atts, 'course_description' ) );
	
			// Saves some overhead by not loading the post again if we don't need to.
			$course = empty( $course ) ? new Course( $course_id ) : object_decode( $course, 'Course' );

			ob_start();
			?>
				<div class="course-description course-description-<?php echo $course_id; ?>">
				<?php echo $course->details->post_content; ?>
				</div>
			<?php
			$content = ob_get_clean();					

			// Return the html in the buffer.
			return $content;
		}		

		/**
		 * Shows the course start date.
		 *
		 * @since 1.0.0
		 */
		function course_start( $atts ) {
            extract( shortcode_atts( array(
                'course_id'       => get_the_ID(),
				'course'          => false,
				'date_format'     => get_option( 'date_format' ),
				'label'           => __( 'Course Start Date', 'cp' ),
				'label_tag'       => 'strong',
				'label_delimeter' => ':',				
            ), $atts, 'course_start' ) );			
	
			// Saves some overhead by not loading the post again if we don't need to.
			$course = empty( $course ) ? new Course( $course_id ) : object_decode( $course, 'Course' );

			$start_date = get_post_meta( $course_id, 'course_start_date', true );
			ob_start();
			?>
				<div class="course-start-date course-start-date-<?php echo $course_id; ?>">
				<?php if ( ! empty ( $label ) ) :?>
					<<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>>
				<?php endif;?>
				<?php echo sp2nbsp( date( $date_format, strtotime( $start_date ) ) ); ?>
				</div>
			<?php
			$content = ob_get_clean();		
			// Return the html in the buffer.
			return $content;
		}				

		/**
		 * Shows the course end date.
		 *
		 * If the course has no end date, the no_date_text will be displayed instead of the date.
		 *
		 * @since 1.0.0
		 */
		function course_end( $atts ) {
            extract( shortcode_atts( array(
                'course_id'       => get_the_ID(),
				'course'          => false,
				'date_format'     => get_option( 'date_format' ),
				'label'           => __( 'Course End Date', 'cp' ),				
				'label_tag'       => 'strong',
				'label_delimeter' => ':',				
				'no_date_text'    => __( 'No End Date', 'cp' ),								
            ), $atts, 'course_end' ) );			
	
			// Saves some overhead by not loading the post again if we don't need to.
			$course = empty( $course ) ? new Course( $course_id ) : object_decode( $course, 'Course' );

			$end_date = get_post_meta( $course_id, 'course_end_date', true );
			$open_ended = 'off' == get_post_meta( $course_id, 'open_ended_course', true ) ? false : true;															
			ob_start();
			?>
				<div class="course-end-date course-end-date-<?php echo $course_id; ?>">
				<?php if ( ! empty ( $label ) ) :?>
					<<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>>
				<?php endif;?>
				<?php echo $open_ended ? $no_date_text : sp2nbsp( date( $date_format, strtotime( $end_date ) ) ); ?>
				</div>
			<?php
			$content = ob_get_clean();					
			// Return the html in the buffer.
			return $content;
		}				

		/**
		 * Shows the course start and end date.
		 *
		 * If the course has no end date, the no_date_text will be displayed instead of the date.		
		 *
		 * @since 1.0.0
		 */
		function course_dates( $atts ) {
            extract( shortcode_atts( array(
                'course_id'       => get_the_ID(),
				'course'          => false,
				'date_format'     => get_option( 'date_format' ),
				'label'           => __( 'Course Dates', 'cp' ),				
				'label_tag'       => 'strong',
				'label_delimeter' => ':',				
				'no_date_text'    => __( 'No End Date', 'cp' ),								
            ), $atts, 'course_dates' ) );			
	
			// Saves some overhead by not loading the post again if we don't need to.
			$course = empty( $course ) ? new Course( $course_id ) : object_decode( $course, 'Course' );

			$start_date = get_post_meta( $course_id, 'course_start_date', true );	
			$end_date = get_post_meta( $course_id, 'course_end_date', true );
			$open_ended = 'off' == get_post_meta( $course_id, 'open_ended_course', true ) ? false : true;																			
			$end_output = $open_ended ? $no_date_text : sp2nbsp( date( $date_format, strtotime( $end_date ) ) );
			ob_start();
			?>
				<div class="course-dates course-dates-<?php echo $course_id; ?>">
				<?php if ( ! empty ( $label ) ) :?>
					<<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>>
				<?php endif;?>
				<?php echo sp2nbsp( date( $date_format, strtotime( $start_date ) ) ) . ' - ' . $end_output; ?>
				</div>
			<?php
			$content = ob_get_clean();					
			// Return the html in the buffer.
			return $content;
		}				

		/**
		 * Shows the enrollment start date.
		 *
		 * If it is an open ended enrollment the no_date_text will be displayed.
		 *
		 * @since 1.0.0
		 */
		function course_enrollment_start( $atts ) {
            extract( shortcode_atts( array(
                'course_id'       => get_the_ID(),
				'course'          => false,
				'date_format'     => get_option( 'date_format' ),
				'label'           => __( 'Enrollment Start Date', 'cp' ),				
				'label_tag'       => 'strong',
				'label_delimeter' => ':',				
				'no_date_text'    => __( 'Enroll Anytime', 'cp' ),				
            ), $atts, 'course_enrollment_start' ) );			
	
			// Saves some overhead by not loading the post again if we don't need to.
			$course = empty( $course ) ? new Course( $course_id ) : object_decode( $course, 'Course' );

			$start_date = get_post_meta( $course_id, 'enrollment_start_date', true );
			$open_ended = 'off' == get_post_meta( $course_id, 'open_ended_enrollment', true ) ? false : true;					
			ob_start();
			?>
				<div class="enrollment-start-date enrollment-start-date-<?php echo $course_id; ?>">
				<?php if ( ! empty ( $label ) ) :?>
					<<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>>
				<?php endif;?>
				<?php echo $open_ended ? $no_date_text : sp2nbsp( date( $date_format, strtotime( $start_date ) ) ); ?>
				</div>
			<?php
			$content = ob_get_clean();					
			// Return the html in the buffer.
			return $content;
		}				
		
		/**
		 * Shows the enrollment end date.
		 *
		 * By default this will not show for open ended enrollments.
		 * Set show_all_dates="yes" to make it display.
		 * If it is an open ended enrollment the no_date_text will be displayed.		
		 *
		 * @since 1.0.0
		 */		
		function course_enrollment_end( $atts ) {
            extract( shortcode_atts( array(
                'course_id'       => get_the_ID(),
				'course'          => false,
				'date_format'     => get_option( 'date_format' ),
				'label'           => __( 'Enrollment End Date', 'cp' ),								
				'label_tag'       => 'strong',
				'label_delimeter' => ':',		
				'no_date_text'    => __( 'Enroll Anytime', 'cp' ),				
				'show_all_dates'  => 'no',		
            ), $atts, 'course_enrollment_end' ) );			
	
			// Saves some overhead by not loading the post again if we don't need to.
			$course = empty( $course ) ? new Course( $course_id ) : object_decode( $course, 'Course' );

			$end_date = get_post_meta( $course_id, 'enrollment_end_date', true );
			$open_ended = 'off' == get_post_meta( $course_id, 'open_ended_enrollment', true ) ? false : true;										
			ob_start();
			?>
				<div class="enrollment-end-date enrollment-end-date-<?php echo $course_id; ?>">
				<?php if ( ! empty ( $label ) ) :?>
					<<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>>
				<?php endif;?>
				<?php echo $open_ended ? $no_date_text : sp2nbsp( date( $date_format, strtotime( $end_date ) ) ); ?>				
				</div>
			<?php
			$content='';
			if ( ! $open_ended || 'yes' == $show_all_dates) {
				$content = ob_get_clean();					
			} else {
				ob_clean();
			}
			// Return the html in the buffer.
			return $content;
		}				
		
		/**
		 * Shows the enrollment start and end date.
		 *
		 * If it is an open ended enrollment the no_date_text will be displayed.
		 *
		 * @since 1.0.0
		 */		
		function course_enrollment_dates( $atts ) {
            extract( shortcode_atts( array(
                'course_id'       => get_the_ID(),
				'course'          => false,
				'date_format'     => get_option( 'date_format' ),
				'label'           => __( 'Enrollment Dates', 'cp' ),								
				'label_tag'       => 'strong',
				'label_delimeter' => ':',
				'no_date_text'    => __( 'Enroll Anytime', 'cp' ),
            ), $atts, 'course_enrollment_dates' ) );			
	
			// Saves some overhead by not loading the post again if we don't need to.
			$course = empty( $course ) ? new Course( $course_id ) : object_decode( $course, 'Course' );

			$start_date = get_post_meta( $course_id, 'enrollment_start_date', true );	
			$end_date = get_post_meta( $course_id, 'enrollment_end_date', true );
			$open_ended = 'off' == get_post_meta( $course_id, 'open_ended_enrollment', true ) ? false : true;										
			ob_start();
			?>
				<div class="enrollment-dates enrollment-dates-<?php echo $course_id; ?>">
				<?php if ( ! empty ( $label ) ) :?>
					<<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>>
				<?php endif;?>
				<?php echo $open_ended ? $no_date_text : sp2nbsp( date( $date_format, strtotime( $start_date ) ) ) . ' - ' . sp2nbsp( date( $date_format, strtotime( $end_date ) ) ); ?>
			</div>
			<?php
			$content = ob_get_clean();					
			// Return the html in the buffer.
			return $content;
		}				

		/**
		 * Shows the course class size.
		 *
		 * If there is no limit set on the course nothing will be displayed.
		 * You can make the no_limit_text display by setting show_no_limit="yes".
		 *
		 * By default it will show the remaining places,
		 * turn this off by setting show_remaining="no".
		 *
		 * @since 1.0.0
		 */
		function course_class_size( $atts ) {
            extract( shortcode_atts( array(
                'course_id'       => get_the_ID(),
				'course'          => false,
				'show_no_limit'   => 'no',				
				'show_remaining'  => 'yes',
				'label'           => __( 'Class Size', 'cp' ),
				'label_tag'       => 'strong',
				'label_delimeter' => ':',
				'no_limit_text'   => __( 'Unlimited', 'cp' ),
				'remaining_text'  => __( '(%d places left)', 'cp' ),
            ), $atts, 'course_class_size' ) );			
	
			// Saves some overhead by not loading the post again if we don't need to.
			$course = empty( $course ) ? new Course( $course_id ) : object_decode( $course, 'Course' );
			
			$content = '';
			
			$is_limited = get_post_meta( $course_id, 'limit_class_size', true ) == 'on' ? true : false;
			$class_size = (int) get_post_meta( $course_id, 'class_size', true );
			
			if( $is_limited ) {
				$content .= $class_size;
                
				if ( 'yes' == $show_remaining ) {
					$remaining = $class_size - $course->get_number_of_students();
					$content .= ' ' . sprintf( $remaining_text, $remaining );
				}
			} else {
				if ( 'yes' == $show_no_limit ) {
					$content .= $no_limit_text;
				}
			}

			if ( ! empty( $content ) ) {
				ob_start();
				?>
					<div class="course-class-size course-class-size-<?php echo $course_id; ?>">
					<?php if ( ! empty ( $label ) ) :?>
						<<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>>
					<?php endif;?>
					<?php echo $content; ?>
					</div>
				<?php
				$content = ob_get_clean();		
			}
			// Return the html in the buffer.
			return $content;
		}				

		/**
		 * Shows the course cost.
		 *
		 * @since 1.0.0
		 */
		function course_cost( $atts ) {
            global $coursepress;
			
            extract( shortcode_atts( array(
                'course_id'       => get_the_ID(),
				'course'          => false,
 				'label'           => __( 'Price', 'cp' ),
				'label_tag'       => 'strong',
				'label_delimeter' => ':',
				'no_cost_text'    => __( 'FREE', 'cp' ),				
            ), $atts, 'course_cost' ) );			
	
			// Saves some overhead by not loading the post again if we don't need to.
			$course = empty( $course ) ? new Course( $course_id ) : object_decode( $course, 'Course' );

			$is_paid = get_post_meta( $course_id, 'paid_course', true ) == 'on' ? true : false;

			$content = '';

			if ( $is_paid  && ($coursepress->is_marketpress_active() || $coursepress->is_marketpress_lite_active() || $coursepress->is_cp_marketpress_lite_active() ) ) {

				$mp_product = get_post_meta( $course_id, 'marketpress_product', true );

				$content .= do_shortcode( '[mp_product_price product_id="' . $mp_product . '" label=""]' );
				
			} else {
				$content .= $no_cost_text;
			}

			if ( ! empty( $content ) ) {
				ob_start();
				?>
					<div class="course-cost course-cost-<?php echo $course_id; ?>">
					<?php if ( ! empty ( $label ) ) :?>
						<<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>>
					<?php endif;?>
					<?php echo $content; ?>
					</div>
				<?php
				$content = ob_get_clean();		
			}
			// Return the html in the buffer.
			return $content;
		}				
		
		/**
		 * Shows the course language.
		 *
		 * @since 1.0.0
		 */
		function course_language( $atts ) {
            extract( shortcode_atts( array(
                'course_id'       => get_the_ID(),
				'course'          => false,
				'label'           => __( 'Course Language', 'cp' ),
				'label_tag'       => 'strong',
				'label_delimeter' => ':',				
            ), $atts, 'course_language' ) );			
	
			// Saves some overhead by not loading the post again if we don't need to.
			$course = empty( $course ) ? new Course( $course_id ) : object_decode( $course, 'Course' );

			$language = get_post_meta( $course_id, 'course_language', true );
			ob_start();
			?>
				<div class="course-language course-language-<?php echo $course_id; ?>">
				<?php if ( ! empty ( $label ) ) :?>
					<<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>>
				<?php endif;?>
				<?php echo $language; ?>
				</div>
			<?php
			$content = ob_get_clean();		
			// Return the html in the buffer.
			return $content;
		}						

		/**
		 * Shows the course category.
		 *
		 * @since 1.0.0
		 */
		function course_category( $atts ) {
            extract( shortcode_atts( array(
                'course_id'       => get_the_ID(),
				'course'          => false,
				'label'           => __( 'Course Category', 'cp' ),
				'label_tag'       => 'strong',
				'label_delimeter' => ':',	
				'no_category_test'=> __( 'None', 'cp' ),			
            ), $atts, 'course_category' ) );			
	
			// Saves some overhead by not loading the post again if we don't need to.
			$course = empty( $course ) ? new Course( $course_id ) : object_decode( $course, 'Course' );

			$content = '';
			
			$categories = Course::get_categories( $course_id );
			foreach( $categories as $key => $category ) {
				$content .= $category->name;
				$content .= count( $categories ) - 1 < $key ? ', ' : '';
			}
			// $category = get_category( $category );
			
			if ( ! $categories || 0 == count( $categories ) ) {
				$content .= $no_category_text;
			}
			
			ob_start();
			?>
				<div class="course-category course-category-<?php echo $course_id; ?>">
				<?php if ( ! empty ( $label ) ) :?>
					<<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>>
				<?php endif;?>
				<?php echo $content; ?>
				</div>
			<?php
			$content = ob_get_clean();		
			
			// Return the html in the buffer.
			return $content;
		}						

		/**
		 * Shows a friendly course enrollment type message.
		 *
		 * @since 1.0.0
		 */
		function course_enrollment_type( $atts ) {
            extract( shortcode_atts( array(
                'course_id'       => get_the_ID(),
				'course'          => false,
				'label'           => __( 'Who can Enroll?', 'cp' ),
				'label_tag'       => 'strong',
				'label_delimeter' => ':',		
				'manual_text'     => __( 'Students are added by instructors.', 'cp' ),
				'prerequisite_text' => __( 'Students need to complete "%s" first.', 'cp' ),		
				'passcode_text'   => __( 'A passcode is required to enroll.', 'cp' ),
				'anyone_text'     => __( 'Anyone', 'cp' ),
            ), $atts, 'course_enrollment_type' ) );			
	
			// Saves some overhead by not loading the post again if we don't need to.
			$course = empty( $course ) ? new Course( $course_id ) : object_decode( $course, 'Course' );

			$enrollment_type = get_post_meta( $course_id, 'enroll_type', true );
			
			$content = '';
			
			switch ( $enrollment_type ) {
				case 'anyone':
					$content = $anyone_text;
					break;	
				case 'passcode':
					$content = $passcode_text;
					break;
				case 'prerequisite':
					$prereq = get_post_meta( $course_id, 'prerequisite', true );
					$pretitle = '<a href="' . get_permalink( $prereq ) . '">' . get_the_title( $prereq ) . '</a>';
					$content = sprintf( $prerequisite_text, $pretitle );
					break;				
				case 'manually':	
					$content = $manual_text;
					break;				
			}
			
			ob_start();
			?>
				<div class="course-enrollment-type course-enrollment-type-<?php echo $course_id; ?>">
				<?php if ( ! empty ( $label ) ) :?>
					<<?php echo $label_tag; ?> class="label"><?php echo $label ?><?php echo $label_delimeter; ?></<?php echo $label_tag; ?>>
				<?php endif;?>
				<?php echo $content; ?>
				</div>
			<?php
			$content = ob_get_clean();		
			// Return the html in the buffer.
			return $content;
		}						

		/**
		 * Shows the course list image.
		 *
		 * @since 1.0.0
		 */
		function course_list_image( $atts ) {
            extract( shortcode_atts( array(
                'course_id'       => get_the_ID(),
				'course'          => false,
				'width'           => 'default',
				'height'          => 'default',
            ), $atts, 'course_list_image' ) );			
	
			// Saves some overhead by not loading the post again if we don't need to.
			$course = empty( $course ) ? new Course( $course_id ) : object_decode( $course, 'Course' );

			$image_src = get_post_meta( $course_id, 'featured_url', true );
			
			list( $img_w, $img_h ) = getimagesize( $image_src );
			
			// Note: by using both it usually reverts to the width
			$width = 'default' == $width ? $img_w : $width;
			$height = 'default' == $height ? $img_h : $height;			

			ob_start();
			?>
				<div class="course-list-image course-list-image-<?php echo $course_id; ?>">
				<img width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="<?php echo $image_src; ?>" alt="<?php echo $course->details->post_title; ?>" title="<?php echo $course->details->post_title; ?>" />
				</div>
			<?php
			$content = ob_get_clean();		
			// Return the html in the buffer.
			return $content;
		}
		
		/**
		 * Shows the course featured video.
		 *
		 * @since 1.0.0
		 */
		function course_featured_video( $atts ) {
            extract( shortcode_atts( array(
                'course_id'       => get_the_ID(),
				'course'          => false,
				'width'           => 'default',
				'height'          => 'default',
            ), $atts, 'course_featured_video' ) );			
	
			// Saves some overhead by not loading the post again if we don't need to.
			$course = empty( $course ) ? new Course( $course_id ) : object_decode( $course, 'Course' );

			$video_src = get_post_meta( $course_id, 'course_video_url', true );
			
            $video_extension = pathinfo( $video_src, PATHINFO_EXTENSION );

			$content = '';

            if ( !empty( $video_extension ) ) {//it's file, most likely on the server
                $attr = array(
                    'src' => $video_src,
                );
				
				if( 'default' != $width ) {
					$attr['width'] = $width;
				}
				
				if( 'default' != $height ) {
					$attr['height'] = $height;
				}

                $content .= wp_video_shortcode( $attr );
            } else {

                $embed_args = array(
                );
				
				if( 'default' != $width ) {
					$embed_args['width'] = $width;
				}
				
				if( 'default' != $height ) {
					$embed_args['height'] = $height;
				}

                $content .= wp_oembed_get( $video_src, $embed_args );
            }

			ob_start();
			?>
				<div class="course-featured-video course-featured-video-<?php echo $course_id; ?>">
				<?php echo $content; ?>
				</div>
			<?php
			$content = ob_get_clean();		
			// Return the html in the buffer.
			return $content;
		}
		
		
		/**
	     *
		 * INSTRUCTOR DETAILS SHORTCODES
		 * =========================
		 *
		 */
		
		/**
		 * Shows all the instructors of the given course.
		 *
		 * Four styles are supported:  
		 *
		 * * style="block" - List profile blocks including name, avatar, description (optional) and profile link. You can choose to make the entire block clickable ( link_all="yes" ) or only the profile link ( link_all="no", Default).
		 * * style="list"  - Lists instructor display names (separated by list_separator).  
		 * * style="link"  - Same as 'list', but returns hyperlinks to instructor profiles.  
		 * * style="count" - Outputs a simple integer value with the total of instructors for the course.  
		 *
		 * @since 1.0.0
		 */		
        function course_instructors( $atts ) {
            global $wp_query;
            global $instructor_profile_slug;

            extract( shortcode_atts( array(
                'course_id'       => get_the_ID(),
				'course'          => false,
                'count'           => false,  // deprecated
                'list'            => false,  // deprecated
                'link'            => false,   // deprecated
				'link_text'       => __( 'View Full Profile', 'cp' ),
				'show_summary'    => 'no',
				'summary_length'  => 50,
				'style'           => 'block',  //list, link, block, count
				'list_separator'  => ', ',
                'avatar_size'     => 80,
				'default_avatar'  => '',
				'link_all'        => 'no',
			), $atts, 'course_instructors' ) );

			// Support previous arguments
			$style = $count ? 'count' : $style;
			$style = $list ? 'list' : $style;
			$style = $link ? 'link' : $style;

			$course = empty( $course ) ? new Course( $course_id ) : object_decode( $course, 'Course' );
			
            $instructors = Course::get_course_instructors( $course_id );

            $content = '';
            $list = array();

			if ( 'count' != $style ) {
	            foreach ( $instructors as $instructor ) {
				
					$profile_href = trailingslashit( site_url() ) . trailingslashit( $instructor_profile_slug ) . trailingslashit( $instructor->user_login );
				
					switch ( $style ) {

						case 'block':
							ob_start();
							?>
							<div class="instructor-profile">
								<?php if ( 'yes' == $link_all ) { ?>
									<a href="<?php echo $profile_href ?>">
								<?php } ?>
								<div class="profile-name"><?php echo $instructor->display_name; ?></div>
								<div class="profile-avatar">
									<?php echo get_avatar( $instructor->ID, $avatar_size, $default_avatar, $instructor->display_name ); ?>
								</div>
								<div class="profile-description"><?php echo author_description_excerpt( $instructor->ID, $summary_length ); ?></div>
								<div class="profile-link">
									<?php if ( 'no' == $link_all ) { ?>
										<a href="<?php echo $profile_href ?>">
									<?php } ?>
									<?php echo $link_text; ?>
									<?php if ( 'no' == $link_all ) { ?>
										</a>
									<?php } ?>								
								</div>
								<?php if ( 'yes' == $link_all ) { ?>
									</a>
								<?php } ?>
							</div>	
							<?php
							$content .= ob_get_clean();				
					
						break;
					
						case 'link':
						case 'list':
		                	$list[] = ( 'link' == $style ? '<a href="' . $profile_href . '">' . $instructor->display_name . '</a>' : $instructor->display_name );
					
						break;					
					}
				}
			}

			switch ( $style ) {
				
				case 'block':
					$content = '' . $content . '';
				break;
				
				case 'list':
				case 'link':				
					$content = implode( $list_separator, $list );
				break;
				
				case 'count':
					$content = count( $instructors );
				break;								
				
			}

			return $content;
        }		
		
        function course_instructor_avatar( $atts ) {
            global $wp_query;

            extract( shortcode_atts( array( 'instructor_id' => 0, 'thumb_size' => 80, 'class' => 'small-circle-profile-image' ), $atts ) );

            $doc = new DOMDocument();
            $doc->loadHTML( get_avatar( $instructor_id, $thumb_size ) );
            $imageTags = $doc->getElementsByTagName( 'img' );

            $content = '';

            foreach ( $imageTags as $tag ) {
                $avatar_url = $tag->getAttribute( 'src' );
            }
            ?>
            <?php
            $content .= '<div class="instructor-avatar">';
            $content .= '<div class="' . $class . '" style="background: url( ' . $avatar_url . ' );"></div>';
            $content .= '</div>';

            return $content;
        }

        function instructor_profile_url( $atts ) {
            global $instructor_profile_slug;

            extract( shortcode_atts( array(
                'instructor_id' => 0 ), $atts ) );

            $instructor = get_userdata( $instructor_id );

            if ( $instructor_id ) {
                return trailingslashit( site_url() ) . trailingslashit( $instructor_profile_slug ) . trailingslashit( $instructor->user_login );
            }
        }		
		
		/**
	     *
		 * UNIT DETAILS SHORTCODES
		 * =========================
		 *
		 */		

        function course_unit_archive_submenu( $atts ) {
            global $coursepress;

            extract( shortcode_atts( array(
                'course_id' => ''
                            ), $atts ) );

            if ( $course_id == '' ) {
                $course_id = do_shortcode( '[get_parent_course_id]' );
            }

            if ( isset( $coursepress->units_archive_subpage ) ) {
                $subpage = $coursepress->units_archive_subpage;
            } else {
                $subpage = '';
            }
            ?>
            <div class="submenu-main-container">
                <ul id="submenu-main" class="submenu nav-submenu">
                    <li class="submenu-item submenu-units <?php echo( isset( $subpage ) && $subpage == 'units' ? 'submenu-active' : '' ); ?>"><a href="<?php echo get_permalink( $course_id ) . $coursepress->get_units_slug(); ?>/"><?php _e( 'Units', 'coursepress' ); ?></a></li>
                    <li class="submenu-item submenu-notifications <?php echo( isset( $subpage ) && $subpage == 'notifications' ? 'submenu-active' : '' ); ?>"><a href="<?php echo get_permalink( $course_id ) . $coursepress->get_notifications_slug(); ?>/"><?php _e( 'Notifications', 'coursepress' ); ?></a></li>
                    <?php
                    $course_obj = new Course( $course_id );
                    $course = $course_obj->get_course();
                    if ( $course->allow_course_discussion == 'on' ) {
                        ?>
                        <li class="submenu-item submenu-discussions <?php echo( isset( $subpage ) && $subpage == 'discussions' ? 'submenu-active' : '' ); ?>"><a href="<?php echo get_permalink( $course_id ) . $coursepress->get_discussion_slug(); ?>/"><?php _e( 'Discussions', 'coursepress' ); ?></a></li>
                        <?php
                    }
                    /* if ( $course->allow_course_grades_page == 'on' ) {
                      ?>
                      <li class="submenu-item submenu-grades <?php echo( isset( $subpage ) && $subpage == 'grades' ? 'submenu-active' : '' ); ?>"><a href="<?php echo get_permalink( $course_id ) . $coursepress->get_grades_slug(); ?>/"><?php _e( 'Grades', 'coursepress' ); ?></a></li>
                      <?php
                      } */
                    if ( $course->allow_workbook_page == 'on' ) {
                        ?>
                        <li class="submenu-item submenu-workbook <?php echo( isset( $subpage ) && $subpage == 'workbook' ? 'submenu-active' : '' ); ?>"><a href="<?php echo get_permalink( $course_id ) . $coursepress->get_workbook_slug(); ?>/"><?php _e( 'Workbook', 'coursepress' ); ?></a></li>
                    <?php } ?>
                    <li class="submenu-item submenu-info"><a href="<?php echo get_permalink( $course_id ); ?>"><?php _e( 'Course Details', 'coursepress' ); ?></a></li>
                </ul><!--submenu-main-->
            </div><!--submenu-main-container-->
            <?php
        }

        function courses_urls( $atts ) {
            global $enrollment_process_url, $signup_url;

            extract( shortcode_atts( array(
                'url' => ''
                            ), $atts ) );

            if ( $url == 'enrollment-process' ) {
                return $enrollment_process_url;
            }

            if ( $url == 'signup' ) {
                return $signup_url;
            }
        }

        function units_dropdown( $atts ) {
            extract( shortcode_atts( array( 'course_id' => ( isset( $wp_query->post->ID ) ? $wp_query->post->ID : 0 ), 'include_general' => false, 'general_title' => '' ), $atts ) );
            $course_obj = new Course( $course_id );
            $units = $course_obj->get_units();

            $dropdown = '<div class="units_dropdown_holder"><select name="units_dropdown" class="units_dropdown">';
            if ( $include_general ) {
                if ( $general_title == '' ) {
                    $general_title = __( '-- General --', 'cp' );
                }
                $dropdown .= '<option value="">' . $general_title . '</option>';
            }
            foreach ( $units as $unit ) {
                $dropdown .= '<option value="' . $unit->ID . '">' . $unit->post_title . '</option>';
            }
            $dropdown .= '</select></div>';

            return $dropdown;
        }

        function course_details( $atts ) {
            global $wp_query, $signup_url;

            $student = new Student( get_current_user_id() );

            extract( shortcode_atts( array(
                'course_id' => ( isset( $wp_query->post->ID ) ? $wp_query->post->ID : 0 ),
                'field' => 'course_start_date'
                            ), $atts ) );

            $course_obj = new Course( $course_id );
            
            if($course_obj->is_open_ended()){
                $open_ended = true;
            }else{
                $open_ended = false;
            }
            
            $course = $course_obj->get_course();

            if ( $field == 'action_links' ) {

                $withdraw_link_visible = false;

                if ( $student->user_enrolled_in_course( $course_id ) ) {
                    if ( ( ( strtotime( $course->course_start_date ) <= time() && strtotime( $course->course_end_date ) >= time() ) || ( strtotime( $course->course_end_date ) >= time() ) ) || $course->open_ended_course == 'on' ) {//course is currently active or is not yet active ( will be active in the future )
                        $withdraw_link_visible = true;
                    }
                }

                $course->action_links = '<div class="apply-links">';

                if ( $withdraw_link_visible === true ) {
                    $course->action_links .= '<a href="?withdraw=' . $course->ID . '" onClick="return withdraw();">' . __( 'Withdraw', 'cp' ) . '</a> | ';
                }
                $course->action_links .= '<a href="' . get_permalink( $course->ID ) . '">' . __( 'Course Details', 'cp' ) . '</a></div>';
            }

            if ( $field == 'class_size' ) {
                if ( $course->class_size == '0' || $course->class_size == '' ) {
                    $course->class_size = __( 'Infinite', 'cp' );
                } else {
                    $count_left = $course->class_size - $course_obj->get_number_of_students();
                    $course->class_size = $course->class_size . ' ' . sprintf( __( '( %d left )', 'cp' ), $count_left );
                }
            }

            $passcode_box_visible = false;

            if ( !isset( $course->enroll_type ) ) {
                $course->enroll_type = 'anyone';
            } else {
                if ( $course->enroll_type == 'passcode' ) {
                    $course->enroll_type = __( 'Anyone with a Passcode', 'cp' );
                    $passcode_box_visible = true;
                }

                if ( $course->enroll_type == 'prerequisite' ) {
                    $course->init_enroll_type = 'prerequisite';
                    $course->enroll_type = sprintf( __( 'Anyone who attanded to the %1s', 'cp' ), '<a href="' . get_permalink( $course->prerequisite ) . '">' . __( 'prerequisite course', 'cp' ) . '</a>' ); //__( 'Anyone who attended to the ', 'cp' );
                }
            }

            if ( $field == 'enroll_type' ) {

                if ( $course->enroll_type == 'anyone' ) {
                    $course->enroll_type = __( 'Anyone', 'cp' );
                }


                if ( $course->enroll_type == 'manually' ) {
                    $course->enroll_type = __( 'Public enrollments are disabled', 'cp' );
                }
            }

            if ( $field == 'course_start_date' or $field == 'course_end_date' or $field == 'enrollment_start_date' or $field == 'enrollment_end_date' ) {
                $date_format = get_option( 'date_format' );
                if ( $course->open_ended_course == 'on' ) {
                    $course->$field = __( 'Open-ended', 'cp' );
                } else {
                    if ( $course->$field == '' ) {
                        $course->$field = __( 'N/A', 'cp' );
                    } else {
                        $course->$field = sp2nbsp( date( $date_format, strtotime( $course->$field ) ) );
                    }
                }
            }

            if ( $field == 'price' ) {
                global $coursepress;
                if ( isset( $course->marketpress_product ) && $course->marketpress_product != '' && ($coursepress->is_marketpress_active() || $coursepress->is_marketpress_lite_active() || $coursepress->is_cp_marketpress_lite_active()) ) {
                    echo do_shortcode( '[mp_product_price product_id="' . $course->marketpress_product . '" label=""]' );
                } else {
                    $course->price = __( 'FREE', 'cp' );
                }
            }

            if ( $field == 'button' ) {

                $course->button = '<form name="enrollment-process" method="post" action="' . do_shortcode( "[courses_urls url='enrollment-process']" ) . '">';

                if ( is_user_logged_in() ) {

                    if ( !$student->user_enrolled_in_course( $course_id ) ) {
                        if ( !$course_obj->is_populated() ) {
                            if ( $course->enroll_type != 'manually' ) {
                                if ( strtotime( $course->course_end_date ) <= time() && $course->open_ended_course == 'off' ) {//Course is no longer active
                                    $course->button .= '<span class="apply-button-finished">' . __( 'Finished', 'cp' ) . '</span>';
                                } else {
                                    if ( ( $course->enrollment_start_date !== '' && $course->enrollment_end_date !== '' && strtotime( $course->enrollment_start_date ) <= time() && strtotime( $course->enrollment_end_date ) >= time() ) || $course->open_ended_course == 'on' ) {
                                        if ( ( $course->init_enroll_type == 'prerequisite' && $student->user_enrolled_in_course( $course->prerequisite ) ) || $course->init_enroll_type !== 'prerequisite' ) {
                                            $course->button .= '<input type="submit" class="apply-button" value="' . __( 'Enroll Now', 'cp' ) . '" />';
                                            $course->button .= '<div class="passcode-box">' . do_shortcode( '[course_details field="passcode_input"]' ) . '</div>';
                                        } else {
                                            $course->button .= '<span class="apply-button-finished">' . __( 'Prerequisite Required', 'cp' ) . '</span>';
                                        }
                                    } else {
                                        if ( strtotime( $course->enrollment_end_date ) <= time() ) {
                                            $course->button .= '<span class="apply-button-finished">' . __( 'Not available any more', 'cp' ) . '</span>';
                                        } else {
                                            $course->button .= '<span class="apply-button-finished">' . __( 'Not available yet', 'cp' ) . '</span>';
                                        }
                                    }
                                }
                            } else {
                                //don't show any button because public enrollments are disabled with manuall enroll type
                            }
                        } else {
                            $course->button .= '<span class="apply-button-finished">' . __( 'Populated', 'cp' ) . '</span>';
                        }
                    } else {
                        if ( ( $course->course_start_date !== '' && $course->course_end_date !== '' ) || $course->open_ended_course == 'on' ) {//Course is currently active
                            if ( ( strtotime( $course->course_start_date ) <= time() && strtotime( $course->course_end_date ) >= time() ) || $course->open_ended_course == 'on' ) {//Course is currently active
                                $course->button .= '<a href="' . get_permalink( $course->ID ) . 'units/" class="apply-button-enrolled">' . __( 'Go to Class', 'cp' ) . '</a>';
                                //$course->button .= '<input type="button" data-url="' . get_permalink( $course->ID ) . 'units/" class="apply-button-enrolled">' . __( 'Go to Class', 'cp' ) . '</a>';
                            } else {

                                if ( strtotime( $course->course_start_date ) >= time() ) {//Waiting for a course to start
                                    $course->button .= '<span class="apply-button-pending">' . __( 'You are enrolled', 'cp' ) . '</span>';
                                }
                                if ( strtotime( $course->course_end_date ) <= time() ) {//Course is no longer active
                                    $course->button .= '<span class="apply-button-finished">' . __( 'Finished', 'cp' ) . '</span>';
                                }
                            }
                        } else {//Course is inactive or pending
                            $course->button .= '<span class="apply-button-finished">' . __( 'Not available yet', 'cp' ) . '</span>';
                        }
                    }
                } else {

                    if ( $course->enroll_type != 'manually' ) {
                        if ( !$course_obj->is_populated() ) {
                            if ( ( strtotime( $course->course_end_date ) <= time() ) && $course->open_ended_course == 'off' ) {//Course is no longer active
                                $course->button .= '<span class="apply-button-finished">' . __( 'Finished', 'cp' ) . '</span>';
                            } else if ( ( $course->course_start_date == '' || $course->course_end_date == '' ) && $course->open_ended_course == 'off' ) {
                                $course->button .= '<span class="apply-button-finished">' . __( 'Not available yet', 'cp' ) . '</span>';
                            } else {


                                if ( ( strtotime( $course->enrollment_end_date ) <= time() ) && $course->open_ended_course == 'off' ) {
                                    $course->button .= '<span class="apply-button-finished">' . __( 'Not available any more', 'cp' ) . '</span>';
                                } else {
                                    $course->button .= '<a href="' . $signup_url . '?course_id=' . $course->ID . '" class="apply-button">' . __( 'Signup', 'cp' ) . '</a>';
                                }
                            }
                        } else {
                            $course->button .= '<span class="apply-button-finished">' . __( 'Populated', 'cp' ) . '</span>';
                        }
                    }
                }
                $course->button .= '<div class="clearfix"></div>';
                $course->button .= wp_nonce_field( 'enrollment_process' );
                $course->button .= '<input type="hidden" name="course_id" value="' . $course_id . '" />';
                $course->button .= '</form>';
            }

            if ( $field == 'passcode_input' ) {
                if ( $passcode_box_visible ) {
                    $course->passcode_input = '<label>' . __( "Passcode: ", "cp" ) . '<input type="password" name="passcode" /></label>';
                }
            }

            if ( !isset( $course->$field ) ) {
                $course->$field = '';
            }

            return $course->$field;
        }


        function get_parent_course_id( $atts ) {
            global $wp;

            if ( array_key_exists( 'coursename', $wp->query_vars ) ) {
                $course_id = Course::get_course_id_by_name( $wp->query_vars['coursename'] );
            } else {
                $course_id = 0;
            }
            return $course_id;
        }


        function courses_student_dashboard( $atts ) {
            global $plugin_dir;
            load_template( $plugin_dir . 'includes/templates/student-dashboard.php', false );
        }

        function courses_student_settings( $atts ) {
            global $plugin_dir;
            load_template( $plugin_dir . 'includes/templates/student-settings.php', false );
        }

        function course_unit_single( $atts ) {
            global $wp;

            extract( shortcode_atts( array( 'unit_id' => 0 ), $atts ) );

            if ( empty( $unit_id ) ) {
                if ( array_key_exists( 'unitname', $wp->query_vars ) ) {
                    $unit = new Unit();
                    $unit_id = $unit->get_unit_id_by_name( $wp->query_vars['unitname'] );
                } else {
                    $unit_id = 0;
                }
            }

            $args = array(
                'post_type' => 'unit',
                'p' => $unit_id
            );

            cp_suppress_errors();
            query_posts( $args );
            //cp_show_errors();
        }

        function course_units_loop( $atts ) {
            global $wp;

            extract( shortcode_atts( array( 'course_id' => 0 ), $atts ) );

            if ( empty( $course_id ) ) {
                if ( array_key_exists( 'coursename', $wp->query_vars ) ) {
                    $course_id = Course::get_course_id_by_name( $wp->query_vars['coursename'] );
                } else {
                    $course_id = 0;
                }
            }

            $current_date = date( 'Y-m-d', current_time( 'timestamp', 0 ) );

            $args = array(
                'category' => '',
                'order' => 'ASC',
                'post_type' => 'unit',
                'post_mime_type' => '',
                'post_parent' => '',
                'post_status' => 'publish',
                'meta_key' => 'unit_order',
                'orderby' => 'meta_value_num',
                'posts_per_page' => '-1',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'course_id',
                        'value' => $course_id
                    ),
                /* array(
                  'key' => 'unit_availability',
                  'value' => $current_date,
                  'compare' => '<='
                  ), */
                )
            );

            query_posts( $args );
        }

        function course_notifications_loop( $atts ) {
            global $wp;

            extract( shortcode_atts( array( 'course_id' => 0 ), $atts ) );

            if ( empty( $course_id ) ) {
                if ( array_key_exists( 'coursename', $wp->query_vars ) ) {
                    $course_id = Course::get_course_id_by_name( $wp->query_vars['coursename'] );
                } else {
                    $course_id = 0;
                }
            }

            $args = array(
                'category' => '',
                'order' => 'ASC',
                'post_type' => 'notifications',
                'post_mime_type' => '',
                'post_parent' => '',
                'post_status' => 'publish',
                'orderby' => 'meta_value_num',
                'posts_per_page' => '-1',
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key' => 'course_id',
                        'value' => $course_id
                    ),
                    array(
                        'key' => 'course_id',
                        'value' => ''
                    ),
                )
            );

            query_posts( $args );
        }

        function course_discussion_loop( $atts ) {
            global $wp;

            extract( shortcode_atts( array( 'course_id' => 0 ), $atts ) );

            if ( empty( $course_id ) ) {
                if ( array_key_exists( 'coursename', $wp->query_vars ) ) {
                    $course_id = Course::get_course_id_by_name( $wp->query_vars['coursename'] );
                } else {
                    $course_id = 0;
                }
            }

            $args = array(
                'category' => '',
                'order' => 'DESC',
                'post_type' => 'discussions',
                'post_mime_type' => '',
                'post_parent' => '',
                'post_status' => 'publish',
                'posts_per_page' => '-1',
                'meta_key' => 'course_id',
                'meta_value' => $course_id
            );

            query_posts( $args );
        }

        function course_units( $atts ) {
            global $wp;

            $content = '';

            extract( shortcode_atts( array( 'course_id' => $course_id ), $atts ) );

            if ( empty( $course_id ) ) {
                if ( array_key_exists( 'coursename', $wp->query_vars ) ) {
                    $course_id = Course::get_course_id_by_name( $wp->query_vars['coursename'] );
                } else {
                    $course_id = 0;
                }
            }

            $course = new Course( $course_id );
            $units = $course->get_units( $course_id, 'publish' );

            $student = new Student( get_current_user_id() );
            //redirect to the parent course page if not enrolled
            if ( !current_user_can( 'manage_options' ) ) {//If current user is not admin, check if he can access to the units
                if ( $course->details->post_author != get_current_user_id() ) {//check if user is an author of a course ( probably instructor )
                    if ( !current_user_can( 'coursepress_view_all_units_cap' ) ) {//check if the instructor, even if it's not the author of the course, maybe has a capability given by the admin
                        if ( !$student->has_access_to_course( $course_id ) ) {//if it's not an instructor who made the course, check if he is enrolled to course
                            //ob_start();
                            wp_redirect( get_permalink( $course_id ) ); //if not, redirect him to the course page so he may enroll it if the enrollment is available
                            exit;
                        }
                    }
                }
            }

            $content .= '<ol>';
            $last_unit_url = '';

            foreach ( $units as $unit ) {
                $unit_details = new Unit( $unit->ID );
                $content .= '<li><a href="' . $unit_details->get_permalink( $course_id ) . '">' . $unit->post_title . '</a></li>';
                $last_unit_url = $unit_details->get_permalink( $course_id );
            }

            $content .= '</ol>';

            if ( count( $units ) >= 1 ) {
                $content .= do_shortcode( '[course_discussion]' );
            }

            if ( count( $units ) == 0 ) {
                $content = __( '0 course units prepared yet. Please check back later.', 'cp' );
            }

            if ( count( $units ) == 1 ) {
                //ob_start();
                wp_redirect( $last_unit_url );
                exit;
            }
            return $content;
        }

        function course_unit_details( $atts ) {
            global $post_id;

            extract( shortcode_atts( array(
                'unit_id' => 0,
                'field' => 'post_title',
                'format' => false,
                'additional' => '2',
                'student_id' => get_current_user_ID(),
                            ), $atts ) );

            if ( $unit_id == 0 ) {
                $unit_id = get_the_ID();
            }

            $unit = new Unit( $unit_id );

            $student = new Student( get_current_user_id() );


            if ( $field == 'is_unit_available' ) {
                $unit->details->$field = $unit->is_unit_available();
            }

            /* ------------ */
            $unit_module = new Unit_Module();

            $front_save_count = 0;

            $modules = $unit_module->get_modules( $unit_id );
            $mandatory_answers = 0;
            $mandatory = 'no';

            foreach ( $modules as $mod ) {


                $mandatory = get_post_meta( $mod->ID, 'mandatory_answer', true );

                if ( $mandatory == 'yes' ) {
                    $mandatory_answers++;
                }

                $class_name = $mod->module_type;

                if ( class_exists( $class_name ) ) {
                    $module = new $class_name();
                    if ( $module->front_save ) {
                        $front_save_count++;
                    }
                }
            }

            $input_modules_count = $front_save_count;
            /* ------------ */
            //$input_modules_count = do_shortcode( '[course_unit_details field="input_modules_count" unit_id="' . $unit_id . '"]' );
            $unit_module = new Unit_Module();
            $responses_count = 0;

            $modules = $unit_module->get_modules( $unit_id );
            foreach ( $modules as $module ) {
                $unit_module = new Unit_Module();
                if ( $unit_module->did_student_responed( $module->ID, $student_id ) ) {
                    $responses_count++;
                }
            }
            $student_modules_responses_count = $responses_count;

            //$student_modules_responses_count = do_shortcode( '[course_unit_details field="student_module_responses" unit_id="' . $unit_id . '"]' );

            if ( $student_modules_responses_count > 0 ) {
                $percent_value = $mandatory_answers > 0 ? ( round( ( 100 / $mandatory_answers ) * $student_modules_responses_count, 0 ) ) : 0;
                $percent_value = ( $percent_value > 100 ? 100 : $percent_value ); //in case that student gave answers on all mandatory plus optional questions
            } else {
                $percent_value = 0;
            }

            if ( $input_modules_count == 0 ) {
                $unit_module = new Unit_Module();
                $grade = 0;
                $front_save_count = 0;
                $assessable_answers = 0;
                $responses = 0;
                $graded = 0;
                //$input_modules_count = do_shortcode( '[course_unit_details field="input_modules_count" unit_id="' . get_the_ID() . '"]' );
                $modules = $unit_module->get_modules( $unit_id );


                if ( $input_modules_count > 0 ) {
                    foreach ( $modules as $mod ) {

                        $class_name = $mod->module_type;
                        $assessable = get_post_meta( $mod->ID, 'gradable_answer', true );

                        if ( class_exists( $class_name ) ) {
                            $module = new $class_name();
                            if ( $module->front_save ) {

                                if ( $assessable == 'yes' ) {
                                    $assessable_answers++;
                                }

                                $front_save_count++;
                                $response = $module->get_response( $student_id, $mod->ID );

                                if ( isset( $response->ID ) ) {
                                    $grade_data = $unit_module->get_response_grade( $response->ID );
                                    $grade = $grade + $grade_data['grade'];

                                    if ( get_post_meta( $response->ID, 'response_grade' ) ) {
                                        $graded++;
                                    }

                                    $responses++;
                                }
                            } else {
                                //read only module
                            }
                        }
                    }
                    $percent_value = ( $format == true ? ( $responses == $graded && $responses == $front_save_count ? '<span class="grade-active">' : '<span class="grade-inactive">' ) . ( $grade > 0 ? round( ( $grade / $assessable_answers ), 0 ) : 0 ) . '%</span>' : ( $grade > 0 ? round( ( $grade / $assessable_answers ), 0 ) : 0 ) );
                } else {
                    $student = new Student( $student_id );
                    if ( $student->is_unit_visited( $unit_id, $student_id ) ) {
                        $grade = 100;
                        $percent_value = ( $format == true ? '<span class="grade-active">' . $grade . '%</span>' : $grade );
                    } else {
                        $grade = 0;
                        $percent_value = ( $format == true ? '<span class="grade-inactive">' . $grade . '%</span>' : $grade );
                    }
                }

                //$percent_value = do_shortcode( '[course_unit_details field="student_unit_grade" unit_id="' . get_the_ID() . '"]' );
            }

            //redirect to the parent course page if not enrolled
            if ( !current_user_can( 'manage_options' ) ) {
                if ( !$student->has_access_to_course( $unit->course_id ) ) {
                    //ob_start();
                    wp_redirect( get_permalink( $unit->course_id ) );
                    exit;
                }
            }

            if ( $field == 'percent' ) {
                $unit->details->$field = $percent_value;
            }

            if ( $field == 'permalink' ) {
                $unit->details->$field = $unit->get_permalink( $unit->course_id );
            }

            if ( $field == 'input_modules_count' ) {
                $unit_module = new Unit_Module();

                $front_save_count = 0;

                $modules = $unit_module->get_modules( $unit_id );

                foreach ( $modules as $mod ) {

                    $class_name = $mod->module_type;

                    if ( class_exists( $class_name ) ) {
                        $module = new $class_name();
                        if ( $module->front_save ) {
                            $front_save_count++;
                        }
                    }
                }

                $unit->details->$field = $front_save_count;
            }

            if ( $field == 'mandatory_input_modules_count' ) {
                $unit_module = new Unit_Module();

                $front_save_count = 0;
                $mandatory_answers = 0;

                $modules = $unit_module->get_modules( $unit_id );

                foreach ( $modules as $mod ) {
                    $mandatory_answer = get_post_meta( $mod->ID, 'mandatory_answer', true );

                    $class_name = $mod->module_type;

                    if ( class_exists( $class_name ) ) {
                        $module = new $class_name();
                        if ( $module->front_save ) {
                            if ( $mandatory_answer == 'yes' ) {
                                $mandatory_answers++;
                            }
                            //$front_save_count++;
                        }
                    }
                }

                $unit->details->$field = $mandatory_answers;
            }
            
            if ( $field == 'assessable_input_modules_count' ) {
                $unit_module = new Unit_Module();

                $front_save_count = 0;
                $assessable_answers = 0;

                $modules = $unit_module->get_modules( $unit_id );

                foreach ( $modules as $mod ) {
                    $assessable = get_post_meta( $mod->ID, 'gradable_answer', true );

                    $class_name = $mod->module_type;

                    if ( class_exists( $class_name ) ) {
                        $module = new $class_name();
                        if ( $module->front_save ) {
                            if ( $assessable == 'yes' ) {
                                $assessable_answers++;
                            }
                            //$front_save_count++;
                        }
                    }
                }

                $unit->details->$field = $assessable_answers;
            }

            if ( $field == 'student_module_responses' ) {
                $unit_module = new Unit_Module();
                $responses_count = 0;
                $mandatory_answers = 0;
                $modules = $unit_module->get_modules( $unit_id );
                foreach ( $modules as $module ) {

                    $mandatory = get_post_meta( $module->ID, 'mandatory_answer', true );

                    if ( $mandatory == 'yes' ) {
                        $mandatory_answers++;
                    }

                    $unit_module = new Unit_Module();
                    if ( $unit_module->did_student_responed( $module->ID, $student_id ) ) {
                        $responses_count++;
                    }
                }

                if ( $additional == 'mandatory' ) {
                    if ( $responses_count > $mandatory_answers ) {
                        $unit->details->$field = $mandatory_answers;
                    } else {
                        $unit->details->$field = $responses_count;
                    }
                    //so we won't have 7 of 6 mandatory answered but mandatory number as a max number
                } else {
                    $unit->details->$field = $responses_count;
                }
            }

            if ( $field == 'student_unit_grade' ) {
                $unit_module = new Unit_Module();
                $grade = 0;
                $front_save_count = 0;
                $responses = 0;
                $graded = 0;
                $input_modules_count = do_shortcode( '[course_unit_details field="input_modules_count" unit_id="' . get_the_ID() . '"]' );
                $modules = $unit_module->get_modules( $unit_id );
                $mandatory_answers = 0;
                $assessable_answers = 0;

                if ( $input_modules_count > 0 ) {
                    foreach ( $modules as $mod ) {

                        $class_name = $mod->module_type;

                        if ( class_exists( $class_name ) ) {
                            $module = new $class_name();
                            if ( $module->front_save ) {
                                $front_save_count++;
                                $response = $module->get_response( $student_id, $mod->ID );
                                $assessable = get_post_meta( $mod->ID, 'gradable_answer', true );
                                $mandatory = get_post_meta( $mod->ID, 'mandatory_answer', true );


                                if ( $assessable == 'yes' ) {
                                    $assessable_answers++;
                                }

                                if ( isset( $response->ID ) ) {

                                    if ( $assessable == 'yes' ) {

                                        $grade_data = $unit_module->get_response_grade( $response->ID );
                                        $grade = $grade + $grade_data['grade'];

                                        if ( get_post_meta( $response->ID, 'response_grade' ) ) {
                                            $graded++;
                                        }

                                        $responses++;
                                    }
                                }
                            } else {
                                //read only module
                            }
                        }
                    }

                    $unit->details->$field = ( $format == true ? ( $responses == $graded && $responses == $front_save_count ? '<span class="grade-active">' : '<span class="grade-inactive">' ) . ( $grade > 0 ? round( ( $grade / $assessable_answers ), 0 ) : 0 ) . '%</span>' : ( $grade > 0 ? round( ( $grade / $assessable_answers ), 0 ) : 0 ) );
                } else {
                    $student = new Student( $student_id );
                    if ( $student->is_unit_visited( $unit_id, $student_id ) ) {
                        $grade = 100;
                        $unit->details->$field = ( $format == true ? '<span class="grade-active">' . $grade . '%</span>' : $grade );
                    } else {
                        $grade = 0;
                        $unit->details->$field = ( $format == true ? '<span class="grade-inactive">' . $grade . '%</span>' : $grade );
                    }
                }
            }

            if ( $field == 'student_unit_modules_graded' ) {
                $unit_module = new Unit_Module();
                $grade = 0;
                $front_save_count = 0;
                $responses = 0;
                $graded = 0;

                $modules = $unit_module->get_modules( $unit_id );

                foreach ( $modules as $mod ) {

                    $class_name = $mod->module_type;

                    if ( class_exists( $class_name ) ) {
                        $module = new $class_name();
                        if ( $module->front_save ) {
                            $front_save_count++;
                            $response = $module->get_response( $student_id, $mod->ID );

                            if ( isset( $response->ID ) ) {
                                $grade_data = $unit_module->get_response_grade( $response->ID );
                                $grade = $grade + $grade_data['grade'];

                                if ( get_post_meta( $response->ID, 'response_grade' ) ) {
                                    $graded++;
                                }

                                $responses++;
                            }
                        } else {
                            //read only module
                        }
                    }
                }

                $unit->details->$field = $graded;
            }

            return $unit->details->$field;
        }

        function course_breadcrumbs( $atts ) {
            global $course_slug, $units_slug, $units_breadcrumbs, $wp;

            extract( shortcode_atts( array(
                'type' => 'unit_archive',
                'course_id' => 0,
                'position' => 'shortcode'
                            ), $atts ) );

            if ( empty( $course_id ) ) {
                if ( array_key_exists( 'coursename', $wp->query_vars ) ) {
                    $course_id = Course::get_course_id_by_name( $wp->query_vars['coursename'] );
                } else {
                    $course_id = 0;
                }
            }

            $course = new Course( $course_id );

            if ( $type == 'unit_archive' ) {
                $units_breadcrumbs = '<div class="units-breadcrumbs"><a href="' . trailingslashit( get_option( 'home' ) ) . $course_slug . '/">' . __( 'Courses', 'cp' ) . '</a> » <a href="' . $course->get_permalink() . '">' . $course->details->post_title . '</a></div>';
            }

            if ( $type == 'unit_single' ) {
                $units_breadcrumbs = '<div class="units-breadcrumbs"><a href="' . trailingslashit( get_option( 'home' ) ) . $course_slug . '/">' . __( 'Courses', 'cp' ) . '</a> » <a href="' . $course->get_permalink() . '">' . $course->details->post_title . '</a> » <a href="' . $course->get_permalink() . $units_slug . '/">' . __( 'Units', 'cp' ) . '</a></div>';
            }

            if ( $position == 'shortcode' ) {
                return $units_breadcrumbs;
            }
        }

        function course_discussion( $atts ) {
            global $wp;

            if ( array_key_exists( 'coursename', $wp->query_vars ) ) {
                $course_id = Course::get_course_id_by_name( $wp->query_vars['coursename'] );
            } else {
                $course_id = 0;
            }

            $course = new Course( $course_id );

            if ( $course->details->allow_course_discussion == 'on' ) {

                $comments_args = array(
                    // change the title of send button 
                    'label_submit' => __( 'Send', 'cp' ),
                    // change the title of the reply section
                    'title_reply' => __( 'Write a Reply or Comment', 'cp' ),
                    // remove "Text or HTML to be displayed after the set of comment fields"
                    'comment_notes_after' => '',
                    // redefine your own textarea ( the comment body )
                    'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><br /><textarea id="comment" name="comment" aria-required="true"></textarea></p>',
                );

                $defaults = array(
                    'author_email' => '',
                    'ID' => '',
                    'karma' => '',
                    'number' => '',
                    'offset' => '',
                    'orderby' => '',
                    'order' => 'DESC',
                    'parent' => '',
                    'post_id' => $course_id,
                    'post_author' => '',
                    'post_name' => '',
                    'post_parent' => '',
                    'post_status' => '',
                    'post_type' => '',
                    'status' => '',
                    'type' => '',
                    'user_id' => '',
                    'search' => '',
                    'count' => false,
                    'meta_key' => '',
                    'meta_value' => '',
                    'meta_query' => '',
                );

                $wp_list_comments_args = array(
                    'walker' => null,
                    'max_depth' => '',
                    'style' => 'ul',
                    'callback' => null,
                    'end-callback' => null,
                    'type' => 'all',
                    'reply_text' => __( 'Reply', 'cp' ),
                    'page' => '',
                    'per_page' => '',
                    'avatar_size' => 32,
                    'reverse_top_level' => null,
                    'reverse_children' => '',
                    'format' => 'xhtml', //or html5 @since 3.6
                    'short_ping' => false // @since 3.6
                );

                comment_form( $comments_args = array(), $course_id );
                wp_list_comments( $wp_list_comments_args, get_comments( $defaults ) );
                //comments_template()
            }
        }

        function unit_discussion( $atts ) {
            global $wp;
            if ( array_key_exists( 'unitname', $wp->query_vars ) ) {
                $unit = new Unit();
                $unit_id = $unit->get_unit_id_by_name( $wp->query_vars['unitname'] );
            } else {
                $unit_id = 0;
            }

            $comments_args = array(
                // change the title of send button 
                'label_submit' => 'Send',
                // change the title of the reply secpertion
                'title_reply' => 'Write a Reply or Comment',
                // remove "Text or HTML to be displayed after the set of comment fields"
                'comment_notes_after' => '',
                // redefine your own textarea ( the comment body )
                'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><br /><textarea id="comment" name="comment" aria-required="true"></textarea></p>',
            );

            comment_form( $comments_args, $unit_id );
        }

        function student_registration_form() {
            global $plugin_dir;
            load_template( $plugin_dir . 'includes/templates/student-signup.php', true );
        }

    }

}

$coursepress_shortcodes = new CoursePress_Shortcodes();
?>
