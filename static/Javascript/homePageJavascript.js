var count = 0;
const profileButton = document.querySelector(".profileButton");

if (profileButton !== null){
    profileButton.addEventListener("click", () => {
        if (count == 0){
            const profileBox = document.getElementById("profileBox");
            profileBox.style.display = "block";
            count += 1;
        }
        else{
            profileBox.style.display = "none";
            count = 0;
        }
        
    })
}




const signInButton = document.querySelector("#SignInButton");
console.log(signInButton);
if (signInButton !== null){
    signInButton.addEventListener("click", () => {
        document.getElementById('id03').style.display="block";
        
    })
}

function myFunction(){
    var x = document.getElementById("myTopnav");
    if(x.className === "topnav"){
        x.className += "responsive";
    }else{
        x.className = "topnav";
    }
}

function closeChannels(){
    alert("Hello");
    //document.querySelector(".channelContainer").style.display = "none";
}



