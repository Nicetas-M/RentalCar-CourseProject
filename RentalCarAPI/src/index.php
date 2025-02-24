<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *, Authorization');
header('Access-Control-Allow-Credentials: true');
header('Content-type: application/json');

require 'connect.php';
/** @var false|resource $connect */
require 'functions.php';

$request = $_SERVER['REQUEST_URI'];
$requests = explode('/', substr($request, 1));
$method = $_SERVER['REQUEST_METHOD'];

if (count($requests) > 0) {
    switch ($method) {
        case 'GET':
            switch ($requests[0]) {
                case 'cars':
                    if (count($requests) > 1) {
                        echo getCar($connect, $requests[1]);
                        break;
                    }
                    echo getCars($connect);
                break;

                case 'users':
                    if (count($requests) > 2 && $requests[1] == 'name') {
                        echo getUserByName($connect, $requests[2]);
                        break;
                    }
                    if (count($requests) > 1) {
                        echo getUser($connect, $requests[1]);
                        break;
                    }
                    echo getUsers($connect);
                break;

                case 'requests':
                    if (count($requests) > 1) {
                        echo getRequest($connect, $requests[1]);
                        break;
                    }
                    echo getRequests($connect);
                break;
            }
        break;
        case 'POST':
            switch ($requests[0]) {
                case 'cars':
                    echo addCar($connect, $_POST);
                break;
                case 'users':
                    echo addUser($connect, $_POST);
                break;
                case 'requests':
                    echo addRequest($connect, $_POST);
                break;
            }
        break;
        case 'PATCH':
            $data = json_decode(file_get_contents('php://input'), true);
            switch ($requests[0]) {
                case 'cars':
                    echo updateCar($connect, $data);
                break;
                case 'users':
                    echo updateUser($connect, $data);
                break;
                case 'requests':
                    echo updateRequest($connect, $data);
                break;
            }
        break;
        case 'DELETE':
            if (count($requests) > 1) {
                switch ($requests[0]) {
                    case 'cars':
                        echo deleteCar($connect, $requests[1]);
                    break;
                    case 'users':
                        echo deleteUser($connect, $requests[1]);
                    break;
                    case 'requests':
                        echo deleteRequest($connect, $requests[1]);
                    break;
                }
            }
        break;
    }
}