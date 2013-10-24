# Doctrine Annotation Scanner [![Build Status](https://travis-ci.org/phramz/doctrine-annotation-scanner.png?branch=master)](https://travis-ci.org/phramz/doctrine-annotation-scanner)

Doctrine Annotation Scanner is a library to scan files and folders for annotated classes using doctrine annotations.

Install
------

It's easy if you use composer!

edit your `composer.json`

``` json
"require": {
    "phramz/doctrine-annotation-scanner": "dev-master"
}
```

or via command line

``` 
php composer.phar require phramz/doctrine-annotation-scanner
```

Example: The Finder
------
The following example will find any classfile under `/tests` that contains either `@Foo` or `@Bar` annotations in 
property, method or class-docblocks.
You can access the search result by iterating over the `Finder` instance. For each classfile you'll get an instance of 
`Symfony\Component\Finder\SplFileInfo`.
For more information about the `Finder` have a look at the Symfony2 documentation at 
http://symfony.com/doc/current/components/finder.html

``` php
<?php

use Phramz\Doctrine\Annotation\Scanner\Finder;
use Doctrine\Common\Annotations\AnnotationReader;

$reader = new AnnotationReader(); // get an instance of the doctrine annotation reader
$finder = new Finder();
$finder->containsAtLeastOneOf('Phramz\Doctrine\Annotation\Fixtures\Annotations\Foo')
    ->containsAtLeastOneOf('Phramz\Doctrine\Annotation\Fixtures\Annotations\Bar')
    ->setReader($reader)
    ->in('/tests');

/** @var Symfony\Component\Finder\SplFileInfo $file */
foreach ($finder as $file) {
    echo "Found: " . $file->getFilename(); // will output for example "Found: AnnotatedClass.php"
}
```

Example: The Scanner
------
The following example will find any classfile under `/tests` that contains either `@Foo` or `@Bar` annotations in
property, method or class-docblocks.
You can access the search result by iterating over the `Scanner` instance. For each classfile you'll get an instance of
`Phramz\Doctrine\Annotation\Scanner\ClassFileInfo` which inherits from `Symfony\Component\Finder\SplFileInfo` but
additionally offers access to the annotations of the class.

``` php
<?php

use Phramz\Doctrine\Annotation\Scanner\Scanner;
use Doctrine\Common\Annotations\AnnotationReader;

$reader = new AnnotationReader(); // get an instance of the doctrine annotation reader
$scanner = new Scanner($reader);

$scanner->scan(array(
        'Phramz\Doctrine\Annotation\Fixtures\Annotations\Foo',
        'Phramz\Doctrine\Annotation\Fixtures\Annotations\Bar'
    ))
    ->in('/tests');

/** @var Phramz\Doctrine\Annotation\Scanner\ClassFileInfo $file */
foreach ($scanner as $file) {
    echo "Found: " . $file->getFilename();    // will output for example "Found: AnnotatedClass.php"
    echo "Class: " . $file->getClassName();   // will output for example
                                              // "Class: Phramz\Annotation\AnnotatedClass"
    print_r($file->getClassAnnotations());    // will give you an array of all annotations
                                              // in the class-docblock
    print_r($file->getMethodAnnotations());   // will give you an array of all methods and
                                              // annotationss in the method-docblocks
    print_r($file->getPropertyAnnotations()); // will give you an array of all properties and
                                              // annotation in the method-docblocks
}
```

Further readings
------

http://symfony.com/doc/current/components/finder.html

http://docs.doctrine-project.org/projects/doctrine-common/en/latest/reference/annotations.html