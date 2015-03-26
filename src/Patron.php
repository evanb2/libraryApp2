<?php
    Class Patron
    {
        private $name;
        private $phone;
        private $id;

        function __construct($name, $phone, $id = null)
        {
            $this->name = $name;
            $this->phone = $phone;
            $this->id = $id;
        }

        //setters
        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function setPhone($new_phone)
        {
            $this->phone = (string) $new_phone;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

        //getters
        function getName()
        {
            return $this->name;
        }

        function getPhone()
        {
            return $this->phone;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO patrons (name, phone) VALUES ('{$this->getName()}', '{$this->getPhone()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function getAll()
        {
            $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons;");
            $patrons = array();
            foreach($returned_patrons as $patron) {
                $name = $patron['name'];
                $phone = $patron['phone'];
                $id = $patron['id'];
                $new_patron = new Patron($name, $phone, $id);
                array_push($patrons, $new_patron);
            }
            return $patrons;
        }

        static function find($search_id)
        {
            $found_patron = null;
            $patrons = Patron::getAll();
            foreach($patrons as $patron) {
                $patron_id = $patron->getId();
                if ($patron_id == $search_id) {
                    $found_patron = $patron;
                }
            }
            return $found_patron;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons *;");
        }

        function addBook($book)
        {
            $GLOBALS['DB']->exec("INSERT INTO books_patrons (book_id, patron_id)
                VALUES ({$book->getId()}, {$this->getId()});");
        }

        function getBooks()
        {
            $query = $GLOBALS['DB']->query("SELECT book_id FROM books_patrons WHERE patron_id = {$this->getId()};");
            $book_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $books = array();
            foreach($book_ids as $id) {
                $book_id = $id['book_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM books WHERE id = {$book_id};");
                $returned_book = $result->fetchAll(PDO::FETCH_ASSOC);

                $title = $returned_book[0]['title'];
                $id = $returned_book[0]['id'];
                $new_book = new Book($title, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

        //function update()

        //function deletePatron()
    }


?>
