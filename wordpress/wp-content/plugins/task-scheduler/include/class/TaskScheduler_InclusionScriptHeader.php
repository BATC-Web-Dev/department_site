<?php
/**
 *    Provides a dockblock for the inclusion script.
 *    
 * @package     Task Scheduler
 * @copyright   Copyright (c) 2014, <Michael Uno>
 * @author        Michael Uno
 * @authorurl    http://michaeluno.jp
 * @since        1.0.0
 * 
 */

// The inclusion script includes this method to use the reflection class.
if ( ! class_exists( 'TaskScheduler_Registry_Base' ) ) {
    include_once( dirname( dirname( dirname( __FILE__ ) ) ) . '/task-scheduler.php' );
}

/**
 * Allows the inclusion script to access plugin registries.
 */
class TaskScheduler_InclusionScriptHeader extends TaskScheduler_Registry_Base {
    
    const Name            = 'Task Scheduler - PHP Class Inclusion Script';
    const Description    = 'Generated by the PHP Class Inclusion Script Creator';
    
}