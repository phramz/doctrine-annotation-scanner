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
use Phramz\Doctrine\Annotation\Scanner\ClassFileInfo;
use Phramz\Doctrine\Annotation\Scanner\Scanner;

/**
 * Class ScannerTest
 * @package Phramz\Doctrine\Annotation\Tests\Scanner
 * @covers Phramz\Doctrine\Annotation\Scanner\Finder
 */
class ScannerTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $scanner = new Scanner(new AnnotationReader());
        $this->assertInstanceOf('Phramz\Doctrine\Annotation\Scanner\Scanner', $scanner);
    }

    public function testGetIterator()
    {
        $scanner = new Scanner(new AnnotationReader());
        $scanner->scan(array('Phramz\Doctrine\Annotation\Fixtures\Annotations\Foo'));

        /** @var ClassFileInfo $classInfo */
        foreach ($scanner->in(__DIR__ . '/../../Fixtures') as $classInfo) {
            $this->assertEquals(
                'Phramz\Doctrine\Annotation\Fixtures\Classes\AnnotatedClass',
                $classInfo->getClassName()
            );

            $test = $classInfo->getClassAnnotations();
            $this->assertInternalType('array', $test);
            $this->assertInstanceOf('Phramz\Doctrine\Annotation\Fixtures\Annotations\Foo', $test[0]);

            $test = $classInfo->getMethodAnnotations();
            $this->assertInternalType('array', $test);
            $this->assertInternalType('array', $test['foo']);
            $this->assertInstanceOf('Phramz\Doctrine\Annotation\Fixtures\Annotations\Foo', $test['foo'][0]);
            $this->assertInternalType('array', $test['bar']);
            $this->assertInstanceOf('Phramz\Doctrine\Annotation\Fixtures\Annotations\Bar', $test['bar'][0]);
            $this->assertInternalType('array', $test['bar']);
            $this->assertInstanceOf('Phramz\Doctrine\Annotation\Fixtures\Annotations\Foo', $test['foobar'][0]);
            $this->assertInstanceOf('Phramz\Doctrine\Annotation\Fixtures\Annotations\Bar', $test['foobar'][1]);

            $test = $classInfo->getPropertyAnnotations();
            $this->assertInternalType('array', $test);
            $this->assertInternalType('array', $test['foo']);
            $this->assertInstanceOf('Phramz\Doctrine\Annotation\Fixtures\Annotations\Foo', $test['foo'][0]);
            $this->assertInternalType('array', $test['bar']);
            $this->assertInstanceOf('Phramz\Doctrine\Annotation\Fixtures\Annotations\Bar', $test['bar'][0]);
            $this->assertInternalType('array', $test['bar']);
            $this->assertInstanceOf('Phramz\Doctrine\Annotation\Fixtures\Annotations\Foo', $test['foobar'][0]);
            $this->assertInstanceOf('Phramz\Doctrine\Annotation\Fixtures\Annotations\Bar', $test['foobar'][1]);
        }
    }
}
