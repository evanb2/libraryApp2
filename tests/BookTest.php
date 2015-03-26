<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";
    require_once "src/Patron.php";

    $DB = new PDO('pgsql:host=localhost;dbname=library_test');

    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
            Patron::deleteAll();
        }

        function test_getTitle()
        {
            //Arrange
            $title = "Hunt For The Red October";
            $id = 1;
            $test_book = new Book($title, $id);

            //Act
            $result = $test_book->getTitle();

            //Assert
            $this->assertEquals($title, $result);
        }

        function test_getId()
        {
            //Arrange
            $title = "Hunt For The Red October";
            $id = 1;
            $test_book = new Book($title, $id);

            //Act
            $result = $test_book->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function test_setId()
        {
            //Arrange
            $title = "Hunt For The Red October";
            $id = 1;
            $test_book = new Book($title, $id);

            //Act
            $test_book->setId(1);

            //Assert
            $result = $test_book->getId();
            $this->assertEquals(1, $result);
        }

        function test_save()
        {
            //Arrange
            $title = "Hunt For The Red October";
            $id = 1;
            $test_book = new Book($title, $id);
            $test_book->save();

            //Act
            $result= Book::getAll();

            //Assert
            $this->assertEquals($test_book, $result[0]);

        }

        function test_getAll()
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

            //Act
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }

        function test_deleteAll()
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

            //Act
            Book::deleteAll();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([], $result);

        }

        function test_find()
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

            //Act
            $result = Book::find($test_book->getId());

            //Assert
            $this->assertEquals($test_book, $result);
        }

        function test_addPatron()
        {
            //Arrange
            $title = "Hunt For The Red October";
            $id = 1;
            $test_book = new Book($title, $id);
            $test_book->save();

            $name = "Tiny Tim";
            $phone = "555-345-7895";
            $id2 = 2;
            $test_patron = new Patron($name, $phone, $id2);
            $test_patron->save();

            //Act
            $test_book->addPatron($test_patron);

            //Assert
            $this->assertEquals($test_book->getPatrons(), [$test_patron]);
        }

        function test_getPatrons()
        {
            //Arrange
            $title = "Hunt For The Red October";
            $id = 1;
            $test_book = new Book($title, $id);
            $test_book->save();

            $name = "Tiny Tim";
            $phone = "555-345-7895";
            $id2 = 2;
            $test_patron = new Patron($name, $phone, $id2);
            $test_patron->save();

            $name2 = "Jimmy John";
            $phone2 = "892-382-1910";
            $id3 = 3;
            $test_patron2 = new Patron($name2, $phone2, $id3);
            $test_patron2->save();

            //Act
            $test_book->addPatron($test_patron);
            $test_book->addPatron($test_patron2);

            //Assert
            $this->assertEquals($test_book->getPatrons(), [$test_patron, $test_patron2]);
        }

        function test_updateTitle()
        {
            //Arrange
            $title = "Hunt For The Red October";
            $id = 1;
            $test_book = new Book($title, $id);
            $test_book->save();

            $new_title = "Alec Baldwin Saves the World";

            //Act
            $test_book->updateTitle($new_title);

            //Assert
            $this->assertEquals("Alec Baldwin Saves the World", $test_book->getTitle());
        }

        function test_deleteBook()
        {
            //Arrange
            $title = "Hunt For The Red October";
            $id = 1;
            $test_book = new Book($title, $id);
            $test_book->save();

            $name = "Tiny Tim";
            $phone = "555-345-7895";
            $id2 = 2;
            $test_patron = new Patron($name, $phone, $id2);
            $test_patron->save();

            //Act
            $test_book->addPatron($test_patron);
            $test_book->deleteBook();

            //Assert
            $this->assertEquals([], $test_patron->getBooks());
        }

        // function test_searchAuthor()
        // {
        //     //Arrange
        //     $title = "Hunt For The Red October";
        //     $id = 1;
        //     $test_book = new Book($title, $id);
        //     $test_book->save();
        //
        //     $title2 = "Tale of Two Cities";
        //     $id2 = 2;
        //     $test_book2 = new Book ($title2, $id2);
        //     $test_book2->save();
        //
        //     $test_search = "Tom Clancy";
        //
        //     //Act
        //     $books = Book::getAll();
        //     $result = $books->searchAuthor($test_search);
        //
        //     //Assert
        //     $this->assertEquals($test_book, $result);
        // }
    }
?>
