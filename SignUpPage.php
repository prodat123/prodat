<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" href="styles/SignUpPageCss.css"></link>
    <meta name="viewport" content="width=device-width, intital-scale=1.0">
    <title>Register</title>
</head>
<body>
  <form id="regForm" action="SignUp.php" method="post">
    <h1>Register:</h1>
    <!-- One "tab" for each step in the form: -->
    <div class="tab">
      <p>Username: <input placeholder="name..." oninput="this.className = ''" name="Username"></p>
      
      <p>Occupation</p> 
      <input type="text" oninput="this.className = ''" name="Occupation" list="occupation-list">
      <datalist id="occupation-list">
        <option value="student">student</option>
        <option value="teacher">teacher</option>
      </datalist>
      
      
    </div>
    <div class="tab">
      Email: <p><input placeholder="@email.com" oninput="this.className = ''" name="Email" id="email" type="email"></p>
      Password: <p><input placeholder="password..." oninput="this.className = ''" name="Password" id="psd" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" type="password"></p>
      <h5 style="color: grey">*at least 1 lowercase letter, at least 1 capital letter, at least 1 number, at least 8 characters</h5>
      Verify Password: <p><input placeholder="password..." oninput="this.className = ''" name="VerifyPassword" id="verifypsd" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" type="password"></p>
    </div>
    
    
    <div style="overflow:auto;">
      <div style="float:right;">
        <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
        <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
      </div>
    </div>
    <!-- Circles which indicates the steps of the form: -->
    <div style="text-align:center;margin-top:40px;">
      <span class="step"></span>
      <span class="step"></span>
    </div>
  </form>

    

<script src="static/Javascript/SignUpJs.js"></script>

</body>
</html>