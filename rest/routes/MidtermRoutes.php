<?php
require_once __DIR__ . '/../services/MidtermService.php';
require_once __DIR__ . '/../../vendor/autoload.php';
Flight::route('GET /connection-check', function(){
    /** TODO
    * This endpoint prints the message from constructor within MidtermDao class
    * Goal is to check whether connection is successfully established or not
    * This endpoint does not have to return output in JSON format
    */
    $dao = new MidtermDao();
});

Flight::route('GET /cap-table', function(){
    /** TODO
    * This endpoint returns list of all share classes within table named cap_table
    * Each class contains description field named 'class' and array of all categories within given class
    * Each category contains description field named 'category' and array of all investors that have shares within given category
    * Each investor has fields: 'diluted_shares' and 'investor' which is obtained by concatanation of first and last name of the investor
    * Outpus is given in figure 2
    * This endpoint should return output in JSON format
    */
    Flight::set('midterm_service', new MidtermService());
    $items = Flight::get('midterm_service')->cap_table();

    header('Content-Type: application/json');
    Flight::json($items, 200);
});

Flight::route('POST /cap-table-record', function(){
    /** TODO
    * This endpoint is used to add new record to cap-table database table. If added successfully output should be the added array with the id of the new record
    * Example output is given in figure 3
    * This endpoint should return output in JSON format
    */
    $payload = Flight::request()->data ->getData();
    Flight::set('midterm_service', new MidtermService());
    $cap = Flight::get('midterm_service')->add_cap_table_record($payload['diluted_shares']);

    Flight::json(['message' => "You have successfully added the cap", 'data' => $cap]);
});


Flight::route('GET /categories', function(){
    /** TODO
    * This endpoint returns list of all categories with the total amount of diluted_shares for each category
    * Output example is given in figure 4
    * This endpoint should return output in JSON format
    */
    Flight::set('midterm_service', new MidtermService());
    $items = Flight::get('midterm_service')->categories();

    header('Content-Type: application/json');
    Flight::json($items, 200);
});

Flight::route("DELETE /investor/@id", function($id){
    /** TODO
    * This endpoint is used to delete investor
    * Endpoint should return the message whether investor has been deleted
    * This endpoint should return output in JSON format
    */
    if($id == NULL || $id == '') {
        Flight::halt(500, "Required parameters are missing!");
    }

    $midterm_service = new MidtermService();
    $midterm_service->delete_investor($id);
    
    Flight::json(['data' => NULL, 'message' => "You have successfully deleted the patient"]);
});


?>
