function login() {
    let userName = document.getElementById("userName").value;
    let password = document.getElementById("passWord").value;


        if(userName == 'admin' && password =='admin'){

            let fullWeb = document.getElementById("full");
            let navv = document.getElementById("navi");
            let loginpage = document.querySelector(".backg");

            fullWeb.style.display = "block";
            navv.style.display = "block";
            loginpage.style.display= "none";
        }
        else{
            document.getElementById("userName").value = ''
            document.getElementById("passWord").value = ''
            alert("Incorrect username or password!!");
            let fullWeb = document.getElementById("full");
            let navv = document.getElementById("navi");
            let loginpage = document.querySelector(".backg");
            fullWeb.style.display = "none";
            navv.style.display = "none";
            loginpage.style.display= "block";
        
        }
}
function displayLogin(){
    let fullWeb = document.getElementById("full");
    let navv = document.getElementById("navi");
    let loginpage = document.querySelector(".backg");
    fullWeb.style.display = "none";
    navv.style.display = "none";
    loginpage.style.display= "block";
}

