const imgbtn = document.querySelectorAll('.imgButton');
const img = document.getElementById("imgEnlarge");
const container = document.querySelector(".imgContainer");
console.log(imgbtn);
imgbtn.forEach(btn => {
    btn.onclick = function(){
        imgId = btn.id;
        const img = document.getElementById("imgEnlarge");
        container.style.display = "block";
        img.src = imgId;
        
    }
});


function closeimg(){
    container.style.display = "none";
}



function chooseCategory(){
    console.log(selectedValue);
    var selectedValue = document.getElementById('categorySort').value;
    localStorage.setItem("selected", selectedValue);
    console.log(localStorage.getItem("selected"));
    document.getElementById('categoryPicker').submit();

}

const select = document.getElementById(localStorage.getItem("selected"));
select.setAttribute("selected", "selected");

function myFunction(){
    var x = document.getElementById("myTopnav");
    if(x.className === "topnav"){
        x.className += "responsive";
    }else{
        x.className = "topnav";
    }
}

