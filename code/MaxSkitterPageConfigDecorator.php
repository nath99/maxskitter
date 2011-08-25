<?php
/**
 * SiteTree decorator which enables page specific Skitter configuration
 * Changes made here will reset enabled staticConfig and SiteConfig configuration.
 * @package maxskitter - silverstripe module for slides management and presentation with jQuery skitter plugin
 * @link skitter http://www.thiagosf.net/projects/jquery/skitter/
 * @link maxskitter http://
 * @author Pali Ondras
 */

class MaxSkitterPageConfigDecorator extends DataObjectDecorator {
	
	function extraStatics() {
		return array(
			'db' => MaxSkitterDefaults::get_dbFields()
		);
	}
	
	function updateCMSFields(&$fields) {			
		foreach (MaxSkitterDefaults::get_dbFields()  as $key => $value) {
			if ($key == "animation") {
				$fields->addFieldToTab("Root.Content.SkitterConfig",MaxSkitterDefaults::get_animations_dropdown());
			} else {
				$fields->addFieldToTab("Root.Content.SkitterConfig",new TextField($key, _t("Skitter.".$key,$key)));
			}
		}	
	}
	
}
