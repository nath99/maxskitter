<?php
/**
 * SiteConfig decorator which enables global SiteConfig Skitter configuration. 
 * Changes made here will reset enabled staticConfig configuration (editable via mysite/_config.php file).
 * @package maxskitter - silverstripe module for slides management and presentation with jQuery skitter plugin
 * @link skitter http://www.thiagosf.net/projects/jquery/skitter/
 * @link maxskitter http://
 * @author Pali Ondras
 */

class MaxSkitterSiteConfigDecorator extends DataObjectDecorator {
	
	function extraStatics() {
		return array(
			'db' => MaxSkitterDefaults::get_dbFields()
		);
	}
	
  // Create CMS fields
  public function updateCMSFields(&$fields) {
		foreach (MaxSkitterDefaults::get_dbFields() as $key => $value) {
			if ($key == "animation") {
				$fields->addFieldToTab("Root.Skitter",MaxSkitterDefaults::get_animations_dropdown());
			} else {
				$fields->addFieldToTab("Root.Skitter",new TextField($key, _t("Skitter.".$key,$key)));
			}
		}	
  }
				
}
//EOF
