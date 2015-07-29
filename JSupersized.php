<?php

/**
 * JSupersized extension class.
 * Fullscreen Slideshow
 * 
 * @version 1.0 
 * @package    Extension
 * @author     Fernando Rosa <nando.megaman@gmail.com>
 * @copyright  (c) 2014 Fernando Rosa
 * @uses Supersized jQuery Plugin http://buildinternet.com/project/supersized
 */

/**
 * @example 
 * //in the any action...
 * 
 * public function actionMyslideshow() {
 *  $this->widget('application.extensions.jSupersized.JSupersized', array(
 *  'titlePage' => 'My Fullscreen SlideShow',
 *  'slides' => array(
 *      array('image' => Yii::app()->request->baseUrl . '/images/folders/abc-01.jpg', 'title' => ''),
 *      array('image' => Yii::app()->request->baseUrl . '/images/folders/abc-02.jpg', 'title' => ''),
 *      array('image' => Yii::app()->request->baseUrl . '/images/folders/abc-03.jpg', 'title' => '')
 *  )));
 * }
 * 
 */
class JSupersized extends CWidget {

    public $titlePage = "SlideShow";

    /* Supersized Config, verify config http://buildinternet.com/project/supersized */
    public $slideshow = 1;
    public $autoplay = 1;
    public $start_slide = 1;
    public $stop_loop = 0;
    public $random = 0;
    public $slide_interval = 7000;
    public $transition = 6;
    public $transition_speed = 1000;
    public $new_window = 1;
    public $pause_hover = 0;
    public $keyboard_nav = 1;
    public $performance = 1;
    public $image_protect = 1;
    public $min_width = 900;
    public $min_height = 0;
    public $vertical_center = 1;
    public $horizontal_center = 1;
    public $fit_always = 1;
    public $fit_portrait = 1;
    public $fit_landscape = 1;
    public $slide_links = 'blank';
    public $thumb_links = 1;
    public $thumbnail_navigation = 0;
    public $slides = array();
    public $progress_bar = 1;
    public $mouse_scrub = 0;

    public function run() {
        echo $this->renderPage();
    }

    protected function registerHeaderScripts() {
        $scripts = "";
        $clientScript = Yii::app()->getClientScript();
        $clientScript->registerCssFile($this->dirAssets() . '/css/supersized.css');
        $clientScript->registerCssFile($this->dirAssets() . '/theme/supersized.shutter.css');
        $clientScript->registerCoreScript('jquery');
        $clientScript->registerScriptFile($this->dirAssets() . '/js/jquery.easing.min.js');
        $clientScript->registerScriptFile($this->dirAssets() . '/js/supersized.3.2.7.min.js');
        $clientScript->registerScriptFile($this->dirAssets() . '/theme/supersized.shutter.min.js');

        $clientScript->registerScript(__CLASS__ . 'ss_1', "
            jQuery(function($){ 
                $.supersized.themeVars.image_path = '".$this->dirAssets()."/img/';                
                $.supersized({				
                    slideshow : " . $this->slideshow . ",
                    autoplay : " . $this->autoplay . ",
                    start_slide : " . $this->start_slide . ",
                    stop_loop : " . $this->stop_loop . ",
                    random : " . $this->random . ",
                    slide_interval : " . $this->slide_interval . ",
                    transition : " . $this->transition . ",
                    transition_speed : " . $this->transition_speed . ",
                    new_window : " . $this->new_window . ",
                    pause_hover : " . $this->pause_hover . ",
                    keyboard_nav : " . $this->keyboard_nav . ",
                    performance : " . $this->performance . ",
                    image_protect : " . $this->image_protect . ",
                    min_width : " . $this->min_width . ",
                    min_height : " . $this->min_height . ",
                    vertical_center : " . $this->vertical_center . ",
                    horizontal_center : " . $this->horizontal_center . ",
                    fit_always : " . $this->fit_always . ",
                    fit_portrait : " . $this->fit_portrait . ",
                    fit_landscape : " . $this->fit_landscape . ",
                    slide_links : '" . $this->slide_links . "',
                    thumb_links : " . $this->thumb_links . ",
                    thumbnail_navigation : " . $this->thumbnail_navigation . ",
                    slides : " . CJavaScript::encode($this->slides) . ",																	
                    progress_bar : " . $this->progress_bar . ",
                    mouse_scrub : " . $this->mouse_scrub . "
        }) });");
        $clientScript->render($scripts);
        return $scripts;
    }

    protected function renderPage() {
        $content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
        $content .= '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">';
        $content .= '<head>';
        $content .= '<title>' . $this->titlePage . '</title>';
        $content .= '<meta http-equiv="content-type" content="text/html; charset=UTF-8" />';
        $content .= '<meta http-equiv="content-type" content="text/html; charset=UTF-8" />';
        $content .= $this->registerHeaderScripts() . ' ';
        $content .= '</head>';
        $content .= '<style type="text/css">';
        $content .= 'ul#demo-block{ margin:0 15px 15px 15px; }';
        $content .= 'ul#demo-block li{ margin:0 0 10px 0; padding:10px; display:inline; float:left; clear:both; color:#aaa; background:url("' . $this->dirAssets() . '/img/bg-black.png"); font:11px Helvetica, Arial, sans-serif; }';
        $content .= 'ul#demo-block li a{ color:#eee; font-weight:bold; }';
        $content .= '</style>';
        $content .= '<body>';
        $content .= '<div id="prevthumb"></div>';
        $content .= '<div id="nextthumb"></div>';
        $content .= '<a id="prevslide" class="load-item"></a>';
        $content .= '<a id="nextslide" class="load-item"></a>';
        $content .= '<div id="thumb-tray" class="load-item">';
        $content .= '<div id="thumb-back"></div>';
        $content .= '<div id="thumb-forward"></div>';
        $content .= '</div>';
        $content .= '<div id="progress-back" class="load-item">';
        $content .= '<div id="progress-bar"></div>';
        $content .= '</div>';
        $content .= '<div id="controls-wrapper" class="load-item">';
        $content .= '<div id="controls">';
        $content .= '<a id="play-button">' . $this->getBtnPause() . '</a>';
        $content .= '<div id="slidecounter">';
        $content .= '<span class="slidenumber"></span> / <span class="totalslides"></span>';
        $content .= '</div>';
        $content .= '<div id="slidecaption"></div>';
        $content .= '<a id="tray-button">' . $this->getBtnTrayUp() . '</a>';
        $content .= '<ul id="slide-list"></ul>';
        $content .= '</div>';
        $content .= '</div>';
        $content .= '</body>';
        $content .= '</html>';
        return $content;
    }

    protected function dirAssets() {
        $dir = dirname(__FILE__);
        return Yii::app()->getAssetManager()->publish($dir);
    }

    protected function getBtnTrayUp() {
        return CHtml::image($this->dirAssets() . '/img/button-tray-up.png', '', array('id' => 'tray-arrow'));
    }

    protected function getBtnPause() {
        return CHtml::image($this->dirAssets() . '/img/pause.png', '', array('id' => 'pauseplay'));
    }

}

?>