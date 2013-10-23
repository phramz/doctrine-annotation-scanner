<?php
/**
 * Copyright (c) 2012-2013 Maximilian Reichel <info@phramz.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace Phramz\Doctrine\Annotation\Tests\Scanner;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use Phramz\Doctrine\Annotation\Fixtures\Annotations\Bar;
use Phramz\Doctrine\Annotation\Fixtures\Annotations\Foo;
use Phramz\Doctrine\Annotation\Scanner\ClassInspector;

/**
 * Class ClassInspectorTest
 * @package Phramz\Doctrine\Annotation\Tests\Scanner
 * @covers Phramz\Doctrine\Annotation\Scanner\ClassInspector
 */
class ClassInspectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClassInspector
     */
    protected $classInspector;

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var string
     */
    protected $fixtureClassname;

    protected function setUp()
    {
        parent::setUp();

        $this->fixtureClassname = 'Phramz\Doctrine\Annotation\Fixtures\Classes\AnnotatedClass';

        $this->reader = new AnnotationReader(); // TODO mock that
        $this->classInspector =  new ClassInspector($this->fixtureClassname, $this->reader);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('Phramz\Doctrine\Annotation\Scanner\ClassInspector', $this->classInspector);
    }

    /**
     * @expectedException \Phramz\Doctrine\Annotation\Exception\ClassNotFoundException
     */
    public function testConstructClassNotFoundException()
    {
        new ClassInspector('NonExistingClass', $this->reader);
    }

    public function testContainsClassAnnotation()
    {
        $this->assertTrue($this->classInspector->containsClassAnnotation(Foo::className()));
        $this->assertFalse($this->classInspector->containsClassAnnotation(Bar::className()));
    }

    public function testContainsMethodAnnotation()
    {
        $this->assertTrue($this->classInspector->containsMethodAnnotation(Foo::className()));
        $this->assertTrue($this->classInspector->containsMethodAnnotation(Bar::className()));
        $this->assertFalse($this->classInspector->containsClassAnnotation('whatever'));
    }

    public function testContainsPropertyAnnotation()
    {
        $this->assertTrue($this->classInspector->containsPropertyAnnotation(Foo::className()));
        $this->assertTrue($this->classInspector->containsPropertyAnnotation(Bar::className()));
        $this->assertFalse($this->classInspector->containsPropertyAnnotation('whatever'));
    }
}
