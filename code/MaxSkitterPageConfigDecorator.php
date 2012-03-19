<?php
/**
 * SiteTree decorator which enables page specific Skitter configuration
 * Changes made here will reset enabled staticConfig and SiteConfig configuration.
 * @package maxskitter - silverstripe module for slides management and presentation with jQuery skitter plugin
 * @link skitter http://www.thiagosf.net/projects/jquery/skitter/
 * @link maxskitter https://github.com/Silvermax/maxskitter/
 * @author Pali Ondras
 */

class MaxSkitterPageConfigDecorator extends DataObjectDecorator {
	
	function extraStatics() {
		return array(
			'db' => MaxSkitterDefaults::get_skitterDbFields()
		);
	}
	
	function updateCMSFields(&$fields) {			
			$fields->addFieldsToTab("Root.Content.SkitterConfig",MaxSkitterDefaults::get_skitterCMSFields());
	}
	
}
