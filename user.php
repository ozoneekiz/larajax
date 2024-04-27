<?php

$data = [
    ["id" =>1, "name" => "John Doe 1", "email" => "jhon@gmail.com", "phone" => "1234567890"],
    ["id" =>2, "name" => "Jane Doe 2", "email" => "jane@gmail.com", "phone" => "1234567890"],
    ["id" =>3, "name" => "John Doe 3", "email" => "Jhon2@gmail.com", "phone" => "1234567890"],
    ["id" =>4, "name" => "John Doe 4", "email" => "jhon@gmail.com", "phone" => "1234567890"],
    ["id" =>6, "name" => "Jane Doe 6", "email" => "jane@gmail.com", "phone" => "1234567890"]
   
];

echo json_encode($data);