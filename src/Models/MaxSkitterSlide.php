<?php

namespace Silvermax\MaxSkitter\Models;

use Page;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Core\Convert;
use Silvermax\MaxSkitter\Config\MaxSkitterDefaults;

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
    private static $db = array(
        'Name' => 'Varchar(64)',
        'Label' => 'Text',
        'animation' => 'Varchar(32)',
        'ExternalLink' => 'Varchar(2083)',
        'animation' => 'Varchar(32)'
    );

    private static $has_one = array(
        'MaxSkitterImage' => Image::class,
        "InternalLink" => SiteTree::class
    );

    private static $belongs_many_many = array(
        'Page' => Page::class
    );

    // Tell the datagrid what fields to show in the table
    private static $summary_fields = array(
        'Name' => 'Name',
        /*	   'Description'=>'Description',*/
        'Label' => 'Label',
        'InternalLink.MenuTitle' => 'Internal LinkTo page',
        'ExternalLink' => 'ExternalLink',
        'Thumbnail' => 'Image'
    );

    public function getCMSFields()
    {
        $fields = new FieldList();

        $internalLink = new TreeDropdownField(
            "InternalLinkID",
            _t("Skitter.InternalLink", "Internal Link"),
            SiteTree::class
        );

        $fields->push(new TextField('Name', _t("Skitter.Name", "Name (internal name, not shown in public site)")));
        $fields->push(new TextField('Label', _t("Skitter.Label", "Label")));
        $fields->push(MaxSkitterDefaults::get_array_dropdown("animation"));
        $fields->push(new TextField('ExternalLink', _t("Skitter.ExternalLink", "External Link")));
        $fields->push($internalLink);

        if ($this->InternalLinkID > 0) {
            $fields->push(new CheckboxField("forceToEmpty", "Remove internal LinkTo", false));
        }

        $fields->push(new UploadField('MaxSkitterImage'));

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    // this function creates the thumnail for the summary fields to use
    public function getThumbnail()
    {
        return $this->MaxSkitterImage()->CMSThumbnail();
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        // Prefix the URL with "http://" if no prefix is found
        if ($this->ExternalLink && (strpos($this->ExternalLink, '://') === false)) {
            $this->ExternalLink = 'http://' . $this->ExternalLink;
        }
        if (isset($_POST["forceToEmpty"]) && $_POST["forceToEmpty"]) {
            $this->InternalLinkID = 0;
        }
    }

    public function animationClass()
    {
        return ($this->animation) ? trim($this->animation, "'") : "notSpecified";
    }

    public function Link()
    {
        // TODO -> InternaLink + anchor Title
        if ($this->ExternalLink) {
            return $this->ExternalLink;
        }

        if ($this->InternalLinkID) {
            return $this->InternalLink()->Link();
        }

        return "#";
    }

    public function slideLabel()
    {
        return ($this->Label) ? Convert::raw2htmlatt($this->Label) : false;
    }
}
