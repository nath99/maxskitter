<?php 
/**
 * Defines ContentController extension, generating skitter JS config and including needed JS and CSS files. 
 * By default, module is checking parent pages if no Slides defined on current page. You can disable this per page via CMS. 
 * Calling $SkitterSlidesRecursive in your theme file will show up your defined Slides.
 * Css: skitter.styles.css is called automaticly and it is almost exact copy from original skitter sources
 * Css: skitter.custom.css is called automaticly, but doesnt exists. Create it in your theme if you need extend skitter.styles.css 
 * Js: all needed JS is called, if you have custom jQuery files, block module version in your mysite/_config.php file by
 * <code>Requirements::block("maxskitter/javascript/xyz.js");</code>
 * @package maxskitter - silverstripe module for slides management and presentation with jQuery skitter plugin
 * @link skitter http://www.thiagosf.net/projects/jquery/skitter/
 * @link maxskitter http://
 * @author Pali Ondras
 */

class MaxSkitterExtension extends Extension {
	
	private static $cachedSlides = false;
	private static $hasCachedSlides = false;
	
	public function onAfterInit() {
		if ($this->owner->SkitterSlidesRecursive()) {
			Requirements::themedCSS("skitter.styles");
			Requirements::themedCSS("skitter.custom");
		   
		   	$JS = array(
		   		"maxskitter/javascript/jquery-1.5.2.min.js",
	        	"maxskitter/javascript/jquery.skitter.min.js",
	        	"maxskitter/javascript/jquery.easing.1.3.js",
	        	"maxskitter/javascript/jquery.animate-colors-min.js"
	        );
	        
	      foreach ($JS as $js) { Requirements::javascript($js);}     
	      Requirements::combine_files("combined.skitter.js", $JS);
		  
		  Requirements::customScript("
				$(document).ready(function() {
				$('#skitter').skitter({
					".$this->owner->get_skitter_config_for_js()."
				});
			});
		");
		}
	}
	
	 public function SkitterSlidesRecursive() {
	 	if (self::$hasCachedSlides) return self::$cachedSlides;
		
   		$page = $this->owner;
   		$slides = $this->owner->MaxSkitterSlides();
   		while (!$slides->exists() && $page->ParentID != 0 && !$page->notRecursiveTeaser) {
   			$page = $page->Parent();
   			$slides = $page->MaxSkitterSlides();
   		} 
   		
   		if ($slides->exists()) {
   			$data = new ArrayData(
	   			array(
		   			"SkitterSlides" => $slides
		   		)
		   	);
			self::$cachedSlides = $data->renderWith('Skitter');
   		} else {
   			self::$cachedSlides = false;
   		}
   		self::$hasCachedSlides = true;
   		return self::$cachedSlides;
   }
   
   	public function get_skitter_config() {
   		$staticConfig = MaxSkitterDefaults::get_staticConfig();
		$siteConfig = SiteConfig::current_site_config();;
		$skitterConfig = array();
		foreach (MaxSkitterDefaults::get_dbFields()  as $key => $value) {
			if (!empty($this->owner->$key) || !empty($siteConfig->$key) || isset($staticConfig[$key])) {
				if (!empty($this->owner->$key)) {
					$config = $this->owner->$key;
					$place = "Page";
				} else {
					if (!empty($siteConfig->$key)) {
						$config = $siteConfig->$key;
						$place = "SiteConfig";
					} else {
						$config = $staticConfig[$key];
						$place = "_config";
					}
				}
				$skitterConfig[$key] = array(
					'config' => $config,
					'place' => $place
				);
			}
		}	
		//debug
		if (MaxSkitterDefaults::$debugSkitter) {
			print_r($skitterConfig);
		}
		return $skitterConfig;
	}
	
	public function get_skitter_config_for_js() {
		$array = array();
		foreach ($this->owner->get_skitter_config() as $key => $value) {
			$array[] = $key.":".$value["config"];
		}
		return implode(",",$array);
	}
	
}
