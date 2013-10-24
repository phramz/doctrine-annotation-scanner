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
use Phramz\Doctrine\Annotation\Scanner\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class FinderTest
 * @package Phramz\Doctrine\Annotation\Tests\Scanner
 * @covers Phramz\Doctrine\Annotation\Scanner\Finder
 */
class FinderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Finder
     */
    protected $finder = null;

    protected function setUp()
    {
        $this->finder = new Finder();
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('Phramz\Doctrine\Annotation\Scanner\Finder', $this->finder);
        $this->assertInstanceOf('Symfony\Component\Finder\Finder', $this->finder);
    }

    public function testFilter()
    {
        $this->finder->containsAtLeastOneOf('Phramz\Doctrine\Annotation\Fixtures\Annotations\Bazz')
            ->containsAtLeastOneOf('Phramz\Doctrine\Annotation\Fixtures\Annotations\Bar')
            ->in(__DIR__ . '/../../Fixtures');

        $this->assertCount(1, $this->finder);

        /** @var SplFileInfo $file */
        foreach ($this->finder as $file) {
            $this->assertEquals('AnnotatedClass.php', $file->getFilename());
        }
    }

    public function testContainsAtLeastOneOf()
    {
        $this->assertSame($this->finder, $this->finder->containsAtLeastOneOf('foo'));
        $this->assertEquals(array('foo'), $this->finder->getContainsAtLeastOneOf());
    }

    /**
     * @expectedException \Phramz\Doctrine\Annotation\Exception\UnsupportedMethodCallException
     */
    public function testDirectories()
    {
        $this->finder->directories();
    }

    public function testCreate()
    {
        $this->assertInstanceOf('Phramz\Doctrine\Annotation\Scanner\Finder', $this->finder->create());
    }

    public function testGetSetReader()
    {
        $reader = $this->getMockBuilder('Doctrine\Common\Annotations\Reader')
            ->getMockForAbstractClass();

        $this->assertSame($this->finder, $this->finder->setReader($reader));
        $this->assertSame($reader, $this->finder->getReader());

    }

    public function testGetSetContainsAtLeastOneOf()
    {
        $test = array('foo');

        $this->assertSame($this->finder, $this->finder->setContainsAtLeastOneOf($test));
        $this->assertSame($test, $this->finder->getContainsAtLeastOneOf());

    }
}
