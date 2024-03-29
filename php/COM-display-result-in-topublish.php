<?php
require 'database_connect.php';

// Query the competition table
$sql = "SELECT * FROM competition WHERE is_archived='0'";
$result = $conn->query($sql);

// If there are competitions, generate HTML code for each of them
if ($result->num_rows > 0) {
    ?>
    <script type="text/javascript">
        document.getElementById('empty').style.display = 'none';
        console.log("display result");
        console.log("Working");
    </script>
    <?php

    while ($row = $result->fetch_assoc()) {
        $competitionNameQuery = "SELECT category_name FROM ongoing_list_of_event WHERE event_id =" . $row["event_id"];
        $competitionNameResult = $conn->query($competitionNameQuery);
    
        if ($competitionNameResult->num_rows > 0) {
            $competitionNameRow = $competitionNameResult->fetch_assoc();
            $competitionName = $competitionNameRow["category_name"];
        } else {
            $competitionName = "Unknown";
        }
        $competition_id = $row['competition_id'];
        $event_id = $row['event_id'];

        // Query the ongoing_criterion table to get the criteria for this competition
        $criteria_sql = "SELECT * FROM ongoing_criterion WHERE event_id = '$event_id'";
        $criteria_result = $conn->query($criteria_sql);

        // Generate HTML code for each competition
        echo "<div class='result_container'>";
        // Display the name of the competition and a button with the competition ID as the ID
        
        echo "<h2 class='parent' id='" . $competitionName ."'>" . $competitionName . "<br><input type='text' name='datetimes' placeholder='No schedule yet...' id='".$competitionName."-input' class='sched_output' disabled/><button class='sched_btn primary-button' id='" . $competitionName . " btn'>Schedule</button></h2>";
      // Generate HTML code for the result div and table
        echo "<div class='result'>";
        echo "<table>";
        echo "<tbody class='responsive-table'>";
        echo "<tr><th>Name</th><th>Organization</th>";

        // Generate HTML code for the criteria columns
        while ($criterion_row = $criteria_result->fetch_assoc()) {
            echo "<th>" . $criterion_row["criterion_name"] . "</th>";
        }

        echo "<th>Overall Score</th></tr>";

        // Query the participants table for this competition
        $participants_sql = "SELECT * FROM participants WHERE competition_id = '$competition_id'";
        $participants_result = $conn->query($participants_sql);

        // Generate HTML code for the scores rows
        while ($participant_row = $participants_result->fetch_assoc()) {
            $participant_name = $participant_row["participant_name"];
            $organization_id = $participant_row["organization_id"];
            $participant_id = $participant_row["participants_id"];

            // Query the organization table to get the organization name
            $org_sql = "SELECT organization_name FROM organization WHERE organization_id = '$organization_id'";
            $org_result = $conn->query($org_sql);
            $organization_name = $org_result->fetch_assoc()["organization_name"];

            echo "<tr><td>" . $participant_name . "</td><td>" . $organization_name . "</td>";

            // Loop through each criterion to get the scores for this participant
            $criteria_result->data_seek(0);
            $total_score = 0;

            while ($criterion_row = $criteria_result->fetch_assoc()) {
                $criterion_id = $criterion_row["criterion_id"];

                // Query the criterion_scoring table to get the final score for this participant and criterion
                $score_sql = "SELECT criterion_final_score FROM criterion_scoring WHERE ongoing_criterion_id = '$criterion_id' AND participants_id = '$participant_id'";
                $score_result = $conn->query($score_sql);
                $final_score = $score_result->fetch_assoc()["criterion_final_score"];

                if ($final_score !== null) {
                    $total_score += $final_score;
                    echo "<td>" . $final_score . "</td>";
                } else {
                    echo "<td></td>";
                }
            }

            echo "<td>" . $total_score . "</td></tr>";
        }

        echo "</tbody></table></div>";
        echo "</div>";
    }
} else {
    // If there are no competitions, display a message
    ?>
    <script>
        var empty = document.getElementById('empty');
        var searchbar = document.querySelector('.inputAndDeleteDiv');
        var pagini = document.querySelector('.pagination');
        empty.style.display = 'flex';
        searchbar.style.display = 'none';
        pagini.style.display = 'none';
    </script>
    <?php
}

// Close connection
$conn->close();
?>
