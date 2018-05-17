<?php
/**
 * This file is part of the ZfOpenGraph package.
 *
 * Copyright (c) Nikola Posa <posa.nikola@gmail.com>
 *
 * For full copyright and license information, please refer to the LICENSE file,
 * located at the package root folder.
 */

namespace ZfOpenGraphTest\View\Helper;

use PHPUnit_Framework_TestCase;
use ZfOpenGraph\View\Helper\OpenGraph;
use Zend\View\Renderer\PhpRenderer as View;

/**
 * @author Nikola Posa <posa.nikola@gmail.com>
 */
class OpenGraphTest extends PHPUnit_Framework_TestCase
{
    protected $helper;

    protected $view;

    protected function setUp()
    {
        $this->helper = new OpenGraph();

        $this->view = new View();
        $this->view->getHelperPluginManager()->setInvokableClass('headmeta', 'ZfOpenGraph\View\Helper\HeadMeta');
        $this->helper->setView($this->view);
    }

    public function testHeadMetaHelperRetrieval()
    {
        $this->assertInstanceOf('ZfOpenGraph\View\Helper\HeadMeta', $this->helper->getHeadMeta());
    }

    public function _testSettingGeneralProperty($property, $value, $propName = null, $method = 'set')
    {
        if ($propName === null) {
            $propName = $property;
        }

        $methodName = $method . ucfirst($property);
        $this->helper->$methodName($value);

        $items = $this->helper->getHeadMeta()->getArrayCopy();
        $this->assertEquals(1, count($items));

        $item = array_shift($items);
        $type = OpenGraph::META_TYPE;
        $this->assertObjectHasAttribute($type, $item);
        $this->assertObjectHasAttribute('content', $item);
        $this->assertObjectHasAttribute($item->type, $item);
        $this->assertEquals('og:' . $propName, $item->$type);
        $this->assertEquals($value, $item->content);
    }

    public function _testSettingStructureProperty($property, $data, $method = 'set')
    {
        $methodName = $method . ucfirst($property);

        $this->helper->$methodName($data);

        $items = $this->helper->getHeadMeta()->getArrayCopy();
        $this->assertEquals(count($data), count($items));

        $i = 0;
        foreach ($data as $key => $value) {
            $item = $items[$i++];
            $prop = "og:$property";
            if (is_string($key)) {
                $prop .= ":$key";
            }
            $this->assertEquals($prop, $item->property);
            $this->assertEquals($value, $item->content);
        }
    }

    public function testSettingType()
    {
        $this->_testSettingGeneralProperty('type', 'website');
    }

    public function testSettingUrl()
    {
        $this->_testSettingGeneralProperty('url', 'http://www.test.com');
    }

    public function testSettingTitle()
    {
        $this->_testSettingGeneralProperty('title', 'Site title');
    }

    public function testSettingDescription()
    {
        $this->_testSettingGeneralProperty('description', 'foo bar baz');
    }

    public function testSettingDeterminer()
    {
        $this->_testSettingGeneralProperty('determiner', 'auto');
    }

    public function testSettingSiteName()
    {
        $this->_testSettingGeneralProperty('siteName', 'FooBar', 'site_name');
    }

    public function testSettingLocale()
    {
        $this->_testSettingGeneralProperty('locale', 'sr');
    }

    public function testSettingLocaleAlternates()
    {
        $this->helper->setLocale('en', array('en_US', 'sr'));

        $items = $this->helper->getHeadMeta()->getArrayCopy();
        $this->assertEquals(3, count($items));

        $this->assertEquals('og:locale', $items[0]->property);
        $this->assertEquals('en', $items[0]->content);

        $this->assertEquals('og:locale:alternate', $items[1]->property);
        $this->assertEquals('en_US', $items[1]->content);

        $this->assertEquals('og:locale:alternate', $items[2]->property);
        $this->assertEquals('sr', $items[2]->content);
    }

    public function testAppendingImageUrl()
    {
        $this->_testSettingGeneralProperty('image', 'http://ia.media-imdb.com/images/rock.jpg', null, 'append');
    }

    public function testAppendingImageData()
    {
        $this->_testSettingStructureProperty('image', array(
            'http://ia.media-imdb.com/images/rock.jpg',
            'width' => 200,
            'height' => 100
        ), 'append');
    }

    public function testPrependingImage()
    {
        $this->helper->appendImage('http://ia.media-imdb.com/images/rock1.jpg');
        $this->helper->prependImage('http://ia.media-imdb.com/images/rock2.jpg');

        $items = $this->helper->getHeadMeta()->getArrayCopy();
        $this->assertEquals(2, count($items));

        $this->assertEquals('og:image', $items[0]->property);
        $this->assertEquals('http://ia.media-imdb.com/images/rock2.jpg', $items[0]->content);

        $this->assertEquals('og:image', $items[1]->property);
        $this->assertEquals('http://ia.media-imdb.com/images/rock1.jpg', $items[1]->content);
    }

    public function testAppendingVideoUrl()
    {
        $this->_testSettingGeneralProperty('video', 'http://example.com/bond/trailer.swf', null, 'append');
    }

    public function testAppendingVideoData()
    {
        $this->_testSettingStructureProperty('video', array(
            'http://example.com/bond/trailer.swf',
            'width' => 400,
            'height' => 300
        ), 'append');
    }

    public function testPrependingVideo()
    {
        $this->helper->appendVideo('http://example.com/bond/trailer1.swf');
        $this->helper->prependVideo('http://example.com/bond/trailer2.swf');

        $items = $this->helper->getHeadMeta()->getArrayCopy();
        $this->assertEquals(2, count($items));

        $this->assertEquals('og:video', $items[0]->property);
        $this->assertEquals('http://example.com/bond/trailer2.swf', $items[0]->content);

        $this->assertEquals('og:video', $items[1]->property);
        $this->assertEquals('http://example.com/bond/trailer1.swf', $items[1]->content);
    }

    public function testAppendingAudioUrl()
    {
        $this->_testSettingGeneralProperty('audio', 'http://example.com/sound.mp3', null, 'append');
    }

    public function testAppendingAudioData()
    {
        $this->_testSettingStructureProperty('audio', array(
            'http://example.com/sound.mp3',
            'secure_url' => 'https://secure.example.com/sound.mp3',
            'type' => 'audio/mpeg'
        ), 'append');
    }

    public function testPrependingAudio()
    {
        $this->helper->appendAudio('http://example.com/sound1.mp3');
        $this->helper->prependAudio('http://example.com/sound2.mp3');

        $items = $this->helper->getHeadMeta()->getArrayCopy();
        $this->assertEquals(2, count($items));

        $this->assertEquals('og:audio', $items[0]->property);
        $this->assertEquals('http://example.com/sound2.mp3', $items[0]->content);

        $this->assertEquals('og:audio', $items[1]->property);
        $this->assertEquals('http://example.com/sound1.mp3', $items[1]->content);
    }

    public function testReversingStructuredDataWhenPrepending()
    {
        $this->helper->appendImage(array(
            'http://ia.media-imdb.com/images/rock1.jpg',
            'width' => 50,
            'height' => 50
        ));
        $this->helper->prependImage(array(
            'http://ia.media-imdb.com/images/rock2.jpg',
            'width' => 100,
            'height' => 100
        ));
        $this->helper->prependImage(array(
            'http://ia.media-imdb.com/images/rock3.jpg',
            'width' => 200,
            'height' => 200
        ));

        $items = $this->helper->getHeadMeta()->getArrayCopy();
        $this->assertEquals(9, count($items));

        $this->assertEquals('og:image', $items[0]->property);
        $this->assertEquals('http://ia.media-imdb.com/images/rock3.jpg', $items[0]->content);
        $this->assertEquals('og:image:width', $items[1]->property);
        $this->assertEquals('200', $items[1]->content);
        $this->assertEquals('og:image:height', $items[2]->property);
        $this->assertEquals('200', $items[2]->content);

        $this->assertEquals('og:image', $items[3]->property);
        $this->assertEquals('http://ia.media-imdb.com/images/rock2.jpg', $items[3]->content);
        $this->assertEquals('og:image:width', $items[4]->property);
        $this->assertEquals('100', $items[4]->content);
        $this->assertEquals('og:image:height', $items[5]->property);
        $this->assertEquals('100', $items[5]->content);

        $this->assertEquals('og:image', $items[6]->property);
        $this->assertEquals('http://ia.media-imdb.com/images/rock1.jpg', $items[6]->content);
        $this->assertEquals('og:image:width', $items[7]->property);
        $this->assertEquals('50', $items[7]->content);
        $this->assertEquals('og:image:height', $items[8]->property);
        $this->assertEquals('50', $items[8]->content);
    }

    public function testSettingCustomTypeProperty()
    {
        $this->helper->appendMusic(array('duration' => 100, 'album' => array('disc' => 1, 'track' => 10)));

        $items = $this->helper->getHeadMeta()->getArrayCopy();
        $this->assertEquals(3, count($items));

        $this->assertEquals('music:duration', $items[0]->property);
        $this->assertEquals('100', $items[0]->content);

        $this->assertEquals('music:album:disc', $items[1]->property);
        $this->assertEquals('1', $items[1]->content);

        $this->assertEquals('music:album:track', $items[2]->property);
        $this->assertEquals('10', $items[2]->content);
    }

    public function testSettingCustomTypePropertyIntKeyStructure()
    {
        $this->helper->appendMusic(array(
            'song' => array(
                'test', //int key
                'disc' => 2,
                'track' => 3
            ),
            'musician' => 'Foo Bar'
        ));

        $items = $this->helper->getHeadMeta()->getArrayCopy();
        $this->assertEquals(4, count($items));

        $this->assertEquals('music:song', $items[0]->property);
        $this->assertEquals('test', $items[0]->content);

        $this->assertEquals('music:song:disc', $items[1]->property);
        $this->assertEquals('2', $items[1]->content);

        $this->assertEquals('music:song:track', $items[2]->property);
        $this->assertEquals('3', $items[2]->content);

        $this->assertEquals('music:musician', $items[3]->property);
        $this->assertEquals('Foo Bar', $items[3]->content);
    }

    public function testSettingCustomTypePropertyArrayAttrib()
    {
        $this->helper->appendBook(array(
            'author' => array('foobar', 'bazbat'), //array
            'release_date' => '2014-10-05T19:42:56+00:00'
        ));

        $items = $this->helper->getHeadMeta()->getArrayCopy();
        $this->assertEquals(3, count($items));

        $this->assertEquals('book:author', $items[0]->property);
        $this->assertEquals('foobar', $items[0]->content);

        $this->assertEquals('book:author', $items[1]->property);
        $this->assertEquals('bazbat', $items[1]->content);

        $this->assertEquals('book:release_date', $items[2]->property);
        $this->assertEquals('2014-10-05T19:42:56+00:00', $items[2]->content);
    }
}
