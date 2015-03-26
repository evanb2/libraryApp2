<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Patron.php";
    require_once "src/Book.php";

    $DB = new PDO('pgsql:host=localhost;dbname=library_test');

    class PatronTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Patron::deleteAll();
            Book::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Tiny Tim";
            $phone = "555-345-7895";
            $id = 2;
            $test_patron = new Patron($name, $phone, $id);

            //Act
            $result = $test_patron->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getPhone()
        {
            //Arrange
            $name = "Tiny Tim";
            $phone = "555-345-7895";
            $id = 2;
            $test_patron = new Patron($name, $phone, $id);

            //Act
            $result = $test_patron->getPhone();

            //Assert
            $this->assertEquals($phone, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Tiny Tim";
            $phone = "555-345-7895";
            $id = 2;
            $test_patron = new Patron($name, $phone, $id);

            //Act
            $result = $test_patron->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function test_setName()
        {
            //Arrange
            $name = "Tiny Tim";
            $phone = "555-345-7895";
            $id = 2;
            $test_patron = new Patron($name, $phone, $id);

            //Act
            $test_patron->setName("Yarbles");
            $result = $test_patron->getName();

            //Assert
            $this->assertEquals("Yarbles", $result);
        }

        function test_setPhone()
        {
            //Arrange
            $name = "Tiny Tim";
            $phone = "555-345-7895";
            $id = 2;
            $test_patron = new Patron($name, $phone, $id);

            //Act
            $test_patron->setPhone("123-921-2189");
            $result = $test_patron->getPhone();

            //Assert
            $this->assertEquals("123-921-2189", $result);
        }

        function test_setId()
        {
            //Arrange
            $name = "Tiny Tim";
            $phone = "555-345-7895";
            $id = 2;
            $test_patron = new Patron($name, $phone, $id);

            //Act
            $test_patron->setId(3);
            $result = $test_patron->getId();

            //Assert
            $this->assertEquals(3, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Tiny Tim";
            $phone = "555-345-7895";
            $id = 2;
            $test_patron = new Patron($name, $phone, $id);

            //Act
            $test_patron->save();

            //Assert
            $result = Patron::getAll();
            $this->assertEquals($test_patron, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Tiny Tim";
            $phone = "555-345-7895";
            $id = 2;
            $test_patron = new Patron($name, $phone, $id);
            $test_patron->save();

            $name2 = "Jimmy John";
            $phone2 = "892-382-1910";
            $id2 = 3;
            $test_patron2 = new Patron($name2, $phone2, $id2);
            $test_patron2->save();

            //Act
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([$test_patron, $test_patron2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Tiny Tim";
            $phone = "555-345-7895";
            $id = 2;
            $test_patron = new Patron($name, $phone, $id);
            $test_patron->save();

            $name2 = "Jimmy John";
            $phone2 = "892-382-1910";
            $id2 = 3;
            $test_patron2 = new Patron($name2, $phone2, $id2);
            $test_patron2->save();

            //Act
            Patron::deleteAll();

            //Assert
            $result = Patron::getAll();
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Tiny Tim";
            $phone = "555-345-7895";
            $id = 2;
            $test_patron = new Patron($name, $phone, $id);
            $test_patron->save();

            $name2 = "Jimmy John";
            $phone2 = "892-382-1910";
            $id2 = 3;
            $test_patron2 = new Patron($name2, $phone2, $id2);
            $test_patron2->save();

            //Act
            $result = Patron::find($test_patron->getId());

            //Assert
            $this->assertEquals($test_patron, $result);
        }

        function test_addBook()
        {
            //Arrange
            $title = "Hunt For The Red October";
            $id = 1;
            $test_book = new Book($title, $id);
            $test_book->save();

            $name = "Jimmy John";
            $phone = "892-382-1910";
            $id2 = 3;
            $test_patron = new Patron($name, $phone, $id2);
            $test_patron->save();

            //Act
            $test_patron->addBook($test_book);

            //Assert
            $this->assertEquals($test_patron->getBooks(), [$test_book]);
        }

        function test_getBooks()
        {
            //Arrange
            $title = "Tale of Two cities";
            $id = 2;
            $test_book = new Book($title, $id);
            $test_book->save();

            $title2 = "Hunt For The Red October";
            $id2 = 1;
            $test_book2 = new Book($title2, $id2);
            $test_book2->save();

            $name = "Tiny Tim";
            $phone = "999-9999";
            $id3 = 3;
            $test_patron = new Patron($name, $phone, $id3);
            $test_patron->save();

            //Act
            $test_patron->addBook($test_book);
            $test_patron->addBook($test_book2);

            //Assert
            $this->assertEquals($test_patron->getBooks(), [$test_book, $test_book2]);
        }

        //function test_deletePatron()

        //function test_update()
    }
?>
