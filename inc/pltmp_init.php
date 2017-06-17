<?php

if (!class_exists('PLTMP_Init')) {

	class PLTMP_Init
	{

		// Register activation/deactivation/uninstall hooks
		public static function registerPluginHooks()
		{
			register_activation_hook(PLTMP_SLUG, array('PLTMP_Init', 'activate'));
			register_deactivation_hook(PLTMP_SLUG, array('PLTMP_Init', 'deactivate'));
			register_uninstall_hook(PLTMP_SLUG, array('PLTMP_Init', 'uninstall'));
		}


		// When plugin is activated
		public static function activate()
		{

		}

		// When plugin is de-activated
		public static function deactivate()
		{

		}


		// Init hooks
		public static function hooks()
		{
			add_action('admin_init', array('PLTMP_Init', 'registerAdminAssets'));
			add_action('admin_enqueue_scripts', array('PLTMP_Init', 'loadAdminAssets'), 10, 1);

			add_action('init', array('PLTMP_Init', 'registerUserAssets'));
			add_action('wp_enqueue_scripts', array('PLTMP_Init', 'loadUserAssets'), 10, 1);
		}


		// Register all Scripts and Styles (BACKEND)
		public static function registerAdminAssets()
		{
			// Scripts
			wp_register_script( 'PLTMP_uikit', PLTMP_URL . 'assets/js/uikit.min.js', array('jquery'));

			// Styles
			wp_register_style( 'PLTMP_uikit', PLTMP_URL . 'assets/css/uikit.min.css');
		}

		// Enqueue Scripts and Styles (BACKEND)
		public static function loadAdminAssets($hook)
		{
			if ($hook == 'post-new.php' || $hook == 'post.php')
			{
				wp_enqueue_script('PLTMP_uikit');
				wp_enqueue_style('PLTMP_uikit');
			}
		}

		// Register all Scripts and Styles (FRONTEND)
		public static function registerUserAssets()
		{
			// Scripts
			wp_register_script( 'PLTMP_main', PLTMP_URL . 'assets/js/pltmp_main.js', array('jquery'));

			// Styles
			wp_register_style( 'PLTMP_main', PLTMP_URL . 'assets/css/pltmp_main.css');
		}

		// Enqueue Scripts and Styles (FRONTEND)
		public static function loadUserAssets($hook)
		{
			// Scripts
			wp_enqueue_script('PLTMP_main');

			// Styles
			wp_enqueue_style('PLTMP_main');
		}


		// Load all Models and init them
		public static function loadModels()
		{
			$models = glob(PLTMP_PATH . '/models/PLTMP_*');
			foreach ($models as $m) {
				require_once($m);

				// Init the model
				$x = explode('PLTMP_', $m);
				$class = 'PLTMP_' . ucfirst(str_replace('.php', '', $x[1]));
				if (method_exists($class, 'initialize')) {
					call_user_func(array($class, 'initialize'));
				}
			}
		}


		// Init the plugin
		public static function init()
		{
			// Init the models
			self::loadModels();

			// Register hooks
			self::registerPluginHooks();

			// Init the hooks
			self::hooks();
		}
	}

}