<?php
/**
 * Defines an SiteTree decorator which enables slides management 	
 * @package maxskitter - silverstripe module for slides management and presentation with jQuery skitter plugin
 * @link skitter http://www.thiagosf.net/projects/jquery/skitter/
 * @link maxskitter https://github.com/Silvermax/maxskitter/
 * @author Pali Ondras
 */

class MaxSkitterDecorator extends DataObjectDecorator {
	
	function extraStatics() {
		return array(
			'db' => array(
				'notRecursive' => 'Boolean'
			),
			'many_many' => array('MaxSkitterSlides'=>'MaxSkitterSlide')
		);
	}
	
	function updateCMSFields(&$fields) {
		$fields->addFieldToTab("Root.Content.SkitterSlides", new CheckboxField("notRecursive",_t("Skitter.notRecursive","Do not grab slides from parent page!")));
				
        $slides = new ManyManyFileDataObjectManager(
			$this->owner, // Controller
			'MaxSkitterSlides', // Source name
			'MaxSkitterSlide', // Source class
			'MaxSkitterImage', // File name on DataObject
			array(
				'Label' => _t("Skitter.Label","Label")
			), // Headings 
			'getCMSFields_forPopup' // Detail fields (function name or FieldSet object)
			// Filter clause
			// Sort clause
			// Join clause
		);
		$slides->setParentClass("Page");
		$slides->setSourceID($this->owner->ID);
		$slides->setOnlyRelated(true);
		$fields->addFieldToTab("Root.Content.SkitterSlides", $slides);
	}
	
   public function getSkitterSlidesRecursive() {
   		$page = $this->owner;
   		$slides = $this->owner->MaxSkitterSlides();
   		while (!$slides->exists() && $page->ParentID != 0 && !$page->notRecursive) {
   			$page = $page->Parent();
   			$slides = $page->MaxSkitterSlides();
   		} 
   		
   		if ($slides->exists()) {
   			$data = new ArrayData(
	   			array(
		   			"SkitterSlides" => $slides
		   		)
		   	);
			return $data->renderWith('Skitter');
   		} else {
   			return false;
   		}
   }
	
}
