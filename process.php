<?php
require 'db.php';

function safe_input($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // UPDATE
    if (isset($_POST['snoedit'])) {
        $snoEdit = intval($_POST['snoedit']);
        $notetitleEdit = safe_input($_POST['notetitleEdit']);
        $notedescEdit = safe_input($_POST['notedescEdit']);

        $stmt = $conn->prepare("UPDATE notes SET note_title = ?, note_description = ? WHERE sno = ?");
        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            header("Location: index.php?msg=error");
            exit();
        }
        
        $stmt->bind_param("ssi", $notetitleEdit, $notedescEdit, $snoEdit);
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            header("Location: index.php?msg=error");
            exit();
        }
        $stmt->close();

        header("Location: index.php?msg=updated");
        exit();
    }
    // CREATE
    else {
        $notetitle = safe_input($_POST['notetitle']);
        $notedesc = safe_input($_POST['notedesc']);

        $stmt = $conn->prepare("INSERT INTO notes (note_title, note_description, timestamp) VALUES (?, ?, CURRENT_TIMESTAMP())");
        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            header("Location: index.php?msg=error");
            exit();
        }
        
        $stmt->bind_param("ss", $notetitle, $notedesc);
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            header("Location: index.php?msg=error");
            exit();
        }
        $stmt->close();

        header("Location: index.php?msg=added");
        exit();
    }
}

// DELETE
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['delete'])) {
    $sno = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM notes WHERE sno = ?");
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        header("Location: index.php?msg=error");
        exit();
    }
    
    $stmt->bind_param("i", $sno);
    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        header("Location: index.php?msg=error");
        exit();
    }
    $stmt->close();

    header("Location: index.php?msg=deleted");
    exit();
}
?>
