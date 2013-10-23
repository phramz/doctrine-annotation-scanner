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

use Doctrine\Common\Annotations\Reader;
use Phramz\Doctrine\Annotation\Exception\ClassNotFoundException;

/**
 * Class ClassInspector
 * @package Phramz\Doctrine\Annotation\Scanner
 */
class ClassInspector
{
    /**
     * @var null|string
     */
    private $classname = null;

    /**
     * @var Reader
     */
    private $reader = null;

    /**
     * @var \ReflectionClass
     */
    private $reflectionClass = null;

    /**
     * @var array|\ReflectionMethod[]
     */
    private $reflectionMethods = array();

    /**
     * @var array|\ReflectionProperty[]
     */
    private $reflectionProperties = array();

    /**
     * @var null|array
     */
    private $classAnnotations = null;

    /**
     * @var null|array
     */
    private $methodAnnotations = null;

    /**
     * @var null|array
     */
    private $propertyAnnotations = null;

    /**
     * @param string $classname The class to inspect
     * @param Reader $reader The annotation reader
     * @throws \Phramz\Doctrine\Annotation\Exception\ClassNotFoundException
     */
    public function __construct($classname, Reader $reader)
    {
        if (!class_exists($classname)) {
            throw new ClassNotFoundException(sprintf("cannot find class %s", $classname));
        }

        $this->classname = $classname;
        $this->reader = $reader;

        $this->reflectionClass = new \ReflectionClass($classname);
        $this->reflectionMethods = $this->reflectionClass->getMethods();
        $this->reflectionProperties = $this->reflectionClass->getProperties();
    }

    /**
     * Returns TRUE if the class is annotated with the given annotationName
     * @param string $annotationName
     * @return bool
     */
    public function containsClassAnnotation($annotationName)
    {
        if (null === $this->classAnnotations) {
            $this->classAnnotations = $this->reader->getClassAnnotations($this->reflectionClass);
        }

        foreach ($this->classAnnotations as $annotation) {
            if ($annotation instanceof $annotationName) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns TRUE if any of the class-methods is annotated with the given annotationName
     * @param string $annotationName
     * @return bool
     */
    public function containsMethodAnnotation($annotationName)
    {
        if (null === $this->methodAnnotations) {
            $this->methodAnnotations = array();

            /** @var \ReflectionMethod $reflectionMethod */
            foreach ($this->reflectionMethods as $reflectionMethod) {
                $this->methodAnnotations[$reflectionMethod->getName()]
                    = $this->reader->getMethodAnnotations($reflectionMethod);
            }
        }

        foreach ($this->methodAnnotations as $annotations) {
            foreach ($annotations as $annotation) {
                if ($annotation instanceof $annotationName) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Returns TRUE if any of the class-properties is annotated with the given annotationName
     * @param string $annotationName
     * @return bool
     */
    public function containsPropertyAnnotation($annotationName)
    {
        if (null === $this->propertyAnnotations) {
            $this->propertyAnnotations = array();

            /** @var \ReflectionProperty $reflectionProperty */
            foreach ($this->reflectionProperties as $reflectionProperty) {
                $this->propertyAnnotations[$reflectionProperty->getName()]
                    = $this->reader->getPropertyAnnotations($reflectionProperty);
            }
        }

        foreach ($this->propertyAnnotations as $annotations) {
            foreach ($annotations as $annotation) {
                if ($annotation instanceof $annotationName) {
                    return true;
                }
            }
        }

        return false;
    }
}
