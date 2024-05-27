<?php
session_start();
include_once "config.php";
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$connection) {
    echo mysqli_error($connection);
    throw new Exception("Database cannot Connect");
} else {
    $action = $_REQUEST['action'] ?? '';

    if ('addUser' == $action) {
        $fname = $_REQUEST['fname'] ?? '';
        $lname = $_REQUEST['lname'] ?? '';
        $username = $_REQUEST['username'] ?? '';
        $password = $_REQUEST['password'] ?? '';
        $role = $_REQUEST['role'] ?? '';

        if ($fname && $lname && $username && $password && $role) {
            $hashPassword = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO users(fname,lname,username,password,role) VALUES ('{$fname}','{$lname}','{$username}','{$hashPassword}','{$role}')";
            mysqli_query($connection, $query);
            header("location:index.php?id=allUser");
        }
    } elseif ('updateUser' == $action) {
        $id = $_REQUEST['id'] ?? '';
        $fname = $_REQUEST['fname'] ?? '';
        $lname = $_REQUEST['lname'] ?? '';
        $username = $_REQUEST['username'] ?? '';
        $role = $_REQUEST['role'] ?? '';

        if ($fname && $lname && $username && $role) {
            $query = "UPDATE users SET fname='{$fname}', lname='{$lname}', username='{$username}', role='{$role}' WHERE id='{$id}'";
            mysqli_query($connection, $query);
            header("location:index.php?id=allUser");
        }
    } elseif ('allUser' == $action) {
        $query = "SELECT * FROM users";
        $result = mysqli_query($connection, $query);
        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
        foreach ($users as $user) {
            echo "Name: ";
            if (!empty($user['fname']) && !empty($user['lname'])) {
                echo $user['fname'] . " " . $user['lname'];
            }
            echo ", Username: ";
            if (!empty($user['username'])) {
                echo $user['username'];
            }
            echo ", Role: ";
            if (!empty($user['role'])) {
                echo $user['role'];
            }
            echo "<br>";
        }
    }
}

if ('addEvent' == $action) {
    $eventType = $_REQUEST['eventType'] ?? '';
    $eventTime = $_REQUEST['eventTime'] ?? '';
    $personName = $_REQUEST['personName'] ?? '';
    $doorName = $_REQUEST['doorName'] ?? '';
    $doorIndexCode = $_REQUEST['doorIndexCode'] ?? '';
    $checkInAndOutType = $_REQUEST['checkInAndOutType'] ?? '';

    if ($eventType && $eventTime && $personName && $doorName && $doorIndexCode && $checkInAndOutType) {
        $query = "INSERT INTO events(eventType, eventTime, personName, doorName, doorIndexCode, checkInAndOutType) VALUES ('{$eventType}', '{$eventTime}', '{$personName}', '{$doorName}', '{$doorIndexCode}', '{$checkInAndOutType}')";
        mysqli_query($connection, $query);
        header("location:index.php?id=allEvent");
    }
} elseif ('updateEvent' == $action) {
    $eventId = $_REQUEST['eventId'] ?? '';
    $eventType = $_REQUEST['eventType'] ?? '';
    $eventTime = $_REQUEST['eventTime'] ?? '';
    $personName = $_REQUEST['personName'] ?? '';
    $doorName = $_REQUEST['doorName'] ?? '';
    $doorIndexCode = $_REQUEST['doorIndexCode'] ?? '';
    $checkInAndOutType = $_REQUEST['checkInAndOutType'] ?? '';

    if ($eventType && $eventTime && $personName && $doorName && $doorIndexCode && $checkInAndOutType) {
        $query = "UPDATE events SET eventType='{$eventType}', eventTime='{$eventTime}', personName='{$personName}', doorName='{$doorName}', doorIndexCode='{$doorIndexCode}', checkInAndOutType='{$checkInAndOutType}' WHERE eventId='{$eventId}'";
        mysqli_query($connection, $query);
        header("location:index.php?id=allEvent");
    }   
} elseif ('allEvent' == $action) {
    $query = "SELECT * FROM events";
    $result = mysqli_query($connection, $query);
    $events = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($events as $event) {
        echo "Event Type: " . $event['eventType'] . ", Event Time: " . $event['eventTime'] . ", Person Name: " . $event['personName'] . ", Door Name: " . $event['doorName'] . ", Door Index Code: " . $event['doorIndexCode'] . ", Check In And Out Type: " . $event['checkInAndOutType'] . "<br>";
    }
}



if ('addEmployees' == $action) {
    $personCode = $_REQUEST['personCode'] ?? '';
    $personName = $_REQUEST['personName'] ?? '';
    $personFamily = $_REQUEST['personFamily'] ?? '';
    $personGivenName = $_REQUEST['personGivenName'] ?? '';
    $personId = $_REQUEST['personId'] ?? '';
    $department = $_REQUEST['department'] ?? '';

    if ($personCode && $personName && $personFamily && $personGivenName && $personId && $department) {
        $query = "INSERT INTO employees(personCode, personName, personFamily, personGivenName, personId, department) VALUES ('{$personCode}', '{$personName}', '{$personFamily}', '{$personGivenName}', '{$personId}', '{$department}')";
        mysqli_query($connection, $query);
        header("location:index.php?id=allEmployees");
    }
}


elseif ('updateEmployees' == $action) {
    $personId = $_REQUEST['personId'] ?? '';
    $personCode = $_REQUEST['personCode'] ?? '';
    $personName = $_REQUEST['personName'] ?? '';
    $personFamily = $_REQUEST['personFamily'] ?? '';
    $personGivenName = $_REQUEST['personGivenName'] ?? '';
    $department = $_REQUEST['department'] ?? '';

    if ($personCode && $personName && $personFamily && $personGivenName && $department) {
        $query = "UPDATE employees SET personCode='{$personCode}', personName='{$personName}', personFamily='{$personFamily}', personGivenName='{$personGivenName}', department='{$department}' WHERE personId='{$personId}'";
        mysqli_query($connection, $query);
        header("location:index.php?id=allEmployees");
    }
}

elseif ('allEmployees' == $action) {
    $query = "SELECT * FROM employees";
    $result = mysqli_query($connection, $query);
    $employees = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($employees as $employee) {
        echo "Person Code: " . $employee['personCode'] . ", Person Name: " . $employee['personName'] . ", Person Family: " . $employee['personFamily'] . ", Person Given Name: " . $employee['personGivenName'] . ", Person ID: " . $employee['personId'] . ", Department: " . $employee['department'] . "<br>";
    }
}





if ('addAttendance' == $action) {
    $eventId = $_REQUEST['eventId'] ?? '';
    $eventType = $_REQUEST['eventType'] ?? '';
    $personName = $_REQUEST['personName'] ?? '';
    $personCode = $_REQUEST['personCode'] ?? '';
    $checkIn = $_REQUEST['checkIn'] ?? '';
    $checkOut = $_REQUEST['checkOut'] ?? '';

    if ($eventId && $eventType && $personName && $personCode && $checkIn && $checkOut) {
        $query = "INSERT INTO attendance(eventId, eventType, personName, personCode, checkIn, checkOut) VALUES ('{$eventId}', '{$eventType}', '{$personName}', '{$personCode}', '{$checkIn}', '{$checkOut}')";
        mysqli_query($connection, $query);
        header("location:index.php?id=allAttendance");
    }
}

elseif ('updateAttendance' == $action) {
    $eventId = $_REQUEST['eventId'] ?? '';
    $eventType = $_REQUEST['eventType'] ?? '';
    $personName = $_REQUEST['personName'] ?? '';
    $personCode = $_REQUEST['personCode'] ?? '';
    $checkIn = $_REQUEST['checkIn'] ?? '';
    $checkOut = $_REQUEST['checkOut'] ?? '';

    if ($eventId && $eventType && $personName && $personCode && $checkIn && $checkOut) {
        $query = "UPDATE attendance SET eventType='{$eventType}', personName='{$personName}', personCode='{$personCode}', checkIn='{$checkIn}', checkOut='{$checkOut}' WHERE eventId='{$eventId}'";
        mysqli_query($connection, $query);
        header("location:index.php?id=allAttendance");
    }
}

elseif ('allAttendance' == $action) {
    $query = "SELECT * FROM attendance";
    $result = mysqli_query($connection, $query);
    $attendances = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($attendances as $attendance) {
        echo "Event ID: " . $attendance['eventId'] . ", Event Type: " . $attendance['eventType'] . ", Person Name: " . $attendance['personName'] . ", Person Code: " . $attendance['personCode'] . ", Check In: " . $attendance['checkIn'] . ", Check Out: " . $attendance['checkOut'] . "<br>";
    }
}


if ('addDepartment' == $action) {
    $namaDepartement = $_REQUEST['namaDepartement'] ?? '';
    $tanggalPembuatan = $_REQUEST['tanggalPembuatan'] ?? '';

    if ($namaDepartement && $tanggalPembuatan) {
        $query = "INSERT INTO department(namaDepartement, tanggalPembuatan) VALUES ('{$namaDepartement}', '{$tanggalPembuatan}')";
        mysqli_query($connection, $query);
        header("location:index.php?id=allDepartment");
    }
}

elseif ('updateDepartment' == $action) {
    $id = $_REQUEST['id'] ?? '';
    $namaDepartement = $_REQUEST['namaDepartement'] ?? '';
    $tanggalPembuatan = $_REQUEST['tanggalPembuatan'] ?? '';

    if ($id && $namaDepartement && $tanggalPembuatan) {
        $query = "UPDATE department SET namaDepartement='{$namaDepartement}', tanggalPembuatan='{$tanggalPembuatan}' WHERE id='{$id}'";
        mysqli_query($connection, $query);
        header("location:index.php?id=allDepartment");
    }
}

elseif ('allDepartment' == $action) {
    $query = "SELECT * FROM department";
    $result = mysqli_query($connection, $query);
    $departments = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($departments as $department) {
        echo "Department ID: " . $department['id'] . ", Department Name: " . $department['namaDepartement'] . ", Department Code: " . $department['tanggalPembuatan'] . "<br>";
    }
}

