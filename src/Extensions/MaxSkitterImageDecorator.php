<?php

namespace Silvermax\MaxSkitter\Extensions;

use SilverStripe\Assets\Image_Backend;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Core\Config\Configurable;

/**
 * Defines MaxSkitter image resize options, if you dont like used cropped resize, use your own copy of this file
 * (with custom name of class and methods), enable it in your mysite/_config.php and copy
 * maxskitter/templates/Includes/SkitterImage.ss in your theme and change called image resizing method name.
 * If you are fine with cropped resizing, you can configure dimension in you mysite/_config.php. Example:
 * <code>
 * MaxSkitterImageDecorator::$SkitterSlideWidth = 850;
 * MaxSkitterImageDecorator::$SkitterSlideHeight = 250;
 * </code>
 * @package maxskitter - silverstripe module for slides management and presentation with jQuery skitter plugin
 * @link skitter http://www.thiagosf.net/projects/jquery/skitter/
 * @link maxskitter https://github.com/Silvermax/maxskitter/
 * @author Pali Ondras
 */

class MaxSkitterImageDecorator extends DataExtension
{
	use Configurable;

	function generateSkitterSlide($gd)
	{
		return $gd->croppedResize($this->config()->get('slideWidth'), $this->config()->get('slideHeight'));
	}

	function SkitterSlide()
	{
		// Generates the manipulation key
		$variant = $this->owner->variantName(__FUNCTION__);
		$width = $this->config()->get('slideWidth');
		$height = $this->config()->get('slideHeight');

		// Instruct the backend to search for an existing variant with this key,
        // and include a callback used to generate this image if it doesn't exist
		return $this->owner->manipulateImage($variant, function (Image_Backend $backend) use ($height, $width) {
			return $backend->croppedResize($width, $height);
        });
	}
}
