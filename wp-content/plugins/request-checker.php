<?php
/*
Plugin Name: Request Checker for ADG
Description: Plugin validating ADG requests against licenses.
Author: Aaron Itzkovitz
Version: 1.0.0
Author URI: http://aaronitzkovitz.com/
*/

// This should be called in wordpress.
if ( ! defined( 'ABSPATH' ) ) { exit; }

// TBI: add portal to update version
add_action( 'admin_menu', 'add_version_portal' );
function add_version_portal(){

	add_menu_page( 'Version Portal', 'Version Portal', 'manage_options', 'version_portal', 'v_portal_markup' );

}

// markup for version portal
function v_portal_markup(){

	?>

	<div class="wrap">
		<h2>Version Portal</h2>
			<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">
	    	<table class="form-table">
				<tbody>	
					<tr>
						<th scope="row" valign="top">Plugin Version</th>
						<td>
							<label>
								<input type="text" name="adg_version" value="<?php echo get_option( 'current_adg_version', 'N/A' ); ?>" />
							</label>
						</td>
					</tr>	
				</tbody>
	    	</table>
	    	<input type="hidden" name="action" value="submit_version" />
	    	<input type="hidden" name="submit_nonce" value="<?php echo wp_create_nonce( 'adg_submit_version_nonce' ); ?>" />
	    	<input class="button-primary" type="submit" value="Save Version" />
	    </form>
	</div>
	<?php
}

add_action( 'admin_post_submit_version', 'update_version' );
function update_version(){
	//die(var_dump($_POST));

	if( isset( $_POST[ 'submit_nonce' ] ) && wp_verify_nonce( $_POST[ 'submit_nonce' ], 'adg_submit_version_nonce' ) ) {
		$new_version = sanitize_text_field( $_POST[ 'adg_version' ] );
		if ( $new_version ){

			update_option( 'current_adg_version', $new_version, TRUE );
			wp_redirect( admin_url(), FALSE );

		} else {

			wp_redirect( admin_url(), FALSE );

		}

	} else {

		wp_redirect( admin_url(), FALSE );

	}

}

// handler to check version
add_action( 'admin_post_nopriv_check_version', 'check_version' );
function check_version(){

	if ( $curr_version = get_option( 'current_adg_version' ) ){
		header( 'HTTP/1.0 200 OK' );
		exit( json_encode( [ 'current_version' => $curr_version ] ) );
	} else {
		header( 'HTTP/1.0 404 Not Found' );
		exit( json_encode([ 'error' => 'Could not get version.' ] ) );
	}

}

// handler for plugin requests
add_action( 'admin_post_nopriv_adg_request', 'check_request' );
function check_request(){

	$rest_json = file_get_contents( 'php://input' );
	$_POST = json_decode( $rest_json, true );

	if ( !isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] != 'adg_request' ){ return; }
	
	function validate( $l_id, $domain, $ref ){

		global $wpdb;
		$SLM_TBL_LICENSE_KEYS = $wpdb->prefix . 'lic_key_tbl';
		$SLM_TBL_LIC_DOMAIN = $wpdb->prefix . 'lic_reg_domain_tbl';

		$q = $wpdb->get_results( "
			SELECT * FROM $SLM_TBL_LICENSE_KEYS
	        WHERE license_key = '$l_id'
	        AND lic_status = 'active'", ARRAY_A
		);

		/*
		// For debugging
		$test_q = $wpdb->get_results( "
			SELECT * FROM $SLM_TBL_LICENSE_KEYS
	        WHERE license_key = '5ac188862ea55'
	        AND lic_status = 'active'", ARRAY_A
		);
		*/

		// if we can't find that license, return 404
		if ( !$q ){
			return false;
		} else {
			
			// Grab all records that match this domain and the correct lic key id
			$lic_id = $q[0]['id'];
			$reg_dom = $wpdb->get_results( "
				SELECT * FROM $SLM_TBL_LIC_DOMAIN
		        WHERE lic_key_id = '$lic_id'
		        AND registered_domain = '$domain'", ARRAY_A
			);

			// For debugging
			/*
			$test_lic_id = $test_q[0]['id'];
			$test_reg_dom = $wpdb->get_results( "
				SELECT * FROM $SLM_TBL_LIC_DOMAIN
		        WHERE lic_key_id = '$lic_id'", ARRAY_A
			);

			ob_start();
			var_dump( $test_reg_dom );
			$contents = ob_get_contents();
			error_log( $contents );
			ob_end_clean();
			*/

			// If we didn't find a domain return false
			if ( !$reg_dom ){ return false; }
			
		}
		return true;

	}

	if( isset( $_POST[ 'asin' ] ) 
		&& isset( $_POST[ 'licenseId' ] )
		&& isset( $_POST[ 'associateTag' ] )
		&& isset( $_POST[ 'keyId' ] )
		&& isset( $_POST[ 'accessKey' ] )
		&& isset( $_POST[ 'domain' ] )
		&& isset( $_POST[ 'prod_ref' ] ) ){

		// Log the request
		try {

			$file = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'request.log';
			$log_str = implode( ' : ', $_POST ) . PHP_EOL;
			file_put_contents( $file, $log_str, FILE_APPEND );

		} catch ( Exception $e ){
			error_log( "Couldn't log request." );
		}

		// $passed = validate( $_POST[ 'licenseId' ], $_POST[ 'domain' ], $_POST[ 'prod_ref' ] );
		if ( true ){
			$secret_key = $_POST[ 'accessKey' ];

			// The region you are interested in
			$endpoint = "webservices.amazon.com";

			$uri = "/onca/xml";

			$params = array(
			    "Service" => "AWSECommerceService",
			    "Operation" => "ItemLookup",
			    "AWSAccessKeyId" => $_POST[ 'keyId' ],
			    "AssociateTag" => $_POST[ 'associateTag' ],
			    "ItemId" => $_POST[ 'asin' ],
			    "IdType" => "ASIN",
			    "ResponseGroup" => "Images,ItemAttributes,Offers,OfferSummary,PromotionSummary,Reviews,EditorialReview"
			);

			// Set current timestamp if not set
			if (!isset($params["Timestamp"])) {
			    $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
			}

			// Sort the parameters by key
			ksort($params);
			$pairs = array();
			foreach ($params as $key => $value) {
			    array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
			}

			// Generate the canonical query
			$canonical_query_string = join("&", $pairs);

			// Generate the string to be signed
			$string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;

			// Generate the signature required by the Product Advertising API
			$signature = base64_encode(hash_hmac("sha256", $string_to_sign, $secret_key, true));

			// Generate the signed URL
			$request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);
			$reponse = wp_remote_get( $request_url );
			$body = wp_remote_retrieve_body( $reponse );
			$xml  = simplexml_load_string( $body );
			$json = json_encode( $xml );

			
			header( 'Content-type: application/json' );
			exit( $json );

		} else {

			error_log( 'Request rejected' );
			header("HTTP/1.0 404 Not Found");
			exit( json_encode([ 'message' => 'License rejected' ] ) );
		}
	} else {
		error_log('wrong params');
		header("HTTP/1.0 404 Not Found");
		exit( json_encode([ 'message' => 'Did not receive correct params' ] ) );
	}
}


// handler for Paypal cancellation
add_action( 'admin_post_nopriv_ipn_custom', 'ipn_cancel' );
function ipn_cancel(){

	if ( isset( $_POST[ 'txn_type' ] ) && $_POST[ 'txn_type' ] == 'subscr_cancel' ){
		
		global $wpdb;
		$SLM_TBL_LICENSE_KEYS = $wpdb->prefix . 'lic_key_tbl';
		$subscr_id = $_POST[ 'subscr_id' ];
		$q = $wpdb->get_results( "
			SELECT id FROM $SLM_TBL_LICENSE_KEYS
			WHERE txn_id = '$subscr_id'", ARRAY_A
		);

		// If we found it delete it.
		if ( !empty( $q ) ){
		
			SLM_Utility::delete_license_key_by_row_id( $q[0][ 'id'] );	
		
		} else {

			error_log('could not delete');

		}
	}
}