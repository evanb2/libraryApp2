<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";
    require_once "src/Author.php";

    $DB = new PDO('pgsql:host=localhost;dbname=library_test');

    Class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Author::deleteAll();
            Book::deleteAll();
        }

        function test_getName()

        function test_getId()

        function test_save()

        function test_getAll()
    }
?>
