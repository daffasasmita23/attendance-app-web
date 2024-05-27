<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Koneksi ke database
    $db = new mysqli('localhost:3307', 'root', '', 'pms');

    if ($db->connect_error) {
        die("Koneksi gagal: " . $db->connect_error);
    }

    // Ekstraksi data form
    $role = isset($_POST['role']) ? $_POST['role'] : null;

// Tambahkan pemeriksaan ini
if (empty($role)) {
    die("Role tidak boleh kosong");
}

    // Hanya handle checkbox yang berhubungan dengan role yang dipilih
    $addUser = isset($_POST['addUser_' . $role]) ? 1 : 0;
    $editUser = isset($_POST['editUser_' . $role]) ? 1 : 0;
    $viewUser = isset($_POST['viewUser_' . $role]) ? 1 : 0;

    $addEvent = isset($_POST['addEvent_' . $role]) ? 1 : 0;
    $editEvent = isset($_POST['editEvent_' . $role]) ? 1 : 0;
    $viewEvent = isset($_POST['viewEvent_' . $role]) ? 1 : 0;

    $addEmployee = isset($_POST['addEmployees_' . $role]) ? 1 : 0;
    $editEmployee = isset($_POST['editEmployees_' . $role]) ? 1 : 0;
    $viewEmployee = isset($_POST['viewEmployees_' . $role]) ? 1 : 0;

    $addAttendance = isset($_POST['addAttendance_' . $role]) ? 1 : 0;
    $editAttendance = isset($_POST['editAttendance_' . $role]) ? 1 : 0;
    $viewAttendance = isset($_POST['viewAttendance_' . $role]) ? 1 : 0;

    $addDepartment = isset($_POST['addDepartment_' . $role]) ? 1 : 0;
    $editDepartment = isset($_POST['editDepartment_' . $role]) ? 1 : 0;
    $viewDepartment = isset($_POST['viewDepartment_' . $role]) ? 1 : 0;

    // Cek apakah role sudah ada
    $sql = "SELECT * FROM permissions WHERE role=?";
    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param('s', $role);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            // Role sudah ada, lakukan update
            $stmt->close();
            $sqlUpdate = "UPDATE permissions SET addUser=?, editUser=?, viewUser=?, addEvent=?, editEvent=?, viewEvent=?, addEmployees=?, editEmployees=?, viewEmployees=?, addAttendance=?, editAttendance=?, viewAttendance=?, addDepartment=?, editDepartment=?, viewDepartment=? WHERE role=?";
            if ($stmtUpdate = $db->prepare($sqlUpdate)) {
                $stmtUpdate->bind_param(
                    'iiiiiiiiiiiiiiis',
                    $addUser,
                    $editUser,
                    $viewUser,
                    $addEvent,
                    $editEvent,
                    $viewEvent,
                    $addEmployee,
                    $editEmployee,
                    $viewEmployee,
                    $addAttendance,
                    $editAttendance,
                    $viewAttendance,
                    $addDepartment,
                    $editDepartment,
                    $viewDepartment,
                    $role
                );
                $stmtUpdate->execute();
                $stmtUpdate->close();
            } else {
                die("Error preparing update statement: " . $db->error);
            }
        } else {
            // Role belum ada, lakukan insert
            $stmt->close();
            $sqlInsert = "INSERT INTO permissions (role, addUser, editUser, viewUser, addEvent, editEvent, viewEvent, addEmployees, editEmployees, viewEmployees, addAttendance, editAttendance, viewAttendance, addDepartment, editDepartment, viewDepartment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            if ($stmtInsert = $db->prepare($sqlInsert)) {
                $stmtInsert->bind_param(
                    'siiiiiiiiiiiiiis',
                    $role,
                    $addUser,
                    $editUser,
                    $viewUser,
                    $addEvent,
                    $editEvent,
                    $viewEvent,
                    $addEmployee,
                    $editEmployee,
                    $viewEmployee,
                    $addAttendance,
                    $editAttendance,
                    $viewAttendance,
                    $addDepartment,
                    $editDepartment,
                    $viewDepartment
                );
                $stmtInsert->execute();
                $stmtInsert->close();
            } else {
                die("Error preparing insert statement: " . $db->error);
            }
        }
    } else {
        die("Error preparing select statement: " . $db->error);
    }
    

    echo "<script type='text/javascript'>window.alert('Data has been updated'); window.location.href='index.php?id=allGroup';</script>";
   

    
    // Tutup koneksi
    $db->close();
}



?>
