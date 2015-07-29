# yii-ext-jsupersized

Yii Framework Extension - Fullscreen Slideshow

## Requirements

Tested 1.1.10x

## Usage

```php
//in the any action...
  public function actionMyslideshow() {
   $this->widget('application.extensions.jSupersized.JSupersized', array(
   'titlePage' => 'My Fullscreen SlideShow',
   'slides' => array(
       array('image' => Yii::app()->request->baseUrl . '/images/folders/abc-01.jpg', 'title' => ''),
       array('image' => Yii::app()->request->baseUrl . '/images/folders/abc-02.jpg', 'title' => ''),
       array('image' => Yii::app()->request->baseUrl . '/images/folders/abc-03.jpg', 'title' => '')
   )));
  }
```

## Demo

* Access [here](http://questor.com.br/produtos/folder/tag/imobiliario).
