<?php

namespace SilverMax\MaxSkitter\Extensions;

use Page;
use SilverMax\MaxSkitter\Model\MaxSkitterDefaults;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Core\Config\Config;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * Page and Siteconfig decorator which enables page specific Skitter configuration
 * Changes made here will reset enabled staticConfig and SiteConfig configuration.
 * @package maxskitter - silverstripe module for slides management and presentation with jQuery skitter plugin
 * @link skitter http://www.thiagosf.net/projects/jquery/skitter/
 * @link maxskitter https://github.com/Silvermax/maxskitter/
 * @author Pali Ondras
 */

class MaxSkitterConfigExtension extends DataExtension
{

    public static function add_to_class($class, $extensionClass, $args = null)
    {
        if ($class == Page::class || $class == SiteConfig::class) {
            Config::modify()->set($class, 'db', MaxSkitterDefaults::get_skitterDbFields());
        }
        parent::add_to_class($class, $extensionClass, $args);
    }

    public function updateCMSFields(FieldList $fields)
    {
        if ($this->owner->baseClass() == "SiteConfig") {
            $fields->addFieldsToTab("Root.SkitterGlobalConfig", MaxSkitterDefaults::get_skitterCMSFields());
        }
    }

    public function updateSettingsFields(FieldList $fields)
    {
        $fields->addFieldsToTab("Root.SkitterPageConfig", MaxSkitterDefaults::get_skitterCMSFields());
    }
}

//EOF