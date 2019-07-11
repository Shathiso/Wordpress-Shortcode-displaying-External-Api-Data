<?php
/**
 * @Zip Code Location Retriever
 * @version 1.
 */
/*
Plugin Name: ZipCode Location Retriever
Plugin URI: 
Description: This plugin Retrieves the City and State for a location through the given ZipCode
Author: Shathiso Ntibi
Version: 1.0
Author URI: 
*/


function sn_zipcode_locator_shortcode( $atts, $content = null  ) {

   //Array of attributes fillable by users inserting the shortcode
    $atts = shortcode_atts( array(
      'zip' => 'zipcode',
    ), $atts, 'sn_zipcode_locator' );

   // Extracting the json data from the ziptastic website with the zipcode variable
   $url = 'http://www.ziptasticapi.com/' . $atts['zip'];
   $response = wp_remote_get($url);
   $dataTable = wp_remote_retrieve_body($response);
   $data = json_decode($dataTable); 


   ob_start(); 

   //Check if data is empty or has an error
   if( is_wp_error( $data) || $data == " "){
       $error = $response->get_error_message();
       echo "something went wrong:" . $error; 
   }
   else{ ?>
  
     <div class="sn_zipcode_locator"> 
        <?php echo '<b>Country</b>: ' . " " . $data->country . '<br/>' . '<b>State:</b>' . " " . $data->state . '<br/>' . '<b>City:</b>' . " " . $data->city ?>  
    </div> 

   <?php return ob_get_clean(); }
}
add_shortcode( 'sn_zipcode_locator', 'sn_zipcode_locator_shortcode' );

