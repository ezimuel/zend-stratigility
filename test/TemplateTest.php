<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @see       http://github.com/zendframework/zend-stratigility for the canonical source repository
 * @copyright Copyright (c) 2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-stratigility/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\Stratigility;

use PHPUnit_Framework_TestCase as TestCase;
use Zend\Stratigility\Template;

class TemplateTest extends TestCase
{
    public function setUp()
    {
        $this->fileTemplate = sys_get_temp_dir() . '/' . uniqid('zend_stratigility_test');
        touch($this->fileTemplate);
    }

    public function tearDown()
    {
        unlink($this->fileTemplate);
    }

    public function testConstruct()
    {
        $template = new Template($this->fileTemplate);
        $this->assertEquals($this->fileTemplate, $template->getFileTemplate());
    }

    public function testSetFileTemplate()
    {
        $template = new Template();
        $template->setFileTemplate($this->fileTemplate);
        $this->assertEquals($this->fileTemplate, $template->getFileTemplate());
    }

    public function testRender()
    {
        file_put_contents($this->fileTemplate, '<h1><?php echo $foo ?></h1>');
        $template = new Template($this->fileTemplate);
        $result = $template->render([ 'foo' => 'bar' ]);
        $this->assertEquals('<h1>bar</h1>', $result);
    }

    public function testRenderWithoutData()
    {
      file_put_contents($this->fileTemplate, '<h1>bar</h1>');
      $template = new Template($this->fileTemplate);
      $result = $template->render();
      $this->assertEquals('<h1>bar</h1>', $result);
    }
}
