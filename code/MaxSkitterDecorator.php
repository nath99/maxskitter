<?php
/**
 * Defines an SiteTree decorator which enables slides management 	
 * @package maxskitter - silverstripe module for slides management and presentation with jQuery skitter plugin
 * @link skitter http://www.thiagosf.net/projects/jquery/skitter/
 * @link maxskitter https://github.com/Silvermax/maxskitter/
 * @author Pali Ondras
 */

class MaxSkitterDecorator extends DataExtension {
	
	static $db = array('notRecursive' => 'Boolean');
	
	static $many_many = array('MaxSkitterSlides'=>'MaxSkitterSlide');
	
	function updateCMSFields(FieldList $fields) {	
		$slides = new GridField('maxSkitterSlides', 'Skitter slides', $this->owner->MaxSkitterSlides(), GridFieldConfig_RelationEditor::create()->addComponents(new GridFieldDeleteAction(true)));
		
		$fields->addFieldToTab("Root.SkitterSlides", $slides);
	}
	
	function updateSettingsFields(FieldList $fields) {
		$fields->addFieldToTab("Root.SkitterConfig", new CheckboxField("notRecursive",_t("Skitter.notRecursive","Do not grab slides from parent page!")));
	}
	
}
