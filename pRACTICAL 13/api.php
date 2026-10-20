<?php
header("Content-Type: application/json; charset=UTF-8");

include "db.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method == "GET") {

    $result = mysqli_query($conn, "SELECT * FROM events ORDER BY id DESC");

    $events = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row;
    }

    echo json_encode($events);
    exit;
}

if ($method == "POST") {

    $data = json_decode(file_get_contents("php://input"), true);

    if (!is_array($data) || !isset($data["action"])) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Invalid request"
        ]);
        exit;
    }

    $action = $data["action"];

    if ($action == "add") {

        $name = trim($data["event_name"] ?? "");
        $date = $data["event_date"] ?? "";

        if ($name == "" ||
            !preg_match("/^\d{4}-\d{2}-\d{2}$/", $date) ||
            !checkdate((int)substr($date, 5, 2),
                       (int)substr($date, 8, 2),
                       (int)substr($date, 0, 4))) {

            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Enter valid event name and date"
            ]);
            exit;
        }

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO events (event_name, event_date) VALUES (?, ?)"
        );

        mysqli_stmt_bind_param($stmt, "ss", $name, $date);
        $ok = mysqli_stmt_execute($stmt);

        echo json_encode([
            "success" => $ok,
            "message" => $ok ? "Event added successfully" : "Add failed"
        ]);
        exit;
    }

    if ($action == "update") {

        $id = filter_var($data["id"] ?? null, FILTER_VALIDATE_INT);
        $name = trim($data["event_name"] ?? "");
        $date = $data["event_date"] ?? "";

        if (!$id || $name == "" ||
            !preg_match("/^\d{4}-\d{2}-\d{2}$/", $date) ||
            !checkdate((int)substr($date, 5, 2),
                       (int)substr($date, 8, 2),
                       (int)substr($date, 0, 4))) {

            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Invalid event details"
            ]);
            exit;
        }

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE events SET event_name=?, event_date=? WHERE id=?"
        );

        mysqli_stmt_bind_param($stmt, "ssi", $name, $date, $id);
        $ok = mysqli_stmt_execute($stmt);

        echo json_encode([
            "success" => $ok,
            "message" => $ok ? "Event updated successfully" : "Update failed"
        ]);
        exit;
    }

    if ($action == "delete") {

        $id = filter_var($data["id"] ?? null, FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Invalid event ID"
            ]);
            exit;
        }

        $stmt = mysqli_prepare(
            $conn,
            "DELETE FROM events WHERE id=?"
        );

        mysqli_stmt_bind_param($stmt, "i", $id);
        $ok = mysqli_stmt_execute($stmt);
        $deleted = mysqli_stmt_affected_rows($stmt);

        echo json_encode([
            "success" => $ok && $deleted > 0,
            "message" => ($ok && $deleted > 0)
                ? "Event deleted successfully"
                : "Event not found or delete failed"
        ]);
        exit;
    }

    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Unknown action"
    ]);
    exit;
}

http_response_code(405);
echo json_encode([
    "success" => false,
    "message" => "Method not allowed"
]);