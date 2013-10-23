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
namespace Phramz\Doctrine\Annotation\Scanner;

use Doctrine\Common\Annotations\AnnotationReader;
use Phramz\Doctrine\Annotation\Exception\AnnotationScannerException;
use Phramz\Doctrine\Annotation\Exception\UnsupportedMethodCallException;
use Symfony\Component\Finder\Finder as BaseFinder;

/**
 * Class Finder
 * @package Phramz\Doctrine\Annotation\Scanner
 */
class Finder extends BaseFinder
{
    /**
     * @var AnnotationReader
     */
    protected $reader = null;

    /**
     * @var array
     */
    protected $containsAtLeastOneOf = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $finder = $this;
        $finder->setReader(new AnnotationReader())
            ->files()
            ->name('*.php')
            ->filter(
                function (\SplFileInfo $file) use ($finder) {
                    if (!$file->isFile()) {
                        return false;
                    }

                    try {
                        $fileInspector = new FileInspector($file->getPathname());
                        $className = $fileInspector->getFullQualifiedClassname();

                        $classInspector = new ClassInspector($className, $finder->getReader());

                        foreach ($finder->getContainsAtLeastOneOf() as $annotation) {
                            if ($classInspector->containsClassAnnotation($annotation)
                                    || $classInspector->containsMethodAnnotation($annotation)
                                    || $classInspector->containsPropertyAnnotation($annotation)) {

                                return true;
                            }
                        }

                    } catch (AnnotationScannerException $ex) {
                        return false;
                    }

                    return false;
                }
            );
    }

    /**
     * @param string $annotation
     * @return Finder
     */
    public function containsAtLeastOneOf($annotation)
    {
        $this->containsAtLeastOneOf[] = $annotation;

        return $this;
    }

    /**
     * @throws UnsupportedMethodCallException
     */
    public function directories()
    {
        throw new UnsupportedMethodCallException("the directories() method is not supported by this Finder!");
    }

    /**
     * @return Finder A new Finder instance
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @param AnnotationReader $reader
     * @return Finder
     */
    public function setReader(AnnotationReader $reader)
    {
        $this->reader = $reader;

        return $this;
    }

    /**
     * @return AnnotationReader
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * @param array $containsAtLeastOneOf
     */
    public function setContainsAtLeastOneOf(array $containsAtLeastOneOf)
    {
        $this->containsAtLeastOneOf = $containsAtLeastOneOf;
    }

    /**
     * @return array
     */
    public function getContainsAtLeastOneOf()
    {
        return $this->containsAtLeastOneOf;
    }
}
