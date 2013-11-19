<?php
require_once dirname(__FILE__).'/../../../../../config/TestConfig.inc.php';

use York\Kernel\Utils\CollectionUtils;
use York\Kernel\Test\YTestCase;

class CollectionUtilsTest extends YTestCase
{
    public function testExplodeTrim()
    {
        $input = '    mouse ,cat , dog  ,  human    ';
        $targetOutput = array(
            'mouse',
            'cat',
            'dog',
            'human',
        );

        $output = CollectionUtils::explodeTrim(',', $input);

        $this->assertTrue(CollectionUtils::isVarDumpEquals($output, $targetOutput));

        // test trailing
        $input = '    mouse ,cat , dog  ,  human,';
        $targetOutput = array(
            'mouse',
            'cat',
            'dog',
            'human',
        );
        $this->assertTrue(CollectionUtils::isVarDumpEquals($output, $targetOutput));

    }

    public function testHasPath()
    {
        $target_array = array(
            'layer1' => array(
                'layer2' => array(
                    'layer3' => array()
                )
            )
        );

        $path = array('layer1', 'layer2', 'layer3');
        $this->assertTrue(CollectionUtils::hasPath($target_array, $path) );
        array_pop($path);
        $this->assertTrue(CollectionUtils::hasPath($target_array, $path) );
    }

    public function testSetToPath()
    {
        $target_array = array();
        $path = array('layer1', 'layer2', 'layer3');
        CollectionUtils::setToPath($target_array, $path, 'hello world!!');

        $this->assertTrue(CollectionUtils::hasPath($target_array, $path) );
        $this->assertTrue($target_array['layer1']['layer2']['layer3'] === 'hello world!!');
    }

    public function testGetFromPath()
    {
        $target_array = array();
        $path = array('layer1', 'layer2', 'layer3');
        CollectionUtils::setToPath($target_array, $path, 'hello world!!');
        $data = CollectionUtils::getFromPath($target_array, $path);
        $this->assertTrue($data === 'hello world!!');
    }
}
