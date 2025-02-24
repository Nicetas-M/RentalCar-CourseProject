<?php

/*
 * Arrays
 */
function resultListToJson($result) {
    $list = [];
    while ($listElement = pg_fetch_assoc($result)) {
        $list[] = $listElement;
    }
    return json_encode($list);
}

function resultToJson($result) {
    return json_encode(pg_fetch_assoc($result));
}


/*
 * Table: Cars
 */
function getCars($connect) {
    return resultListToJson(pg_query($connect, "SELECT * FROM Cars"));
}

function getCar($connect, $id) {
    return resultToJson(pg_query($connect, "SELECT * FROM Cars WHERE id = $id"));
}

function addCar($connect, $data) {
    $name = $data['name'];
    $horsepower = $data['horsepower'];
    $enginecapacity = $data['enginecapacity'];
    $price = $data['price'];

    $qresult = pg_query($connect, "INSERT INTO Cars (name, horsepower, enginecapacity, price) "
        . "VALUES ('$name', $horsepower, $enginecapacity, $price) RETURNING id");

    $res = null;
    if ($qresult) {
        http_response_code(201);
        $row = pg_fetch_assoc($qresult);
        $res = [
            "status" => "success",
            "id" => $row['id']
        ];
    } else {
        http_response_code(500);
        $res = [
            "status" => "failure",
            "id" => null
        ];
    }

    return json_encode($res);
}

function updateCar($connect, $data) {
    $id = $data['id'];
    $name = $data['name'];
    $horsepower = $data['horsepower'];
    $enginecapacity = $data['enginecapacity'];
    $price = $data['price'];

    $qresult = pg_query($connect, "UPDATE Cars SET name = '$name', horsepower =  $horsepower, "
        . "enginecapacity = $enginecapacity, price = $price WHERE id = $id");

    $res = null;
    if ($qresult) {
        http_response_code(201);
        $res = [
            "status" => "success",
            "id" => $id
        ];
    } else {
        http_response_code(500);
        $res = [
            "status" => "failure",
            "id" => $id
        ];
    }

    return json_encode($res);
}

function deleteCar($connect, $id) {
    return resultToJson(pg_query($connect, "DELETE FROM Cars WHERE id = $id"));
}


/*
 * Table: Users
 */
function getUsers($connect) {
    return resultListToJson(pg_query($connect, "SELECT * FROM Users"));
}

function getUser($connect, $id) {
    return resultToJson(pg_query($connect, "SELECT * FROM Users WHERE id = $id"));
}

function getUserByName($connect, $name) {
    return resultToJson(pg_query($connect, "SELECT * FROM Users WHERE name = '$name'"));
}

function addUser($connect, $data) {
    $name = $data['name'];
    $password = $data['password'];
    $age = $data['age'];
    $phone = $data['phone'];

    $qresult = pg_query($connect, "INSERT INTO Users (name, password, age, phone) "
        . "VALUES ('$name', '$password', $age, '$phone') RETURNING id");

    $res = null;
    if ($qresult) {
        http_response_code(201);
        $row = pg_fetch_assoc($qresult);
        $res = [
            "status" => "success",
            "id" => $row['id']
        ];
    } else {
        http_response_code(500);
        $res = [
            "status" => "failure",
            "id" => null
        ];
    }

    return json_encode($res);
}

function updateUser($connect, $data) {
    $id = $data['id'];
    $name = $data['name'];
    $password = $data['password'];
    $age = $data['age'];
    $phone = $data['phone'];

    $qresult = pg_query($connect, "UPDATE Users SET name = '$name', password = '$password', age = $age,"
        . " phone = $phone WHERE id = $id ");

    $res = null;
    if ($qresult) {
        http_response_code(201);
        $res = [
            "status" => "success",
            "id" => $id
        ];
    } else {
        http_response_code(500);
        $res = [
            "status" => "failure",
            "id" => $id
        ];
    }

    return json_encode($res);
}

function deleteUser($connect, $id) {
    return resultToJson(pg_query($connect, "DELETE FROM Users WHERE id = $id"));
}

/*
 * Table: Requests
 */
function getRequests($connect) {
    return resultListToJson(pg_query($connect, "SELECT * FROM Requests"));
}

function getRequest($connect, $id) {
    return rsultToJson(pg_query($connect, "SELECT * FROM Requests WHERE id = $id"));
}

function addRequest($connect, $data) {
    $userid = $data['userid'];
    $carid = $data['carid'];
    $startdate = $data['startdate'];
    $enddate = $data['enddate'];

    $qresult = pg_query($connect, "INSERT INTO Requests (userid, carid, startdate, enddate) "
        . "VALUES ($userid, $carid, '$startdate', '$enddate') RETURNING id");

    $res = null;
    if ($qresult) {
        http_response_code(201);
        $row = pg_fetch_assoc($qresult);
        $res = [
            "status" => "success",
            "id" => $row['id']
        ];
    } else {
        http_response_code(500);
        $res = [
            "status" => "failure",
            "id" => null
        ];
    }

    return json_encode($res);
}

function updateRequest($connect, $data) {
    $id = $data['id'];
    $userid = $data['userid'];
    $carid = $data['carid'];
    $startdate = $data['startdate'];
    $enddate = $data['enddate'];

    $qresult = pg_query($connect, "UPDATE Requests SET userid = $userid, cardid = $carid, "
        . " startdate = '$startdate', enddate = '$enddate' WHERE id = $id");

    $res = null;
    if ($qresult) {
        http_response_code(201);
        $row = pg_fetch_assoc($qresult);
        $res = [
            "status" => "success",
            "id" => $row['id']
        ];
    } else {
        http_response_code(500);
        $res = [
            "status" => "failure",
            "id" => null
        ];
    }

    return json_encode($res);
}

function deleteRequest($connect, $id) {
    return resultToJson(pg_query($connect, "DELETE FROM Requests WHERE id = $id"));
}