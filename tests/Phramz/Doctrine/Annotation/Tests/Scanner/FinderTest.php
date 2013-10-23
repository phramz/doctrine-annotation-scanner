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
 * @covers
 */
class FinderTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $finder = new Finder();
        $this->assertInstanceOf('Phramz\Doctrine\Annotation\Scanner\Finder', $finder);
        $this->assertInstanceOf('Symfony\Component\Finder\Finder', $finder);
    }

    public function testFilter()
    {
        $finder = new Finder();
        $finder->containsAtLeastOneOf('Phramz\Doctrine\Annotation\Fixtures\Annotations\Bazz')
            ->containsAtLeastOneOf('Phramz\Doctrine\Annotation\Fixtures\Annotations\Bar')
            ->in(__DIR__ . '/../../Fixtures');

        $this->assertCount(1, $finder);

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $this->assertEquals('AnnotatedClass.php', $file->getFilename());
        }
    }
}
