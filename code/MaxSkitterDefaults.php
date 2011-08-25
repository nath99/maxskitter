<?php
/**
 * Defines MaxSkitter degault configuration and common methods 	
 * @package maxskitter - silverstripe module for slides management and presentation with jQuery skitter plugin
 * @link skitter http://www.thiagosf.net/projects/jquery/skitter/
 * @link maxskitter http://
 * @author Pali Ondras
 */

class MaxSkitterDefaults {
	
		public static $debugSkitter = false;
	
		private static $dbFields = array(
				'velocity' => 'Varchar(8)',
				'interval' => 'Varchar(8)',
				'animation' => 'Varchar(32)',
				'numbers' => 'Varchar(8)',
				'navigation' => 'Varchar(8)',
				'label' => 'Varchar(8)',
				'easing_default' => 'Varchar(32)',
				'animateNumberOut' => 'Varchar(64)',
				'animateNumberOver' => 'Varchar(64)',
				'animateNumberActive' => 'Varchar(64)',
				'thumbs' => 'Varchar(8)',
				'hideTools' => 'Varchar(8)',
				'fullscreen' => 'Varchar(8)',
				'dots' => 'Varchar(8)',
				'width_label' => 'Varchar(32)',
				'show_randomly' => 'Varchar(8)'
	);
	
	public function set_dbFields($array) {
		self::$dbFields = $array;
	}
	
	public function get_dbFields() {
		return self::$dbFields;
	}
	
	private static $animations = array(
		'cube', 
		'cubeRandom', 
		'block', 
		'cubeStop', 
		'cubeHide', 
		'cubeSize', 
		'horizontal', 
		'showBars', 
		'showBarsRandom', 
		'tube',
		'fade',
		'fadeFour',
		'paralell',
		'blind',
		'blindHeight',
		'blindWidth',
		'directionTop',
		'directionBottom',
		'directionRight',
		'directionLeft',
		'cubeStopRandom',
		'cubeSpread'
	);
	
	public function set_animations($array) {
		self::$animations = $array;
	}
	
	public function get_animations() {
		return self::$animations;
	}
	
	public function get_animations_dropdown() {
		$animations = self::$animations;
				foreach ($animations as $key => $value) {
					$new_key = "'".$value."'";
					$animations_for_dd[$new_key] = $value;
				}
				$dd = new DropdownField("animation",_t("Skitter.animation","Used animation"),$animations_for_dd);
				$dd->setEmptyString(_t("Skitter.animationDefault","-- Default animation --"));
				return $dd;
	}
	
		private static $staticConfig = array();
	
	public function set_staticConfig($array) {
		self::$staticConfig = $array;
	}
	
	public function get_staticConfig() {
		return self::$staticConfig;
	}
	
}
