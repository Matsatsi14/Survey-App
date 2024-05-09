<?php

$name = isset($_REQUEST['name']) ? $_REQUEST['name'] : "";
$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";
$dob = isset($_REQUEST['dob']) ? $_REQUEST['dob'] : "";
$contactnumber = isset($_REQUEST['contactnumber']) ? $_REQUEST['contactnumber'] : "";
$favorite_foods = isset($_REQUEST['favorite_foods']) ? implode(", ", $_REQUEST['favorite_foods']) : "";
$agreement1 = isset($_REQUEST['agreement1']) ? $_REQUEST['agreement1'] : "";
$agreement2 = isset($_REQUEST['agreement2']) ? $_REQUEST['agreement2'] : "";
$agreement3 = isset($_REQUEST['agreement3']) ? $_REQUEST['agreement3'] : "";
$agreement4 = isset($_REQUEST['agreement4']) ? $_REQUEST['agreement4'] : "";


require_once("config.php");


$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE) or die("Error, Unable to connect to database!");


$query = "INSERT INTO SurveyResponses (name, email, dob, contactnumber, favorite_foods, agreement1, agreement2, agreement3, agreement4)
            VALUES ('$name', '$email', '$dob', '$contactnumber', '$favorite_foods', '$agreement1', '$agreement2', '$agreement3', '$agreement4')";
$result = mysqli_query($conn, $query) or die("Error, unable to insert survey responses");


mysqli_close($conn);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey App</title>
    <script>
      function validateForm() {
        let name = document.getElementById("name").value;
        let email = document.getElementById("email").value;
        let dob = document.getElementById("dob").value;
        let contactnumber = document.getElementById("contactnumber").value;
        let favoriteFoods = document.querySelectorAll(
          "input[name='favorite_foods[]']:checked"
        ).length;
        let agreement1 = document.querySelectorAll(
          "input[name='agreement1']:checked"
        ).length;
        let agreement2 = document.querySelectorAll(
          "input[name='agreement2']:checked"
        ).length;
        let agreement3 = document.querySelectorAll(
          "input[name='agreement3']:checked"
        ).length;
        let agreement4 = document.querySelectorAll(
          "input[name='agreement4']:checked"
        ).length;

        if (
          name === "" ||
          email === "" ||
          dob === "" ||
          contactnumber === "" ||
          favoriteFoods === 0 ||
          agreement1 === 0 ||
          agreement2 === 0 ||
          agreement3 === 0 ||
          agreement4 === 0
        ) {
          alert(
            "Please fill out all fields and select a rating for each question."
          );
          return false;
        }

        let age = new Date().getFullYear() - new Date(dob).getFullYear();
        if (age < 5 || age > 120) {
          alert(
            "You must be between the ages of 5 and 120 to fill out this survey."
          );
          return false;
        }

        if (!/^\d{10}$/.test(contactnumber)) {
          alert(
            "Please enter a valid South African contact number with 10 digits."
          );
          return false;
        }

        return true;
      }
      function showConfirmationMessage(name) {
        alert("Thank you, " + name + "! Your survey responses have been successfully recorded!");
      }
    </script>
</head>
<body>
    <nav>
  <a class="left-link" href="survey_screen.php">_Surveys</a>
  <div>
    <a href="survey_screen.php" <?php if(basename($_SERVER['PHP_SELF']) == 'survey_screen.php') echo 'class="active"'; ?>>FILL OUT SURVEY</a>
    <a href="survey_results.php" <?php if(basename($_SERVER['PHP_SELF']) == 'survey_results.php') echo 'class="active"'; ?>>VIEW SURVEY RESULTS</a>
  </div>
</nav>
    <form
      action="survey_screen.php"
      method="POST"
      onsubmit="showConfirmationMessage(document.getElementById('name').value); return validateForm();"
      id="survey-form"
    >
      <p>
  Personal Details:
  <label for="name" style="margin-left: 125px">Full Names</label><br />
  <input
    type="text"
    class="input-field"
    id="name"
    name="name"
    required
  /><br /><br />
  <label for="email" style="margin-left: 250px">Email</label><br />
  <input
    type="email"
    class="input-field"
    id="email"
    name="email"
    required
  /><br /><br />
  <label for="dob" style="margin-left: 250px">Date of Birth</label><br />
  <input
    type="date"
    class="input-field"
    id="dob"
    name="dob"
    required
  /><br /><br />
  <label for="contactnumber" style="margin-left: 250px"
    >Contact Number</label
  ><br />
  <input
    type="tel"
    class="input-field"
    id="contactnumber"
    name="contactnumber"
    pattern="[0-9]{10}"
    required
  /><br /><br />
</p>

      <div class="food">
        <p>
          What is your favourite food?
          <label
            ><input type="checkbox" name="favorite_foods[]" value="Pizza" />
            Pizza</label
          >
          <label
            ><input type="checkbox" name="favorite_foods[]" value="Pasta" />
            Pasta</label
          >
          <label
            ><input
              type="checkbox"
              name="favorite_foods[]"
              value="Pap and Wors"
            />
            Pap and Wors</label
          >
          <label
            ><input type="checkbox" name="favorite_foods[]" value="Other" />
            Other</label
          >
        </p>
      </div>
      <br />
      <p>
        Please rate your level of agreement on scale from 1 to 5, with 1 being
        "Strongly Agree" and 5 being "Strongly Disagree."
      </p>
      <table border="1">
        <thead>
          <tr>
            <th>Agreement</th>
            <th>Strongly Agree</th>
            <th>Neutral</th>
            <th>Agree</th>
            <th>Disagree</th>
            <th>Strongly Disagree</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>I like to watch movies</td>
            <td><input type="radio" name="agreement1" value="1" /></td>
            <td><input type="radio" name="agreement1" value="2" /></td>
            <td><input type="radio" name="agreement1" value="3" /></td>
            <td><input type="radio" name="agreement1" value="4" /></td>
            <td><input type="radio" name="agreement1" value="5" /></td>
          </tr>
          <tr>
            <td>I like to listen to radio</td>
            <td><input type="radio" name="agreement2" value="1" /></td>
            <td><input type="radio" name="agreement2" value="2" /></td>
            <td><input type="radio" name="agreement2" value="3" /></td>
            <td><input type="radio" name="agreement2" value="4" /></td>
            <td><input type="radio" name="agreement2" value="5" /></td>
          </tr>
          <tr>
            <td>I like to eat out</td>
            <td><input type="radio" name="agreement3" value="1" /></td>
            <td><input type="radio" name="agreement3" value="2" /></td>
            <td><input type="radio" name="agreement3" value="3" /></td>
            <td><input type="radio" name="agreement3" value="4" /></td>
            <td><input type="radio" name="agreement3" value="5" /></td>
          </tr>
          <tr>
            <td>I like to watch TV</td>
            <td><input type="radio" name="agreement4" value="1" /></td>
            <td><input type="radio" name="agreement4" value="2" /></td>
            <td><input type="radio" name="agreement4" value="3" /></td>
            <td><input type="radio" name="agreement4" value="4" /></td>
            <td><input type="radio" name="agreement4" value="5" /></td>
          </tr>
        </tbody>
      </table>
      <br /><br />
      <input type="submit" value="Submit" />
    </form>
</body>
</html>