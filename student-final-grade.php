<?php
/**
 * Shortcode handlers
 *
 * @package CoursePress
 * Description: Adds Average Grade which can be used as a shortcode in Basic Certificate of CoursePress Pro Version 2.2.2. 
 */

/**
 * Templating shortcodes.
 *
 */

add_filter( 'coursepress_basic_certificate_vars', function ( $vars ){



if ( ! isset( $_REQUEST['c'] ) || ! isset( $_REQUEST['u'] ) ) {

    return $vars;

}


$replacement 	= '';

$course_id 		= intval( $_REQUEST['c'] );

$student_id 	= intval( $_REQUEST['u'] );



$student_progress = CoursePress_Data_Student::get_completion_data( $student_id, $course_id );

$final_grade = (int) CoursePress_Helper_Utility::get_array_val(

$student_progress, 'completion/average'

);


$vars['STUDENT_FINAL_GRADE'] = $final_grade . '%';


return $vars;


}, 10 );
