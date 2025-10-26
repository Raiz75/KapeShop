<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="images\kapeShop-logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
/**css */
        body{
            padding: 0;
            margin:0;
            font-family: Arial, sans-serif;
            background-color: whitesmoke;
            font-size: 1vw;
        }
    /* Navigation */
        .navigation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 10px;
            background-color: rgba(223, 202, 159);
            z-index: 1;
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.25);
            display: flex;
            align-items: center;
            height: 10vh;
        }
        .logo {
            min-width: 100px;
            height: 100%;
            margin-left: 50px;
        }
        .logo-text{
            font-size: 2em;
        }
        .logo-text span{
            color: rgba(153, 112, 23);
        }
        .navPanel{
            list-style-type: none;
            display: flex;
            align-items: center;
            position: absolute;
            right: 3vw;
        }
        .aa{
            display: block;
            padding: 20px;
            color: black;
            border-bottom:5px  solid transparent;
            text-decoration: none;
            cursor: pointer;
            transition: .2s ease-in-out;
        }
        .aa:hover{
            color: rgba(153, 112, 23);
            border-bottom:5px  solid rgba(153, 112, 23);
        }
        .selectedNav{
            color: rgba(153, 112, 23);
        }
        .navPanel img{
            width: 50px;
            height: 50px;
        }
    /**profile */
        .profile-content {
            display: none;
            position: absolute;
            background-color: rgba(153, 112, 23);
            min-width: 200px;
            z-index: 1;
            transition: .2s ease-in-out;
        }
        .profile-content a {
            padding: 20px;
            color: white;
            border:1px solid transparent;
            border-left:5px solid transparent;
            display: block;
            padding: 20px;
            text-decoration: none;
            cursor: pointer;
            transition: .2s ease-in-out;
        }
        .profile-content a:hover{
            border:1px solid rgba(153, 112, 23);
            border-left:5px  solid rgba(153, 112, 23);
            background-color: rgba(255, 239, 207);
            color:rgba(153, 112, 23);
        }
        .profile:hover .profile-content {
            display: block;
        }
        /*changePassPanel*/
        .changePassPanel{
            position: fixed;
            top: 90px;
            right: 300px;
            z-index: 1;
            width: 20%;
            text-align: center;
            padding: 10px;
            background-color: rgba(255, 239, 207);
            box-shadow: 0px 0px 5px grey;
            border-radius: 12px;
            visibility: hidden;
            opacity:0;
            transition: .3s ease-in-out;
        }
        .changePassPanel button{
            border:1px solid rgba(153, 112, 23);
            background-color: rgba(153, 112, 23);
            font-size: 1em;
            margin: 10px;
            padding:.8vw;
            border-radius: 12px;
            color:white;
            width: 30%;
            transform: translateY(-3px);
            box-shadow: 0px 3px 5px grey;
            transition: .3s ease-in-out;
        }
        .changePassPanel button:hover{
            color:rgba(153, 112, 23);
            background-color: white;
            box-shadow: 0px 0px 2px grey;
            transform: translateY(0px);
        }
        .changePassPanel p{
            font-size: 2em;
        }
        .changePassPanel input{
            margin-bottom: 10px;
            width: 60%;
            height: 30px;;
            border-radius: 7px;
            border:1px solid rgba(153, 112, 23);
            box-sizing: border-box;
            align-self: center;
        }
    /**cart */
        .cartbox{
            border-left: 3px solid rgba(153, 112, 23);
            position: fixed;
            right:0;
            top:0;
            width:500px;
            height: 915px;
            background-color: rgba(223, 202, 159);
            transform: translateX(510px); 
            z-index: 1;
            box-shadow: 0px 0px 5px grey;
            transition: .5s ease-in-out;
        }
        .cartbox button{
            border:1px solid rgba(153, 112, 23);
            background-color: rgba(153, 112, 23);
            font-size: 1em;
            padding:10px;
            border-radius: 12px;
            color:white;
            width: 20%;
            box-shadow: 0px 3px 5px grey;
            transform: translateY(-1px);
            transition: .3s ease-in-out;
        }
        .cartbox button:hover{
            background-color: white;
            transform: translateY(0px);
            box-shadow: 0px 0px 2px grey;
            color: rgba(153, 112, 23);
        }
        .xBtn{
            margin: 20px;
        }
        .productsScroll{
            max-height: 730px;
            overflow-y: auto;
            border-top: 2px solid rgba(153, 112, 23);
        }
        .cartProd{
            box-shadow: 0px 1px 3px grey;
            border-radius: 12px;
            background-color: whitesmoke;
            height: 100px;
            display:block;
            display:flex;
            align-items: center;
            margin: 20px;
            position: relative;
            gap: 10px;
            padding:5px;
        }
        .cartProdDetails{
            height: 100%;
            width: 100%;
            position: relative;
            display: flex;
        }
        .cartProdDetails img{
            height: 100%;
            margin-right:10px;
        }
        .textDetails {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            grid-template-rows: auto auto;
        }
        .prodCartName {
            grid-column: span 4;
        }
        .prodCartPrice {
            grid-column: span 2;
        }
        .prodCartQuan {
            grid-column: span 1;
            width: 100%;
            height: 50%;
            border-radius: 7px;
            border:1px solid rgba(153, 112, 23);
            box-sizing: border-box;
            align-self: center;
        }
    /**checkout pannel */
        .checkoutPanel{
            position:fixed;
            bottom:-400px;
            right:0px;
            height: 500px;
            width:500px;
            background-color: white;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
            grid-template-rows:  80px 70px 70px 70px 70px 80px;
            box-sizing: border-box;
            border-radius: 12px;
            padding:20px;
            box-shadow: 0px 0px 5px grey;
            transform: translateX(510px); 
            z-index: 1;
            transition: .5s ease-in-out;
        }
        .checkoutPanel img{
            width:30%;
        }
        .checkoutPanel input[type="radio"] {
            margin-left: auto;
        }
        .checkoutPanel label{
            height: 80%;
            grid-column: span 5;
            grid-row: span 1;
            display: flex;
            align-items: center;
            text-align: center;
            padding:20px;
            box-sizing: border-box;
            gap: 20px;
            background-color: whitesmoke;
            box-shadow: 0px 1px 5px grey;
            transform:translateY(-1px);
            border-radius: 12px;
            transition: .3s ease-in-out;
        }
        .checkoutPanel label:hover{
            transform:translateY(0px);
            box-shadow: 0px 0px 2px grey;
        }
        .checkoutPanel button{
            border:1px solid rgba(153, 112, 23);
            background-color: rgba(153, 112, 23);
            font-size: 1em;
            padding:10px;
            border-radius: 12px;
            color:white; 
            margin: 0 10px;
            width:200px;
            box-shadow: 0px 3px 5px grey;
            transform: translateY(-1px);
            transition: .3s ease-in-out;
        }
        .checkoutPanel button:hover{
            background-color: white;
            transform: translateY(0px);
            box-shadow: 0px 0px 2px grey;
            color: rgba(153, 112, 23);
        }
        .selectNote{
            grid-column: span 5;
            grid-row: span 1;
            color: grey;
            display: flex;
            align-items: center;
            padding: 5px;
        }
        .order{
            grid-column: span 5;
            grid-row: span 1;
            height:60%;
            display:flex;
            justify-content: space-between;
            align-items: center;
        }
        .PlaceOrderBox {
            grid-column: span 5;
            grid-row: span 1;
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
        }
        .PlaceOrderBox button {
            height: 60%;
            width: 100%;
        }
        /* una */
        .una{
            display: flex;
            position: relative;
        }
    /**bean image */
        .b0{
            position: absolute;
            bottom: 22%;
            right: 5%;
            height: 20vw;
            filter: drop-shadow(0px 80px 30px rgba(0, 0, 0, 0.4));
        }
        .b0 img{
            width: 33vw;
        }
        .b1{
            position: absolute;
            top: -20vw;
            right:730px;
            height: 250px;
            opacity:0;
            z-index: 2;
            transform: translateY(0px);
            transition: transform .5s ease-in-out, opacity 0.5s ease-in-out;
        }
        .b2{
            position: absolute;
            top: -20vw;
            right: 290px;
            height: 200px;
            z-index: 1;
            opacity:0;
            transform: translateY(0px);
            transition: transform 1s ease-in-out, opacity 0.5s ease-in-out;
        }
        .b3{
            position: absolute;
            top: -20vw;
            right: 0px;
            height: 220px;
            z-index: 1;
            opacity:0;
            transform: translateY(0px);
            transition: transform .7s ease-in-out, opacity 0.5s ease-in-out;
        }
        .b0:hover ~ .b1, 
        .b0:hover ~ .b2, 
        .b0:hover ~ .b3{
            opacity:1;
            transform: translateY(200px);
        }
    /**prod selection */
        .prodShowcase{
            margin-top: 50px;
            width: 55%;
            text-align: center;
        }
        .title {
            font-size: 1.9em;
        }
        .prodBoxContainer{
            display: flex;
        }
        .prod-box{
            width: 250px;
            height: 450px;
            margin: 25px;
            padding: 10px;
            position: relative;
            border-left: 3px solid rgba(153, 112, 23, 0.75);
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
            transition: .5s ease-in-out;
            box-sizing: border-box;
        }
        .prod-box:hover{
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.75);
        }
        .prodDetails{
            text-align: center;
        }
        .ttl{
            color:rgba(153, 112, 23);
        }
        /**carousel */
        .contImg{width: 100%;}
        .carousel-container {
            width: 100%;
            overflow: hidden;
            position: relative;
            border-radius: 15px;
        }
        .carousel {
            display: flex;
            width: 100%;
            transition: transform 0.5s ease-in-out;
            filter: drop-shadow(5px 5px 10px rgba(0, 0, 0, 1));
        }
        .carousel img {width: 100%;}
        .prev, .next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 3px;
            cursor: pointer;
            font-size: 25px;
            opacity: 25%;
        }
        .prev { left: 3px; }
        .next { right: 3px; }
    /**about us */
        .abt{
            background-color:rgba(223, 202, 159);
            text-align: center;
            padding-top: 50px;
            padding-bottom: 100px;
            margin-top: 100px;
        }
        .aboutUs{
            font-size: 1.5em;
            display: flex;
            text-align: center;
            justify-content: center;
            align-items: center;
        }
        .aboutUs img{
            width: 50vw;
            margin-right: 30px;
        }
        .abtHistory{
            align-items: left;
            width: 700px;
        }
    /**footer */
        .footer {
            background-color: rgba(153, 112, 23, 0.75);
            color: white;
        }
        .footerDetails{
            display:flex;
            justify-content: center;
            gap:200px;
        }
        .footerDetails img{
            width: 30px;
            border-radius:100%;
            transition: 0.5s ease-in-out;
        }
        .footerDetails img:hover{
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.50);
        }
        .copyright {
            text-align: center;
            padding-bottom: 10px;
        }
        footer hr{
            width: 75%;
        }
    /**alert */
        .alert {
            position: fixed;
            top: 120px;
            left: 50px;
            color: white;
            width: 20%;
            height: 60px;
            opacity: 0;
            visibility: hidden;
            padding-left: 10px;
            border-radius: 20px;
            z-index: 10;
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
    <!--alert-->
        <div class="alert" id="alert">
            <p id="alertText">text</p>
            <button id="closeBtn"><img  src="images/icon-close.png"></button>
        </div>
    <!--contents-->
        <!--navigation-->
            <div class="navigation">
                <img class="logo" src="images/kapeShop-logo.png">
                <p class="logo-text"><b>Kape<span>Shop</span></b></p>

                <ul class="navPanel">
                    <li><a class="aa selectedNav">HOME</a></li>
                    <li><a class="aa"href="productPage.php">PRODUCT</a></li>
                    <li class="profile">
                        <a class="aa" class="dropbtn">PROFILE</a>
                        <div class="profile-content">
                            <a onclick="openChangePassPanel()">Change Password</a>
                            <a onclick="endSession()">Logout</a>
                        </div>
                    </li>
                    <li><a class="aa" onclick="openCart()"><img src="images/cart-icon.png"></a></li>
                </ul>
            </div> 
            <br><br><br><br><br><br><br>
        <!--cart-->
            <div class="cartbox" id="cartbox">
                <button class="xBtn" onclick="closeCart()">Back</button>
                <button onclick="deleteProd()">delete</button>
                <div class="productsScroll">
                    <!--cart products display-->
                    <!-- <label class="cartProd">
                            <input type="checkbox" name="cartProd" onchange="updateTotal()">
                            <div class="cartProdDetails">
                                <img src="images/email-icon.png">
                                <div class="textDetails">
                                    <p class="prodCartName">${name}</p>
                                    <p class="prodCartPrice">P${price}.00</p>
                                    <p></p>
                                    <input class="prodCartQuan" type="number" value="${quantity}" onchange="updateQuantity(this, ${index})" min="1" max="99">
                                </div>
                            </div>
                        </label>-->
                </div>
            </div>
        <!--checkout panel-->
            <div class="checkoutPanel" id="checkoutPanel">
                <div class="order">
                    <div style="display:flex; gap:10px;">
                        <p>TOTAL: </p>
                        <p id="totalPrice"></p>
                    </div>
                    <button id="Checkout" onclick="openPayment()">Checkout</button>
                </div>
                <span class="selectNote">Select a payment method:</span>
                <label>
                    <img src="images/icon-GCash.png">
                    <p>GCash</p>
                    <input type="radio" name="meth" value="GCash">
                </label>
                <label class="qqq">
                    <img src="images/icon-PayMaya.png">
                    <p>PayMaya</p>
                    <input type="radio" name="meth" value="PayMaya">
                </label>
                <label>
                    <img src="images/icon-PayPal.png">
                    <p>PayPal</p>
                    <input type="radio" name="meth" value="PayPal">
                </label>
                <div class="PlaceOrderBox">
                    <button class="PlaceOrderBtn" onclick="PlaceOrderProd()" id="PlaceOrderBtn">Place Order</button>
                </div>
            </div>
        <!--change pass panel-->
            <form class="changePassPanel" id="changePassPanel">
                <p>Change Password</p>
                <label for="newPassInput">New Password</label><br>
                <input type="password" id="newPassInput" placeholder="Password" required><br>
                <label for="conNewPassInput">Confirm New Password</label><br>
                <input type="password" id="conNewPassInput" placeholder="Confirm Password" required><br>
                <button type="button" onclick="closeChangePassPanel()">Cancel</button>
                <button onclick="changePass(event)">Change</button>
            </form>
        <!--product selection-->
            <div class="una">
                <div class="prodShowcase">
                    <p class="title ttl move-up">OUR COFFEE OFFER</p>
                    <p class="title move-up">Discover our most delicious and beloved café offerings</p>
                <!--hot coffee-->
                    <div class="prodBoxContainer move-up">
                        <div class="prod-box">
                            <div class="contImg">
                                <div class="carousel-container">
                                    <div class="carousel" id="c1" data-index="0">
                                        <img src="images/hotAmericano.png">
                                        <img src="images/hotEspresso.png">
                                        <img src="images/hotMocha.png">
                                        <img src="images/hotCappuccino.png">
                                    </div>
                                    <button class="prev" onclick="moveSlide(-1, document.getElementById('c1'))">&#10094;</button>
                                    <button class="next" onclick="moveSlide(1, document.getElementById('c1'))">&#10095;</button>
                                </div>
                            </div>
                            <div class="prodDetails">
                                <p class="ttl">HOT COFFEE</p>
                                <p>A rich, aromatic cup of freshly brewed coffee, served steaming hot for a perfect balance of bold flavor and comforting warmth.</p>
                            </div>
                        </div>
                <!--iced coffee-->
                        <div class="prod-box">
                            <div class="contImg">
                                <div class="carousel-container">
                                    <div class="carousel" id="c2" data-index="0">
                                        <img src="images/IcedAmericano.png">
                                        <img src="images/IcedCaramelLatte.png">
                                        <img src="images/IcedChaiLatte.png">
                                        <img src="images/IcedLatte.png">
                                        <img src="images/IcedMocha.png">
                                    </div>
                                    <button class="prev" onclick="moveSlide(-1, document.getElementById('c2'))">&#10094;</button>
                                    <button class="next" onclick="moveSlide(1, document.getElementById('c2'))">&#10095;</button>
                                </div>
                            </div>
                            <div class="prodDetails">
                                <p class="ttl">ICED COFFEE</p>
                                <p>A refreshing iced coffee, brewed to perfection and served chilled for a smooth, bold flavor with a cool kick.</p>
                            </div>
                        </div>
                <!--frappe-->
                        <div class="prod-box">
                            <div class="contImg">
                                <div class="carousel-container">
                                    <div class="carousel" id="c3" data-index="0">
                                        <img src="images/frappeCaramel.png">
                                        <img src="images/frappeChocolate.png">
                                        <img src="images/frappeMocha.png">
                                        <img src="images/frappeStrawberry.png">
                                        <img src="images/frappeVanilla.png">
                                    </div>
                                    <button class="prev" onclick="moveSlide(-1, document.getElementById('c3'))">&#10094;</button>
                                    <button class="next" onclick="moveSlide(1, document.getElementById('c3'))">&#10095;</button>
                                </div>
                            </div>
                            <div class="prodDetails">
                                <p class="ttl">FRAPPE</p>
                                <p>A creamy, ice-blended frappe with rich coffee flavor, topped with whipped cream for a refreshing and indulgent treat.</p>
                            </div>
                        </div>
                <!--dessert-->
                        <div class="prod-box">
                            <div class="contImg">
                                <div class="carousel-container">
                                    <div class="carousel" id="c4" data-index="0">
                                        <img src="images/dessertCinnamonRolll.png">
                                        <img src="images/dessertChocolateChipCookie.png">
                                        <img src="images/dessertBlueberryMuffin.png">
                                        <img src="images/dessertFrenchBread.png">
                                        <img src="images/dessertCroissant.png">
                                    </div>
                                    <button class="prev" onclick="moveSlide(-1, document.getElementById('c4'))">&#10094;</button>
                                    <button class="next" onclick="moveSlide(1, document.getElementById('c4'))">&#10095;</button>
                                </div>
                            </div>
                            <div class="prodDetails">
                                <p class="ttl">DESSERT</p>
                                <p>Indulge in our delightful desserts, from rich, creamy cakes to warm, freshly baked pastries—perfectly sweet treats for any craving</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--coffee beans-->
                <a class="b0 move-up" href="productPage.php"><img src="images/b0.png"></a>
                <img class="b1" src="images/b1.png">
                <img class="b2" src="images/b2.png">
                <img class="b3" src="images/b3.png">
            </div>
    <!--about us-->
            <div class="abt">
                <p class="title ttl move-up">ABOUT US</p>
                <p class="title move-up">Our story and passion for quality coffee</p>
                <div class="aboutUs">
                    <img class="move-up" src="images/abt.avif">
                    <div class="abtHistory move-up">
                        <p>At Kape Shop, we believe that a great cup of coffee brings people together. Our mission is simple: to create a warm and inviting space where the community can gather, unwind, and enjoy the perfect brew.
                        We take pride in our coffee, sourcing high-quality beans from small, ethical farms around the world. Each batch is carefully roasted in-house to bring out its unique flavors, ensuring that every sip is fresh and satisfying.</p>
                        Beyond coffee, we offer a selection of handcrafted dishes made from scratch daily, using locally sourced ingredients whenever possible. Whether you’re here for your morning caffeine fix, a hearty meal, or a quiet space to work, Kape Shop is your home away from home.
                        Come in, grab a cup, and stay awhile!</p>
                    </div>
                </div>
            </div>
    <!--footer-->
            <footer class="footer">
                <div class="footerDetails">
                    <!-- Business Hours -->
                    <div>
                        <h3>Business Hours</h3>
                        <p>Monday - Friday: 7:00 AM - 8:00 PM</p>
                        <p>Saturday - Sunday: 8:00 AM - 9:00 PM</p>
                    </div>
                    <!-- Location & Contact -->
                    <div>
                        <h3>Find Us</h3>
                        <p>123 Coffee Street, Brewville, CA 94123</p>
                        <p>(555) 123-4567</p>
                        <p>kapeShop@gmail.com</p>
                    </div>
                    <!-- socials links -->
                    <div>
                        <h3>Socials</h3>
                        <img src="images/x-icon.png">
                        <img src="images/fb-icon.png">
                        <img src="images/insta-icon.png">
                    </div>
                </div>
                <!-- copyrights -->
                <hr>
                <div class="copyright">
                    <p>&copy; 2025 kape Shop. All rights reserved.</p>
                </div>
            </footer>
<!--script-->
    <script>
    //carousel slide
        function moveSlide(next, id) {
            let slideImg = id.querySelectorAll('img'); // Get all images inside c1
            let totalSlideImg = slideImg.length; // Get total number of images
            let slideInd = parseInt(id.getAttribute('data-index')) || 0; // Store index in HTML attribute

            slideInd += next;
            if (slideInd < 0) slideInd = totalSlideImg - 1;
            if (slideInd >= totalSlideImg) slideInd = 0;

            id.style.transform = `translateX(${-slideInd * 100}%)`;
            id.setAttribute('data-index', slideInd); // Store index for next use
        }
    //profile function
        //logout
        function endSession() {
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState === 4 && xhttp.status === 200) {
                    window.location.href = "index.php";
                }
            };
            xhttp.open("GET", "func-sessionEnd.php", true);
            xhttp.send();
        }
        //change password
        function openChangePassPanel() {
            document.getElementById('changePassPanel').style.visibility = 'visible';
            document.getElementById('changePassPanel').style.opacity = '1';
        }
        function changePass(event) {
            event.preventDefault();
            const password = document.getElementById("newPassInput").value.trim();
            const confirmPass = document.getElementById("conNewPassInput").value.trim();
            if (password=="" || confirmPass=="") {
                showAlert("Please fill all the blanks.", "rgb(247, 84, 84)");
            }else if (password !== confirmPass) {
                showAlert("Passwords do not match.", "rgb(247, 84, 84)");
                document.getElementById("changePassPanel").reset();
            }else{
                //record new Pass
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "func-profileChangePassword.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        showAlert("Password changed successfully." , "rgb(36, 221, 67)");
                        closeChangePassPanel();
                    }
                };
                xhr.send("password=" + encodeURIComponent(password));
            }
        }
        function closeChangePassPanel() {
            document.getElementById('changePassPanel').style.visibility = 'hidden';
            document.getElementById('changePassPanel').style.opacity = '0';
            document.getElementById("changePassPanel").reset();
        }
    //cart functions
        const sessionEmail = "<?php echo $_SESSION['user']; ?>";
        function openCart(){
            document.getElementById('cartbox').style.transform = 'translateX(0px)';
            document.getElementById('checkoutPanel').style.transform = 'translateY(0px)';
            document.getElementById('Checkout').textContent = 'Checkout';
            document.getElementById('Checkout').setAttribute('onclick', 'openPayment();');
            const radios = document.querySelectorAll('input[name="meth"]');
            radios.forEach(radio => radio.checked = false);
            const chckBox = document.querySelectorAll('input[name="cartProd"]');
            chckBox.forEach(checkbox => checkbox.checked = false);
            updateTotal();
        }
        function closeCart(){
            document.getElementById('cartbox').style.transform = 'translateX(510px)';
            document.getElementById('checkoutPanel').style.transform = 'translateX(500px)';
        }
        function openPayment(){
            const checkboxes = document.querySelectorAll('input[name="cartProd"]');
            let anyChecked = false;
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    anyChecked = true;
                }
            });
            if (!anyChecked) {
                showAlert("No items selected.", "rgb(247, 84, 84)");
                return;
            }
            document.getElementById('checkoutPanel').style.transform = 'translateY(-390px)';
            document.getElementById('Checkout').textContent = 'Cancel';
            document.getElementById('Checkout').setAttribute('onclick', 'closePayment();');
        }
        function closePayment(){
            document.getElementById('checkoutPanel').style.transform = 'translateY(0px)';
            document.getElementById('Checkout').textContent = 'Checkout';
            document.getElementById('Checkout').setAttribute('onclick', 'openPayment();');
            const radios = document.querySelectorAll('input[name="meth"]');
            radios.forEach(radio => radio.checked = false);
        }
        let cartItems = [];
        window.onload = function() {
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const xml = xhr.responseXML;
                    const email = sessionEmail; // declared in PHP
                    const users = xml.getElementsByTagName("user");
                    cartItems = [];
                    for (let i = 0; i < users.length; i++) {
                        const userEmail = users[i].getElementsByTagName("email")[0].textContent;
                        if (userEmail === email) {
                            const cart = users[i].getElementsByTagName("cart")[0];
                            const items = cart?.getElementsByTagName("item") || [];
                            if (items.length === 0) {
                                displayNoProducts();
                                return;
                            }
                            for (let j = 0; j < items.length; j++) {
                                const id = items[j].getElementsByTagName("prodCartId")[0]?.textContent || '';
                                const name = items[j].getElementsByTagName("prodCartName")[0]?.textContent || '';
                                const price = items[j].getElementsByTagName("prodCartPrice")[0]?.textContent || '';
                                const quantity = items[j].getElementsByTagName("prodCartQuan")[0]?.textContent || '';
                                const image = items[j].getElementsByTagName("prodCartImg")[0]?.textContent || '';
                                cartItems.push({ id, name, price, quantity, image });
                            }
                            break;
                        }
                    }
                    if (cartItems.length > 0) {
                        displayCartItems();
                    } else {
                        displayNoProducts();
                    }
                }
            };
            xhr.open("GET", "xmlFiles/userData.xml", true);
            xhr.send();
        }
    //display cart list
        function displayCartItems() {
            const container = document.querySelector(".productsScroll");
            container.innerHTML = "";
            cartItems.forEach(({ id, name, price, quantity, image }) => {
                const itemHTML = `
                    <label class="cartProd" data-id="${id}">
                        <input type="checkbox" name="cartProd" onchange="updateTotal()">
                        <div class="cartProdDetails">
                            <img src="${image}">
                            <div class="textDetails">
                                <p class="prodCartName">${name}</p>
                                <p class="prodCartPrice">P${price}.00</p>
                                <input class="prodCartQuan" type="number" value="${quantity}" onchange="updateQuantity(this, ${id})" min="1" max="99">
                            </div>
                        </div>
                    </label>
                    `;
                container.innerHTML += itemHTML;
            });
            updateTotal();
        }
    //update total
        function updateTotal() {
            const selectedItems = document.querySelectorAll('label.cartProd input[name="cartProd"]:checked');
            let total = 0;
            selectedItems.forEach(checkbox => {
                const prodLabel = checkbox.closest('.cartProd');
                const prodId = prodLabel.getAttribute("data-id");
                const quantityInput = prodLabel.querySelector('.prodCartQuan');
                const quantity = parseInt(quantityInput.value);
                const item = cartItems.find(item => item.id === prodId);
                if (item && !isNaN(quantity)) {
                    const price = parseFloat(item.price);
                    if (!isNaN(price)) {
                        total += quantity * price;
                    }
                }
            });
            document.getElementById("totalPrice").textContent = `₱${total.toFixed(2)}`;
        }
    //update xml quan
        function updateQuantity(input, pId) {
            const newQuantity = parseInt(input.value);
            if (isNaN(newQuantity) || newQuantity < 1) return;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "func-cartUpdateQuantity.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");

            const payload = {
                email: sessionEmail,
                id: pId,
                quantity: newQuantity
            };

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    const response = xhr.responseText.trim();
                    if (xhr.status === 200 && response === "success") {
                        showAlert("Quantity updated!", "rgb(36, 221, 67)");
                    } else if (response === "error:insufficient_stock") {
                        showAlert("Quantity Exceeds stock.", "rgb(247, 84, 84)");
                        input.value--; // reset to a valid minimum
                    } else {
                        showAlert("Error updating quantity: " + response, "rgb(247, 84, 84)");
                    }
                }
            };

            xhr.send(JSON.stringify(payload));
        }
    //display no prod
        function displayNoProducts() {
            const container = document.querySelector(".productsScroll");
            container.innerHTML = `<p style="text-align:center; padding: 20px;">No products in your cart.</p>`;
        }
    //delete selected prod
        function deleteProd() {
            const checkboxes = document.querySelectorAll('input[name="cartProd"]:checked');
            if (checkboxes.length === 0) {
                showAlert("No items selected.", "rgb(247, 84, 84)");
                return;
            }
            const selectedIds = Array.from(checkboxes).map(cb =>
                cb.closest('.cartProd').getAttribute("data-id")
            );
            const updatedCart = cartItems.filter(item => !selectedIds.includes(item.id));
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "func-cartDeleteProd.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    cartItems = updatedCart;
                    showAlert("Product Successfully Deleted!", "rgb(36, 221, 67)");
                    displayCartItems();
                }
            };
            const payload = {
                email: sessionEmail,
                deletedIds: selectedIds
            };
            xhr.send(JSON.stringify(payload));
        }
    //checkout
        function PlaceOrderProd() {
            const checkboxes = document.querySelectorAll('input[name="cartProd"]');
            const selectedCart = [];
            const remainingCart = [];
            checkboxes.forEach((checkbox) => {
                const prodLabel = checkbox.closest('label.cartProd');
                const prodId = prodLabel.getAttribute('data-id');
                const item = cartItems.find(item => item.id === prodId);
                if (checkbox.checked) {
                    if (item) selectedCart.push(item);
                } else {
                    if (item) remainingCart.push(item);
                }
            });
            const selectedMethod = document.querySelector('input[name="meth"]:checked');
            let haveSelected = false;
            if (!selectedMethod) {
                showAlert("No payment method selected.", "rgb(247, 84, 84)");
            } else {
                const urls = {
                    "GCash": "https://new.gcash.com/",
                    "PayMaya": "https://www.maya.ph/",
                    "PayPal": "https://www.paypal.com/ph/home"
                };
                if (urls[selectedMethod.value]) {
                    window.open(urls[selectedMethod.value], "_blank");
                    haveSelected = true;
                }
            }
            if (haveSelected) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "func-cartCheckout.php", true);
                xhr.setRequestHeader("Content-Type", "application/json");
                const payload = {
                    email: sessionEmail,
                    checkedOutItems: selectedCart
                };
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        cartItems = remainingCart;
                        displayCartItems();
                        updateTotal();
                        showAlert("Product Successfully Purchased!", "rgb(36, 221, 67)");
                        closeCart();
                    }
                };
                xhr.send(JSON.stringify(payload));
            }
        }
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
    </script>
</body>
</html>