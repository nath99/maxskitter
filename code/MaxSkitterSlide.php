<?php
/**
 * DataObject holding Slide data. If you fill in External link, InternalLink setup will be ignored.
 * You can setup per slide animation effect.
 * @package maxskitter - silverstripe module for slides management and presentation with jQuery skitter plugin
 * @link skitter http://www.thiagosf.net/projects/jquery/skitter/
 * @link maxskitter https://github.com/Silvermax/maxskitter/
 * @author Pali Ondras
 */

class MaxSkitterSlide extends DataObject
{
	static $db = array (
		'Label' => 'Text',
		'animation' => 'Varchar(32)',
		'ExternalLink' => 'Varchar(2083)',
		'animation' => 'Varchar(32)'
	);
	
	static $has_one = array (
		'MaxSkitterImage' => 'Image',
		"InternalLink" => "SiteTree"
	);
	
	static $belongs_many_many = array('Page'=>'Page');
	
	public function getCMSFields_forPopup()
	{
		$internalLink = new SimpleTreeDropdownField("InternalLinkID", _t("Skitter.InternalLink","Internal Link"), "SiteTree");
   		$internalLink->setEmptyString(_t("Skitter.InternalLinkSelect","-- select Internal Link --")); 
		
		return new FieldSet(
			new TextField('Label', _t("Skitter.Label","Label")),
			MaxSkitterDefaults::get_animations_dropdown(),
			new TextField('ExternalLink', _t("Skitter.ExternalLink","External Link")),
			$internalLink,
			new FileIFrameField('MaxSkitterImage')
		);
	}
	
   /**
    * Add newly created items to the parent
    */
   function onAfterWrite() {
      $relatedClass = 'Page';
      if ( array_key_exists('ctf[parentClass]', $this->record) && $this->record['ctf[parentClass]'] == $relatedClass ) {
        $components = $this->getManyManyComponents($relatedClass);
    	if ( ! in_array((int)$this->record['ctf[sourceID]'], $components->getIdList()) ) {
        	$components->add((int)$this->record['ctf[sourceID]']);
			$components->write();
        }
     }
     parent::onAfterWrite();
   } 
	
	function onBeforeWrite() {
		parent::onBeforeWrite();
		// Prefix the URL with "http://" if no prefix is found
		if($this->ExternalLink && (strpos($this->ExternalLink, '://') === false)) {
			$this->ExternalLink = 'http://' . $this->ExternalLink;
		}
	}
	
	function animationClass() {
		return ($this->animation) ? trim($this->animation,"'") : "notSpecified";
	}
	
	function Link() {
		// TODO -> InternaLink + anchor Title
		if ($this->owner->ExternalLink) return $this->owner->ExternalLink;
		if ($this->owner->InternalLinkID) return $this->owner->InternalLink()->Link();
		return "#";
	}
	
	function Title() {
		if ($this->owner->Label) return Convert::raw2htmlatt($this->owner->Label);
		if ($this->owner->InternalLinkID) return $this->owner->InternalLink()->Title;
	}
	
}