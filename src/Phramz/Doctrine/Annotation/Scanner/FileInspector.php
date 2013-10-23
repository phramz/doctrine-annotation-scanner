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

use Phramz\Doctrine\Annotation\Exception\FileNotFoundException;

/**
 * Class FileInspector
 * @package Phramz\Doctrine\Annotation\Scanner
 */
class FileInspector
{
    private $filename = null;
    private $classname = null;
    private $namespace = null;

    /**
     * @param string $filename The file to inspect
     * @throws FileNotFoundException
     */
    public function __construct($filename)
    {
        if (!is_file($filename)) {
            throw new FileNotFoundException(sprintf("cannot find file %s", $filename));
        }

        $tokens = token_get_all(file_get_contents($filename));

        $this->classname =  basename($filename, '.php');
        $this->namespace = $this->parseNamespace($tokens);
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getFullQualifiedClassname()
    {
        return "{$this->namespace}\\{$this->classname}";
    }

    /**
     * @return string
     */
    public function getClassname()
    {
        return $this->classname;
    }

    /**
     * @return null|string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Extracts the namespace from tokenized file
     * @param array $tokens
     * @return string|null the classname or null
     */
    private function parseNamespace($tokens)
    {
        $namespace = null;
        for ($offset=0; $offset < count($tokens); $offset++) {
            if (!is_array($tokens[$offset])) {
                continue;
            }

            if (T_NAMESPACE === $tokens[$offset][0]) {
                $offset++; // the next token is a whitespace

                return $this->parseNamespaceString($tokens, $offset);
            }
        }

        return $namespace;
    }

    /**
     * Extracts the namespace from tokenized file
     * @param array $tokens
     * @param integer $offset
     * @return string
     */
    private function parseNamespaceString($tokens, $offset)
    {
        $namespace = '';

        for ($offset++; $offset < count($tokens); $offset++) {
            // expecting T_STRING
            if (!is_array($tokens[$offset])) {
                break;
            }

            if (isset($tokens[$offset][0]) && T_STRING === $tokens[$offset][0]) {
                $namespace .= $tokens[$offset][1];
            } else {
                break;
            }

            // expecting T_NS_SEPARATOR
            $offset++;
            if (!is_array($tokens[$offset])) {
                continue;
            }

            if (isset($tokens[$offset][0]) && T_NS_SEPARATOR === $tokens[$offset][0]) {
                $namespace .= $tokens[$offset][1];
            } else {
                break;
            }
        }

        return $namespace;
    }
}
