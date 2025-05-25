<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: landingPage_index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="images\kapeShop-logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <style>
/**css */
        body {
            padding:0;
            margin: 0;
            background-color: whitesmoke;
            font-family: Arial, sans-serif;
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
            width: 5%;
            height: 100%;
            margin-left: 50px;
        }
        .logo-text{
            font-size: 30px;
            margin-left: 5px;
            margin-right: 1050px;
        }
        .logo-text span{
            color: rgba(153, 112, 23);
        }
        .navPanel{
            list-style-type: none;
            display: flex;
            align-items: center;
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
            padding:5px;
            border-radius: 12px;
            color:white;
            width: 20%;
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

    /*content div*/
        .contentDiv{
            display: flex;
            width: 95%;
            margin: auto;
            margin-top:50px;
            margin-bottom:80px;
            justify-content: space-between;
            text-align:center;
            min-height:900px;
        }
    /*sort panel*/
        .sortPannel{
            width: 20%;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 5px grey;
            max-height: fit-content;
            font-size: 1.5em;
        }
        .sortPannel hr{
            width: 90%;
            margin-top:15px;
            margin-bottom:15px;
        }
    /* tagSearch */
        .tagSearchBox input{
            width: 70%;
            padding: 10px;
            border: 1px solid  rgba(153, 112, 23, .9);
            background-color: white;
            color: rgba(153, 112, 23, .9);
            border-radius: 10px;
        }
        .tagSearchBox input::placeholder {
            color: rgba(153, 112, 23, .9);
        }
        .tagSearchBox button{
            width: 50%;
            border:1px solid rgba(153, 112, 23, .9);
            background-color: rgba(153, 112, 23, .9);
            color: white;
            border-radius: 10px;
            padding: 5px;
            box-shadow: 0px 2px 5px grey;
            transform: translateY(-1px);
            transition: .3s ease-in-out;
        }
        .tagSearchBox button:hover{
            transform: translateY(0px);
            color: rgba(153, 112, 23, .9);
            background-color: white;
            box-shadow: 0px 0px 0px grey;
        }
    /**parameter sort */
        .parameterSort select{
            width: 70%;
            border: 1px solid  rgba(153, 112, 23, .9);
            background-color: white;
            color: rgba(153, 112, 23, .9);
            border-radius: 10px;
            padding: 10px;
        }
    /* categorySort */
        .categorySort{
            text-align:center;
        }
        .categories{
            width: 80%;
            margin:10px;
            border: 1px solid  rgba(153, 112, 23, .9);
            background-color: rgba(153, 112, 23, .9);
            color: white;
            border-radius: 10px;
            padding: 5px;
            box-shadow: 0px 2px 5px grey;
            transform: translateY(-1px);
            font-size: 1em;
            transition: .3s ease-in-out;
        }
        .categories:hover{
            transform: translateY(0px);
            box-shadow: 0px 0px 0px grey;
            background-color: white;
            color: rgba(153, 112, 23, .9);
        }
        .selectedCategory{
            transform: translateY(0px);
            box-shadow: 0px 0px 0px grey;
            background-color: white;
            color: rgba(153, 112, 23, .9);
        }
    /* prodDisplay */
        .prodDisplayBox{
            width: 75%;
            position: relative;
        }
        .prodDisplay{
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 3rem;
        }
        .prodBox{
            text-align:center;
            border-radius: 20px;
            height:fit-content;
            background-color: white;
            border-left: 3px solid rgba(153, 112, 23, .9);
            box-shadow: 0px 0px 8px grey;
        }
        .prodBox img{
            width: 60%;
            border-radius: 20px;
            filter: drop-shadow(5px 5px 10px rgba(0, 0, 0, 1));
        }
        .prodInfo{
            display: flex;
            margin-top: 20px;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }
        .prodDetail1{
            width: 70%;
        }
        .prodDetail1Tags{
            font-size: .8em;
            color: grey;
        }
        .prodDetail2{
            width: 30%;
        }
        .prodDetail2 input{
            width: 100%;
            height: 30%;
            box-sizing: border-box;
        }
        .prodDetail2 button{
            width: 100%;
            height: 70%;
            border-bottom-right-radius: 15px;
            border:1px solid rgba(153, 112, 23, .9);
            background-color: rgba(153, 112, 23, .9);
            color:white;
            transition: 0.3s ease-in-out;
            font-size: 1.2em;
        }
        .prodDetail2 button:hover{
            box-shadow: 0px 0px 0px grey;
            background-color: white;
            color: rgba(153, 112, 23, .9);
        }
        .noProducts {
            text-align: center;
            font-style: italic;
            color: #888;
            padding: 20px;
            font-size: 2em;
            grid-column: span 3;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0px 0px 5px grey;
        }
        .nextPrevBtn{
            width: 100%;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 3rem;
            position: absolute;
            bottom:-70px;
            font-size: 1.2em;
        }
        .nextPrevBtn button{
            border:1px solid rgba(153, 112, 23, .9);
            background-color: rgba(153, 112, 23, .9);
            color:white;
            font-size: 1.1em;
            border-radius:10px;
            box-shadow: 0px 2px 5px grey;
            transform: translateY(-2px);
            transition: 0.3s ease-in-out;
        }
        .nextPrevBtn button:hover{
            box-shadow: 0px 0px 0px grey;
            transform: translateY(0px);
            background-color: white;
            color:rgba(153, 112, 23, .9);
        }
        .disabledPaginationBtn{
            pointer-events: none;
            opacity: 0.5;
            cursor: default;
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
    /**footer */
        .footer {
            background-color: rgba(153, 112, 23, 0.75);
            color: white;
            margin-top: 30px;
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
    </style>
</head>
<body>
    <!--alert-->
        <div class="alert" id="alert">
            <p id="alertText">text</p>
            <button id="closeBtn"><img  src="images/icon-close.png"></button>
        </div>
    <!--navigation-->
        <div class="navigation">
            <img class="logo" src="images/kapeShop-logo.png">
            <p class="logo-text"><b>Kape<span>Shop</span></b></p>
            <ul class="navPanel">
                <li><a class="aa" href="homePage.php">HOME</a></li>
                <li><a class="aa selectedNav" href="productPage.php">PRODUCT</a></li>
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
            <div class="productsScroll"></div>
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
    <!--content-->
        <div class="contentDiv">
        <!--sort panel-->
            <div class="sortPannel">
                <!--tag search-->
                <div class="tagSearchBox">
                    <p>Search Tags</p>
                    <input type="search" id="tagSearch" placeholder="Search Tags">
                    <button id="tagSearchBtn">Search</button>
                </div>
                <hr>
                <!--parameter search-->
                <div class="parameterSort">
                    <p>Sort By</p>
                    <select id="parameterSort">
                        <option>A to Z</option>
                        <option>Z to A</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                    </select>
                </div>
                <hr>
                <!--category search-->
                <div class="categorySort" id="categorySort">
                    <p>Category Search</p>
                    <button class="categories selectedCategory" id="all">All</button>
                </div>
            </div>
        <!--product display-->
            <div class="prodDisplayBox">
                <div class="prodDisplay" id="prodDisplay"></div>
                <div class="nextPrevBtn">
                    <button id="prevBtn" onclick="prevPage()">Prev</button>
                    <p id="pageInfo"></p>
                    <button id="nextBtn" onclick="nextPage()">Next</button>
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
    //profile function
        //logout
        function endSession() {
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState === 4 && xhttp.status === 200) {
                    window.location.href = "landingPage_index.php";
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
    //product display panel
        let products = [];
        let currentCategory = "all";
        let currentTag = "";
        window.onload = function () {
            cartPanelFunc();
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState === 4 && this.status === 200) {
                    const xmlDoc = xhttp.responseXML;
                    const productNodes = xmlDoc.getElementsByTagName("product");
                    products = [];
                    const categorySet = new Set();
                    for (let i = 0; i < productNodes.length; i++) {
                        const ID = productNodes[i].getElementsByTagName("ID")[0]?.textContent || "";
                        const name = productNodes[i].getElementsByTagName("name")[0].textContent;
                        const price = parseFloat(productNodes[i].getElementsByTagName("price")[0].textContent);
                        const image = productNodes[i].getElementsByTagName("img")[0].textContent;
                        const category = productNodes[i].getElementsByTagName("category")[0]?.textContent.trim().toLowerCase() || "other";
                        // Parse <tags><tag>...</tag></tags>
                        const tagElements = productNodes[i].getElementsByTagName("tag");
                        const tags = [];
                        for (let t = 0; t < tagElements.length; t++) {
                            tags.push(tagElements[t].textContent.toLowerCase().trim());
                        }
                        // Include ID in the product object
                        products.push({ ID, name, price, image, category, tags });
                        categorySet.add(category);
                    }
                    createCategoryButtons(categorySet);
                    filterCat('all');
                }
            };
            xhttp.open("GET", "xmlFiles/prodData.xml", true);
            xhttp.send();

            document.getElementById("tagSearchBtn").addEventListener("click", function () {
                const tagInput = document.getElementById("tagSearch").value.trim().toLowerCase();
                currentTag = tagInput;
                currentPage = 0;
                displayFilteredAndSorted();
            });
            // Sorting event listener
            document.querySelector("select").addEventListener("change", displayFilteredAndSorted);
        };
        //dynamic button creations
        function createCategoryButtons(categorySet) {
            const container = document.getElementById("categorySort");
            // Clear existing buttons except "All"
            container.innerHTML = `<p>Category Search:</p><button class="categories selectedCategory" id="all" onclick="filterCat('all')">All</button>`;
            Array.from(categorySet).forEach(cat => {
                const btn = document.createElement("button");
                const catId = cat.toLowerCase();
                btn.textContent = cat.charAt(0).toUpperCase() + cat.slice(1);
                btn.classList.add("categories");
                btn.id = catId;
                // Bind category click event
                btn.addEventListener("click", () => filterCat(catId));
                container.appendChild(btn);
            });
        }
        let currentPage = 0;
        const itemsPerPage = 6;
        // CATEGORY FILTER FUNCTIONS
        function filterCat(categoryId) {
            document.getElementById("tagSearch").value = "";
            currentTag = "";
            currentCategory = categoryId;
            document.querySelectorAll('.categories').forEach(btn => {
                btn.classList.remove("selectedCategory");
            });
            currentPage=0;
            document.getElementById(categoryId).classList.add("selectedCategory");
            displayFilteredAndSorted();
        }
        // COMBINED FILTER + SORT DISPLAY
        function displayFilteredAndSorted() {
            let filtered = products;
            // Filter by category
            if (currentCategory !== "all") {
                filtered = filtered.filter(prod => prod.category === currentCategory);
            }
            // Filter by tag
            if (currentTag !== "") {
                filtered = filtered.filter(prod => prod.tags.some(tag => tag.includes(currentTag)));
            }
            // Sort
            const sortValue = document.getElementById("parameterSort").value;
            if (sortValue === "A to Z") {
                filtered.sort((a, b) => a.name.localeCompare(b.name));
            } else if (sortValue === "Z to A") {
                filtered.sort((a, b) => b.name.localeCompare(a.name));
            } else if (sortValue === "Price: Low to High") {
                filtered.sort((a, b) => a.price - b.price);
            } else if (sortValue === "Price: High to Low") {
                filtered.sort((a, b) => b.price - a.price);
            }
            // dont display the 0 stock
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "xmlFiles/prodData.xml", true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const xmlDoc = xhr.responseXML;
                    const xmlProducts = xmlDoc.getElementsByTagName("product");
                    // Build a map of stock per product ID
                    const stockMap = {};
                    for (let i = 0; i < xmlProducts.length; i++) {
                        const id = xmlProducts[i].getElementsByTagName("ID")[0].textContent;
                        const stock = parseInt(xmlProducts[i].getElementsByTagName("stock")[0].textContent);
                        stockMap[id] = stock;
                    }
                    // Filter out products with stock = 0
                    const inStockFiltered = filtered.filter(prod => stockMap[prod.ID] > 0);
                    const start = currentPage * itemsPerPage;
                    const end = start + itemsPerPage;
                    // Show message if no product matches
                    if (inStockFiltered.length === 0) {
                        document.getElementById("prodDisplay").innerHTML = `
                            <div class="noProducts">No products match your search.</div>
                        `;
                        updatePaginationButtons(0);
                        return;
                    }
                    displayProducts(inStockFiltered.slice(start, end));
                    updatePaginationButtons(inStockFiltered.length);
                }
            };
            xhr.send();
        }
        function nextPage() {
            let filtered = products;
            if (currentCategory !== "all") {
                filtered = products.filter(prod => prod.category === currentCategory);
            }
            if ((currentPage + 1) * itemsPerPage < filtered.length) {
                currentPage++;
                displayFilteredAndSorted();
            }
        }
        function prevPage() {
            if (currentPage > 0) {
                currentPage--;
                displayFilteredAndSorted();
            }
        }
        function updatePaginationButtons(totalItems) {
            if(currentPage === 0){
                document.getElementById("prevBtn").classList.add("disabledPaginationBtn");
            }else{
                document.getElementById("prevBtn").classList.remove("disabledPaginationBtn");
            }
            if((currentPage + 1) * itemsPerPage >= totalItems){
                document.getElementById("nextBtn").classList.add("disabledPaginationBtn");
            }else{
                document.getElementById("nextBtn").classList.remove("disabledPaginationBtn");
            }
            const pageInfo = document.getElementById("pageInfo");
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            pageInfo.textContent = `Page ${currentPage + 1} of ${totalPages}`;
        }
        // RENDER FUNCTION
        function displayProducts(productList) {
            const container = document.getElementById("prodDisplay");
            container.innerHTML = "";
            productList.forEach(({ ID, name, price, image, tags }) => {
                const tagHTML = tags.map(tag => `<span class="tag">${tag}</span>`).join(", ");
                const productHTML = `
                    <div class="prodBox">
                        <img src="${image}">
                        <div class="prodInfo">
                            <div class="prodDetail1">
                                <div class="prodDetail1Tags">${tagHTML}</div>
                                <p><b>${name}</b></p>
                                <p>P${price}.00</p>
                            </div>
                            <div class="prodDetail2">
                                <input type="number" max="100" min="1" value="1" placeholder="Enter Quantity">
                                <button onclick="addToCart(this, '${ID}', '${name}', ${price}, '${image}')">Add</button>
                            </div>
                        </div>
                    </div>
                `;
                container.innerHTML += productHTML;
            });
        }
    // ADD PRODUCT TO CART
        function addToCart(button, prodID, prodName, prodPrice, prodImage) {
            const quantityInput = button.parentElement.querySelector('input[type="number"]');
            const quantity = parseInt(quantityInput.value);
            if (!quantity || quantity < 1) {
                showAlert("Please Enter quantity.", "rgb(247, 84, 84)");
                return;
            }
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "func-cartAddProd.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            const params = `prodCartID=${encodeURIComponent(prodID)}&prodCartName=${encodeURIComponent(prodName)}&prodCartPrice=${encodeURIComponent(prodPrice)}&prodCartQuan=${quantity}&prodCartImg=${encodeURIComponent(prodImage)}`;
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = xhr.responseText.trim();

                    if (response === "success") {
                        showAlert("Product Successfully Added!", "rgb(36, 221, 67)");
                        cartPanelFunc();
                    } else if (response === "error:insufficient_stock") {
                        showAlert("Quantity Exceeds Available Stock.", "rgb(247, 84, 84)");
                    } else if (response === "error:product_not_found") {
                        showAlert("Product not found.", "rgb(247, 84, 84)");
                    } else {
                        showAlert("An Unknown Error Occurred.", "rgb(247, 84, 84)");
                    }
                }
            };
            xhr.send(params);
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
        function cartPanelFunc() {
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
    </script>
</body>
</html>