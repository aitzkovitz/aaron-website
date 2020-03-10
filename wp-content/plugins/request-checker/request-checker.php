<?php
/*
Plugin Name: Request Checker for ADG
Description: Plugin validating ADG requests against licenses.
Author: Aaron Itzkovitz
Version: 1.0.0
Author URI: http://aaronitzkovitz.com/
*/

use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\api\DefaultApi;
use Amazon\ProductAdvertisingAPI\v1\ApiException;
use Amazon\ProductAdvertisingAPI\v1\Configuration;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\GetItemsRequest;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\GetItemsResource;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\PartnerType;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\ProductAdvertisingAPIClientException;

require_once(__DIR__ . '/vendor/autoload.php'); // change path as needed


// This should be called in wordpress.
if ( ! defined( 'ABSPATH' ) ) { exit; }

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
	
	function validate( $l_id, $domain, $ref ){

		global $wpdb;
		$SLM_TBL_LICENSE_KEYS = $wpdb->prefix . 'lic_key_tbl';
		$SLM_TBL_LIC_DOMAIN = $wpdb->prefix . 'lic_reg_domain_tbl';

		$q = $wpdb->get_results( "
			SELECT * FROM $SLM_TBL_LICENSE_KEYS
	        WHERE license_key = '$l_id'
	        AND lic_status = 'active'", ARRAY_A
		);

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

			$items = getItems($_POST['asin'], $_POST[ 'keyId' ], $_POST[ 'accessKey' ], $_POST[ 'associateTag' ]);
			if (!empty($items)) {
				$json = json_encode( $items );
				header( 'Content-type: application/json' );
				exit( $json );
			}			

			error_log( 'API Error' );
			header("HTTP/1.0 404 Not Found");
			exit( json_encode([ 'message' => 'PA API Error' ] ) );

		} else {

			error_log( 'Request rejected because license does not exist.' );
			header("HTTP/1.0 403 Permission Denied");
			exit( json_encode([ 'message' => 'License rejected' ] ) );
		}
	} else {
		error_log('ADG sent the wrong parameters for a request.');
		header("HTTP/1.0 404 Not Found");
		exit( json_encode([ 'message' => 'Did not receive correct params.' ] ) );
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

function getItems($itemId, $accessKey, $secretKey, $partnerTag)
{
	$itemInfo = [];

    $config = new Configuration();

    /*
     * Add your credentials
     * Please add your access key here
     */
    $config->setAccessKey($accessKey);
    # Please add your secret key here
    $config->setSecretKey($secretKey);
;

    /*
     * PAAPI host and region to which you want to send request
     * For more details refer: https://webservices.amazon.com/paapi5/documentation/common-request-parameters.html#host-and-region
     */
    $config->setHost('webservices.amazon.com');
    $config->setRegion('us-east-1');

    $apiInstance = new DefaultApi(
    /*
     * If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
     * This is optional, `GuzzleHttp\Client` will be used as default.
     */
        new GuzzleHttp\Client(), $config);

    # Request initialization

    # Choose item id(s)
    $itemIds = [$itemId];

    /*
     * Choose resources you want from GetItemsResource enum
     * For more details, refer: https://webservices.amazon.com/paapi5/documentation/get-items.html#resources-parameter
     */
    $resources = [
		GetItemsResource::ITEM_INFOTITLE,
		GetItemsResource::OFFERSLISTINGSPRICE,
		GetItemsResource::IMAGESPRIMARYSMALL,
		GetItemsResource::IMAGESPRIMARYMEDIUM,
		GetItemsResource::IMAGESPRIMARYLARGE,
		GetItemsResource::OFFERSLISTINGSSAVING_BASIS,
		GetItemsResource::ITEM_INFOFEATURES
	];

    # Forming the request
    $getItemsRequest = new GetItemsRequest();
    $getItemsRequest->setItemIds($itemIds);
    $getItemsRequest->setPartnerTag($partnerTag);
    $getItemsRequest->setPartnerType(PartnerType::ASSOCIATES);
    $getItemsRequest->setResources($resources);

    # Validating request
    $invalidPropertyList = $getItemsRequest->listInvalidProperties();
    $length = count($invalidPropertyList);
	
	// if ($length > 0) {
    //     echo "Error forming the request", PHP_EOL;
    //     foreach ($invalidPropertyList as $invalidProperty) {
    //         echo $invalidProperty, PHP_EOL;
    //     }
    //     return;
    // }

    # Sending the request
    try {
        $getItemsResponse = $apiInstance->getItems($getItemsRequest);

        # Parsing the response
        if ($getItemsResponse->getItemsResult() != null) {
            if ($getItemsResponse->getItemsResult()->getItems() != null) {
				$responseList = parseResponse($getItemsResponse->getItemsResult()->getItems());
				$item = $responseList[$itemId];
				
				if ($item != null) {

					// title
					if ($item->getItemInfo() != null and $item->getItemInfo()->getTitle() != null
						and $item->getItemInfo()->getTitle()->getDisplayValue() != null) {
						$itemInfo['item_title'] = $item->getItemInfo()->getTitle()->getDisplayValue();
					}

					// page URL
					if ($item->getDetailPageURL() != null) {
						$itemInfo['detail_page_url'] = $item->getDetailPageURL();
					}

					// buying price
					if ($item->getOffers() != null and
						$item->getOffers()->getListings() != null
						and $item->getOffers()->getListings()[0]->getPrice() != null
						and $item->getOffers()->getListings()[0]->getPrice()->getDisplayAmount() != null) {
							$itemInfo['buying_price'] = $item->getOffers()->getListings()[0]->getPrice()->getDisplayAmount();
					}

					// percent saved
					if ($item->getOffers() != null and
						$item->getOffers()->getListings() != null
						and $item->getOffers()->getListings()[0]->getPrice() != null
						and $item->getOffers()->getListings()[0]->getPrice()->getSavings() != null
						and $item->getOffers()->getListings()[0]->getPrice()->getSavings()->getPercentage() != null) {
							$itemInfo['savings_percentage'] = $item->getOffers()->getListings()[0]->getPrice()->getSavings()->getPercentage();
					}

					// original price
					if ($item->getOffers() != null and
						$item->getOffers()->getListings() != null
						and $item->getOffers()->getListings()[0]->getSavingBasis() != null
						and $item->getOffers()->getListings()[0]->getSavingBasis()->getDisplayAmount() != null ) {
							$itemInfo['original_price'] = $item->getOffers()->getListings()[0]->getSavingBasis()->getDisplayAmount();
						}

					// large image
					if ($item->getImages() != null and
						$item->getImages()->getPrimary() != null
						and $item->getImages()->getPrimary()->getLarge() != null) {
							$itemInfo['image_large'] = $item->getImages()->getPrimary()->getLarge()->getURL();
						}

					// medium image
					if ($item->getImages() != null and
						$item->getImages()->getPrimary() != null
						and $item->getImages()->getPrimary()->getMedium() != null) {
							$itemInfo['image_medium'] = $item->getImages()->getPrimary()->getMedium()->getURL();
						}	

					// small image
					if ($item->getImages() != null and
						$item->getImages()->getPrimary() != null
						and $item->getImages()->getPrimary()->getSmall() != null) {
							$itemInfo['image_small'] = $item->getImages()->getPrimary()->getSmall()->getURL();
						}

					// features
					if ($item->getItemInfo() != null and $item->getItemInfo()->getFeatures() != null
						and $item->getItemInfo()->getFeatures()->getDisplayValues() != null) {
						$itemInfo['item_description'] = $item->getItemInfo()->getFeatures()->getDisplayValues();
					}


				} else {
					$file = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'request.log';
					file_put_contents( $file, "API Could not find item with that ID.", FILE_APPEND );
				}
            }
		}
		
        if ($getItemsResponse->getErrors() != null) {
			$err_str = 'Error code: '. $getItemsResponse->getErrors()[0]->getCode() . PHP_EOL . 'Error message: ' . $getItemsResponse->getErrors()[0]->getMessage() . PHP_EOL;
			$file = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'request.log';
			file_put_contents( $file, $err_str , FILE_APPEND );
		}
		
		return $itemInfo;

    } catch (ApiException $exception) {
		$err_msg = '';
        $err_msg .= "Error calling PA-API 5.0!" . PHP_EOL;
        $err_msg .= "HTTP Status Code: " . $exception->getCode() . PHP_EOL;
		$err_msg .= "Error Message: " . $exception->getMessage() . PHP_EOL;
		
        if ($exception->getResponseObject() instanceof ProductAdvertisingAPIClientException) {
            $errors = $exception->getResponseObject()->getErrors();
            foreach ($errors as $error) {
				$err_msg .= "Error Type: " . $error->getCode() . PHP_EOL;
                $err_msg .= "Error Message: " . $error->getMessage() . PHP_EOL;
            }
        } else {
            $err_msg .= "Error response body: " . $exception->getResponseBody() . PHP_EOL;
		}
		
		return [];

    } catch (Exception $exception) {
		$err_msg .= "Error Message: " . $exception->getMessage() . PHP_EOL;
		
		return [];
    }
}

/**
 * Returns the array of items mapped to ASIN
 *
 * @param array $items Items value.
 *
 * @return array of \Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\Item mapped to ASIN.
 */
function parseResponse($items)
{
    $mappedResponse = array();
    foreach ($items as $item) {
        $mappedResponse[$item->getASIN()] = $item;
    }
    return $mappedResponse;
}