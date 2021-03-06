<?php
namespace giorgiosaud\slickwp;

use giorgiosaud\slickwp\shortcodes\slickShortcode;
use giorgiosaud\slickwp\shortcodes\multiSlickShortcode;

class Initializers extends Singleton
{
	public $version="1.0";
	/**
     * Define constant if not already set.
     *
     * @param string      $name  Constant name.
     * @param string|bool $value Constant value.
     */
    private function define($name, $value)
    {
        if (!defined($name)) {
            define($name, $value);
        }
    }
	public function __construct()
	{

		$this->defineConstants();
        
		$this->initHooks();
		if (is_admin()) {
			$my_settings_page = new Options();
		}
		do_action('giorgioslickplugin_loaded');
	}
	private function defineConstants()
	{
		$upload_dir = wp_upload_dir(null, false);
		$this->define('SLICKWP_ABSPATH', dirname(SLICKWP_FILE) . '/');
		$this->define('SLICKWP_BASENAME', plugin_basename(SLICKWP_FILE));
		$this->define('SLICKWP_VERSION', $this->version);
        $this->define('SLICKWP_CMB2PREFIX','SLICKWP_');
	}
    /**
     * Initialize Hooks
     */
    private function initHooks()
    {	
        ImageSizes::getInstance();
    	slickShortcode::getInstance();
        multiSlickShortcode::getInstance();
    	StylesAndScripts::getInstance();
        CMB2Fields::getInstance();
    }
}