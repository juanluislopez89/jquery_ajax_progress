<?php
function repetitive_server_function() {
    /***********************************************************
    * 
    *                   STATUS DETECTION
    * 
    ***********************************************************/
    // If request does not contain the parameter 'total_items', it means that the request is the first one, 
    // so we need to call the function get_total() to get the total number of items to process. 
    // If the request contains the parameter 'total_items', it means that the request is not the first one, so we dont need 
    // to call the function get_total()
    $total_items = (isset($_POST['total_items']) && $_POST['total_items'] > 0) ? intval($_POST['total_items']) : get_total();
    
    // If request does not contain the parameter 'current_item', it means that the request is the first one, so we need to
    // initialize the variable $current_item to 0. If the request contains the parameter 'current_item', it means that the
    // request is not the first one, so we dont need to initialize the variable $current_item
    $current_item = (isset($_POST['current_item']) && $_POST['current_item'] > 0) ? intval($_POST['current_item']) : 0;

    /***********************************************************
    * 
    *                  TASK EXECUTION
    * 
    ***********************************************************/
    // Do something here
        sleep(1); //Emulates a task that takes 1 second
    // End of your task
    $current_item++;

    /***********************************************************
    * 
    *                 PROGRESS REPORTING
    * 
    ***********************************************************/
    // Progress calculation
    $progress = $current_item * 100 / $total_items;
    // If the current item is the last one, the process is finished, so we set the variable $continue to false.
    $continue = $current_item == $total_items ? false : true;
    // Response
    $response = array(
        'error' => false,
        'total_items' => $total_items,
        'current_item' => $current_item,
        'progress' => round($progress, 2),
        'continue' => $continue
    );
    // Send the response to the client
    header('Content-Type: application/json');
    echo json_encode($response);
}

// This function retireves the total number of items to process, this is called only once at the begining of the process.if
// the request does not contain the parameter 'total_items'. 
// Its like the plugin asking to server how many items it needs to process?. 
// After that the plugin will send a all the requests with the parameter 'total_items'

function get_total() {
    //Count a number of files to process in a directory (at the begining of the process)
    //Count the database records to process (at the begining of the process)
    //Count the number emails to send (at the begining of the process)
    return 5;
}
?>