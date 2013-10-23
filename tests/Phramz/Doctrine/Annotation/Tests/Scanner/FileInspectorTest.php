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
use Phramz\Doctrine\Annotation\Scanner\FileInspector;

/**
 * Class FileInspectorTest
 * @package Phramz\Doctrine\Annotation\Tests\Scanner
 * @covers Phramz\Doctrine\Annotation\Scanner\FileInspector
 */
class FileInspectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FileInspector
     */
    protected $fileInspector;

    protected $fixtureFilename;
    protected $fixtureClassname;
    protected $fixtureFqcn;
    protected $fixtureNamespace;

    protected function setUp()
    {
        parent::setUp();

        $this->fixtureFilename = __DIR__ . '/../../Fixtures/Classes/AnnotatedClass.php';
        $this->fixtureClassname = 'AnnotatedClass';
        $this->fixtureNamespace = 'Phramz\Doctrine\Annotation\Fixtures\Classes';
        $this->fixtureFqcn = $this->fixtureNamespace . '\\' . $this->fixtureClassname;

        $this->fileInspector =  new FileInspector($this->fixtureFilename);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('Phramz\Doctrine\Annotation\Scanner\FileInspector', $this->fileInspector);
    }

    /**
     * @expectedException \Phramz\Doctrine\Annotation\Exception\FileNotFoundException
     */
    public function testConstructFileNotFoundException()
    {
        new FileInspector('not-existing-file');
    }

    public function testGetFileName()
    {
        $this->assertEquals($this->fixtureFilename, $this->fileInspector->getFilename());
    }

    public function testGetClassname()
    {
        $this->assertEquals($this->fixtureClassname, $this->fileInspector->getClassname());
    }

    public function testGetFullQualifiedClassname()
    {
        $this->assertEquals($this->fixtureFqcn, $this->fileInspector->getFullQualifiedClassname());
    }

    public function testGetNamespace()
    {
        $this->assertEquals($this->fixtureNamespace, $this->fileInspector->getNamespace());
    }
}
