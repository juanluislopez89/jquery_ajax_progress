<?php
function my_callback() {
    /***********************************************************
    * 
    *                   DETECCION DE ESTADO
    * 
    ***********************************************************/
    // Lo primero de todo es saber si la llamada ajax trae un parametro llamado total, si no lo trae es que es la primera llamada.
    $total_items = (isset($_POST['total_items']) && $_POST['total_items'] > 0) ? intval($_POST['total_items']) : get_total();
    // Si no trae el parametro total, es que es la primera llamada, por lo que establecemos el progreso a 0
    $current_item = (isset($_POST['current_item']) && $_POST['current_item'] > 0) ? intval($_POST['current_item']) : 0;

    /***********************************************************
    * 
    *                  EJECUCION DE LA TAREA
    * 
    ***********************************************************/
    sleep(1); //Emulates a task that takes 1 second
    $current_item++;

    /***********************************************************
    * 
    *                 ACTUALIZACION DE PROGRESO
    * 
    ***********************************************************/
    // Porcentaje de progreso
    $progress = $current_item * 100 / $total_items;
    // Determinamos si hay que continuar o si ya hemos terminado
    $continue = $current_item == $total_items ? false : true;
    // Array de respuesta
    $response = array(
        'error' => false,
        'total_items' => $total_items,
        'current_item' => $current_item,
        'progress' => round($progress, 2),
        'continue' => $continue
    );
    // Salida JSON de la respuesta
    header('Content-Type: application/json');
    echo json_encode($response);
}

function get_total() {
    return 5;
}
?>