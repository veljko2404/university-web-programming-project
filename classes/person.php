<?php

    class Person {
        protected $name;
        protected $username;
        protected $password;

        public function __construct(string $name, string $username, string $password){
            $this->name = $name;
            $this->username = $username;
            $this->password = $password;
        }

        public function getFirstname(): string {
            return $this->name;
        }
    
        public function getSurname(): string {
            return $this->username;
        }
    
        public function getEmail(): string {
            return $this->password;
        }
    }