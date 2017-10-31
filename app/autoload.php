<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/** @var ClassLoader $loader */
$loader = require __DIR__.'/../vendor/autoload.php';

AnnotationRegistry::registerLoader([$loader, 'loadClass']);
class PHPUnit_Framework_TestCase extends \PHPUnit\Framework\TestCase {}
class PHPUnit_Util_ErrorHandler extends \PHPUnit\Util\ErrorHandler {}
class PHPUnit_Util_Test extends \PHPUnit\Util\Test {}

return $loader;
