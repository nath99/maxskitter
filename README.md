**MaxSkitter** is SilverStripe module for slides management and presentation with jQuery skitter plugin.

**Skitter** is full-featured jQuery Slideshow plugin with beautifull transitions. Is highly configurable and has good performance. Skitter website is here: http://www.thiagosf.net/projects/jquery/skitter/, github sources here: https://github.com/thiagosf/SkitterSlideshow

This module makes Skitter working with your SilverStripe installation.

## Key features

* Almost all Skitter options editable via SS installation in 3 places: config file (global config), SiteConfig (global config) and Page (page specific config)
* Any Page can have unlimited Slides, Slides are shared between Pages. You can enable/disable any Slide on any Page.
* Any Page can have any combination of Slides, custom sort order available on per page basis too.
* Each slide can point to External or Internal URL.

## Requirements

[SilverStripe ^4](https://www.silverstripe.org/download/)
[UndefinedOffset/SortableGridField](https://github.com/UndefinedOffset/SortableGridField)

## Installation

`composer require silvermax/maxskitter`

Add the following yml to your configuration (either config.yml or a new maxskitter.yml file):

```yml
Page:
  extensions:
    - Silvermax\MaxSkitter\Extensions\MaxSkitterDecorator
    - Silvermax\MaxSkitter\Extensions\MaxSkitterConfigExtension

PageController:
  extensions:
    - Silvermax\MaxSkitter\Extensions\MaxSkitterExtension

SilverStripe\SiteConfig\SiteConfig:
  extensions:
    - Silvermax\MaxSkitter\Extensions\MaxSkitterConfigExtension

SilverStripe\Assets\Image:
  extensions:
    - Silvermax\MaxSkitter\Extensions\MaxSkitterImageDecorator
```

## Configuration
### Skitter options

You can configure skitter options in 3 places (its up to you which one you use, but remember, that Page config will overwrite SiteConfig & staticConfig and SiteConfig will overwrite staticConfig).

**StaticConfig example (placed in mysite/_config.php):**

```php
MaxSkitterDefaults::set_staticConfig(array(
    "animation" => "cube",
    "easing_default" => "easeOutBack",
    "animateNumberActive" => "{backgroundColor:'#004581', color:'#fff'}",
    "navigation" => "false",
    "label" => "false"
));
```

**SiteConfig:**

Find Skitter tab in your SiteConfig section. Place values as on skitter homepage: http://www.thiagosf.net/projects/jquery/skitter/. So if you want cube animation, place in the field: cube, if you dont need navigation place in the field: false...

**Page config:**

Exactly same as SiteConfig, config tab available in Root.Content.SkitterConfig tab of your Page.

### Configuration of Skitter box size and Skitter images size:

If you are fine with cropped resizing of your images, you can configure dimension in your _config/config.yml. Example:

```yml
Silvermax\MaxSkitter\Extensions\MaxSkitterImageDecorator:
  slideWidth: <your_value>
  slideHeight: <your_value>
```

Default box size is 800x300px which will not suit your needs in many case. This size is defined in maxskitter/css/skitter.styles.css. You can copy this file to your theme and edit as you need, or you can just create css called skitter.custom.css in your theme and edit only what you need (this css will be called automaticly), example:

```css
.box_skitter {position:relative;width:850px;height:250px;background:#fff;}
.box_skitter .info_slide {right:15px; left: auto}
```

if you dont like used cropped resize, use your own copy of file maxskitter/code/MaxSkitterImageDecorator.php (with custom name of class and methods), enable it in your mysite/_config.php and copy  maxskitter/templates/Includes/SkitterImage.ss in your theme and change called image resizing method name.

## Adding slides

Each page has tab with Slides manager (Root.Content.SkitterSlides), which enables uploading and managing Skitter Slides. If you need reorder slides, make sure you saved current selection. Only checked (enabled) Slides are shown on the Page (because same Slides can be used on multiple Pages, you must have an option to enable/disable Slides on any Page. After you upload new slides, they are automaticly related to current Page, if you dont need them, just uncheck coresponding checkboxes. If you want to add Slide uploaded in the past to some Pages's selection, just uncheck option "Show only related items" and select from all uploaded slides.

## Showing slides in Template

Place in your desired template file (this will generate Skitter HTML if slides available and nothing if no slides defined):

```html
$SkitterSlidesRecursive
```

or (this will show your no-slide image if no slides available)

```html
<% if SkitterSlidesRecursive %>
	$SkitterSlidesRecursive
<% else %>
	<img src="$themedir/images/no-slide.jpg" alt="" />
<% end_if %>
```

## Collaboration
If you want to help out and make some improvements please fork this project and submit a pull request (see this guide on how to do this:  [Pull requests](http://help.github.com/pull-requests/)).

## Problems / issues
There are 3 common issues with maxskitter module: 1) Slides are not showing up. Reason: slides are added via backend, but not activated by checking the checkbox.(SS 2.4 only) 2) Script doesn't work. Reason: core jquery is called twice - if you have your own core jquery already called, disable maxskitter's version by adding thins into mysite/_config.php: Requirements::block("maxskitter/javascript/jquery-1.6.3.min.js"); Same issue is possible with easing and animate-color jquery files. Block them if your own versions already called. 3) Instead of slides, black box is shown. Reason: javascript conflicts - if maxskitter is not working even 1) and 2) is fine, try to disable all your custom JS scripts if it helps.
