<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="images\kapeShop-logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <style>
/**css */
    /**body */
        body{
            padding: 0;
            margin:0;
            text-align: center;
            font-size: 1vw;
            font-family: Arial, sans-serif;
        }
        .bg{
            background-image: url("images/reglog-bg.jpg");
            background-size: 100vw;
            background-repeat: no-repeat;
            background-blend-mode: darken;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.3);
            filter: blur(10px);
            z-index: -1;
        }
    /*signup*/
        .signupForm{
            position: absolute;
            top: 5vw;
            width: 30vw;
            height: 30vw;
            margin: 5vw 35vw 20vw 35vw;
            background-color: rgba(255, 245, 221, 0.75);
            border-radius:12px;
            filter: drop-shadow(5px 5px 10px rgba(0, 0, 0, 1));
            overflow: hidden;
        }
        .signupForm::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("images/kapeShop-logo.png");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            filter: blur(5px); /* Adjust blur level */
            z-index: -1; /* Ensures it stays behind the content */
        }
        .logo{
            position: absolute;
            top:5px;
            left:230px;
            width: 20%;
            height: 20%;
            filter: drop-shadow(5px 5px 10px rgba(0, 0, 0, .5));
        }
        .signupForm h1{
            margin-top: 130px;
            filter: drop-shadow(5px 5px 10px rgba(0, 0, 0, .5));
        }
        .inputForm{
            display: flex;
            width: 75%;
            height: 10%;
            margin: auto;
            margin: 5% auto;
            border-radius:50px;
            background-color: white;
            filter: drop-shadow(5px 5px 10px rgba(0, 0, 0, .5));
        }
        .inputForm img{
            width: 15%;
            height: 100%;
        }
        .inputForm input{
            width: 85%;
            border: none;
            border-radius:50px;
        }
        .signUpBtn{
            width: 75%;
            height: 10%;
            border-radius:12px;
            background-color: rgba(153, 112, 23, 0.75);
            color: white;
            border: none;
            font-size: 1em;
            filter: drop-shadow(5px 5px 10px rgba(0, 0, 0, .5));
            transition: .5s ease;
        }
        .signUpBtn:hover{
            background-color: rgb(255, 255, 255);
            border: 1px solid rgba(153, 112, 23, 0.75);
            color: rgba(153, 112, 23, 0.75);
        }
        .back{
            position: absolute;
            top:0px;
            left:0px;
            width: 10%;
            height: 10%;
            filter: drop-shadow(5px 5px 10px rgba(0, 0, 0, .5));
            transition: .5s ease;
        }
        .back:hover{
            width: 11%;
            height: 11%;
        }
    /**captcha */
        .captcha{
            border:1px solid rgba(153, 112, 23);
            width: 28vw;
            height: 15vw;
            border-radius: 12px;
            background-color: rgb(224, 179, 80);
            position: absolute;
            top:430px;
            left: 690px;
            display: none;
        }
        .captcha p{
            color: white;
        }
        .captcha img{
            width: 80%;
            margin: 10px;
            border: 1px solid rgba(153, 112, 23, 0.75);
            border-radius: 12px;
        }
        .captcha input{
            width: 30%;
            margin: 10px;
            border:1px solid rgba(153, 112, 23, 0.75);
            height: 30px;
            border-radius: 12px;
        }
        .captcha button{
            width: 20%;
            border: none;
            height: 30px;
            border-radius: 12px;
            background-color: rgba(153, 112, 23, 0.75);
            color: white;
            font-size: 1.2em;
        }
        .captcha button:hover{
            background-color: white;
            color: rgba(153, 112, 23, 0.75);
            border: 1px solid rgba(153, 112, 23, 0.75);
        }
    /**email verification */
        .verEmail{
            border:1px solid rgba(153, 112, 23);
            width: 28vw;
            height: 15vw;
            border-radius: 12px;
            background-color: rgb(224, 179, 80);
            position: absolute;
            top:430px;
            left: 690px;
            display:none;
        }
        .verEmail p{
            color: white;
            font-size: 2em;
        }
        .verEmail input{
            width: 60%;
            margin: 10px;
            border:1px solid rgba(153, 112, 23, 0.75);
            height: 50px;
            border-radius: 12px;
        }
        .verEmail button{
            width: 50%;
            border: none;
            height: 50px;
            border-radius: 12px;
            background-color: rgba(153, 112, 23, 0.75);
            color: white;
            font-size: 1.2em;
        }
        .verEmail button:hover{
            background-color: white;
            color: rgba(153, 112, 23, 0.75);
            border: 1px solid rgba(153, 112, 23, 0.75);
        }
    /**alert */
        .alert {
            position: absolute;
            top: 120px;
            left: 50px;
            color: white;
            width: 20%;
            height: 60px;
            opacity: 0;
            visibility: hidden;
            padding-left: 10px;
            border-radius: 20px;
            z-index: 1;
            transition:0.5s ease-in-out;
        }
        .alert.show {
            opacity: 1;
            visibility: visible;
        }
        .alert img {
            width: 100%;
        }
        .alert p {
            width: 85%;
            text-align: left;
        }
        .alert button {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 7%;
            padding: 0px;
            line-height: 0;
            border: none;
            background: transparent;
        }
    /**animation */
        .move-up{
            opacity: 0;
            transform: translateY(50px);
            transition: opacity .5s ease, transform 1s ease; 
        }
        .move-up.visible1 {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
<!--content-->
        <div class="bg"></div>
    <!--alert-->
        <div class="alert" id="alert">
            <p id="alertText">text</p>
            <button id="closeBtn"><img  src="images/icon-close.png"></button>
        </div>
    <!--signin form-->
        <form class="signupForm move-up" id="signupForm">
            <img class="logo move-up" src="images/profile-icon.png">
            <h1 class="move-up">SIGN UPP</h1>
            <div class="inputForm move-up">
                <img src="images/email-icon.png">
                <input type="email" id="signupEmail" name="signupEmail" placeholder="Email" required>
            </div>
            <div class="inputForm move-up">
                <img src="images/password-icon.png">
                <input type="password" id="signupPass" name="signupPass" placeholder="Password" required>
            </div>
            <div class="inputForm move-up">
                <img src="images/password-icon.png">
                <input type="password" id="signupConPass" name="signupConPass" placeholder="Confirm Password" required>
            </div>
            <button type="submit" class="signUpBtn move-up" onclick="signup(event)">Signup</button>
            <a href="landingPage_index.php">
                <img class="back move-up" src="images/back-icon.png" alt="Back">
            </a>
        </form>
    <!--captcha-->    
        <div class="captcha" id="captcha">
            <p>Captcha verification</p>
            <img id="captchaImg" src="images/captcha1.png"><br>
            <input type="text" id="captchaInput" placeholder="Enter here" required><br>
            <button id="verifyCaptchaImg" onclick="verifyCaptchaCode()">verify</button>
        </div>
    <!--verify Email-->    
        <div class="verEmail" id="verEmail">
            <p>Email verification</p>
            <input type="number" id="emailCodeInput" placeholder="Enter code here" required>
            <button id="verifyEmail" onclick="verifyEmailCode()">verify</button>
        </div>
<!-- script -->
    <script>
    //sign up
        function signup(event) {
            event.preventDefault();
            const email = document.getElementById("signupEmail").value.trim();
            const password = document.getElementById("signupPass").value.trim();
            const confirmPass = document.getElementById("signupConPass").value.trim();
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    const xmlDoc = this.responseXML;
                    const users = xmlDoc.getElementsByTagName("user");
                    let emailExists = false;
                    for (let i = 0; i < users.length; i++) {
                        const existingEmail = users[i].getElementsByTagName("email")[0].textContent;
                        if (existingEmail === email) {
                            emailExists = true;
                            break;
                        }
                    }
                    if (email=="" || password=="" || confirmPass=="") {
                        showAlert("Please fill all the blanks.", "rgb(247, 84, 84)");
                    }else if (emailExists) {
                        showAlert("Email already exists.", "rgb(247, 84, 84)");
                        document.getElementById("signupEmail").value = "";
                    } else if (password !== confirmPass) {
                        showAlert("Passwords do not match.", "rgb(247, 84, 84)");
                        document.getElementById("signupConPass").value = "";
                        document.getElementById("signupPass").value = "";
                    } else {
                    //captcha
                        captchaSelector();
                    }
                }
            };
            xhttp.open("GET", "xmlFiles/userData.xml", true);
            xhttp.send();
        }
    //captcha
        let captcha = ["images/captcha1.png","images/captcha2.png","images/captcha3.png"];
        let matchValue = ["mwxe2", "AAXUE", "263S2V"];
        let selectedCaptcha = 0;
        let emailVerCode = 0;
        
        function captchaSelector(){
            let picked = Math.floor(Math.random() * 3);
            selectedCaptcha=picked;
            document.getElementById("captchaImg").src = captcha[picked];
            document.getElementById("verifyCaptchaImg").value = matchValue[picked];
            document.getElementById("captcha").style.display = "block";
        }
        function verifyCaptchaCode(){
            let ans = document.getElementById("captchaInput").value;
            if(matchValue[selectedCaptcha]===ans){
                sendEmail();
                showAlert("Check your email for the code", "rgb(36, 221, 67)");
                document.getElementById("captcha").style.display = "none";
                document.getElementById("captchaInput").value = "";
            //show email verification div
                document.getElementById("verEmail").style.display = "block";
            }else{
                document.getElementById("captcha").style.display = "none";
                document.getElementById("captchaInput").value = "";
                showAlert("code do not match.", "rgb(247, 84, 84)");
            }
        }
    //send email
        function sendEmail(){
            const email = document.getElementById("signupEmail").value;
                const xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 200) {
                        emailVerCode = this.responseText.trim();
                    }
                };
                xhttp.open("GET", "func-emailVerify.php?email=" + encodeURIComponent(email), true);
                xhttp.send();
        }
    //email verification
        function verifyEmailCode(){
            let inputEmailVerCode = document.getElementById("emailCodeInput").value; 
            let inputEmail = document.getElementById("signupEmail").value;
            let inputPass = document.getElementById("signupPass").value;
            console.log(emailVerCode);
            if(emailVerCode== inputEmailVerCode){
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "func-saveUser.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    console.log(xhr.readyState, xhr.status);
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        showAlert("Signup successful! log in your account.", "rgb(36, 221, 67)");
                        document.getElementById("signupForm").reset();
                        document.getElementById("verEmail").style.display = "none";
                    }
                };
                xhr.send(`email=${inputEmail}&password=${inputPass}`);
            }else{
                document.getElementById("verEmail").style.display = "none";
                document.getElementById("emailCodeInput").value = "";

                document.getElementById("signupEmail").value = "";
                document.getElementById("signupPass").value = "";
                document.getElementById("signupConPass").value = "";
                showAlert("code do not match.", "rgb(247, 84, 84)");
            }
        }
    //animation
        const moveUp = document.querySelectorAll('.move-up');
        const upObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible1');
                }
            });
        }, { threshold: 0.1 });
        moveUp.forEach(el => upObserver.observe(el));
    //alert
        let alertTimeoutId;
        function showAlert(message, bgColor) {
            const alertBox = document.getElementById("alert");
            const closeBtn = document.getElementById("closeBtn");
            const alertText = document.getElementById("alertText");
            if (alertTimeoutId) clearTimeout(alertTimeoutId);
            alertBox.classList.add("show");
            alertBox.style.display = "block";
            alertBox.style.backgroundColor = bgColor;
            alertBox.style.borderColor = bgColor;
            closeBtn.style.backgroundColor = bgColor;
            alertText.innerHTML = message;
            closeBtn.onclick = function () {
                alertBox.classList.remove("show");
                clearTimeout(alertTimeoutId);
            };
            alertTimeoutId = setTimeout(() => {
                alertBox.classList.remove("show");
            }, 3000);
        }
    </script>
</body>
</html>