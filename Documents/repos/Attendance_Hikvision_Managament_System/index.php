<?php
session_start();
$sessionId = $_SESSION['id'] ?? '';
$sessionRole = $_SESSION['role'] ?? '';
echo "$sessionId $sessionRole";
if (!$sessionId && !$sessionRole) {
    header("location:login.php");
    die();
}

ob_start();

include_once "config.php";
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$connection) {
    echo mysqli_error($connection);
    throw new Exception("Database cannot Connect");
}

$id = $_REQUEST['id'] ?? 'dashboard';
$action = $_REQUEST['action'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=1024">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Dashboard</title>

    <style>
        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .pagination a {
            margin: 0 5px;
            padding: 5px 10px;
            border: 1px solid #ddd;
            color: red;
            text-decoration: none;
        }

        .pagination a:hover {
            background-color: #ddd;
        }

        .search-form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .search-form input[type="text"],
        .search-form select {
            margin-right: 10px;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .search-form input[type="submit"] {
            padding: 5px 10px;
            border-radius: 5px;
            border: none;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
        }

        .search-form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .sidebar__item {
            padding: 10px;
        }

        .sidebar__item.active {
            color: #fff;
        }

        .sidebar__item a {
            color: rgba(255, 255, 255, 0.55);
            font-size: 16px;
            letter-spacing: 1px;
            font-weight: 500;
        }

        .sidebar__item a.active {
            color: #fff;
        }

        .sidebar__item i {
            color: rgba(255, 255, 255, 0.55);
            padding: 0 10px;
        }

        .sidebar__item:hover a,
        .sidebar__item:hover i {
            color: #fff;
            transition: 0.3s ease;
        }

        .sidebar__item .arrow {
            display: inline-block;
            margin-right: 5px;
            transition: transform 0.3s ease;
        }

        #userMenu a {
            color: rgba(255, 255, 255, 0.55);
            font-size: 16px;
            letter-spacing: 1px;
            font-weight: 500;
            white-space: normal;
            /* Allow text to wrap to the next line */
            overflow: visible;
            /* Show all text, don't hide it */
            display: block;
            /* Display links as block elements */
        }

        #userMenu a.active {
            color: #fff;
        }

        #userMenu a i {
            color: rgba(255, 255, 255, 0.55);
            padding: 0 10px;
        }

        #userMenu a:hover,
        #userMenu a.active,
        #userMenu a:hover i,
        #userMenu a.active i {
            color: #fff;
            transition: 0.3s ease;
        }

        #eventmenu a {
            color: rgba(255, 255, 255, 0.55);
            font-size: 16px;
            letter-spacing: 1px;
            font-weight: 500;
            white-space: normal;
            /* Allow text to wrap to the next line */
            overflow: visible;
            /* Show all text, don't hide it */
            display: block;
            /* Display links as block elements */
        }

        #eventmenu a.active {
            color: #fff;
        }

        #eventmenu a i {
            color: rgba(255, 255, 255, 0.55);
            padding: 0 10px;
        }

        #eventmenu a:hover,
        #eventmenu a.active,
        #eventmenu a:hover i,
        #eventmenu a.active i {
            color: #fff;
            transition: 0.3s ease;
        }

        #employeemenu a {
            color: rgba(255, 255, 255, 0.55);
            font-size: 16px;
            letter-spacing: 1px;
            font-weight: 500;
            white-space: normal;
            /* Allow text to wrap to the next line */
            overflow: visible;
            /* Show all text, don't hide it */
            display: block;
            /* Display links as block elements */
        }

        #employeemenu a.active {
            color: #fff;
        }

        #employeemenu a i {
            color: rgba(255, 255, 255, 0.55);
            padding: 0 10px;
        }

        #employeemenu a:hover,
        #employeemenu a.active,
        #employeemenu a:hover i,
        #employeemenu a.active i {
            color: #fff;
            transition: 0.3s ease;
        }

        #attendancemenu a {
            color: rgba(255, 255, 255, 0.55);
            font-size: 16px;
            letter-spacing: 1px;
            font-weight: 500;
            white-space: normal;
            /* Allow text to wrap to the next line */
            overflow: visible;
            /* Show all text, don't hide it */
            display: block;
            /* Display links as block elements */
        }

        #attendancemenu a.active {
            color: #fff;
        }

        #attendancemenu a i {
            color: rgba(255, 255, 255, 0.55);
            padding: 0 10px;
        }

        #attendancemenu a:hover,
        #attendancemenu a.active,
        #attendancemenu a:hover i,
        #attendancemenu a.active i {
            color: #fff;
            transition: 0.3s ease;
        }

        #departmentmenu a {
            color: rgba(255, 255, 255, 0.55);
            font-size: 16px;
            letter-spacing: 1px;
            font-weight: 500;
            white-space: normal;
            /* Allow text to wrap to the next line */
            overflow: visible;
            /* Show all text, don't hide it */
            display: block;
            /* Display links as block elements */
        }

        #departmentmenu a.active {
            color: #fff;
        }

        #departmentmenu a i {
            color: rgba(255, 255, 255, 0.55);
            padding: 0 10px;
        }

        #departmentmenu a:hover,
        #departmentmenu a.active,
        #departmentmenu a:hover i,
        #departmentmenu a.active i {
            color: #fff;
            transition: 0.3s ease;
        }



        /* CSS for the select dropdown */
        #roleSelect {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 6px;
            margin-bottom: 16px;
            resize: vertical;
        }





        .save-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #224abe;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
            /* tambahkan ukuran font jika perlu */
            border-radius: 5px;
            /* tambahkan border-radius untuk membuat tombol lebih bulat */
            width: 100px;
            /* tambahkan lebar jika perlu */
            text-align: center;
            /* ratakan teks ke tengah */
        }

        .cancel-button {
            margin-top: 20px;
            margin-left: 10px;
            /* tambahkan margin kiri untuk memberi jarak antara tombol "Save" dan "Cancel" */
            padding: 10px 20px;
            background-color: #f44336;
            /* warna merah untuk tombol "Cancel" */
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
            border-radius: 5px;
            width: 100px;
            text-align: center;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;

        }

        .select-all-label {
            font-size: 15px;
            /* Atur ukuran font sesuai kebutuhan */
        }

        .addRole-container button {
            position: relative;
            right: -70px;
            top: 40px;
        }

        #permissions {
            width: 500px !important;
            /* Atur lebar tabel menjadi 500 piksel */
            height: 300px !important;
            /* Atur tinggi tabel menjadi 300 piksel */
        }
    </style>
</head>

<body>
    <!--------------------------------- Secondary Navber -------------------------------->
    <section class="topber">
        <div class="topber__title">
            <span class="topber__title--text">
                <?php
                if ('dashboard' == $id) {
                    echo "DashBoard";
                } elseif ('addUser' == $id) {
                    echo "Add User";
                } elseif ('allUser' == $id) {
                    echo "All Users";
                } elseif ('allEvent' == $id) {
                    echo "Attempt details";
                } elseif ('allEmployees' == $id) {
                    echo "Master Employees";
                } elseif ('addEmployees' == $id) {
                    echo "Add Employees";
                } elseif ('allAttendance' == $id) {
                    echo "Attendance CheckInAndOut";
                } elseif ('addAttendance' == $id) {
                    echo "Add Attendance ";
                } elseif ('editManager' == $action) {
                    echo "Edit Manager";
                } elseif ('editPharmacist' == $action) {
                    echo "Edit Pharmacist";
                } elseif ('editSalesman' == $action) {
                    echo "Edit Salesman";
                } elseif ('editGroup' == $action) {
                    $roleId = $_REQUEST['id'];
                    $selectGroup = "SELECT * FROM permissions WHERE role='{$roleId}'";
                    $result = mysqli_query($connection, $selectGroup);
                    $row = mysqli_fetch_assoc($result);
                    echo "Edit " . $row['role'];
                }
                ?>

            </span>
        </div>


        <div class="topber__profile">
            <?php
            $query = "SELECT fname,lname,role,avatar FROM users WHERE id='$sessionId'";
            $result = mysqli_query($connection, $query);

            if ($data = mysqli_fetch_assoc($result)) {
                $fname = $data['fname'];
                $lname = $data['lname'];
                $role = $data['role'];
                $avatar = $data['avatar'];
            ?>
                <img src="assets/img/<?php echo "$avatar"; ?>" height="25" width="25" class="rounded-circle" alt="profile">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php
                    echo "$fname $lname (" . ucwords($role) . " )";
                }
                    ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="index.php">Dashboard</a>
                        <a class="dropdown-item" href="index.php?id=userProfile">Profile</a>
                        <?php if ('admin' == $sessionRole) { ?>
                            <a class="dropdown-item" href="index.php?id=allGroup">Group Role</a>
                        <?php } ?>
                        <a class="dropdown-item" href="logout.php">Log Out</a>
                    </div>
                </div>
        </div>
    </section>
    <!--------------------------------- Secondary Navber -------------------------------->


    <!--------------------------------- Sideber -------------------------------->
    <section id="sideber" class="sideber">
        <ul class="sideber__ber">
            <h3 class="sideber__panel"><i id="left" class="fas fa-laugh-wink"></i> Attendance App</h3>
            <li id="left" class="sideber__item<?php if ('dashboard' == $id) {
                                                    echo " active";
                                                } ?>">
                <a href="index.php?id=dashboard"><i id="left" class="fas fa-tachometer-alt"></i>Dashboard</a>
            </li>

            <?php
            function hasAddUserPermission($role, $connection)
            {
                return hasPermission($role, 'addUser', $connection);
            }

            function hasEditUserPermission($role, $connection)
            {
                return hasPermission($role, 'editUser', $connection);
            }

            function hasViewUserPermission($role, $connection)
            {
                return hasPermission($role, 'viewUser', $connection);
            }

            function hasEditEventPermission($role, $connection)
            {
                return hasPermission($role, 'editEvent', $connection);
            }

            function hasViewEventPermission($role, $connection)
            {
                return hasPermission($role, 'viewEvent', $connection);
            }

            function hasAddEmployeesPermission($role, $connection)
            {
                return hasPermission($role, 'addEmployees', $connection);
            }

            function hasEditEmployeesPermission($role, $connection)
            {
                return hasPermission($role, 'editEmployees', $connection);
            }

            function hasViewEmployeesPermission($role, $connection)
            {
                return hasPermission($role, 'viewEmployees', $connection);
            }

            function hasAddAttendancePermission($role, $connection)
            {
                return hasPermission($role, 'addAttendance', $connection);
            }

            function hasEditAttendancePermission($role, $connection)
            {
                return hasPermission($role, 'editAttendance', $connection);
            }

            function hasViewAttendancePermission($role, $connection)
            {
                return hasPermission($role, 'viewAttendance', $connection);
            }

            function hasAddEventPermission($role, $connection)
            {
                return hasPermission($role, 'addEvent', $connection);
            }

            function hasAddDepartmentPermission($role, $connection)
            {
                return hasPermission($role, 'addDepartment', $connection);
            }

            function hasViewDepartmentPermission($role, $connection)
            {
                return hasPermission($role, 'viewDepartment', $connection);
            }

            function hasEditDepartmentPermission($role, $connection)
            {
                return hasPermission($role, 'editDepartment', $connection);
            }

            function hasPermission($role, $permission, $connection)
            {
                // Query untuk mendapatkan izin dari database
                $sql = "SELECT $permission FROM permissions WHERE role = ?";

                // Persiapan dan eksekusi pernyataan
                $stmt = $connection->prepare($sql);
                $stmt->bind_param('s', $role);
                $stmt->execute();

                // Dapatkan hasil
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                // Cek izin
                return $row && $row[$permission] == 1;
            }
            ?>

            <?php if (hasAddUserPermission($sessionRole, $connection) || hasViewUserPermission($sessionRole, $connection)) { ?>
                <div class="sidebar__item<?php if ('addUser' == $id || 'allUser' == $id) {
                                                echo " active";
                                            } ?>">
                    <a href="#" data-toggle="collapse" data-target="#userMenu" aria-expanded="false" aria-controls="userMenu">
                        <i class="fas fa-user"></i> User<i class="fa fa-angle-left arrow"></i>
                    </a>
                    <div id="userMenu" class="collapse">
                        <?php if (hasAddUserPermission($sessionRole, $connection)) { ?>
                            <!-- Only For Users with addUser Permission -->
                            <a class="sideber__item<?php if ('addUser' == $id) {
                                                        echo " active";
                                                    } ?>" href="index.php?id=addUser">
                                <i class="fas fa-user-plus"></i> Add User
                            </a>
                        <?php } ?>
                        <?php if (hasViewUserPermission($sessionRole, $connection)) { ?>
                            <!-- Only For Users with viewUser Permission -->
                            <a class="sideber__item<?php if ('allUser' == $id) {
                                                        echo " active";
                                                    } ?>" href="index.php?id=allUser">
                                <i class="fas fa-user"></i> All Users
                            </a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (hasAddEventPermission($sessionRole, $connection) || hasViewEventPermission($sessionRole, $connection)) { ?>
                <div class="sidebar__item<?php if ('allEvent' == $id || 'addEvent' == $id) {
                                                echo " active";
                                            } ?>">
                    <a href="#" data-toggle="collapse" data-target="#eventMenu" aria-expanded="false" aria-controls="eventMenu">
                        <i class="fas fa-calendar-alt"></i> Event Details <i class="fa fa-angle-left arrow"></i>
                    </a>
                    <div id="eventMenu" class="collapse">
                        <?php if (hasViewEventPermission($sessionRole, $connection)) { ?>
                            <!-- Only For Users with viewEvent Permission -->
                            <a class="sidebar__item<?php if ('allEvent' == $id) {
                                                        echo " active";
                                                    } ?>" href="index.php?id=allEvent">
                                <i class="fas fa-calendar-alt"></i> Event Type
                            </a>
                        <?php } ?>
                        <?php if (hasAddEventPermission($sessionRole, $connection)) { ?>
                            <!-- Only For Users with addEvent Permission -->
                            <a class="sidebar__item<?php if ('addEvent' == $id) {
                                                        echo " active";
                                                    } ?>" href="index.php?id=addEvent">
                                <i class="fas fa-calendar-alt"></i> Add Event
                            </a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>


            <?php if (hasAddEmployeesPermission($sessionRole, $connection) || hasViewEmployeesPermission($sessionRole, $connection)) { ?>
                <div class="sidebar__item<?php if ('allEmployees' == $id || 'addEmployees' == $id) {
                                                echo " active";
                                            } ?>">
                    <a href="#" data-toggle="collapse" data-target="#employeeMenu" aria-expanded="false" aria-controls="employeeMenu">
                        <i class="fas fa-users"></i> Employee <i class="fa fa-angle-left arrow"></i>
                    </a>
                    <div id="employeeMenu" class="collapse">
                        <?php if (hasViewEmployeesPermission($sessionRole, $connection)) { ?>
                            <!-- Only For Users with viewEmployees Permission -->
                            <a class="sidebar__item<?php if ('allEmployees' == $id) {
                                                        echo " active";
                                                    } ?>" href="index.php?id=allEmployees">
                                <i class="fas fa-users"></i> All Employees
                            </a>
                        <?php } ?>
                        <?php if (hasAddEmployeesPermission($sessionRole, $connection)) { ?>
                            <!-- Only For Users with addEmployees Permission -->
                            <a class="sidebar__item<?php if ('addEmployees' == $id) {
                                                        echo " active";
                                                    } ?>" href="index.php?id=addEmployees">
                                <i class="fas fa-users"></i> Add Employees
                            </a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (hasAddAttendancePermission($sessionRole, $connection) || hasViewAttendancePermission($sessionRole, $connection)) { ?>
                <div class="sidebar__item<?php if ('allAttendance' == $id || 'addAttendance' == $id) {
                                                echo " active";
                                            } ?>">
                    <a href="#" data-toggle="collapse" data-target="#attendanceMenu" aria-expanded="false" aria-controls="attendanceMenu">
                        <i class="fas fa-calendar-check"></i> Attendance <i class="fa fa-angle-left arrow"></i>
                    </a>
                    <div id="attendanceMenu" class="collapse">
                        <?php if (hasViewAttendancePermission($sessionRole, $connection)) { ?>
                            <!-- Only For Users with viewAttendance Permission -->
                            <a class="sidebar__item<?php if ('allAttendance' == $id) {
                                                        echo " active";
                                                    } ?>" href="index.php?id=allAttendance">
                                <i class="fas fa-calendar-check"></i> Attendance
                            </a>
                        <?php } ?>
                        <?php if (hasAddAttendancePermission($sessionRole, $connection)) { ?>
                            <!-- Only For Users with addAttendance Permission -->
                            <a class="sidebar__item<?php if ('addAttendance' == $id) {
                                                        echo " active";
                                                    } ?>" href="index.php?id=addAttendance">
                                <i class="fas fa-calendar-check"></i> Add Attendance
                            </a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (hasViewDepartmentPermission($sessionRole, $connection) || hasAddDepartmentPermission($sessionRole, $connection)) { ?>
                <div class="sidebar__item<?php if ('allDepartment' == $id || 'addDepartment' == $id) {
                                                echo " active";
                                            } ?>">
                    <a href="#" data-toggle="collapse" data-target="#departmentMenu" aria-expanded="false" aria-controls="departmentMenu">
                        <i class="fas fa-building"></i> Department <i class="fa fa-angle-left arrow"></i>
                    </a>
                    <div id="departmentMenu" class="collapse">
                        <?php if (hasViewDepartmentPermission($sessionRole, $connection)) { ?>
                            <!-- Only For Users with viewDepartment Permission -->
                            <a class="sidebar__item<?php if ('allDepartment' == $id) {
                                                        echo " active";
                                                    } ?>" href="index.php?id=allDepartment">
                                <i class="fas fa-building"></i> All Departments
                            </a>
                        <?php } ?>
                        <?php if (hasAddDepartmentPermission($sessionRole, $connection)) { ?>
                            <!-- Only For Users with addDepartment Permission -->
                            <a class="sidebar__item<?php if ('addDepartment' == $id) {
                                                        echo " active";
                                                    } ?>" href="index.php?id=addDepartment">
                                <i class="fas fa-plus-square"></i> Add Department
                            </a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

        </ul>
    </section>
    <!--------------------------------- #Sideber -------------------------------->


    <!--------------------------------- Main section -------------------------------->
    <section class="main">
        <div class="container">

            <!-- ---------------------- DashBoard ------------------------ -->
            <?php if ('dashboard' == $id) { ?>
                <div class="dashboard p-5">
                    <div class="total">
                        <div class="row">
                            <div class="col-3">
                                <div class="total__box text-center">
                                    <h1>
                                        <?php
                                        $query = "SELECT COUNT(*) totalUser FROM users;";
                                        $result = mysqli_query($connection, $query);
                                        $totalUser = mysqli_fetch_assoc($result);
                                        echo $totalUser['totalUser'];
                                        ?>
                                    </h1>
                                    <h2>User</h2>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="total__box text-center">
                                    <h1>
                                        <?php
                                        $query = "SELECT COUNT(*) totalEmployees FROM employees;";
                                        $result = mysqli_query($connection, $query);
                                        $totalEmployees = mysqli_fetch_assoc($result);
                                        echo $totalEmployees['totalEmployees'];
                                        ?>
                                    </h1>
                                    <h2>Employees</h2>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="total__box text-center">
                                    <h1>
                                        <?php
                                        $query = "SELECT COUNT(*) totalEvents FROM events;";
                                        $result = mysqli_query($connection, $query);
                                        $totalEvents = mysqli_fetch_assoc($result);
                                        echo $totalEvents['totalEvents'];
                                        ?>

                                    </h1>
                                    <h2>Event</h2>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="total__box text-center">
                                    <h1><?php
                                        $query = "SELECT COUNT(*) totalAttendance FROM attendance;";
                                        $result = mysqli_query($connection, $query);
                                        $totalUser = mysqli_fetch_assoc($result);
                                        echo $totalUser['totalAttendance'];
                                        ?><h1>
                                            <h2>Attendance</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- ---------------------- DashBoard ------------------------ -->

            <!-- ---------------------- Group Role ------------------------- -->
            <?php if ('allGroup' == $id) { ?>
                <?php
                $result = mysqli_query($connection, "SELECT * FROM permissions");
                ?>


                <!-- Modal -->
                <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addRoleModalLabel">Add Role</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="add_role.php" method="post">
                                    <div class="mb-3">
                                        <label for="role-name" class="form-label">Role Name</label>
                                        <input type="text" class="form-control" id="role-name" name="role_name">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="allPermissions">
                    <div class="addRole-container">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                            Add Role
                        </button>
                        <div class="main__table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Role</th>
                                        <th scope="col">Create Date</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($permission = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <td><?php echo $permission['role']; ?></td>
                                            <td><?php echo $permission['create_date']; ?></td>
                                            <td><?php printf("<a href='index.php?action=editGroup&id=%s'><i class='fas fa-edit'></i></a>", $permission['role']); ?></td>
                                            <td><?php printf("<a class='delete' href='index.php?action=deleteGroup&id=%s'><i class='fas fa-trash'></i></a>", $permission['role']); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>

                <?php if ('editGroup' == $action) {
                    $roleId = $_REQUEST['id'];
                    $selectGroup = "SELECT * FROM permissions WHERE role='{$roleId}'";
                    $result = mysqli_query($connection, $selectGroup);
                    $row = mysqli_fetch_assoc($result);
                ?>

                    <div class="editGroup">
                        <form method="post" action="process_permissions.php" id="myForm">

                            <div id='permissions_<?php echo $roleId; ?>' class='main__table'>
                                <label class="select-all-label">
                                    <input type="checkbox" onClick="toggle(this)" /> Select All
                                </label>
                                <table class='table'>
                                    <thead>
                                        <tr>
                                            <th scope='col'>Permission </th>
                                            <th scope='col'>Add</th>
                                            <th scope='col'>Edit</th>
                                            <th scope='col'>View</th>
                                            <th scope='col'>Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $permissions = ['User', 'Event', 'Employees', 'Attendance', 'Department'];
                                        $actions = ['add', 'edit', 'view'];

                                        foreach ($permissions as $permission) {
                                            echo "<tr><td>$permission</td>";
                                            foreach ($actions as $action) {
                                                $column_name = $action . $permission;
                                                echo "<td><input type='checkbox' name='{$column_name}_{$roleId}' id='{$column_name}_{$roleId}' " . ($row[$column_name] == 1 ? 'checked' : '') . "></td>";
                                            }
                                            echo "<td>$roleId</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="button-container">
                                <input type="submit" value="Save" class="save-button">
                                <input type="hidden" name="role" value="<?php echo $roleId; ?>">
                                <input type="button" value="Cancel" class="cancel-button" onclick="window.history.back();">
                            </div>
                        </form>
                    </div>
                <?php } ?>

                <?php if ('deleteGroup' == $action) {
                    $roleId = $_REQUEST['id'];
                    $deleteGroup = "DELETE FROM permissions WHERE role='{$roleId}'";
                    $result = mysqli_query($connection, $deleteGroup);
                    header("location:index.php?id=allUser");
                } ?>


                <!-- ---------------------- Group Role ------------------------- -->




                <!-- ---------------------- Role Base Access Control ------------------------ -->

                <?php if ('RBAC' == $id) { ?>
                    <div class="RBAC">

                        <form method="post" action="process_permissions.php" id="myForm">
                            <?php
                            $query = "SELECT * FROM permissions";
                            $result = mysqli_query($connection, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $role = $row['role'];
                                echo "<div id='permissions_$role' class='main__table' style='display: none;'>";
                                echo "<table class='table'>";
                                echo "<thead>
                                    <tr>
                                        <th scope='col'>Permission </th>
                                        <th scope='col'>Add</th>
                                        <th scope='col'>Edit</th>
                                        <th scope='col'>View</th>
                                        <th scope='col'>Role</th>
                                    </tr>
                                  </thead>
                                  <tbody>";


                                $permissions = ['User', 'Event', 'Employees', 'Attendance', 'Department'];
                                $actions = ['add', 'edit', 'view'];

                                foreach ($permissions as $permission) {
                                    echo "<tr><td>$permission</td>";
                                    foreach ($actions as $action) {
                                        $column_name = $action . $permission;
                                        echo "<td><input type='checkbox' name='{$column_name}_{$role}' id='{$column_name}_{$role}' " . ($row[$column_name] == 1 ? 'checked' : '') . "></td>";
                                    }
                                    echo "<td>$role</td></tr>";
                                }


                                echo "</tbody>";
                                echo "</table>";
                                echo "</div>";
                            }
                            ?>

                            <input type="submit" value="Submit">
                        </form>
                    </div>
                <?php } ?>



                <!-- ---------------------- Role Base Access Control ------------------------ -->

                <!-- ---------------------- USER ------------------------ -->
                <div class="user">
                    <?php if ('allUser' == $id) { ?>
                        <div class="allUser">
                            <div class="main__table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Avatar</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Role</th>
                                            <?php if (hasEditUserPermission($sessionRole, $connection)) { ?>
                                                <!-- Only For Users wi  th editUser Permission -->
                                                <th scope="col">Edit</th>
                                                <th scope="col">Delete</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $getUsers = "SELECT * FROM users";
                                        $result = mysqli_query($connection, $getUsers);

                                        while ($user = mysqli_fetch_assoc($result)) {
                                            if (empty($user['fname']) || empty($user['lname']) || empty($user['username'])) {
                                                continue;
                                            } ?>
                                            <tr>
                                                <td>
                                                    <?php if (!empty($user['avatar'])) { ?>
                                                        <center><img class="rounded-circle" width="40" height="40" src="assets/img/<?php echo $user['avatar']; ?>" alt=""></center>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($user['fname']) && !empty($user['lname'])) {
                                                        printf("%s %s", $user['fname'], $user['lname']);
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($user['username'])) {
                                                        printf("%s", $user['username']);
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($user['role'])) {
                                                        printf("%s", $user['role']);
                                                    } ?>
                                                </td>
                                                <?php if (hasEditUserPermission($sessionRole, $connection)) { ?>
                                                    <!-- Only For Users with editUser Permission -->
                                                    <td><?php printf("<a href='index.php?action=editUser&id=%s'><i class='fas fa-edit'></i></a>", $user['id']) ?></td>
                                                    <td><?php printf("<a class='delete' href='index.php?action=deleteUser&id=%s'><i class='fas fa-trash'></i></a>", $user['id']) ?></td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } ?>

                    <!-- ---------------------- USER ------------------------ -->

                    <?php if ('addUser' == $id) {    ?>
                        <div class="addUser">
                            <div class="main__form">
                                <div class="main__form--title text-center">Add New User</div>
                                <form action="add.php" method="POST" id="myForm1">
                                    <div class="form-row">
                                        <div class="col col-12">
                                            <label class="input">
                                                <i id="left" class="fas fa-user-circle"></i>
                                                <input type="text" name="fname" placeholder="First name" required>
                                            </label>
                                        </div>
                                        <div class="col col-12">
                                            <label class="input">
                                                <i id="left" class="fas fa-user-circle"></i>
                                                <input type="text" name="lname" placeholder="Last Name" required>
                                            </label>
                                        </div>
                                        <div class="col col-12">
                                            <label class="input">
                                                <i id="left" class="fas fa-user-circle"></i>
                                                <input type="text" name="username" placeholder="Username" required>
                                            </label>
                                        </div>
                                        <div class="col col-12">
                                            <label class="input">
                                                <i id="left" class="fas fa-key"></i>
                                                <input id="pwdinput" type="password" name="password" placeholder="Password" required>
                                                <i id="pwd" class="fas fa-eye right"></i>
                                            </label>
                                        </div>
                                        <div class="col col-12">
                                            <label class="input">
                                                <i id="left" class="fas fa-lock"></i>
                                                <select id="roleSelects" name="role" onchange="showPermissionsTable(this.value)">
                                                    <option value="" disabled selected>-- Select Role --</option>
                                                    <?php
                                                    $query = "SELECT DISTINCT role FROM permissions";
                                                    $result = mysqli_query($connection, $query);
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<option value='" . $row['role'] . "'>" . $row['role'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="button-container">
                                        <input type="submit" value="Submit">
                                        <input type="hidden" name="action" value="addUser">
                                    </div>
                            </div>
                        </div>
                        <?php


                        $query = "SELECT * FROM permissions";
                        $result = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $role = $row['role'];
                            echo "<div id='permissions_$role' class='main__table' style='display:none'>";
                            echo "<label class='select-all-label'><input type='checkbox' onClick='toggle(this)' /> Select All</label>";
                            echo "<table class='table'>";
                            echo "<thead>
<tr>
<th scope='col'>Permission </th>
<th scope='col'>Add</th>
<th scope='col'>Edit</th>
<th scope='col'>View</th>
<th scope='col'>Role</th>
</tr>
</thead>
<tbody>";

                            $permissions = ['User', 'Event', 'Employees', 'Attendance', 'Department'];
                            $actions = ['add', 'edit', 'view'];

                            foreach ($permissions as $permission) {
                                echo "<tr><td>$permission</td>";
                                foreach ($actions as $action) {
                                    $column_name = $action . $permission;
                                    echo "<td><input type='checkbox' name='{$column_name}_{$role}' id='{$column_name}_{$role}' " . ($row[$column_name] == 1 ? 'checked' : '') . "></td>";
                                }
                                echo "<td>$role</td></tr>";
                            }

                            echo "</tbody>";
                            echo "</table>";
                            echo "</div>";
                        }
                        ?>
                        </form>
                </div>
                </div>
            <?php } ?>

            <?php if ('editUser' == $action) {
                echo "Action is editUser<br>";
                $userId = $_REQUEST['id'];
                $selectUsers = "SELECT * FROM users WHERE id='{$userId}'";
                $result = mysqli_query($connection, $selectUsers);

                $user = mysqli_fetch_assoc($result); ?>
                <div class="addUser">
                    <div class="main__form">
                        <div class="main__form--title text-center">Update User</div>
                        <form id="myForm2" method="POST">
                            <div class="form-row">
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-user-circle"></i>
                                        <input type="text" name="fname" placeholder="First name" value="<?php echo $user['fname']; ?>" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-user-circle"></i>
                                        <input type="text" name="lname" placeholder="Last Name" value="<?php echo $user['lname']; ?>" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-user-circle"></i>
                                        <input type="text" name="username" placeholder="Username" value="<?php echo $user['username']; ?>" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-lock"></i>
                                        <input id="roleInput" type="text" name="roles" placeholder="role" value="<?php echo $user['role']; ?>" readonly required>
                                    </label>


                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-lock"></i>
                                        <select id="roleSelects" name="role" onchange="showPermissionsTable(this.value)">
                                            <option value="" disabled selected>-- Select Role --</option>
                                            <?php
                                            $query = "SELECT DISTINCT role FROM permissions";
                                            $result = mysqli_query($connection, $query);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='" . $row['role'] . "'>" . $row['role'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </label>
                                </div>

                            </div>
                            <input type="hidden" name="action" value="updateUser">
                            <input type="hidden" name="id" value="<?php echo $userId; ?>">
                            <div class="col col-12">
                                <input type="submit" value="Update">
                            </div>
                    </div>

                    <?php

                    $query = "SELECT * FROM permissions";
                    $result = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $role = $row['role'];
                        echo "<div id='permissions_$role' class='main__table' style='display:none'>";
                        echo "<label class='select-all-label'><input type='checkbox' onClick='toggle(this)' /> Select All</label>";
                        echo "<table class='table'>";
                        echo "<thead>
                        <tr>
                        <th scope='col'>Permission </th>
                        <th scope='col'>Add</th>
                        <th scope='col'>Edit</th>
                        <th scope='col'>View</th>
                        <th scope='col'>Role</th>
                        </tr>
                        </thead>
                        <tbody>";

                        $permissions = ['User', 'Event', 'Employees', 'Attendance', 'Department'];
                        $actions = ['add', 'edit', 'view'];

                        foreach ($permissions as $permission) {
                            echo "<tr><td>$permission</td>";
                            foreach ($actions as $action) {
                                $column_name = $action . $permission;
                                echo "<td><input type='checkbox' name='{$column_name}_{$role}' id='{$column_name}_{$role}' " . ($row[$column_name] == 1 ? 'checked' : '') . "></td>";
                            }
                            echo "<td>$role</td></tr>";
                        }

                        echo "</tbody>";
                        echo "</table>";
                        echo "</div>";
                    }
                    ?>
                    </form>
                </div>
        </div>
    <?php } ?>

    <?php if ('deleteUser' == $action) {
        $userId = $_REQUEST['id'];
        $deleteUser = "DELETE FROM users WHERE id ='{$userId}'";
        $result = mysqli_query($connection, $deleteUser);
        header("location:index.php?id=allUser");
    } ?>
    </div>
    <!-- ---------------------- User ------------------------ -->




    <!-- ---------------------- Employee Data ------------------------ -->
    <?php if ('allEmployees' == $id) { ?>
        <?php
        $searchTerm = $_GET['search'] ?? '';
        $rowsPerPage = $_GET['rowsPerPage'] ?? 10;
        $currentPage = $_GET['page'] ?? 1;
        $offset = ($currentPage - 1) * $rowsPerPage;

        $result = mysqli_query($connection, "SELECT COUNT(*) FROM employees WHERE personName LIKE '%$searchTerm%'");
        $row = mysqli_fetch_row($result);
        $totalRows = $row[0];
        $totalPages = ceil($totalRows / $rowsPerPage);
        ?>

        <form action="index.php" method="GET" class="search-form">
            <input type="hidden" name="id" value="allEmployees">
            <input type="text" name="search" placeholder="Search employees" value="<?php echo $searchTerm; ?>">
            <select name="rowsPerPage">
                <option value="5" <?php echo $rowsPerPage == 5 ? 'selected' : ''; ?>>5</option>
                <option value="10" <?php echo $rowsPerPage == 10 ? 'selected' : ''; ?>>10</option>
                <option value="20" <?php echo $rowsPerPage == 20 ? 'selected' : ''; ?>>20</option>
                <option value="50" <?php echo $rowsPerPage == 50 ? 'selected' : ''; ?>>50</option>
            </select>
            <input type="submit" value="Search">
        </form>

        <?php
        $getEmployees = "SELECT * FROM employees WHERE 
                (personCode LIKE '%$searchTerm%' OR 
                personName LIKE '%$searchTerm%' OR 
                personFamily LIKE '%$searchTerm%' OR 
                personGivenName LIKE '%$searchTerm%' OR 
                department LIKE '%$searchTerm%') 
                LIMIT $offset, $rowsPerPage";
        $result = mysqli_query($connection, $getEmployees);
        ?>

        <div class="allEmployees">
            <div class="main__table">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">NIK</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Person Family</th>
                            <th scope="col">Person Given Name</th>
                            <th scope="col">Person ID</th>
                            <th scope="col">Dept</th>
                            <?php if (hasEditEmployeesPermission($sessionRole, $connection)) { ?>
                                <!-- Only For Users with editUser Permission -->
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($employee = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php printf("%s", $employee['personCode']); ?></td>
                                <td><?php printf("%s", $employee['personName']); ?></td>
                                <td><?php printf("%s", $employee['personFamily']); ?></td>
                                <td><?php printf("%s", $employee['personGivenName']); ?></td>
                                <td><?php printf("%s", $employee['personId']); ?></td>
                                <td><?php printf("%s", $employee['department']); ?></td>
                                <?php if (hasEditEmployeesPermission($sessionRole, $connection)) { ?>
                                    <!-- Only For Users with editEmployee Permission -->
                                    <td><?php printf("<a href='index.php?action=editEmployee&id=%s'><i class='fas fa-edit'></i></a>", $employee['personId']) ?></td>
                                    <td><?php printf("<a class='delete' href='index.php?action=deleteEmployee&id=%s'><i class='fas fa-trash'></i></a>", $employee['personId']) ?></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination">
            <?php
            for ($i = 1; $i <= $totalPages; $i++) {
                $active = $i == $currentPage ? 'active' : '';
                echo "<a class='$active' href='index.php?id=allEmployees&search=$searchTerm&rowsPerPage=$rowsPerPage&page=$i'>$i</a> ";
            }
            ?>
        </div>
    <?php } ?>

    <?php if ('addEmployees' == $id) { ?>
        <div class="addEmployee">
            <div class="main__form">
                <div class="main__form--title text-center">Add New Employee</div>
                <form action="add.php" method="POST">
                    <div class="form-row">
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-user-circle"></i>
                                <input type="text" name="personCode" placeholder="NIK" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-user-circle"></i>
                                <input type="text" name="personName" placeholder="Name" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-user-circle"></i>
                                <input type="text" name="personFamily" placeholder="Person Family" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-user-circle"></i>
                                <input type="text" name="personGivenName" placeholder="Person Given Name" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-user-circle"></i>
                                <input type="text" name="personId" placeholder="Person ID" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-user-circle"></i>
                                <input type="text" name="department" placeholder="Department" required>
                            </label>
                            <input type="hidden" name="action" value="addEmployees">
                            <div class="col col-12">
                                <input type="submit" value="Submit">
                            </div>
                        </div>
                </form>
            </div>
        </div>
    <?php } ?>

    <?php if ('editEmployee' == $action) {
        $personId = $_REQUEST['id'];
        $selectEmployees = "SELECT * FROM employees WHERE personId='{$personId}'";
        $result = mysqli_query($connection, $selectEmployees);

        $employee = mysqli_fetch_assoc($result); ?>
        <div class="addEmployee">
            <div class="main__form">
                <div class="main__form--title text-center">Update Employee</div>
                <form action="add.php" method="POST">
                    <div class="form-row">
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-user-circle"></i>
                                <input type="text" name="personCode" placeholder="NIK" value="<?php echo $employee['personCode']; ?>" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-user-circle"></i>
                                <input type="text" name="personName" placeholder="Name" value="<?php echo $employee['personName']; ?>" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-user-circle"></i>
                                <input type="text" name="personFamily" placeholder="Person Family" value="<?php echo $employee['personFamily']; ?>" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-user-circle"></i>
                                <input type="text" name="personGivenName" placeholder="Person Given Name" value="<?php echo $employee['personGivenName']; ?>" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-user-circle"></i>
                                <input type="text" name="department" placeholder="Department" value="<?php echo $employee['department']; ?>" required>
                            </label>
                        </div>
                    </div>
                    <input type="hidden" name="action" value="updateEmployee">
                    <input type="hidden" name="id" value="<?php echo $personId; ?>">
                    <div class="col col-12">
                        <input type="submit" value="Update">
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>

    <?php if ('deleteEmployee' == $action) {
        $personId = $_REQUEST['id'];
        $deleteEmployee = "DELETE FROM employees WHERE personId ='{$personId}'";
        $result = mysqli_query($connection, $deleteEmployee);
        header("location:index.php?id=allEmployees");
    } ?>

    <!-- ---------------------- Employee Data ------------------------ -->
    <!-- ---------------------- Attendance CheckInAndOut ------------------------ -->
    <div class="attendance">
        <?php if ('allAttendance' == $id) { ?>
            <?php
            $searchTerm = $_GET['search'] ?? '';
            $searchDate = $_GET['searchDate'] ?? '';
            $rowsPerPage = $_GET['rowsPerPage'] ?? 10;
            $currentPage = $_GET['page'] ?? 1;
            $offset = ($currentPage - 1) * $rowsPerPage;

            if ($searchTerm != '') {
                $result = mysqli_query($connection, "SELECT COUNT(*) FROM attendance WHERE personName LIKE '%$searchTerm%'");
                $getAttendance = "SELECT * FROM attendance WHERE personName LIKE '%$searchTerm%' LIMIT $offset, $rowsPerPage";
            } elseif ($searchDate != '') {
                $result = mysqli_query($connection, "SELECT COUNT(*) FROM attendance WHERE (DATE(checkIn) = DATE('$searchDate') OR DATE(checkOut) = DATE('$searchDate'))");
                $getAttendance = "SELECT * FROM attendance WHERE (DATE(checkIn) = DATE('$searchDate') OR DATE(checkOut) = DATE('$searchDate')) LIMIT $offset, $rowsPerPage";
            } else {
                $result = mysqli_query($connection, "SELECT COUNT(*) FROM attendance");
                $getAttendance = "SELECT * FROM attendance LIMIT $offset, $rowsPerPage";
            }

            $row = mysqli_fetch_row($result);
            $totalRows = $row[0];
            $totalPages = ceil($totalRows / $rowsPerPage);

            $result = mysqli_query($connection, $getAttendance);
            ?>

            <form action="index.php" method="GET" class="search-form">
                <input type="hidden" name="id" value="allAttendance">
                <input type="text" name="search" placeholder="Search attendance" value="<?php echo $searchTerm; ?>">
                <input type="date" name="searchDate" placeholder="Search by date" value="<?php echo $searchDate; ?>">
                <select name="rowsPerPage">
                    <option value="5" <?php echo $rowsPerPage == 5 ? 'selected' : ''; ?>>5</option>
                    <option value="10" <?php echo $rowsPerPage == 10 ? 'selected' : ''; ?>>10</option>
                    <option value="20" <?php echo $rowsPerPage == 20 ? 'selected' : ''; ?>>20</option>
                    <option value="50" <?php echo $rowsPerPage == 50 ? 'selected' : ''; ?>>50</option>
                </select>
                <input type="submit" value="Search">
            </form>




            <div class="allAttendance">
                <div class="main__table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">eventId</th>
                                <th scope="col">eventType</th>
                                <th scope="col">Person Name</th>
                                <th scope="col">Person Code</th>
                                <th scope="col">Check In Time</th>
                                <th scope="col">Check Out Time</th>
                                <?php if (hasEditAttendancePermission($sessionRole, $connection)) { ?>
                                    <!-- Only For Users with editUser Permission -->
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($attendance = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php printf("%s", $attendance['eventId']); ?></td>
                                    <td><?php printf("%s", $attendance['eventType']); ?></td>
                                    <td><?php printf("%s", $attendance['personName']); ?></td>
                                    <td><?php printf("%s", $attendance['personCode']); ?></td>
                                    <td><?php printf("%s", $attendance['checkIn']); ?></td>
                                    <td><?php printf("%s", $attendance['checkOut']); ?></td>
                                    <?php if (hasEditAttendancePermission($sessionRole, $connection)) { ?>
                                        <!-- Only For Users with editAttendance Permission -->
                                        <td><?php printf("<a href='index.php?action=editAttendance&id=%s'><i class='fas fa-edit'></i></a>", $attendance['eventId']) ?></td>
                                        <td><?php printf("<a class='delete' href='index.php?action=deleteAttendance&id=%s'><i class='fas fa-trash'></i></a>", $attendance['eventId']) ?></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="pagination">
                <?php
                for ($i = 1; $i <= $totalPages; $i++) {
                    $active = $i == $currentPage ? 'active' : '';
                    echo "<a class='$active' href='index.php?id=allAttendance&search=$searchTerm&rowsPerPage=$rowsPerPage&page=$i'>$i</a> ";
                }
                ?>
            </div>
        <?php } ?>
    </div>

    <?php if ('addAttendance' == $id) { ?>
        <div class="addAttendance">
            <div class="main__form">
                <div class="main__form--title text-center">Add New Attendance</div>
                <form action="add.php" method="POST">
                    <div class="form-row">
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-calendar-alt"></i>
                                <input type="text" name="eventId" placeholder="Event ID" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-calendar-alt"></i>
                                <input type="text" name="eventType" placeholder="Event Type" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-user"></i>
                                <input type="text" name="personName" placeholder="Person Name" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-id-card"></i>
                                <input type="text" name="personCode" placeholder="Person Code" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-clock"></i>
                                <input type="datetime-local" name="checkIn" required>
                                <small>For:CheckIn</small>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-clock"></i>
                                <input type="datetime-local" name="checkOut" required>
                                <small>For:CheckOut</small>
                            </label>
                        </div>
                        <input type="hidden" name="action" value="addAttendance">
                        <div class="col col-12">
                            <input type="submit" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>

    <?php if ('editAttendance' == $action) {
        $eventId = $_REQUEST['id'];
        $selectAttendance = "SELECT * FROM attendance WHERE eventId='{$eventId}'";
        $result = mysqli_query($connection, $selectAttendance);

        $attendance = mysqli_fetch_assoc($result); ?>
        <div class="editAttendance">
            <div class="main__form">
                <div class="main__form--title text-center">Update Attendance</div>
                <form action="add.php" method="POST">
                    <div class="form-row">
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-calendar-alt"></i>
                                <input type="text" name="eventType" placeholder="Event Type" value="<?php echo $attendance['eventType']; ?>" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-user"></i>
                                <input type="text" name="personName" placeholder="Person Name" value="<?php echo $attendance['personName']; ?>" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-id-card"></i>
                                <input type="text" name="personCode" placeholder="Person Code" value="<?php echo $attendance['personCode']; ?>" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-clock"></i>
                                <input type="datetime-local" name="checkIn" placeholder="Check In Time" value="<?php echo date('Y-m-d\TH:i', strtotime($attendance['checkIn'])); ?>" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-clock"></i>
                                <input type="datetime-local" name="checkOut" placeholder="Check Out Time" value="<?php echo date('Y-m-d\TH:i', strtotime($attendance['checkOut'])); ?>" required>
                            </label>
                        </div>
                    </div>
                    <input type="hidden" name="action" value="updateAttendance">
                    <input type="hidden" name="id" value="<?php echo $eventId; ?>">
                    <div class="col col-12">
                        <input type="submit" value="Update">
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>

    <?php if ('deleteAttendance' == $action) {
        $attendanceId = $_REQUEST['id'];
        $deleteAttendance = "DELETE FROM attendance WHERE eventId ='{$attendanceId}'";
        $result = mysqli_query($connection, $deleteAttendance);
        header("location:index.php?id=allAttendance");
    } ?>
    </div>



    <!-- ---------------------- Attendance CheckInAndOut ------------------------ -->

    <!-- ---------------------- Event Data ------------------------ -->
    <div class="event">
        <?php if ('allEvent' == $id) { ?>
            <?php
            $searchTerm = $_GET['search'] ?? '';
            $searchDate = $_GET['searchDate'] ?? '';
            $rowsPerPage = $_GET['rowsPerPage'] ?? 10;
            $currentPage = $_GET['page'] ?? 1;
            $offset = ($currentPage - 1) * $rowsPerPage;

            if ($searchTerm != '') {
                $result = mysqli_query($connection, "SELECT COUNT(*) FROM events WHERE eventId LIKE '%$searchTerm%' OR eventType LIKE '%$searchTerm%' OR eventTime LIKE '%$searchTerm%' OR personName LIKE '%$searchTerm%' OR doorName LIKE '%$searchTerm%' OR doorIndexCode LIKE '%$searchTerm%' OR checkInAndOutType LIKE '%$searchTerm%' OR personId LIKE '%$searchTerm%'");
                $getEvents = "SELECT * FROM events WHERE eventId LIKE '%$searchTerm%' OR eventType LIKE '%$searchTerm%' OR eventTime LIKE '%$searchTerm%' OR personName LIKE '%$searchTerm%' OR doorName LIKE '%$searchTerm%' OR doorIndexCode LIKE '%$searchTerm%' OR checkInAndOutType LIKE '%$searchTerm%' OR personId LIKE '%$searchTerm%' LIMIT $offset, $rowsPerPage";
            } elseif ($searchDate != '') {
                $result = mysqli_query($connection, "SELECT COUNT(*) FROM events WHERE (DATE(eventTime) = DATE('$searchDate'))");
                $getEvents = "SELECT * FROM events WHERE (DATE(eventTime) = DATE('$searchDate')) LIMIT $offset, $rowsPerPage";
            } else {
                $result = mysqli_query($connection, "SELECT COUNT(*) FROM events");
                $getEvents = "SELECT * FROM events LIMIT $offset, $rowsPerPage";
            }

            $row = mysqli_fetch_row($result);
            $totalRows = $row[0];
            $totalPages = ceil($totalRows / $rowsPerPage);
            ?>

            <form action="index.php" method="GET" class="search-form">
                <input type="hidden" name="id" value="allEvent">
                <input type="text" name="search" placeholder="Search events" value="<?php echo $searchTerm; ?>">
                <input type="date" name="searchDate" placeholder="Search by date" value="<?php echo $searchDate; ?>">
                <select name="rowsPerPage">
                    <option value="5" <?php echo $rowsPerPage == 5 ? 'selected' : ''; ?>>5</option>
                    <option value="10" <?php echo $rowsPerPage == 10 ? 'selected' : ''; ?>>10</option>
                    <option value="20" <?php echo $rowsPerPage == 20 ? 'selected' : ''; ?>>20</option>
                    <option value="50" <?php echo $rowsPerPage == 50 ? 'selected' : ''; ?>>50</option>
                </select>
                <input type="submit" value="Search">
            </form>

            <?php
            $result = mysqli_query($connection, $getEvents);
            ?>


            <div class="allEvent">
                <div class="main__table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Event ID</th>
                                <th scope="col">Event Type</th>
                                <th scope="col">Event Time</th>
                                <th scope="col">Person Name</th>
                                <th scope="col">Door Name</th>
                                <th scope="col">Door Index Code</th>
                                <th scope="col">Check In And Out Type</th>
                                <th scope="col">Person ID</th>
                                <?php if (hasEditEventPermission($sessionRole, $connection)) { ?>
                                    <!-- Only For Users with editUser Permission -->
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($event = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php printf("%s", $event['eventId']); ?></td>
                                    <td><?php printf("%s", $event['eventType']); ?></td>
                                    <td><?php printf("%s", $event['eventTime']); ?></td>
                                    <td><?php printf("%s", $event['personName']); ?></td>
                                    <td><?php printf("%s", $event['doorName']); ?></td>
                                    <td><?php printf("%s", $event['doorIndexCode']); ?></td>
                                    <td><?php printf("%s", $event['checkInAndOutType']); ?></td>
                                    <td><?php printf("%s", $event['personId']); ?></td>
                                    <?php if (hasEditEventPermission($sessionRole, $connection)) { ?>
                                        <!-- Only For Users with editEvent Permission -->
                                        <td><?php printf("<a href='index.php?action=editEvent&id=%s'><i class='fas fa-edit'></i></a>", $event['eventId']) ?></td>
                                        <td><?php printf("<a class='delete' href='index.php?action=deleteEvent&id=%s'><i class='fas fa-trash'></i></a>", $event['eventId']) ?></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="pagination">
                <?php
                for ($i = 1; $i <= $totalPages; $i++) {
                    $active = $i == $currentPage ? 'active' : '';
                    echo "<a class='$active' href='index.php?id=allEvent&search=$searchTerm&rowsPerPage=$rowsPerPage&page=$i'>$i</a> ";
                }
                ?>
            </div>
        <?php } ?>
    </div>

    <?php if ('addEvent' == $id) { ?>
        <div class="addEvent">
            <div class="main__form">
                <div class="main__form--title text-center">Add New Event</div>
                <form action="add.php" method="POST">
                    <div class="form-row">
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-calendar-alt"></i>
                                <input type="text" name="eventId" placeholder="Event ID" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-calendar-alt"></i>
                                <input type="text" name="eventType" placeholder="Event Type" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label for="eventTime" class="input">
                                <i id="left" class="fas fa-clock"></i>
                                <input type="datetime-local" name="eventTime" id="eventTime" required>
                                <small>
                                    Event Time
                                </small>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-user"></i>
                                <input type="text" name="personName" placeholder="Person Name" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-door-open"></i>
                                <input type="text" name="doorName" placeholder="Door Name" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-code"></i>
                                <input type="text" name="doorIndexCode" placeholder="Door Index Code" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-check-circle"></i>
                                <input type="text" name="checkInAndOutType" placeholder="Check In And Out Type" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-user"></i>
                                <input type="text" name="personId" placeholder="Person ID" required>
                            </label>
                        </div>
                        <input type="hidden" name="action" value="addEvent">
                        <div class="col col-12">
                            <input type="submit" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>

    <?php if ('editEvent' == $action) {
        $eventId = $_REQUEST['id'];
        $selectEvents = "SELECT * FROM events WHERE eventId='{$eventId}'";
        $result = mysqli_query($connection, $selectEvents);

        $event = mysqli_fetch_assoc($result); ?>
        <div class="editEvent">
            <div class="main__form">
                <div class="main__form--title text-center">Update Event</div>
                <form action="add.php" method="POST">
                    <div class="form-row">
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-calendar-alt"></i>
                                <input type="text" name="eventType" placeholder="Event Type" value="<?php echo $event['eventType']; ?>" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-clock"></i>
                                <input type="datetime-local" name="eventTime" placeholder="Event Time" value="<?php echo $event['eventTime']; ?>" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-user"></i>
                                <input type="text" name="personName" placeholder="Person Name" value="<?php echo $event['personName']; ?>" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-door-open"></i>
                                <input type="text" name="doorName" placeholder="Door Name" value="<?php echo $event['doorName']; ?>" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-code"></i>
                                <input type="text" name="doorIndexCode" placeholder="Door Index Code" value="<?php echo $event['doorIndexCode']; ?>" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-check-circle"></i>
                                <input type="text" name="checkInAndOutType" placeholder="Check In And Out Type" value="<?php echo $event['checkInAndOutType']; ?>" required>
                            </label>
                        </div>
                        <input type="hidden" name="action" value="updateEvent">
                        <input type="hidden" name="eventId" value="<?php echo $eventId; ?>">
                        <div class="col col-12">
                            <input type="submit" value="Update">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>

    <?php if ('deleteEvent' == $action) {
        $eventId = $_REQUEST['id'];
        $deleteEvent = "DELETE FROM events WHERE eventId ='{$eventId}'";
        $result = mysqli_query($connection, $deleteEvent);
        header("location:index.php?id=allEvent");
    } ?>
    </div>

    <!-- ---------------------- Event Data ------------------------ -->

    <!-- ---------------------- Data Departement ------------------------ -->

    <div class="department">
        <?php if ('allDepartment' == $id) { ?>
            <?php
            $searchTerm = $_GET['search'] ?? '';
            $rowsPerPage = $_GET['rowsPerPage'] ?? 10;
            $currentPage = $_GET['page'] ?? 1;
            $offset = ($currentPage - 1) * $rowsPerPage;

            if ($searchTerm != '') {
                $result = mysqli_query($connection, "SELECT COUNT(*) FROM department WHERE id LIKE '%$searchTerm%' OR namaDepartement LIKE '%$searchTerm%' OR tanggalPembuatan LIKE '%$searchTerm%'");
                $getDepartments = "SELECT * FROM department WHERE id LIKE '%$searchTerm%' OR namaDepartement LIKE '%$searchTerm%' OR tanggalPembuatan LIKE '%$searchTerm%' LIMIT $offset, $rowsPerPage";
            } else {
                $result = mysqli_query($connection, "SELECT COUNT(*) FROM department");
                $getDepartments = "SELECT * FROM department LIMIT $offset, $rowsPerPage";
            }

            $row = mysqli_fetch_row($result);
            $totalRows = $row[0];
            $totalPages = ceil($totalRows / $rowsPerPage);
            ?>

            <form action="index.php" method="GET" class="search-form">
                <input type="hidden" name="id" value="allDepartment">
                <input type="text" name="search" placeholder="Search departments" value="<?php echo $searchTerm; ?>">
                <select name="rowsPerPage">
                    <option value="5" <?php echo $rowsPerPage == 5 ? 'selected' : ''; ?>>5</option>
                    <option value="10" <?php echo $rowsPerPage == 10 ? 'selected' : ''; ?>>10</option>
                    <option value="20" <?php echo $rowsPerPage == 20 ? 'selected' : ''; ?>>20</option>
                    <option value="50" <?php echo $rowsPerPage == 50 ? 'selected' : ''; ?>>50</option>
                </select>
                <input type="submit" value="Search">
            </form>

            <?php
            $result = mysqli_query($connection, $getDepartments);
            ?>

            <div class="allDepartment">
                <div class="main__table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nama Departement</th>
                                <th scope="col">Tanggal Pembuatan</th>
                                <?php if (hasEditDepartmentPermission($sessionRole, $connection)) { ?>
                                    <!-- Only For Users with editUser Permission -->
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            while ($department = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php printf("%s", $department['id']); ?></td>
                                    <td><?php printf("%s", $department['namaDepartement']); ?></td>
                                    <td><?php printf("%s", $department['tanggalPembuatan']); ?></td>
                                    <?php if (hasEditDepartmentPermission($sessionRole, $connection)) { ?>
                                        <!-- Only For Users with editUser Permission -->
                                        <td><?php printf("<a href='index.php?action=editDepartment&id=%s'><i class='fas fa-edit'></i></a>", $department['id']) ?></td>
                                        <td><?php printf("<a class='delete' href='index.php?action=deleteDepartment&id=%s'><i class='fas fa-trash'></i></a>", $department['id']) ?></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="pagination">
                <?php
                for ($i = 1; $i <= $totalPages; $i++) {
                    $active = $i == $currentPage ? 'active' : '';
                    echo "<a class='$active' href='index.php?id=allDepartment&search=$searchTerm&rowsPerPage=$rowsPerPage&page=$i'>$i</a> ";
                }
                ?>
            </div>
        <?php } ?>
    </div>

    <?php if ('editDepartment' == $action) {
        // Fetch the department data
        $departmentId = $_GET['id'];
        $query = "SELECT * FROM department WHERE id = '{$departmentId}'";
        $result = mysqli_query($connection, $query);
        $department = mysqli_fetch_assoc($result);
    ?>
        <div class="editDepartment">
            <div class="main__form">
                <div class="main__form--title text-center">Edit Department</div>
                <form action="add.php" method="POST">
                    <div class="form-row">
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-building"></i>
                                <input type="text" name="namaDepartement" placeholder="Department Name" value="<?php echo $department['namaDepartement']; ?>" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-calendar"></i>
                                <input type="date" name="tanggalPembuatan" value="<?php echo $department['tanggalPembuatan']; ?>" required>
                            </label>
                        </div>
                        <input type="hidden" name="action" value="updateDepartment">
                        <input type="hidden" name="id" value="<?php echo $department['id']; ?>">
                        <div class="col col-12">
                            <input type="submit" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>





    <?php if ('deleteDepartment' == $action) {
        $departmentId = $_REQUEST['id'];
        $deleteDepartment = "DELETE FROM department WHERE id ='{$departmentId}'";
        $result = mysqli_query($connection, $deleteDepartment);
        header("location:index.php?id=allDepartment");
    } ?>


    <?php if ('addDepartment' == $id) { ?>
        <div class="addDepartment">
            <div class="main__form">
                <div class="main__form--title text-center">Add Department</div>
                <form action="add.php" method="POST">
                    <div class="form-row">
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-building"></i>
                                <input type="text" name="namaDepartement" placeholder="Department Name" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-calendar"></i>
                                <input type="date" name="tanggalPembuatan" required>
                            </label>
                        </div>
                        <input type="hidden" name="action" value="addDepartment">
                        <div class="col col-12">
                            <input type="submit" value="Add">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>






    <!-- ---------------------- Data Departement ------------------------ -->


    <!-- ---------------------- User Profile ------------------------ -->
    <?php if ('userProfile' == $id) {
        $query = "SELECT * FROM users WHERE id='$sessionId'";
        $result = mysqli_query($connection, $query);
        $data = mysqli_fetch_assoc($result)
    ?>
        <div class="userProfile">
            <div class="main__form myProfile">
                <form action="index.php">
                    <div class="main__form--title myProfile__title text-center">My Profile</div>
                    <div class="form-row text-center">
                        <div class="col col-12 text-center pb-3">
                            <img src="assets/img/<?php echo $data['avatar']; ?>" class="img-fluid rounded-circle" alt="">
                        </div>
                        <div class="col col-12">
                            <h4><b>Full Name : </b><?php printf("%s %s", $data['fname'], $data['lname']); ?></h4>
                        </div>
                        <div class="col col-12">
                            <h4><b>Username : </b><?php printf("%s", $data['username']); ?></h4>
                        </div>
                        <input type="hidden" name="id" value="userProfileEdit">
                        <div class="col col-12">
                            <input class="updateMyProfile" type="submit" value="Update Profile">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>

    <?php if ('userProfileEdit' == $id) {
        $query = "SELECT * FROM {$sessionRole} WHERE id='$sessionId'";
        $result = mysqli_query($connection, $query);
        $data = mysqli_fetch_assoc($result)
    ?>

        <div class="userProfileEdit">
            <div class="main__form">
                <div class="main__form--title text-center">Update My Profile</div>
                <form enctype="multipart/form-data" action="add.php" method="POST">
                    <div class="form-row">
                        <div class="col col-12 text-center pb-3">
                            <img id="pimg" src="assets/img/<?php echo $data['avatar']; ?>" class="img-fluid rounded-circle" alt="">
                            <i class="fas fa-pen pimgedit"></i>
                            <input onchange="document.getElementById('pimg').src = window.URL.createObjectURL(this.files[0])" id="pimgi" style="display: none;" type="file" name="avatar">
                        </div>
                        <div class="col col-12">
                            <?php if (isset($_REQUEST['avatarError'])) {
                                echo "<p style='color:red;' class='text-center'>Please make sure this file is jpg, png or jpeg</p>";
                            } ?>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-user-circle"></i>
                                <input type="text" name="fname" placeholder="First name" value="<?php echo $data ? $data['fname'] : ''; ?>" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-user-circle"></i>
                                <input type="text" name="lname" placeholder="Last Name" value="<?php echo $data ? $data['lname'] : ''; ?>" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-user"></i>
                                <input type="text" name="username" placeholder="Username" value="<?php echo $data ? $data['username'] : ''; ?>" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-key"></i>
                                <input id="pwdinput" type="password" name="oldPassword" placeholder="Old Password" required>
                                <i id="pwd" class="fas fa-eye right"></i>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-key"></i>
                                <input id="pwdinput" type="password" name="newPassword" placeholder="New Password" required>
                                <p>Type Old Password if you don't want to change</p>
                                <i id="pwd" class="fas fa-eye right"></i>
                            </label>
                        </div>
                        <input type="hidden" name="action" value="updateProfile">
                        <div class="col col-12">
                            <input type="submit" value="Update">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>
    <!-- ---------------------- User Profile ------------------------ -->

    </div>

    </section>

    <!--------------------------------- #Main section -------------------------------->

    <!-- Optional JavaScript -->
    <script src="assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Js -->
    <script src="./assets/js/app.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#addRoleForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah aksi default form

                $.ajax({
                    type: 'POST',
                    url: 'add_role.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response); // Menampilkan pesan dari server
                        $('#addRoleModal').modal('hide'); // Menutup modal
                    },
                    error: function() {
                        alert('An error occurred.');
                    }
                });
            });
        });
    </script>

    <script>
        function submitForm() {
            var form = document.getElementById('myForm2');
            var roleSelect = document.getElementById('roleSelects');
            if (roleSelect.value) {
                form.action = 'process_permissions.php';
            } else {
                form.action = 'add.php';
            }
            form.submit();
        }
    </script>

    <script>
        function showPermissionsTable(value) {
            // Hide all permissions tables
            var tables = document.getElementsByClassName('main__table');
            for (var i = 0; i < tables.length; i++) {
                tables[i].style.display = 'none';
            }

            // Show the selected permissions table
            if (role) {
                var table = document.getElementById('permissions_' + role);
                if (table) {
                    table.style.display = 'block';
                }
            }

            var roleInput = document.getElementById('roleInput');
            roleInput.value = value;
        }
    </script>

    <script>
        document.getElementById('roleSelects').addEventListener('change', function() {
            // Hide all tables
            var tables = document.querySelectorAll("[id^='permissions_']");
            for (var i = 0; i < tables.length; i++) {
                tables[i].style.display = 'none';
            }

            // Show the selected table
            var selectedRole = this.value;
            var selectedTable = document.getElementById('permissions_' + selectedRole);
            if (selectedTable) {
                selectedTable.style.display = 'block';
            }
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#roleSelect').change(function() {
                var role = $(this).val();
                $.ajax({
                    url: 'fetch_permissions.php',
                    type: 'post',
                    data: {
                        role: role
                    },
                    success: function(response) {
                        console.log('Success response:', response); // Print success response
                        $('#permissions').html(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error response:', jqXHR); // Print error response
                        console.log(textStatus, errorThrown);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#deleteRoleForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah aksi default form

                $.ajax({
                    type: 'POST',
                    url: 'delete_role.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response); // Menampilkan pesan dari server
                        $('#deleteRoleModal').modal('hide'); // Menutup modal
                        location.reload(); // Reload halaman untuk memperbarui daftar role
                    },
                    error: function() {
                        alert('An error occurred.');
                    }
                });
            });
        });
    </script>


    <script>
        document.querySelectorAll('.sidebar__item').forEach(item => {
            item.addEventListener('click', event => {
                const arrow = item.querySelector('.arrow');
                if (arrow.classList.contains('fa-angle-left')) {
                    arrow.classList.remove('fa-angle-left');
                    arrow.classList.add('fa-angle-down'); // Change to down arrow
                } else {
                    arrow.classList.remove('fa-angle-down');
                    arrow.classList.add('fa-angle-left'); // Change to left arrow
                }
            });
        });
    </script>



    <script>
        function toggle(source) {
            checkboxes = document.querySelectorAll('input[type=\"checkbox\"]');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>



    <script>
        window.onload = function() {
            var roleSelect = document.getElementById('roleSelect');
            roleSelect.onchange = function() {
                // Hide all permissions divs and disable their checkboxes
                var permissionsDivs = document.getElementsByClassName('main__table');
                for (var i = 0; i < permissionsDivs.length; i++) {
                    permissionsDivs[i].style.display = 'none';
                    var checkboxes = permissionsDivs[i].getElementsByTagName('input');
                    for (var j = 0; j < checkboxes.length; j++) {
                        if (checkboxes[j].type == 'checkbox') {
                            checkboxes[j].disabled = true;
                        }
                    }
                }



                // Save the selected role to localStorage
                localStorage.setItem('lastSelectedRole', this.value);
            }

            // If there's a last selected role, show its table and set the dropdown value
            var lastSelectedRole = localStorage.getItem('lastSelectedRole');
            if (lastSelectedRole) {
                var lastSelectedTable = document.getElementById('permissions_' + lastSelectedRole);
                if (lastSelectedTable) {
                    lastSelectedTable.style.display = 'block';
                }
                roleSelect.value = lastSelectedRole;
            }

            // Trigger the onchange event to show the correct table and disable checkboxes
            roleSelect.onchange();

            // Prevent other roles' checkboxes from being fitted by removing them from the DOM before submit
            var form = document.getElementById('myForm');
            form.onsubmit = function() {
                var selectedRole = roleSelect.value;
                var permissionsDivs = document.getElementsByClassName('main__table');
                var divsToRemove = [];
                for (var i = 0; i < permissionsDivs.length; i++) {
                    if (permissionsDivs[i].id !== 'permissions_' + selectedRole) {
                        divsToRemove.push(permissionsDivs[i]);
                    }
                }
                for (var i = 0; i < divsToRemove.length; i++) {
                    divsToRemove[i].parentNode.removeChild(divsToRemove[i]);
                }
            }
        }
    </script>

    <script>
        document.getElementById('myForm1').addEventListener('submit', function(event) {
            event.preventDefault();

            var roleSelect = document.getElementById('roleSelect');
            if (roleSelect.value === '') {
                alert('Please select a role');
                return;
            }

            // Load checkbox states from localStorage
            var checkboxes = this.getElementsByTagName('input');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    var checkboxState = localStorage.getItem(checkboxes[i].id);
                    if (checkboxState === 'true') {
                        checkboxes[i].checked = true;
                    } else if (checkboxState === 'false') {
                        checkboxes[i].checked = false;
                    }
                }
            }

            fetch('process_permissions.php', {
                method: 'POST',
                body: new FormData(this)
            }).then(function(response) {
                if (response.ok) {
                    return response.text();
                } else {
                    throw new Error('Error: ' + response.statusText);
                }
            }).then(function(text) {
                console.log(text);
            }).catch(function(error) {
                console.error(error);
            });

            // Save checkbox states to localStorage
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    localStorage.setItem(checkboxes[i].id, checkboxes[i].checked);
                }
            }

            this.action = 'add.php';
            this.submit();
        });
    </script>

</body>

</html>