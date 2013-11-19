<?php
////////////////////////////// path //////////////////////////////
if (empty($GLOBALS['KERNEL_ROOT'])) {
    $GLOBALS['KERNEL_ROOT'] = dirname(__FILE__).'/../';
}

////////////////////////////// Thrift //////////////////////////////
require_once $GLOBALS['KERNEL_ROOT'] . 'lib/Thrift/ClassLoader/ThriftClassLoader.php';

use Thrift\ClassLoader\ThriftClassLoader;

$GEN_DIR = realpath(dirname(__FILE__).'/..').'/class';

$thriftLoader = new ThriftClassLoader();
$thriftLoader->registerNamespace('Thrift', $GLOBALS['KERNEL_ROOT'] . 'lib');
$thriftLoader->registerDefinition('York\\Thrift\\Commons', $GEN_DIR);
$thriftLoader->register();

////////////////////////////// autoload //////////////////////////////
// PSR-0 AutoLoader
require_once $GLOBALS['KERNEL_ROOT'].'vendor/autoload.php';
