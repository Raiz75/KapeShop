<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="images\kapeShop-logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signin Page</title>
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
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-blend-mode: darken;
            height: 100vh;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.3);
            filter: blur(10px);
            z-index: -1;
        }
    /*signin*/
        .signinForm{
            position: absolute;
            top: 5vw;
            width: 30vw;
            height: 30vw;
            margin: 5vw 35vw;
            background-color: rgba(255, 245, 221, 0.75);
            border-radius:12px;
            filter: drop-shadow(5px 5px 10px rgba(0, 0, 0, 1));
            overflow: hidden;
        }
        .signinForm::before {
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
            filter: blur(5px);
            z-index: -1;
        }
        .logo{
            margin: 1vw auto;
            width: 20%;
            height: 20%;
            filter: drop-shadow(5px 5px 10px rgba(0, 0, 0, .5));
        }
        .signinForm h1{
            margin: .5vw auto;
            filter: drop-shadow(5px 5px 10px rgba(0, 0, 0, .5));
        }
        .inputForm{
            display: flex;
            width: 75%;
            height: 10%;
            margin: .8vw auto;
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
        .signInBtn{
            width: 70%;
            height: 10%;
            border-radius:12px;
            background-color: rgba(153, 112, 23, 0.75);
            color: white;
            border: none;
            font-size: 1em;
            filter: drop-shadow(5px 5px 10px rgba(0, 0, 0, .5));
            transition: .5s ease;
        }
        .signInBtn:hover{
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
            transition: .5s ease-in-out;
        }
        .back:hover{
            width: 11%;
            height: 11%;
        }
        .forgetPass{
            margin: 3vw auto;
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
    <!--alert-->
        <div class="alert" id="alert">
            <p id="alertText">text</p>
            <button id="closeBtn"><img  src="images/icon-close.png"></button>
        </div>
        <div class="bg"></div>
    <!--signin form-->
        <form class="signinForm move-up">
            <img class="logo move-up" src="images/profile-icon.png">
            <h1 class="move-up">SIGN IN</h1>
            <div class="inputForm move-up">
                <img src="images/email-icon.png">
                <input type="email" id="signinEmail" name="signinEmail" placeholder="Email" required>
            </div>
            <div class="inputForm move-up">
                <img src="images/password-icon.png">
                <input type="password" id="signinPass" name="signinPass" placeholder="Password" required>
            </div>
            <button type="submit" class="signInBtn move-up" onclick="signin(event)" >Sign In</button>
            <a href="index.php">
                <img class="back move-up" src="images/back-icon.png" alt="Back">
            </a>
            <p class="forgetPass">Can't remember your password? <a href="#" onclick="forgetPass(event)">Forget password</a></p>
        </form>
<!-- script -->

    <script>
    //login
        function signin(event) {
            event.preventDefault();
            const inputEmail = document.getElementById("signinEmail").value.trim();
            const inputPass = document.getElementById("signinPass").value.trim();
            if(inputEmail== "" || inputPass==""){
                showAlert("Please fill all the fields.", "rgb(247, 84, 84)");
                return;
            }
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState === 4 && xhttp.status === 200) {
                    const xmlDoc = xhttp.responseXML;
                    const users = xmlDoc.getElementsByTagName("user");
                    let found = false;
                    for (let i = 0; i < users.length; i++) {
                        const email = users[i].getElementsByTagName("email")[0].textContent;
                        const password = users[i].getElementsByTagName("password")[0].textContent;
                        const status = users[i].getElementsByTagName("status")[0].textContent;
                        console.log(email);
                        
                        if(inputEmail === "admin@admin"){
                            if(inputPass==="admin"){
                                showAlert("Login successful!", "rgb(36, 221, 67)");
                                setSession();
                            }else{
                                showAlert("Incorrect password.", "rgb(247, 84, 84)");
                            }
                        }else if (email === inputEmail) {
                            found = true;
                            if (password === inputPass) {
                                if (status === "active") {
                                    showAlert("Login successful!", "rgb(36, 221, 67)");
                                    setSession();
                                } else {
                                    showAlert("Account is not deactivated.", "rgb(247, 84, 84)");
                                }
                            } else {
                                showAlert("Incorrect password.", "rgb(247, 84, 84)");
                            }
                            break;
                        }
                    }
                    if (!found) {
                        showAlert("Email not found.", "rgb(247, 84, 84)");
                    }
                }
            };
            xhttp.open("GET", "xmlFiles/userData.xml", true);
            xhttp.send();
        }
    //forget password
        function forgetPass(event) {
            event.preventDefault();
            showAlert("Reset password request sent.", "rgb(36, 221, 67)");
            const inputEmail = document.getElementById("signinEmail").value.trim();
            if (inputEmail === "") {
                showAlert("Please enter your email.", "rgb(247, 84, 84)");
                return;
            }
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState === 4 && xhttp.status === 200) {
                    const xmlDoc = xhttp.responseXML;
                    const users = xmlDoc.getElementsByTagName("user");
                    let found = false;
                    for (let i = 0; i < users.length; i++) {
                        const email = users[i].getElementsByTagName("email")[0].textContent;
                        if (email === inputEmail) {
                            found = true;
                            // Email found — send password reset request
                            const sendPassReq = new XMLHttpRequest();
                            sendPassReq.onreadystatechange = function () {
                                if (sendPassReq.readyState === 4 && sendPassReq.status === 200) {
                                    const response = sendPassReq.responseText.trim();

                                    if (response.startsWith("Failed")) {
                                        showAlert(response, "rgb(247, 84, 84)");
                                    } else {
                                        let newPass = response;
                                        showAlert("Check your email for new password.", "rgb(36, 221, 67)");
                                        // update XML
                                        const newPassRec = new XMLHttpRequest();
                                        newPassRec.open("POST", "func-saveNewPass.php", true);
                                        newPassRec.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                        newPassRec.send(`email=${inputEmail}&password=${newPass}`);
                                    }
                                }
                            };
                            sendPassReq.open("GET", "func-forgetPassword.php?email=" + encodeURIComponent(inputEmail), true);
                            sendPassReq.send();
                            break;
                        }
                    }
                    if (!found) {
                        showAlert("Email not found.", "rgb(247, 84, 84)");
                    }
                }
            };
            xhttp.open("GET", "xmlFiles/userData.xml", true);
            xhttp.send();
        }
    //set session
        function setSession() {
            const inputEmail = document.getElementById("signinEmail").value.trim();
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (xhttp.readyState === 4 && xhttp.status === 200) {
                    if (xhttp.responseText === "success") {
                        showAlert("Login successful!", "rgb(36, 221, 67)");
                        if(inputEmail=="admin@admin"){
                            window.location.href = "adminPage.php"; // Redirect if needed
                        }else{
                            window.location.href = "homePage.php"; // Redirect if needed
                        }
                    } else {
                        alert("Error setting session.");
                    }
                }
            };
            xhttp.open("POST", "func-sessionBegin.php", true);
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhttp.send("email=" + encodeURIComponent(inputEmail));
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