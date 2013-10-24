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

use Phramz\Doctrine\Annotation\Scanner\ClassFileInfo;

/**
 * Class ClassFileInfoTest
 * @package Phramz\Doctrine\Annotation\Tests\Scanner
 * @covers Phramz\Doctrine\Annotation\Scanner\ClassFileInfo
 */
class ClassFileInfoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Phramz\Doctrine\Annotation\Scanner\ClassFileInfo
     */
    private $classFileInfo = null;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $mockSplFileInfo = null;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $mockClassInspector = null;

    protected function setUp()
    {
        $this->mockSplFileInfo = $this->getMockBuilder('Symfony\Component\Finder\SplFileInfo')
            ->setMethods(array(
                'getRelativePath',
                'getRelativePathname',
                'getContents',
                'getPath',
                'getFilename',
                'getExtension',
                'getBasename',
                'getPathname',
                'getPerms',
                'getInode',
                'getSize',
                'getOwner',
                'getGroup',
                'getATime',
                'getMTime',
                'getCTime',
                'getType',
                'isWritable',
                'isReadable',
                'isExecutable',
                'isFile',
                'isDir',
                'isLink',
                'getLinkTarget',
                'getRealPath',
                'getFileInfo',
                'getPathInfo',
                'openFile',
                'setFileClass',
                'setInfoClass',
                '__toString'
            ))
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockClassInspector = $this->getMockBuilder('Phramz\Doctrine\Annotation\Scanner\ClassInspector')
            ->setMethods(array(
                'containsClassAnnotation',
                'containsMethodAnnotation',
                'containsPropertyAnnotation',
                'getClassName',
                'getClassAnnotations',
                'getMethodAnnotations',
                'getPropertyAnnotations'
            ))
            ->disableOriginalConstructor()
            ->getMock();

        $this->classFileInfo = new ClassFileInfo($this->mockSplFileInfo, $this->mockClassInspector);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('Symfony\Component\Finder\SplFileInfo', $this->classFileInfo);
    }

    public function testGetClassName()
    {
        $this->mockClassInspector->expects($this->once())
            ->method('getClassName');

        $this->classFileInfo->getClassName();
    }

    public function testGetClassAnnotations()
    {
        $this->mockClassInspector->expects($this->once())
            ->method('getClassAnnotations');

        $this->classFileInfo->getClassAnnotations();
    }

    public function testGetMethodAnnotations()
    {
        $this->mockClassInspector->expects($this->once())
            ->method('getMethodAnnotations');

        $this->classFileInfo->getMethodAnnotations();
    }

    public function testGetPropertyAnnotations()
    {
        $this->mockClassInspector->expects($this->once())
            ->method('getPropertyAnnotations');

        $this->classFileInfo->getPropertyAnnotations();
    }

    public function testGetPath()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getPath');

        $this->classFileInfo->getPath();
    }

    public function testGetFilename()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getFilename');

        $this->classFileInfo->getFilename();
    }

    public function testGetExtension()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getExtension');

        $this->classFileInfo->getExtension();
    }

    public function testGetBasename()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getBasename')
            ->with('foo');

        $this->classFileInfo->getBasename('foo');
    }

    public function testGetPathname()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getPathname');

        $this->classFileInfo->getPathname();
    }

    public function testGetPerms()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getPerms');

        $this->classFileInfo->getPerms();
    }

    public function testGetInode()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getInode');

        $this->classFileInfo->getInode();
    }

    public function testGetSize()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getSize');

        $this->classFileInfo->getSize();
    }

    public function testGetOwner()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getOwner');

        $this->classFileInfo->getOwner();
    }

    public function testGetGroup()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getGroup');

        $this->classFileInfo->getGroup();
    }

    public function testGetATime()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getATime');

        $this->classFileInfo->getATime();
    }

    public function testGetMTime()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getMTime');

        $this->classFileInfo->getMTime();
    }

    public function testGetCTime()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getCTime');

        $this->classFileInfo->getCTime();
    }

    public function testGetType()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getType');

        $this->classFileInfo->getType();
    }

    public function testIsWritable()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('isWritable');

        $this->classFileInfo->isWritable();
    }

    public function testIsReadable()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('isReadable');

        $this->classFileInfo->isReadable();
    }

    public function testIsExecutable()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('isExecutable');

        $this->classFileInfo->isExecutable();
    }

    public function testIsFile()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('isFile');

        $this->classFileInfo->isFile();
    }

    public function testIsDir()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('isDir');

        $this->classFileInfo->isDir();
    }

    public function testIsLink()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('isLink');

        $this->classFileInfo->isLink();
    }

    public function testGetLinkTarget()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getLinkTarget');

        $this->classFileInfo->getLinkTarget();
    }

    public function testGetRealPath()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getRealPath');

        $this->classFileInfo->getRealPath();
    }

    public function testGetFileInfo()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getFileInfo')
            ->with('foo');

        $this->classFileInfo->getFileInfo('foo');
    }

    public function testGetPathInfo()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getPathInfo')
            ->with('foo');

        $this->classFileInfo->getPathInfo('foo');
    }

    public function testOpenFile()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('openFile')
            ->with('foo', 'bar', 'bazz');

        $this->classFileInfo->openFile('foo', 'bar', 'bazz');
    }

    public function setFileClass()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('setFileClass')
            ->with('foo');

        $this->classFileInfo->setFileClass('foo');
    }

    public function setInfoClass()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('setInfoClass')
            ->with('foo');

        $this->classFileInfo->setInfoClass('foo');
    }

    public function testGetRelativePath()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getRelativePath');

        $this->classFileInfo->getRelativePath();
    }

    public function testGetRelativePathname()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getRelativePathname');

        $this->classFileInfo->getRelativePathname();
    }

    public function testGetContents()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('getContents');

        $this->classFileInfo->getContents();
    }

    public function testToString()
    {
        $this->mockSplFileInfo->expects($this->once())
            ->method('__toString');

        $this->classFileInfo->__toString();
    }
}
