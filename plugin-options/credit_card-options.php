<?php

if ( ! defined( 'PG_WCAUTHNET' ) ) {
	exit;
} // Exit if accessed directly

return array(
	'credit_card' => array(
		'landing_cc' => array(
			'type' => 'custom_tab',
			'action' => 'yith_wcauthnet_payment_credit_card_gateway_settings_tab'
		)
	)
);