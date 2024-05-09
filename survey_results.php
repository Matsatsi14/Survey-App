<?php

require_once("config.php");


$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE) or die("Error, Unable to connect to database!");


$query = "SELECT * FROM SurveyResponses";
$result = mysqli_query($conn, $query) or die("Error, unable to fetch survey data");


$totalSurveys = mysqli_num_rows($result);


$query = "SELECT AVG(TIMESTAMPDIFF(YEAR, dob, CURDATE())) AS avgAge FROM SurveyResponses";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$averageAge = round($row['avgAge']);


$query = "SELECT MAX(TIMESTAMPDIFF(YEAR, dob, CURDATE())) AS maxAge, MIN(TIMESTAMPDIFF(YEAR, dob, CURDATE())) AS minAge FROM SurveyResponses";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$oldestAge = $row['maxAge'];
$youngestAge = $row['minAge'];


$query = "SELECT COUNT(*) AS pizzaCount FROM SurveyResponses WHERE favorite_foods LIKE '%Pizza%'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$pizzaCount = $row['pizzaCount'];
$pizzaPercentage = round(($pizzaCount / $totalSurveys) * 100, 1);


$query = "SELECT COUNT(*) AS pastaCount FROM SurveyResponses WHERE favorite_foods LIKE '%Pasta%'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$pastaCount = $row['pastaCount'];
$pastaPercentage = round(($pastaCount / $totalSurveys) * 100, 1);


$query = "SELECT COUNT(*) AS papAndWorsCount FROM SurveyResponses WHERE favorite_foods LIKE '%Pap and Wors%'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$papAndWorsCount = $row['papAndWorsCount'];
$papAndWorsPercentage = round(($papAndWorsCount / $totalSurveys) * 100, 1);


$query = "SELECT AVG(agreement1) AS avgAgreement1, AVG(agreement2) AS avgAgreement2, AVG(agreement3) AS avgAgreement3, AVG(agreement4) AS avgAgreement4 FROM SurveyResponses";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$avgAgreementMovies = round($row['avgAgreement1'], 1);
$avgAgreementRadio = round($row['avgAgreement2'], 1);
$avgAgreementEatOut = round($row['avgAgreement3'], 1);
$avgAgreementTV = round($row['avgAgreement4'], 1);


mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Results</title>
    <link rel="stylesheet" href="survey_results.css">
</head>
<body>
    <nav>
  <a class="left-link" href="survey_screen.php">_Surveys</a>
  <div>
    <a href="survey_screen.php" <?php if(basename($_SERVER['PHP_SELF']) == 'survey_screen.php') echo 'class="active"'; ?>>FILL OUT SURVEY</a>
    <a href="survey_results.php" <?php if(basename($_SERVER['PHP_SELF']) == 'survey_results.php') echo 'class="active"'; ?>>VIEW SURVEY RESULTS</a>
  </div>
</nav>

    <h1>Survey Results</h1>
    <?php if ($totalSurveys > 0): ?>
    <div class="survey-info">
    <table>
        <tr>
            <td>Total number of surveys:</td>
            <td><?php echo $totalSurveys; ?></td>
        </tr>
        <tr>
            <td>Average Age:</td>
            <td><?php echo $averageAge; ?> years old</td>
        </tr>
        <tr>
            <td>Oldest person who participated in the survey:</td>
            <td><?php echo $oldestAge; ?> years old</td>
        </tr>
        <tr>
            <td>Youngest person who participated in the survey:</td>
            <td><?php echo $youngestAge; ?> years old</td>
        </tr>
        <tr>
            <td></td> 
            <td></td> 
        </tr>
        <tr>
            <td>Percentage of people who like Pizza:</td>
            <td><?php echo $pizzaPercentage; ?>%</td>
        </tr>
        <tr>
            <td>Percentage of people who like Pasta:</td>
            <td><?php echo $pastaPercentage; ?>%</td>
        </tr>
        <tr>
            <td>Percentage of people who like Pap and Wors:</td>
            <td><?php echo $papAndWorsPercentage; ?>%</td>
        </tr>
        <tr>
            <td></td> 
            <td></td> 
        </tr>
        <tr>
            <td>People who like to watch movies:</td>
            <td><?php echo $avgAgreementMovies; ?></td>
        </tr>
        <tr>
            <td>People who like to listen to radio:</td>
            <td><?php echo $avgAgreementRadio; ?></td>
        </tr>
        <tr>
            <td>People who like to eat out:</td>
            <td><?php echo $avgAgreementEatOut; ?></td>
        </tr>
        <tr>
            <td>People who like to watch TV:</td>
            <td><?php echo $avgAgreementTV; ?></td>
        </tr>
    </table>
</div>

    <?php else: ?>
    <p>No Surveys Available</p>
    <?php endif; ?>

</body>
</html>
