<?php
/**
 * Page and Siteconfig decorator which enables page specific Skitter configuration
 * Changes made here will reset enabled staticConfig and SiteConfig configuration.
 * @package maxskitter - silverstripe module for slides management and presentation with jQuery skitter plugin
 * @link skitter http://www.thiagosf.net/projects/jquery/skitter/
 * @link maxskitter https://github.com/Silvermax/maxskitter/
 * @author Pali Ondras
 */

class MaxSkitterConfigExtension extends DataExtension {
		
	static function add_to_class($class, $extensionClass, $args = null) {
        if($class == 'Page' || $class == "SiteConfig") {
            Config::inst()->update($class, 'db', MaxSkitterDefaults::get_skitterDbFields());
        }
        parent::add_to_class($class, $extensionClass, $args);
    } 
	
	function updateCMSFields(FieldList $fields) {		
		if ($this->ownerBaseClass == "SiteConfig") {
			$fields->addFieldsToTab("Root.SkitterGlobalConfig",MaxSkitterDefaults::get_skitterCMSFields());
		}
	}
	
	function updateSettingsFields(FieldList $fields) {			
			$fields->addFieldsToTab("Root.SkitterPageConfig",MaxSkitterDefaults::get_skitterCMSFields());
	}
	
}

//EOF