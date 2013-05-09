<?php

/**
 * Debug library
 *
 * Various functions for use in debugging
 */

/**
 * A wrap around print_r that keeps track of the file/line this function
 * called from.
 */
function debug($var) {
    $dir = __DIR__;
    $backtrace = current(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1));

    echo "<pre><strong>"
    . str_replace($dir, "APP", $backtrace['file']) . " @ Line {$backtrace['line']}:"
    . "</strong><br />" . htmlentities(print_r($var, true)) . "</pre>";
}


function debug_panel() {

    $memory = number_format(memory_get_peak_usage() / 1024 / 1024, 2);
    $time = $_SERVER['REQUEST_TIME_FLOAT'];
    $time = number_format((microtime(true) - $time) * 1000, 2);

    echo "

    <style type='text/css'>
        #debug-panel {
            position:fixed;
            right:0;
            bottom:0;
            font-size:12px;
            line-height:12px;
        }
    </style>

    <div id='debug-panel'>
        {$memory} mb /
        {$time} ms
    </div>

    ";
}
