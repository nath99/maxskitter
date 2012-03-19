<?php
/**
 * SiteConfig decorator which enables global SiteConfig Skitter configuration. 
 * Changes made here will reset enabled staticConfig configuration (editable via mysite/_config.php file).
 * @package maxskitter - silverstripe module for slides management and presentation with jQuery skitter plugin
 * @link skitter http://www.thiagosf.net/projects/jquery/skitter/
 * @link maxskitter https://github.com/Silvermax/maxskitter/
 * @author Pali Ondras
 */

class MaxSkitterSiteConfigDecorator extends DataObjectDecorator {
	
	function extraStatics() {
		return array(
			'db' => MaxSkitterDefaults::get_skitterDbFields()
		);
	}
	
	function updateCMSFields(&$fields) {			
			$fields->addFieldsToTab("Root.Skitter",MaxSkitterDefaults::get_skitterCMSFields());
	}
				
}
//EOF
