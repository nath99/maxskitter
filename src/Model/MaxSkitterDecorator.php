<?php

namespace SilverMax\MaxSkitter\Model;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

/**
 * Defines an SiteTree decorator which enables slides management
 * @package maxskitter - silverstripe module for slides management and presentation with jQuery skitter plugin
 * @link skitter http://www.thiagosf.net/projects/jquery/skitter/
 * @link maxskitter https://github.com/Silvermax/maxskitter/
 * @author Pali Ondras
 */

class MaxSkitterDecorator extends DataExtension
{

	private static $db = array('notRecursive' => 'Boolean');

	private static $many_many = array('MaxSkitterSlides' => 'MaxSkitterSlide');

	private static $many_many_extraFields = array(
		'MaxSkitterSlides' => array(
			'SortOrder' => 'Int'
		)
	);

	function updateCMSFields(FieldList $fields)
	{

		$fields->addFieldToTab('Root.SkitterSlides', $grid = new GridField('MaxSkitterSlides', 'Skitter slides', $this->owner->MaxSkitterSlides(), GridFieldConfig_RelationEditor::create(10)));

		if (class_exists("GridFieldSortableRows")) {
			$grid->getConfig()->addComponent(new GridFieldSortableRows('SortOrder'));
		}
	}

	function updateSettingsFields(FieldList $fields)
	{
		$fields->addFieldToTab("Root.SkitterConfig", new CheckboxField("notRecursive", _t("Skitter.notRecursive", "Do not grab slides from parent page!")));
	}

	public function OrderedSkitterSlides()
	{
		return $this->owner->getManyManyComponents('MaxSkitterSlides')->sort('SortOrder');
	}
}
