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
        {
            //Arrange
            $name = "Charles Dickens";
            $id = 1;
            $test_author = new Author($name, $id);

            //Act
            $result = $test_author->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Charles Dickens";
            $id = 1;
            $test_author = new Author($name, $id);

            //Act
            $result = $test_author->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function test_setId()
        {
            //Arrange
            $name = "Charles Dickens";
            $id = 1;
            $test_author = new Author($name, $id);

            //Act
            $test_author->setId(2);
            $result = $test_author->getId();

            //Assert
            $this->assertEquals(2, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Charles Dickens";
            $id = 1;
            $test_author = new Author($name, $id);
            $test_author->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals($test_author, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Charles Dickens";
            $id = 1;
            $test_author = new Author($name, $id);
            $test_author->save();

            $name2 = "Tom Clancy";
            $id2 = 2;
            $test_author2 = new Author($name2, $id2);
            $test_author2->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Charles Dickens";
            $id = 1;
            $test_author = new Author($name, $id);
            $test_author->save();

            $name2 = "Tom Clancy";
            $id2 = 2;
            $test_author2 = new Author($name2, $id2);
            $test_author2->save();

            //Act
            Author::deleteAll();
            $result = Author::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Charles Dickens";
            $id = 1;
            $test_author = new Author($name, $id);
            $test_author->save();

            $name2 = "Tom Clancy";
            $id2 = 2;
            $test_author2 = new Author($name2, $id2);
            $test_author2->save();

            //Act
            $result = Author::find($test_author->getId());

            //Assert
            $this->assertEquals($test_author, $result);

        }

        function test_searchAuthors()
        {
            //Arrange
            $title = "Hunt For The Red October";
            $id = 1;
            $test_book = new Book($title, $id);
            $test_book->save();

            $title2 = "Tale of Two Cities";
            $id2 = 2;
            $test_book2 = new Book ($title2, $id2);
            $test_book2->save();

            $test_search = "Tom Clancy";

            //Act
            $books = Book::getAll();
            $result = $books->searchAuthors($test_search);

            //Assert
            $this->assertEquals($test_book, $result);
        }
    }
?>
