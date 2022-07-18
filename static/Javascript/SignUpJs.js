var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  if (currentTab >= x.length) {
    //...the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

const passwordInput = document.getElementById("psd");
const passwordVerification = document.getElementById("verifypsd")
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");


passwordInput.onblur = function(){
  document.getElementById("message").style.display = "none";
}


function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  var psdValidation = true;
  var emailValidation = true;
  var psdVerification = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:

  for (i = 0; i < y.length; i++) {
    
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].classList.add("invalidInput");
      
      // and set the current valid status to false:
      valid = false;
    }else{
      if(y[i].id == "psd"){
        
        var lowerCaseLetters = /[a-z]/g;
        var upperCaseLetters = /[A-Z]/g;
        var numbers = /[0-9]/g;
        if(passwordInput.value.match(lowerCaseLetters) && passwordInput.value.match(upperCaseLetters) && passwordInput.value.match(numbers) && passwordInput.value.length >= 8){
          psdValidation = true;
        }else{
          psdValidation = false;
          passwordInput.classList.add("invalidInput");
        }

        if(passwordInput.value == passwordVerification.value){
          psdVerification = true;
        }else{
          psdVerification = false;
          passwordVerification.classList.add("invalidInput");
        }
        
      }
      if(y[i].id == "email"){
        const emailInput = document.getElementById("email");
        if(!emailInput.checkValidity()){
          emailValidation = false;
          emailInput.classList.add("invalidInput");
        }else{
          emailValidation = true;
        }
      }
      
      if(psdValidation && emailValidation && psdVerification){
        valid = true;
      }else{
        valid = false;
      }
      
    } 
      
    
      
  }
    
  
  
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].classList.add("finish");
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}