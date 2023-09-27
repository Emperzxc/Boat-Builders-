<?php
require 'database_connection.php';

$event_name = $_POST['event_name'];
$event_start_date = date("y-m-d", strtotime($_POST['event_start_date']));
$event_end_date = date("y-m-d", strtotime($_POST['event_end_date']));

// Check if the event_name already exists in the database
$check_query = "SELECT * FROM `calendar_event_master` WHERE `boatID` = '$event_name'";
$result = mysqli_query($con, $check_query);

if (mysqli_num_rows($result) > 0) {
    // The event_name already exists in the database
    $data = array(
        'status' => false,
        'msg' => 'Event with the same boatID already exists. Make sure that you do not have an existing schedule for this boat.'
    );
} else {
    // Insert the event into the database
    $insert_query = "INSERT INTO `calendar_event_master` (`boatID`, `event_start_date`, `event_end_date`) VALUES ('$event_name', '$event_start_date', '$event_end_date')";
    
    if (mysqli_query($con, $insert_query)) {
        $data = array(
            'status' => true,
            'msg' => 'Event added successfully!'
        );
    } else {
        $data = array(
            'status' => false,
            'msg' => 'Sorry, Event not added. Please check '
        );
    }
}

echo json_encode($data);
?>
