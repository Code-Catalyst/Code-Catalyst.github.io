<?php
include 'database_connect.php';
include 'P&J-admin-authenticate.php';

// Get the event code and judge name from the request
$data = json_decode(file_get_contents('php://input'), true);
$eventCode = $data['event_code'];
$judgeName = $data['judge_name'];

// Query the ongoing_list_of_event table to get the event ID based on the event code
$eventQuery = "SELECT event_id FROM ongoing_list_of_event WHERE event_code = '$eventCode'";
$eventResult = $conn->query($eventQuery);

if ($eventResult->num_rows > 0) {
  $eventRow = $eventResult->fetch_assoc();
  $eventId = $eventRow['event_id'];

  // Fetch the criteria data using the event ID and judge name
  $criteriaQuery = "SELECT oc.ongoing_criterion_id, oc.criterion_name, oc.criterion_percent
                    FROM ongoing_criterion oc
                    INNER JOIN competition c ON oc.event_id = c.event_id
                    INNER JOIN judges j ON c.competition_id = j.competition_id
                    WHERE c.event_id = $eventId AND j.judge_name = '$judgeName'";

  $criteriaResult = $conn->query($criteriaQuery);

  if ($criteriaResult->num_rows > 0) {
    // Create and display the criteria table
    echo '<form action="php/P&J-admin-action-scores.php" method="POST">';
    echo '<table>';
    echo '<tr><th>Criterion Name</th><th>Criterion Percent</th></tr>';

    while ($row = $criteriaResult->fetch_assoc()) {
      echo '<tr>';
      echo '<td> <label class="col-form-label" style="color: rgb(255,255,255);">' . $row['criterion_name'] . '</label></td>';
      echo '<td> <input type="number" class="cforms scoreinp" name="criterion_temp_score[]" style="text-align: center;color: white !important;background: rgba(0,0,0,0.22) !important;" min="1" max="10" placeholder="10" oninput="checkInputs()" required>';
      echo '<input type="hidden" name="ongoing_criterion_ids[]" value="' . $row['ongoing_criterion_id'] . '"></td>';
      echo '</tr>';
    }

    echo '</table>';
    echo '<div class="col offset-xl-2 offset-xxl-1" style="text-align: center;">
      <div class="btn-toolbar" style="text-align: center;">
          <div class="btn-group" role="group" style="text-align: center;margin-top: 10px; 
          align-items: center;">
          <button class="primary-button" type="submit" value="Add" id="save_btnS" name="save_scores">Save</button>
          <button onclick="showSubmit()" class="success-button buttonsubmit" type="submit" style="text-align: center;"  value="Add" id="submit_btnS" name="submit_scores">Submit</button>
          <button onclick="showCancel()" class="secondary-button delJ" id="cancelButton" type="button"  style="display:inline;" disabled>Cancel</button>
          </div>
      </div>
  </div>';
  } else {
    echo 'No criteria found.';
  }
} else {
  echo 'Event not found.';
}

$conn->close();
?>

