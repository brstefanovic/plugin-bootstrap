<?php

if (!class_exists('PLTMP_Helper')) {

	class PLTMP_Helper
	{

		/**
		 *
		 * – Output JSON format to Browser
		 *
		 * @param $type      ... type of response (success, warning, error)
		 * @param $message   ... output message
		 * @param null $data ... additional data
		 */
		public static function json($type, $message, $data = NULL)
		{
			wp_send_json(array(
				'status' => $type,
				'message' => $message,
				'data' => $data
			));
			wp_die();
		}


		/**
		 *
		 *  – Checks for basic server requirements needed to run the plugin
		 *
		 * @return bool ... returns whether the website has the requirements needed to run the plugin
		 */
		public static function verifyRequirements()
		{
			global $wp_version;
			if (version_compare(PHP_VERSION, PLTMP_REQUIRED_PHP_VERSION, '<')) {
				return false;
			}
			if (version_compare($wp_version, PLTMP_REQUIRED_WP_VERSION, '<')) {
				return false;
			}
			if (is_multisite() != PLTMP_REQUIRED_WP_NETWORK) {
				return false;
			}

			return true;
		}

	}

}