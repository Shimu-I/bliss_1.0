<?php
session_start();
$host = 'localhost';
$dbname = 'dcm';
$username = 'root';
$password = 'admin';

try {
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
