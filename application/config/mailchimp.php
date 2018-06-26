<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//----------------------------------------------------------------------------
// Mailchimp API v3 REST Client
// ---------------------------------------------------------------------------
// Settings file
//
// @author    Stefan Ashwell
// @version   1.0
// @updated   14/03/2016
//----------------------------------------------------------------------------

/**
 * API Key
 *
 * Your API Key from your account
 */

$config['api_key']      = '2e763759f01341f8e5f69e247848450f-us9';
$config['client_id'] =   '826491785515';
/**
 * API Endpoint
 *
 * Typically this can remain as the default https://<dc>.api.mailchimp.com/3.0/
 */

$config['api_endpoint'] = 'https://<dc>.api.mailchimp.com/3.0/';
$config['call_back'] = "http://localhost/game/index.php/newsletters/callback.php";