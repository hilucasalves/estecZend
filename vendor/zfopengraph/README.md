# ZfOpenGraph

[![Build Status](https://travis-ci.org/nikolaposa/ZfOpenGraph.svg?branch=master)](https://travis-ci.org/nikolaposa/ZfOpenGraph)

ZfOpenGraph is a [Zend Framework 2](http://framework.zend.com) module which facilitates insertion
and utilization of OpenGraph meta tags (http://ogp.me) within some ZF2-based application.

## Installation

You can install this module either by cloning this project into your `./vendor/` directory,
or using composer, which is more recommended:

Add this project into your composer.json:

```json
"require": {
    "nikolaposa/zf-open-graph": "1.*"
}
```

Tell composer to download ZfOpenGraph by running update command:

```bash
$ php composer.phar update
```

For more information about composer itself, please refer to [getcomposer.org](http://getcomposer.org/).

### Enable the module in your `application.config.php`:

```php
<?php
return array(
    'modules' => array(
        // ...
        'ZfOpenGraph',
    ),
    // ...
);
```

## Usage

This module heavily depends on the `Zend\View\Helper\HeadMeta` view helper, through which actual
meta tags are added, thus you MUST invoke rendering of the `HeadMeta` container in the head section
of your layout:
```php
<head>
    <?php echo $this->headMeta(); ?>
</head>
```

### Available methods

ZfOpenGraph module features a `OpenGraph` view helper, which exposes methods for adding appropriate
OpenGraph meta tags. For example:
```php
$this->openGraph()->setType('website');

$this->openGraph()->setTitle('Some title');

$this->openGraph()->setDescription('Some description');

$this->openGraph()->setLocale('en', array('en_US', 'sr'));

$this->openGraph()->appendImage('http://ia.media-imdb.com/images/rock.jpg');

$this->openGraph()->prependImage(array(
    'http://ia.media-imdb.com/images/rock123.jpg',
    'width' => 100,
    'height' => 100
));

//"Virtual" methods for custom types:

$this->openGraph()->appendMusic(array(
    'song' => array(
        'http://www.test.com/song1',
        'disc' => 1,
        'track' => 7
    ),
    'release_date' => '2014-09-05T19:42:56+00:00'
));

$this->openGraph()->appendArticle(array(
    'published_time' => '2014-10-04T19:42:56+00:00',
    'modified_time' => '2014-10-05T19:42:56+00:00',
    'author' => 'http://www.test.com/foo.bar',
));

$this->openGraph()->appendBook(array(
    'author' => array('Author 1', 'Author 2'),
    'release_date' => '2014-10-05T19:42:56+00:00'
));
```

