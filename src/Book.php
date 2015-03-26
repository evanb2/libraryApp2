<?php
    Class Book
    {
        private $title;
        private $id;

        function __construct($title, $id = null)
        {
            $this->title = $title;
            $this->id = $id;
        }
        //setters
        function setTitle($new_title)
        {
            $this->title = (string) $new_title;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }
        //getters
        function getTitle()
        {
            return $this->title;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO books (title)
                VALUES ('{$this->getTitle()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        function addPatron($patron)
        {
            $GLOBALS['DB']->exec("INSERT INTO books_patrons (book_id, patron_id)
                VALUES ({$this->getId()}, {$patron->getId()});");
        }

        function getPatrons()
        {
            $query = $GLOBALS['DB']->query("SELECT patron_id FROM books_patrons WHERE
                book_id = {$this->getId()};");
            $patron_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $patrons = array();
            foreach($patron_ids as $id) {
                $patron_id = $id['patron_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM patrons WHERE id = {$patron_id};");
                $returned_patron = $result->fetchAll(PDO::FETCH_ASSOC);

                $name = $returned_patron[0]['name'];
                $phone = $returned_patron[0]['phone'];
                $id = $returned_patron[0]['id'];
                $new_patron = new Patron($name, $phone, $id);
                array_push($patrons, $new_patron);
            }
            return $patrons;
        }

        static function getAll()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
            $books = array();
            foreach($returned_books as $book) {
                $title = $book['title'];
                $id = $book['id'];
                $new_book = new Book($title, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

        static function find($search_id)
        {
            $found_book = null;
            $books = Book::getAll();
            foreach($books as $book) {
                $book_id = $book->getId();
                if ($book_id == $search_id) {
                    $found_book = $book;
                }
            }
            return $found_book;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM books*;");
            $GLOBALS['DB']->exec("DELETE FROM books_patrons*;");
        }

        function updateTitle($new_title)
        {
            $GLOBALS['DB']->exec("UPDATE books SET title = '{$new_title}' WHERE id = {$this->getId()};");
            $this->setTitle($new_title);
        }

        function deleteBook()
        {
            $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM books_patrons WHERE book_id = {$this->getId()};");
        }
    }
?>
