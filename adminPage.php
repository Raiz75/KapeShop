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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

    <title>Admin Page</title>
    <style>
        body {
            padding:0;
            margin: 0;
            background-color: whitesmoke;
            font-family: Arial, sans-serif;
            font-size: .8vw;
        }
        .blur-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(8px);
            z-index: 5;
            transition: .5s ease;
        }
    /**side panel */
        .sidePanel{
            position: fixed;
            width: 20%;
            height: 100%;
            background-color: rgba(153, 112, 23, .50);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
            gap: 7%;
            box-shadow: 0px 2px 5px grey;
        }
        .sidePanel img{
            width: 70%;
        }
        .sidePanelBtn{
            width: 13vw;
            height: 2.5vw;
            border: .1vw solid rgba(153, 112, 23);
            border-radius: 12px;
            background-color: rgba(153, 112, 23);
            color: white;
            transform: translateY(-3px);
            font-size: 1.2em;
            box-shadow: 0px 2px 5px grey;
            transition: .3s ease;
        }
        .sidePanelBtn:hover{
            transform: translateY(0px);
            box-shadow: 0px 0px 2px grey;
            background-color: white;
            color: rgba(153, 112, 23);
        }
        .SelectedSidePanelBtn{
            transform: translateY(0px);
            box-shadow: 0px 0px 2px grey;
            background-color: white;
            color: rgba(153, 112, 23);
        }
    /**content */
        .content{
            position: absolute;
            right:0;
            width: 80%;
            height: 100%;
            overflow-y: scroll;
        }
        .title{
            font-size: 1.8em;
            height: 10%;
            color: rgba(153, 112, 23);
        }
/**home */
        .homeSet{
            display: block;
            padding: 2vw;
            padding-top: 0vw;
        }
        .chartjs-legend ul {
            max-height: 5vw;
            overflow-y: auto;
        }
        .chartDisplay {
            background-color: white;
            padding: 1vw;
            border: 1px solid blue;
            border-radius: 0.5vw;
            max-height: 40vw;
            max-width: 60vw;
        }
        .topChartDiv{
            display: flex;
            gap: 1vw;
            color: rgba(153, 112, 23);
            font-size: 2rem; 
            font-weight: bold; 
            text-align: center;
        }
        .topChartDiv span{
            font-size: .8rem; 
            color: grey;
        }
        .dataChart{
            background-color: white;
            flex: 1;
            height: 12vw;
            display: flex;
            justify-content: space-between;
            border-radius: .5vw;
            box-shadow: 0px 2px 5px grey;
            padding: 1vw;
            box-sizing: border-box;
        }
        .textData{
            width: 50%;
        }
        .topChartDiv img{
            width: 50%;
        }
        .flexDiv{
            display: flex;
            gap: 1vw;
            margin: 1vw auto 1vw auto;
        }
        .topSellingChart {
            max-width: 47vw;
            max-height: 25vw;
            background-color: white;
            padding: .5vw;
            border-radius: .5vw;
            box-shadow: 0px 2px 5px grey;
        }
        .drawSoldAndSoldInventoryChart{
            max-width: 27vw;
            max-height: 25vw;
            background-color: white;
            padding: .5vw;
            border-radius: .5vw;
            box-shadow: 0px 2px 5px grey;
        }
        .salesOverTimeChart{
            max-width: 47vw;
            max-height: 25vw;
            background-color: white;
            padding: .5vw;
            border-radius: .5vw;
            box-shadow: 0px 2px 5px grey;
        }
        .salesByCustomerChart{
            max-width: 27vw;
            max-height: 25vw;
            background-color: white;
            padding: .5vw;
            border-radius: .5vw;
            box-shadow: 0px 2px 5px grey;
        }
    /**sales history table */
        .salesTablePanel{
            width: 100%;
            background-color: white;
            box-sizing: border-box;
            box-shadow: 0px 2px 5px grey;
            border-radius: .5vw;
            padding:1vw;
            text-align:center;
            max-height: 45vw;
        }
        .salesTablePanelContainer{
            max-height: 30vw;
            overflow-y: auto;
        }
        .salesTablePanel table {
            width: 100%;
            border: none;
            cursor: pointer;
        }
        .salesTablePanel th, .salesTablePanel td {
            padding: 8px;
            text-align: center;
            border: none;
        }
        .salesTablePanel th {
            background-color: rgba(153, 112, 23);
            color: white;
        }
        .salesTablePanel p{
            font-size: 1.5em;
            font-style: bold;
        }
        .totalRev{
            text-align: left;
            margin: .5vw;
            width: 15vw;
            border: 1px solid rgba(153, 112, 23);
            padding: .5vw;
            box-sizing: border-box;
            border-radius: .5vw;
            color: grey;
            font-size: .8em;
        }
        .totalRev2{
            font-size: 3em;
            font-weight: bold;
            color:rgba(153, 112, 23);
        }
        .generateReport{
            text-align:right;
        }
        .generateReport button{
            margin: auto;
            margin-top: 3vw;
            height: 3vw;
            width: 30%;
            background-color: rgba(153, 112, 23);
            color: white;
            border: .1vw solid rgba(153, 112, 23);
            box-shadow: 0px 1px 3px grey;
            border-radius:.3vw;
            transform: translateY(-.1vw);
            font-size: 1.5em;
            transition: .3s ease;
        }
        .generateReport button:hover{
            background-color: white;
            color: rgba(153, 112, 23);
            box-shadow: 0px 0px 1px grey;
            transform: translateY(0vw);
        }
/**prod Setting */
        .prodSet{
            display: none;
            padding: 2vw;
            padding-top: 0vw;
        }
        .prodSetContent{
            display: flex;
            gap: 3%;
        }
    /**prod table */
        .prodTablePanel{
            width: 75%;
            background-color: white;
            box-sizing: border-box;
            box-shadow: 0px 2px 5px grey;
            border-radius: .5vw;
            padding:1vw;
            text-align:center;
            max-height: 37vw;
        }
        .prodTablePanelContainer{
            max-height: 30vw;
            overflow-y: auto;
        }
        .prodTablePanel table {
            width: 100%;
            border: none;
            cursor: pointer;
        }
        .prodTablePanel th, .prodTablePanel td {
            padding: 8px;
            text-align: center;
            border: none;
        }
        .prodTablePanel th {
            background-color: rgba(153, 112, 23);
            color: white;
        }
        .prodTablePanel tr:hover{
            background-color:rgb(199, 199, 199);
            transition: .1s ease;
        }
        .prodTablePanel p{
            font-size: 1.5em;
            font-style: bold;
        }
        thead th {
            position: sticky;
            top: 0;
            z-index: 1;
            }
    /**prod crud panel */
        .prodCrudPanel{
            background-color: white;
            height: 45vw;
            width: 25%;
            box-sizing: border-box;
            box-shadow: 0px 2px 5px grey;
            border-radius: .5vw;
            padding:1vw;
            display: flex;
            flex-direction: column;
            gap: 2vw;
        }
        .prodCrudPanel button{
            background-color: rgba(153, 112, 23);
            color: white;
            border: .1vw solid rgba(153, 112, 23);
            box-shadow: 0px 1px 3px grey;
            border-radius:.3vw;
            transform: translateY(-.1vw);
            transition: .3s ease;
        }
        .prodCrudPanel button:hover{
            background-color: white;
            color: rgba(153, 112, 23);
            box-shadow: 0px 0px 1px grey;
            transform: translateY(0vw);
        }
        .prodCrudPanel input, .prodCrudPanel select{
            border: none;
            border-bottom:.1vw solid grey;
            border-radius:.3vw;
        }
        .inputLabel{
            font-size: .7em;
            color: grey;
        }
    /**prodAction */
        .prodAction{
            width: 100%;
            height: 3vw;
            display:flex;
            gap: .2vw;
        }
        .prodAction button{
            flex:1;
            background-color: rgba(153, 112, 23);
            color: white;
            height: 100%;
            width: 100%;
            border: .1vw solid rgba(153, 112, 23);
            box-shadow: 0px 1px 3px grey;
            border-radius:.3vw;
            transform: translateY(-.1vw);
            transition: .3s ease;
        }
        .disabledButton{
            opacity: .75;
            cursor: not-allowed;
            pointer-events: none;
        }
    /**ID div */
        .IDDiv{
            width: 100%;
            height: 1.5vw;
            position: relative;
        }
        .IDDiv input{
            width: 30%;
            height: 100%;
            box-sizing: border-box;
            text-align: center;
        }
        .IDDiv button{
            position: absolute;
            top:0px;
            right: 0px;
            width: 35%;
            height: 100%;
        }
    /**name div */
        .nameDiv{
            width: 100%;
            height: 2.5vw;
        }
        .nameDiv input{
            width: 100%;
            height: 1.5vw;
            box-sizing: border-box;
        }
    /**categoryDiv */
        .categoryDiv {
            width: 100%;
            height: 4.6vw;
        }
        .categoryDiv select{
            width: 100%;
            height: 1.5vw;
            box-sizing: border-box;
        }
        .categoryDivTop{
            display: flex;
            height: 1.5vw;
            align-items: center;
            position: relative;
        }
        .categoryDivTop button{
            position: absolute;
            top:0px;
            right: 0px;
            width: 35%;
            height: 100%;
        }
        .addCategoryDiv{
            width: 100%;
            height: 1.5vw;
        }
        .addCategoryDiv button{
            width: 20%;
            height: 100%;
        }
        .addCategoryDiv input{
            width: 78.5%;
            height: 100%;
            box-sizing: border-box;
        }
    /**priceDiv */
        .priceDiv{
            width: 100%;
            height: 2.5vw;
        }
        .priceDiv input{
            width: 100%;
            height: 1.5vw;
            box-sizing: border-box;
        }
    /**quantityDiv */
        .quantityDiv{
            width: 100%;
            height: 2.5vw;
        }
        .quantityDiv input{
            width: 100%;
            height: 1.5vw;
            box-sizing: border-box;
        }
    /**urlDiv */
        .urlDiv{
            width: 100%;
            height: 5.3vw;
            position: relative;
        }
        .urlDiv input{
            width: 100%;
            height: 1.5vw;
            box-sizing: border-box;
        }
        .urlDivTop{
            display: flex;
            height: 1.5vw;
            align-items: center;
            position: relative;
        }
        .urlDivTop button{
            position: absolute;
            top:0px;
            right: 0px;
            width: 35%;
            height: 100%;
        }
        .addUrlDiv{
            width: 100%;
            height: 1.5vw;
        }
        .addUrlDiv button{
            width: 20%;
            height: 100%;
        }
        .addUrlDiv input{
            width: 78.5%;
            height: 100%;
            box-sizing: border-box;
        }
    /**tagDiv */
        .tagDiv{
            width: 100%;
            height: 7.6vw;
        }
        .tagDivTop{
            display: flex;
            height: 1.5vw;
            align-items: center;
            position: relative;
        }
        .tagDivTop button{
            position: absolute;
            top:0px;
            right: 0px;
            width: 35%;
            height: 100%;
        }
        .tagContainer{
            max-height: 4vw;
            overflow-y: auto;
        }
        .addTagDiv{
            width: 100%;
            height: 1.5vw;
        }
        .addTagDiv button{
            width: 20%;
            height: 100%;
        }
        .addTagDiv input{
            width: 78.5%;
            height: 100%;
            box-sizing: border-box;
        }
    /**table */
/**account Setting */
        .accSet{
            display: none;
            padding: 2vw;
            padding-top: 0vw;
            overflow-y: auto;
        }
    /**Acc table */
        .accTablePanel{
            width: 100%;
            background-color: white;
            box-sizing: border-box;
            box-shadow: 0px 2px 5px grey;
            border-radius: .5vw;
            padding:1vw;
            text-align:center;
            max-height: 37vw;
        }
        .accTablePanelContainer{
            max-height: 30vw;
            overflow-y: auto;
        }
        .accTablePanel button{
            background-color: rgba(153, 112, 23);
            color: white;
            height: 1.5vw;
            width: 30%;
            border: .1vw solid rgba(153, 112, 23);
            box-shadow: 0px 1px 3px grey;
            border-radius:.3vw;
            transform: translateY(-.1vw);
            transition: .3s ease;
        }
        .accTablePanel button:hover{
            background-color: white;
            color: rgba(153, 112, 23);
            box-shadow: 0px 0px 1px grey;
            transform: translateY(0vw);
        }
        .accTablePanel table {
            width: 100%;
            border: none;
            cursor: pointer;
        }
        .accTablePanel th, .accTablePanel td {
            padding: 8px;
            text-align: center;
            border: none;
        }
        .accTablePanel th {
            background-color: rgba(153, 112, 23);
            color: white;
        }
        .accTablePanel tr:hover{
            background-color:rgb(199, 199, 199);
            transition: .1s ease;
        }
        .accTablePanel p{
            font-size: 1.5em;
            font-style: bold;
        }
        thead th {
            position: sticky;
            top: 0;
            z-index: 1;
        }
        .reqAdminPassDiv{
            width: 20vw;
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: .5vw;
            padding: 1vw;
            border-radius:.5vw;
            align-items: center;
            background-color: white;
            box-shadow: 0px 2px 5px grey;
            z-index:6;
            position: fixed;
            top: 10vw;
            left:50vw;
            opacity:0;
            visibility: hidden;
            transition: .3s ease;
        }
        .reqAdminPassDiv input{
            width: 70%;
            height: 1.5vw;
            border:none;
            border-bottom: .1vw solid grey;
            border-radius: 1.2vw;
        }
        .reqAdminPassAction{
            width: 70%;
            display: flex;
            gap: .5vw;
        }
        .reqAdminPassAction button{
            background-color: rgba(153, 112, 23);
            color: white;
            height: 1.5vw;
            width: 50%;
            border: .1vw solid rgba(153, 112, 23);
            box-shadow: 0px 1px 3px grey;
            border-radius:.3vw;
            transform: translateY(-.1vw);
            transition: .3s ease;
        }
        .reqAdminPassAction button:hover{
            background-color: white;
            color: rgba(153, 112, 23);
            box-shadow: 0px 0px 1px grey;
            transform: translateY(0vw);
        }
        
/**alert */
        .alert {
            position: fixed;
            top: 120px;
            right: 50px;
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
    </style>
</head>
<body>
    <div id="blur"></div>
<!--alert-->
    <div class="alert" id="alert">
        <p id="alertText">text</p>
        <button id="closeBtn"><img  src="images/icon-close.png"></button>
    </div>
<!--side panel-->
    <div class="sidePanel">
        <img src="images\kapeShop-logo.png">
        <button class="sidePanelBtn SelectedSidePanelBtn" id="homeBtn" onclick="gotoNext('homeSet', 'homeBtn')">Dashboard</button>
        <button class="sidePanelBtn" id="prodSetBtn" onclick="gotoNext('prodSet', 'prodSetBtn')">Product Settings</button>
        <button class="sidePanelBtn" id="accSetBtn" onclick="gotoNext('accSet', 'accSetBtn')">Account Settings</button>
        <button class="sidePanelBtn" onclick="endSession()">Logout</button>
    </div>
    <div class="content">
    <!--home div-->
        <div class="homeSet" id="homeSet">
            <div class="title">
                <p><b>Dashboard</b></p>
            </div>
        <!--charts-->
            <div class="chartsDiv" id="chartsDiv">
                <div id="reportDiv">
                    <!--top charts-->
                        <div class="topChartDiv">
                            <div class="dataChart">
                                <div class="textData">
                                    <p id="salesTodayDisplay">Loading...</p>
                                    <span>Sales Today</span>
                                </div>
                                <img src="images/icon-sales.png">
                            </div>
                            <div class="dataChart">
                                <div class="textData">
                                    <p id="stockAlertDisplay">Loading...</p>
                                    <span>Low Stock Products</span>
                                </div>
                                <img src="images/icon-stock.png">
                            </div>
                            <div class="dataChart">
                                <div class="textData">
                                    <p id="registeredAccountsDisplay">Loading...</p>
                                    <span>Registered Users</span>
                                </div>
                                <img src="images/icon-users.png">
                            </div>
                        </div>
                    <!--bottom charts-->
                        <div class="flexDiv">
                            <canvas class="topSellingChart" id="topSellingChart"></canvas>
                            <canvas class="drawSoldAndSoldInventoryChart" id="drawSoldAndSoldInventoryChart"></canvas>
                        </div>
                        <div class="flexDiv">
                            <canvas class="salesByCustomerChart" id="salesByCustomerChart"></canvas>
                            <canvas class="salesOverTimeChart" id="salesOverTimeChart"></canvas>
                        </div>
                </div>
        <!--sales table-->
                <div class="salesTablePanel" id="salesTablePanel">
                    <p><b>Sales History</b></p>
                    <div class="salesTablePanelContainer">
                        <table id="saleshistoryTable">
                            <thead>
                            <tr>
                                <th>Email</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- Dynamic rows will be added here -->
                            </tbody>
                        </table>
                    </div>
                    <div class="totalRev">
                        <span>Total Revenue</span><br><br>
                        <span class="totalRev2" id="totalRev">loading...</span>
                    </div>
                    
                </div>
            </div>
            <div class="generateReport">
                <button onclick="generateReport()">generate report</button>
            </div>
            
        </div>
    <!--product settings div-->
        <div class="prodSet" id="prodSet">
            <div class="title">
                <p><b>Product Settings</b></p>
            </div>
        <!--prodCrudPanel-->
            <div class="prodSetContent">
                    <div class="prodCrudPanel">
                    <!--ID div-->
                        <div class="IDDiv">
                            <label class="inputLabel" for="prodID">Product ID:</label>
                            <input type="text" name="prodID" id="prodID" readonly>
                        </div>
                    <!--name div-->
                        <div class="nameDiv">
                            <label class="inputLabel" for="prodNameInput">Name:</label>
                            <input type="text" name="prodNameInput" id="prodNameInput" placeholder="Enter Name">
                        </div>
                    <!--price div-->
                        <div class="priceDiv">
                            <label class="inputLabel">Price:</label>
                            <input type="number" name="prodPriceInput" id="prodPriceInput" placeholder="Enter Price">
                        </div>
                    <!--quantity div-->
                        <div class="quantityDiv">
                            <label class="inputLabel">Quantity:</label>
                            <input type="number" name="prodQuantityInput" id="prodQuantityInput" placeholder="Enter Quantity">
                        </div>
                    <!--url div-->
                        <div class="urlDiv">
                            <div class="urlDivTop">
                                <label class="inputLabel">Image URL:</label>
                                <button type="button" onclick="toggleAddUrl()">New URL</button>
                            </div>
                            <input type="text" id="urlDisplay" placeholder="Image URL" readonly disable>
                            <div class="addUrlDiv" id="addUrlDiv" style="display: none; margin-top: 8px;">
                                <input type="file" name="prodImageInput" id="prodImageInput" accept="image/*">
                                <button type="button" onclick="addUrl()">Add</button>
                            </div>
                        </div>
                    <!--category div-->
                        <div class="categoryDiv">
                            <div class="categoryDivTop">
                                <label class="inputLabel">Select Category:</label>
                                <button type="button" onclick="toggleAddCat()">New Category</button>
                            </div>
                            <select id="categorySelect">
                                <!-- Categories from XML will load here -->
                            </select>
                           <div class="addCategoryDiv" id="addCategoryDiv" style="display: none;">
                                <input type="text" id="newCategoryInput" placeholder="Enter Category">
                                <button onclick="addCategory()">Add</button>
                            </div>
                        </div>
                    <!--tags div-->
                        <div class="tagDiv">
                            <div class="tagDivTop">
                                <label class="inputLabel" for="tagSelect">Select Tag/s:</label>
                                <button onclick="toggleAddTag()">New Tag</button>
                            </div>
                            <div class="tagContainer" id="tagContainer">
                                <label><input type="checkbox" value="Hot" onchange="handleTagSelection(this)"> Hot</label><br>
                                <label><input type="checkbox" value="Cold" onchange="handleTagSelection(this)"> Cold</label><br>
                                <label><input type="checkbox" value="Frappe" onchange="handleTagSelection(this)"> Frappe</label><br>
                                <label><input type="checkbox" value="Dessert" onchange="handleTagSelection(this)"> Dessert</label><br>
                            </div>
                            <div class="addTagDiv" id="addTagDiv" style="display:none; margin-top: 8px;">
                                <input class="newTagInput" type="text" id="newTagInput" placeholder="Enter Tag" />
                                <button onclick="addTag()">Add</button>
                            </div>
                        </div>
            <!--action-->              
                        <div class="prodAction">
                            <button type="button" id="createNewProduct" onclick="createProduct()">New Product</button>
                            <button type="button" id="createNewProductCancel" onclick="cancelCreateProduct()" style="display: none;">Cancel</button>
                            <button type="button" id="updateProduct" onclick="updateProduct()">Update Product</button>
                            <button type="button" id="deleteProduct" onclick="deleteProd()">Delete Product</button>
                        </div>
                    </div>
        <!--prodTable-->
                <div class="prodTablePanel" id="prodTablePanel">
                    <p><b>Product Inventory</b></p>
                    <div class="prodTablePanelContainer">
                        <table id="productTable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Category</th>
                                <th>Tags</th>
                                <th>Sold Count</th>
                                <th>Image URL</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- Dynamic rows will be added here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    <!--account settings div-->
        <div class="accSet" id="accSet">
            <div class="title">
                <p><b>Account Settings</b></p>
            </div>
            <div class="accTablePanel" id="accTablePanel">
                <p><b>Account List</b></p>
                <div class="accTablePanelContainer">
                    <table id="accTable">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dynamic rows will be added here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="reqAdminPassDiv" id="reqAdminPassDiv">
                <p>Are you sure you want to delete this account?</p>
                <input type="password" name="reqAdminPass" id="reqAdminPass" placeholder="Enter Admin Password"><br>
                <input type="hidden" id="emailToDelete">
                <div class="reqAdminPassAction">
                    <button id="delAcc" onclick="confirmDelete()">Confirm Delete</button>
                    <button onclick="hideDeleteAccConfirm()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <script>
    //session logout
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
    //div selecting
        function gotoNext(panelId, buttonId) {
            const panels = ['homeSet', 'prodSet', 'accSet'];
            panels.forEach(id => {
                document.getElementById(id).style.display = "none";
            });
            const buttons = ['homeBtn', 'prodSetBtn', 'accSetBtn'];
            buttons.forEach(id => {
                document.getElementById(id).classList.remove("SelectedSidePanelBtn");
            });

            // Show selected panel
            document.getElementById(panelId).style.display = "block";
            document.getElementById(buttonId).classList.add("SelectedSidePanelBtn");
        }
    //onload
        window.onload = function() {
            //dashboard
            getAllXmlData().then(() => {
                displaySalesToday();
                displayLowStockAlert();
                displayTotalRegisteredAccounts();

                drawTopSellingChart();
                drawSalesOverTimeChart();
                drawSalesByCustomerChart();
                drawSoldAndSoldInventoryChart();
            });
            //sales history
            loadSalesHistoryTable();
            //prod loads
            loadCategoriesFromXML();
            loadTagsFromXML();
            loadProductTable();
            //acc loads
            loadAccountTable()
        };
//dashboard charts
        let userDatas = [];
        let prodDatas = [];
        let salesDatas = [];
    //get all data from xml
        function getAllXmlData() {
            return new Promise((resolve) => {
                let loadedCount = 0;
                function checkDone() {
                    loadedCount++;
                    if (loadedCount === 3) {
                        resolve(); // All 3 XMLs loaded
                    }
                }
            // Load userData.xml
                const userReq = new XMLHttpRequest();
                userReq.open("GET", "xmlFiles/userData.xml", true);
                userReq.onreadystatechange = function () {
                    if (userReq.readyState === 4 && userReq.status === 200) {
                        const xml = userReq.responseXML;
                        const users = xml.getElementsByTagName("user");
                        for (let i = 0; i < users.length; i++) {
                            const email = users[i].getElementsByTagName("email")[0].textContent;
                            userDatas.push({ email }); // Add more fields if needed
                        }
                        checkDone();
                    }
                };
                userReq.send();
            // Load prodData.xml
                const prodReq = new XMLHttpRequest();
                prodReq.open("GET", "xmlFiles/prodData.xml", true);
                prodReq.onreadystatechange = function () {
                    if (prodReq.readyState === 4 && prodReq.status === 200) {
                        const xml = prodReq.responseXML;
                        const products = xml.getElementsByTagName("product");
                        for (let i = 0; i < products.length; i++) {
                            const ID = products[i].getElementsByTagName("ID")[0]?.textContent;
                            const name = products[i].getElementsByTagName("name")[0].textContent;
                            const price = parseFloat(products[i].getElementsByTagName("price")[0].textContent);
                            const stock = parseInt(products[i].getElementsByTagName("stock")[0].textContent);
                            const soldCount = parseInt(products[i].getElementsByTagName("soldCount")[0].textContent);
                            const category = products[i].getElementsByTagName("category")[0]?.textContent || "";
                            const tagElements = products[i].getElementsByTagName("tag");
                            let tags = [];
                            for (let j = 0; j < tagElements.length; j++) {
                                tags.push(tagElements[j]?.textContent?.trim() || "");
                            }
                            prodDatas.push({ ID, name, price, stock, soldCount, category, tags });
                        }
                        checkDone();
                    }
                };
                prodReq.send();
            // Load salesHistory.xml
                const salesReq = new XMLHttpRequest();
                salesReq.open("GET", "xmlFiles/salesHistory.xml", true);
                salesReq.onreadystatechange = function () {
                    if (salesReq.readyState === 4 && salesReq.status === 200) {
                        const xml = salesReq.responseXML;
                        const sales = xml.getElementsByTagName("item");
                        for (let i = 0; i < sales.length; i++) {
                            const email = sales[i].getElementsByTagName("email")[0].textContent;
                            const prodName = sales[i].getElementsByTagName("prodName")[0].textContent;
                            const quantity = parseInt(sales[i].getElementsByTagName("quantity")[0].textContent);
                            const price = parseFloat(sales[i].getElementsByTagName("price")[0].textContent);
                            const date = sales[i].getElementsByTagName("date")[0].textContent;

                            salesDatas.push({ email, prodName, quantity, price, date });
                        }
                        checkDone();
                    }
                };
                salesReq.send();
            });
        }
    //sales today
        function displaySalesToday() {
            const padZero = (num) => num.toString().padStart(2, '0');
            const today = `${padZero(new Date().getMonth() + 1)}/${padZero(new Date().getDate())}/${new Date().getFullYear()}`;
            let total = 0;
            salesDatas.forEach(sale => {
                if (sale.date === today) {
                total += sale.quantity * sale.price;
                }
            });
            document.getElementById('salesTodayDisplay').textContent = `₱${total.toLocaleString()}`;
        }
    //low stock
        function displayLowStockAlert() {
            const lowStockCount = prodDatas.filter(product => Number(product.stock) <= 30).length;
            document.getElementById('stockAlertDisplay').textContent = lowStockCount;
        }
    //account signed in
        function displayTotalRegisteredAccounts() {
            const totalUsers = userDatas.length - 1;
            document.getElementById('registeredAccountsDisplay').textContent = totalUsers;
        }
    //top selling chart
        function drawTopSellingChart() {
            const salesMap = {};
            salesDatas.forEach(sale => {
                const name = sale.prodName;
                if (!salesMap[name]) {
                    salesMap[name] = 0;
                }
                salesMap[name] += sale.quantity;
            });
            const sortedSales = Object.entries(salesMap)
                .map(([prodName, quantity]) => ({ prodName, quantity }))
                .sort((a, b) => b.quantity - a.quantity)
                .slice(0, 10); // Top 10 only
            const labels = sortedSales.map(item => item.prodName);
            const quantities = sortedSales.map(item => item.quantity);
            const ctx = document.getElementById('topSellingChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Units Sold',
                        data: quantities,
                        backgroundColor:['#5E3219', '#87553B','#A67B5B', '#BC9773', '#C8AD7F'],
                        borderColor: 'rgba(153, 112, 23)',
                        borderWidth: 1,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            },
                            title: {
                                display: true,
                                text: 'Quantity Sold'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Product Name'
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Top 10 Best-Selling Products',
                            font: {
                                size: 24
                            }
                        },
                        legend: {
                            display: true
                        }
                    }
                }
            });
        }
    //sales over time
        function drawSalesOverTimeChart() {
            const dateSalesMap = {};
            salesDatas.forEach(sale => {
                const date = sale.date;
                const total = sale.quantity * sale.price;
                if (!dateSalesMap[date]) {
                    dateSalesMap[date] = 0;
                }
                dateSalesMap[date] += total;
            });
            const sortedEntries = Object.entries(dateSalesMap).sort((a, b) => {
                const d1 = new Date(a[0]);
                const d2 = new Date(b[0]);
                return d1 - d2;
            });
            const labels = sortedEntries.map(entry => entry[0]);
            const totals = sortedEntries.map(entry => entry[1]);
            const ctx = document.getElementById('salesOverTimeChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Sales (₱)',
                        data: totals,
                        fill: false,
                        borderColor: 'rgba(153, 112, 23, .50)',
                        backgroundColor: 'rgba(153, 112, 23)',
                        tension: 0,
                        pointRadius: 5,
                        pointHoverRadius: 10
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Total Sales (₱)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Sales Over Time',
                            font: {
                                size: 24
                            }
                        },
                        legend: {
                            display: true
                        }
                    }
                }
            });
        }
    //sales by cutomer
        function drawSalesByCustomerChart() {
            const customerMap = {};
            salesDatas.forEach(sale => {
                const email = sale.email;
                const revenue = sale.price * sale.quantity;
                if (!customerMap[email]) {
                    customerMap[email] = 0;
                }
                customerMap[email] += revenue;
            });

            const sortedEntries = Object.entries(customerMap)
                .sort((a, b) => b[1] - a[1])
                .slice(0, 5);

            const emails = sortedEntries.map(entry => entry[0]);
            const revenues = sortedEntries.map(entry => entry[1]);

            const ctx = document.getElementById('salesByCustomerChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: emails,
                    datasets: [{
                        label: 'Total Revenue (₱)',
                        data: revenues,
                        backgroundColor: ['#5E3219', '#87553B','#A67B5B', '#BC9773', '#C8AD7F'],
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Top 5 buyers',
                            font: {
                                size: 24
                            }
                        },
                        legend: {
                            position: 'left',
                            labels: {
                                boxWidth: 15
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    return `${label}: ₱${value.toLocaleString()}`;
                                }
                            }
                        }
                    }
                }
            });
        }

    //sold and unsold
        function drawSoldAndSoldInventoryChart() {
            const labels = [];
            const stockCounts = [];
            const soldCounts = [];

            prodDatas.forEach(prod => {
                const stock = parseInt(prod.stock);
                const sold = parseInt(prod.soldCount);

                labels.push(prod.name);
                stockCounts.push(stock);
                soldCounts.push(sold);
            });

            const ctx = document.getElementById('drawSoldAndSoldInventoryChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Stock',
                            data: stockCounts,
                            backgroundColor: '#A67B5B'
                        },
                        {
                            label: 'Sold',
                            data: soldCounts,
                            backgroundColor: '#5E3219'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Product Stock and Sales Comparison',
                            font: {
                                size: 24
                            }
                        },
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        x: {
                            stacked: false
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    //sales history table
        function loadSalesHistoryTable() {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "xmlFiles/salesHistory.xml", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const xml = xhr.responseXML;
                    const sales = xml.getElementsByTagName("item");
                    const tableBody = document.querySelector("#saleshistoryTable tbody");
                    const totalRevDisplay = document.getElementById("totalRev");
                    
                    tableBody.innerHTML = ""; // Clear existing rows
                    let totalRevenue = 0;

                    for (let i = 0; i < sales.length; i++) {
                        const email = sales[i].getElementsByTagName("email")[0]?.textContent || "";
                        const prodName = sales[i].getElementsByTagName("prodName")[0]?.textContent || "";
                        const price = parseFloat(sales[i].getElementsByTagName("price")[0]?.textContent || "0");
                        const quantity = parseInt(sales[i].getElementsByTagName("quantity")[0]?.textContent || "0");
                        const date = sales[i].getElementsByTagName("date")[0]?.textContent || "";

                        // Compute and accumulate total
                        const subtotal = price * quantity;
                        totalRevenue += subtotal;

                        const row = document.createElement("tr");
                        row.innerHTML = `
                            <td>${email}</td>
                            <td>${prodName}</td>
                            <td>₱${price.toFixed(2)}</td>
                            <td>${quantity}</td>
                            <td>${date}</td>
                        `;
                        tableBody.appendChild(row);
                    }

                    // Display the total revenue
                    totalRevDisplay.textContent = `₱${totalRevenue.toFixed(2)}`;
                }
            };
            xhr.send();
        }

























//prod settings 
    //handel url display
        function toggleAddUrl() {
            const div = document.getElementById("addUrlDiv");
            div.style.display = div.style.display === "none" ? "block" : "none";
        }
        function addUrl() {
            const fileInput = document.getElementById("prodImageInput");
            const file = fileInput.files[0];
            if (file) {
                document.getElementById("urlDisplay").value = file.name;
            } else {
                showAlert("Please Select a File.", "rgb(247, 84, 84)"); 
            }
            // Hide the file input again
            document.getElementById("addUrlDiv").style.display = "none";
        }
    //load category
        function loadCategoriesFromXML() {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "xmlFiles/prodData.xml", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const xml = xhr.responseXML;
                    const products = xml.getElementsByTagName("product");
                    const categorySet = new Set();
                    for (let i = 0; i < products.length; i++) {
                        const category = products[i].getElementsByTagName("category")[0].textContent.trim();
                        if (category) {
                            const formatted = category.charAt(0).toUpperCase() + category.slice(1).toLowerCase();
                            categorySet.add(formatted);
                        }
                    }
                    const select = document.getElementById("categorySelect");
                    select.innerHTML = '';
                    categorySet.forEach(cat => {
                        const option = document.createElement("option");
                        option.value = cat.toLowerCase();
                        option.textContent = cat;
                        select.appendChild(option);
                    });
                }
            };
            xhr.send();
        }
        function toggleAddCat() {
            const div = document.getElementById("addCategoryDiv");
            div.style.display = div.style.display === "none" ? "block" : "none";
        }
        function addCategory() {
            const input = document.getElementById('newCategoryInput');
            const categoryName = input.value.trim();
            const select = document.getElementById('categorySelect');

            if (categoryName === "") {
                showAlert("Please enter a category name.", "rgb(247, 84, 84)");
                return;
            }

            // Check for duplicates
            for (let option of select.options) {
                if (option.value.toLowerCase() === categoryName.toLowerCase()) {
                    showAlert("Category already exists.", "rgb(247, 84, 84)");
                    return;
                }
            }
            // Add new category at the end
            const newOption = document.createElement('option');
            newOption.value = categoryName.toLowerCase();
            newOption.textContent = categoryName.charAt(0).toUpperCase() + categoryName.slice(1).toLowerCase();
            select.appendChild(newOption);

            // Select the new category
            select.value = newOption.value;
            document.getElementById('addCategoryDiv').style.display = 'none';
            input.value = "";
        }
    //load tags
        let selectedTags = [];
        function loadTagsFromXML() {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "xmlFiles/prodData.xml", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const xml = xhr.responseXML;
                    const products = xml.getElementsByTagName("product");
                    const tagSet = new Set();

                    for (let i = 0; i < products.length; i++) {
                        const tags = products[i].getElementsByTagName("tag");
                        for (let j = 0; j < tags.length; j++) {
                            const tag = tags[j].textContent.trim().toLowerCase();
                            if (tag) {
                                tagSet.add(tag);
                            }
                        }
                    }

                    const container = document.getElementById("tagContainer");
                    container.innerHTML = '';

                    Array.from(tagSet)
                        .forEach(tag => {
                            const label = document.createElement("label");
                            label.innerHTML = `<input type="checkbox" value="${tag}" onchange="handleTagSelection(this)"> ${tag}`;
                            container.appendChild(label);
                            container.appendChild(document.createElement("br"));
                        });
                }
            };
            xhr.send();
        }

        function handleTagSelection(checkbox) {
            const checkedBoxes = document.querySelectorAll('#tagContainer input[type="checkbox"]:checked');

            if (checkedBoxes.length > 3) {
                showAlert("Select Only 3 Tags.", "rgb(247, 84, 84)");
                checkbox.checked = false;
                return;
            }

            selectedTags = Array.from(checkedBoxes).map(cb => cb.value.toLowerCase());
        }

        function toggleAddTag() {
            const div = document.getElementById("addTagDiv");
            div.style.display = div.style.display === "none" ? "block" : "none";
        }

        function addTag() {
            const input = document.getElementById("newTagInput");
            const tagName = input.value.trim().toLowerCase(); // force lowercase

            if (tagName === "") {
                showAlert("Enter a Tag Name.", "rgb(247, 84, 84)"); 
                return;
            }

            // Check for duplicates
            const existingInputs = document.querySelectorAll('#tagContainer input[type="checkbox"]');
            for (let inputEl of existingInputs) {
                if (inputEl.value === tagName) {
                    showAlert("Tag Already Exists.", "rgb(247, 84, 84)"); 
                    return;
                }
            }

            const container = document.getElementById("tagContainer");
            const label = document.createElement("label");
            label.innerHTML = `<input type="checkbox" value="${tagName}" onchange="handleTagSelection(this)"> ${tagName}`;
            container.appendChild(label);
            container.appendChild(document.createElement("br"));

            input.value = "";
            document.getElementById("addTagDiv").style.display = "none";
        }


    //load prod table
        function loadProductTable() {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "xmlFiles/prodData.xml", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const xml = xhr.responseXML;
                    const products = xml.getElementsByTagName("product");
                    const tableBody = document.querySelector("#productTable tbody");
                    tableBody.innerHTML = ""; // Clear existing rows

                    for (let i = 0; i < products.length; i++) {
                        const ID = products[i].getElementsByTagName("ID")[0]?.textContent || "";
                        const name = products[i].getElementsByTagName("name")[0]?.textContent || "";
                        const price = products[i].getElementsByTagName("price")[0]?.textContent || "";
                        const quantity = products[i].getElementsByTagName("stock")[0]?.textContent || "";
                        const img = products[i].getElementsByTagName("img")[0]?.textContent || "";
                        const category = products[i].getElementsByTagName("category")[0]?.textContent || "";
                        const soldCount = products[i].getElementsByTagName("soldCount")[0]?.textContent || "";

                        // Get tags safely
                        const tagElements = products[i].getElementsByTagName("tag");
                        let tags = [];
                        for (let j = 0; j < tagElements.length; j++) {
                            tags.push(tagElements[j]?.textContent?.trim() || "");
                        }

                        const row = document.createElement("tr");
                        row.id = `product-${ID}`; // Unique ID for the row
                        row.innerHTML = `
                            <td>${ID}</td>
                            <td>${name}</td>
                            <td>${price}.00</td>
                            <td>${quantity}</td>
                            <td>${category}</td>
                            <td>${tags.join(", ")}</td>
                            <td>${soldCount}</td>
                            <td>${img}</td>
                        `;
                        tableBody.appendChild(row);
                    }
                }
            };
            xhr.send();
        }

        document.getElementById("productTable").addEventListener("click", function(event) {
            const clickedRow = event.target.closest("tr");
            if (clickedRow) {
                // Assuming each row has its ID set, and columns are fixed order:
                const cells = clickedRow.children;
                // Extract data from the row cells
                const product = {
                    ID: cells[0].textContent.trim(),
                    name: cells[1].textContent.trim(),
                    price: cells[2].textContent.trim().replace('.00',''), // remove .00 suffix
                    quantity: cells[3].textContent.trim(),
                    category: cells[4].textContent.trim(),
                    tags: cells[5].textContent.trim().split(", ").filter(tag => tag !== ""),
                    soldCount: cells[6].textContent.trim(),
                    imageUrl: cells[7].textContent.trim()
                };
                // Populate form fields with product data
                const prodID = document.getElementById('prodID');
                if (prodID) prodID.value = product.ID || '';
                document.getElementById('prodNameInput').value = product.name || '';
                document.getElementById('prodPriceInput').value = product.price || '';
                document.getElementById('prodQuantityInput').value = product.quantity || '';
                const urlDisplay = document.getElementById('urlDisplay');
                if (urlDisplay) urlDisplay.value = product.imageUrl || '';
                // Set category select
                const categorySelect = document.getElementById('categorySelect');
                const categoryValue = (product.category || '').toLowerCase();
                let found = false;
                for (let i = 0; i < categorySelect.options.length; i++) {
                    if (categorySelect.options[i].value.toLowerCase() === categoryValue) {
                        categorySelect.selectedIndex = i;
                        found = true;
                        break;
                    }
                }
                if (!found && categoryValue !== '') {
                    const newOption = document.createElement("option");
                    newOption.value = categoryValue;
                    newOption.textContent = categoryValue.charAt(0).toUpperCase() + categoryValue.slice(1);
                    categorySelect.appendChild(newOption);
                    categorySelect.value = categoryValue;
                }
                // Check/uncheck tag checkboxes
                const selectedTags = product.tags.map(tag => tag.toLowerCase());
                const checkboxes = document.querySelectorAll('#tagContainer input[type="checkbox"]');
                checkboxes.forEach(cb => {
                    const cbValue = cb.value.trim().toLowerCase();
                    cb.checked = selectedTags.includes(cbValue);
                });
            }
        });
    //new product 1
        let isCreating = false;
        function cancelCreateProduct(){
            isCreating = false;
            document.getElementById("prodID").value = "";
            document.getElementById("updateProduct").classList.remove("disabledButton");
            document.getElementById("deleteProduct").classList.remove("disabledButton");
            document.getElementById("createNewProduct").textContent = "New Product";
            document.getElementById("createNewProductCancel").style.display = "none";
        }
        function createProduct() {
            document.getElementById("createNewProductCancel").style.display = "block";
            if (!isCreating) {
                const xhr = new XMLHttpRequest();
                xhr.open("GET", "xmlFiles/prodData.xml", true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const xml = xhr.responseXML;
                        const incrementID = xml.getElementsByTagName("incrementID")[0].textContent;
                        window.newProductID = incrementID;
                        document.getElementById("prodID").value = window.newProductID;
                        document.getElementById("prodNameInput").value = "";
                        document.getElementById("prodPriceInput").value = "";
                        document.getElementById("prodQuantityInput").value = "";
                        document.getElementById("urlDisplay").value = "";
                        document.getElementById("categorySelect").selectedIndex = 0;
                        const checkboxes = document.querySelectorAll("#tagContainer input[type='checkbox']");
                        checkboxes.forEach(cb => cb.checked = false);
                        document.getElementById("createNewProduct").textContent = "Save";
                        document.getElementById("updateProduct").classList.add("disabledButton");
                        document.getElementById("deleteProduct").classList.add("disabledButton");
                        isCreating = true;
                    }
                };
                xhr.send();
            } else {
                const ID = document.getElementById("prodID").value;
                const name = document.getElementById("prodNameInput").value;
                const price = document.getElementById("prodPriceInput").value;
                const quantity = document.getElementById("prodQuantityInput").value;
                const imageUrl = document.getElementById("urlDisplay").value;
                const category = document.getElementById("categorySelect").value;
                const selectedTags = [];
                document.querySelectorAll("#tagContainer input[type='checkbox']:checked").forEach(cb => {
                    selectedTags.push(cb.value);
                });
                let tagsXml = "";
                selectedTags.forEach(tag => {
                    tagsXml += `<tag>${tag}</tag>`;
                });
                if (!name || !price || !quantity || !imageUrl || !category || selectedTags.length === 0) {
                    showAlert("Please fill in all fields.", "rgb(247, 84, 84)");
                } else {
                    const newProductXml = `
<product>
    <ID>${ID}</ID>
    <img>images/${imageUrl}</img>
    <name>${name}</name>
    <category>${category}</category>
    <price>${price}</price>
    <stock>${quantity}</stock>
    <soldCount>0</soldCount>
    <tags>
        ${tagsXml}
    </tags>
</product>
`.trim();
    //new product 2                
                    const xhr = new XMLHttpRequest();
                    xhr.open("POST", "func-adminCreateProd.php", true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                if (xhr.responseText === "success") {
                                    showAlert("Product Successfully Created!", "rgb(36, 221, 67)");
                                    // Reset form here...
                                    document.getElementById("prodID").value = "";
                                    document.getElementById("prodNameInput").value = "";
                                    document.getElementById("prodPriceInput").value = "";
                                    document.getElementById("prodQuantityInput").value = "";
                                    document.getElementById("urlDisplay").value = "";
                                    document.getElementById("categorySelect").selectedIndex = 0;
                                    const checkboxes = document.querySelectorAll("#tagContainer input[type='checkbox']");
                                    checkboxes.forEach(cb => cb.checked = false);
                                    document.getElementById("createNewProduct").textContent = "New Product";
                                    isCreating = false;
                                    document.getElementById("updateProduct").classList.remove("disabledButton");
                                    document.getElementById("deleteProduct").classList.remove("disabledButton");
                                    showAlert("Creating Product, Please Wait.", "rgb(221, 187, 36)");
                                    cancelCreateProduct();
                                    setTimeout(() => {
                                        showAlert("Product Successfully Created!", "rgb(36, 221, 67)");
                                        loadProductTable();
                                    }, 3000);
                                } else if (xhr.responseText === "error:duplicate_name") {
                                    showAlert("Product Name Already Exists.", "rgb(247, 84, 84)");
                                } else {
                                    showAlert("Error saving product.", "rgb(247, 84, 84)");
                                }
                            }
                        }
                    };
                    xhr.send("newProduct=" + encodeURIComponent(newProductXml));
                }
            }
        }
    //update product 1
        function updateProduct() {
            const ID = document.getElementById("prodID").value;
            const name = document.getElementById("prodNameInput").value;
            const price = document.getElementById("prodPriceInput").value;
            const quantity = document.getElementById("prodQuantityInput").value;
            const imageUrl = document.getElementById("urlDisplay").value;
            const category = document.getElementById("categorySelect").value;
            const selectedTags = [];
            document.querySelectorAll("#tagContainer input[type='checkbox']:checked").forEach(cb => {
                selectedTags.push(cb.value);
            });
            if (!ID) {
                showAlert("No product selected to update.", "rgb(247, 84, 84)");
                return;
            }
            if (!name || !price || !quantity || !imageUrl || !category || selectedTags.length === 0) {
                showAlert("Please fill in all fields.", "rgb(247, 84, 84)");
                return;
            }
            const xhrLoad = new XMLHttpRequest();
            xhrLoad.open("GET", "xmlFiles/prodData.xml", true);
            xhrLoad.onreadystatechange = function () {
                if (xhrLoad.readyState === 4 && xhrLoad.status === 200) {
                    const xml = xhrLoad.responseXML;
                    const products = xml.getElementsByTagName("product");
                    let currentSoldCount = "0";
                    for (let i = 0; i < products.length; i++) {
                        const productID = products[i].getElementsByTagName("ID")[0]?.textContent;
                        if (productID === ID) {
                            currentSoldCount = products[i].getElementsByTagName("soldCount")[0]?.textContent || "0";
                            break;
                        }
                    }
                    let tagsXml = "";
                    selectedTags.forEach(tag => {
                        tagsXml += `<tag>${tag}</tag>`;
                    });
                    const updatedProductXml = `
<product>
    <ID>${ID}</ID>
    <img>${imageUrl.startsWith("images/") ? imageUrl : "images/" + imageUrl}</img>
    <name>${name}</name>
    <category>${category}</category>
    <price>${price}</price>
    <stock>${quantity}</stock>
    <soldCount>${currentSoldCount}</soldCount>
    <tags>
        ${tagsXml}
    </tags>
</product>
`.trim();
    //update product 2
                    // Now send to PHP to update
                    const xhrUpdate = new XMLHttpRequest();
                    xhrUpdate.open("POST", "func-adminUpdateProd.php", true);
                    xhrUpdate.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhrUpdate.onreadystatechange = function () {
                        if (xhrUpdate.readyState === 4) {
                            if (xhrUpdate.status === 200) {
                                if (xhrUpdate.responseText === "success") {
                                    showAlert("Updating Product, Please Wait.", "rgb(221, 187, 36)");
                                    setTimeout(() => {
                                        showAlert("Product successfully updated!", "rgb(36, 221, 67)");
                                        loadProductTable();
                                         document.getElementById("prodID").value = "";
                                        document.getElementById("prodNameInput").value = "";
                                        document.getElementById("prodPriceInput").value = "";
                                        document.getElementById("prodQuantityInput").value = "";
                                        document.getElementById("urlDisplay").value = "";
                                        document.getElementById("categorySelect").selectedIndex = 0;
                                        const checkboxes = document.querySelectorAll("#tagContainer input[type='checkbox']");
                                        checkboxes.forEach(cb => cb.checked = false);
                                    }, 3000);
                                } else {
                                    showAlert("Failed to update product.", "rgb(247, 84, 84)");
                                    console.error(xhrUpdate.responseText);
                                }
                            }
                        }
                    };
                    xhrUpdate.send("updatedProductXml=" + encodeURIComponent(updatedProductXml) + "&ID=" + encodeURIComponent(ID));
                }
            };
            xhrLoad.send();
        }
    //delete product
        function deleteProd() {
            const prodID = document.getElementById("prodID").value.trim();

            if (!prodID) {
                showAlert("No product selected to delete.", "rgb(247, 84, 84)");
                return;
            }
            const xhr = new XMLHttpRequest();
                    xhr.open("POST", "func-adminDeleteProd.php", true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                                if (xhr.responseText === "success") {

                                    showAlert("Deleting Product, Please Wait.", "rgb(221, 187, 36)");
                                    setTimeout(() => {
                                        showAlert("Product Successfully Deleted!", "rgb(36, 221, 67)");
                                        loadProductTable();
                                        loadProductTable();
                                         document.getElementById("prodID").value = "";
                                        document.getElementById("prodNameInput").value = "";
                                        document.getElementById("prodPriceInput").value = "";
                                        document.getElementById("prodQuantityInput").value = "";
                                        document.getElementById("urlDisplay").value = "";
                                        document.getElementById("categorySelect").selectedIndex = 0;
                                        const checkboxes = document.querySelectorAll("#tagContainer input[type='checkbox']");
                                        checkboxes.forEach(cb => cb.checked = false);
                                    }, 3000);
                                } else {
                                    showAlert("Failed to delete product.", "rgb(247, 84, 84)");
                                    console.error(xhr.responseText);
                                }
                        }
                    };
                    xhr.send("ID=" + encodeURIComponent(prodID));
        }
//account settings
    //load acc table
        function loadAccountTable() {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "xmlFiles/userData.xml", true); // adjust path if needed
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const xml = xhr.responseXML;
                    const users = xml.getElementsByTagName("user");
                    const tableBody = document.querySelector("#accTable tbody");
                    tableBody.innerHTML = "";
                    for (let i = 1; i < users.length; i++) {
                        const email = users[i].getElementsByTagName("email")[0]?.textContent || "";
                        const password = users[i].getElementsByTagName("password")[0]?.textContent || "";
                        const status = users[i].getElementsByTagName("status")[0]?.textContent || "";
                        const row = document.createElement("tr");
                        row.innerHTML = `
                            <td>${email}</td>
                            <td>${password}</td>
                            <td>${status}</td>
                            <td><button onclick="showDeleteAccConfirm('${email}')">Delete</button></td>
                        `;
                        tableBody.appendChild(row);
                    }
                }
            };
            xhr.send();
        }
        function showDeleteAccConfirm(email) {
            document.getElementById("blur").classList.add("blur-overlay");
            document.getElementById("reqAdminPassDiv").style.visibility = "visible";
            document.getElementById("reqAdminPassDiv").style.opacity = "1";

            // Store the email to delete
            document.getElementById("emailToDelete").value = email;
        }
        function confirmDelete() {
            let reqAdminPass = document.getElementById("reqAdminPass").value.trim();
            let email = document.getElementById("emailToDelete").value;

            if (reqAdminPass === "") {
                showAlert("Please Enter the Admin Password.", "rgb(221, 187, 36)");
            } else if (reqAdminPass !== "admin") {
                showAlert("Wrong Password.", "rgb(247, 84, 84)");
            } else {
                hideDeleteAccConfirm();
                deleteAcc(email); // Call actual delete function
            }
        }
        function hideDeleteAccConfirm(){
            document.getElementById("blur").classList.remove("blur-overlay");
            document.getElementById("reqAdminPassDiv").style.visibility="hidden";
            document.getElementById("reqAdminPassDiv").style.opacity="o";
            document.getElementById("reqAdminPass").value="";
        }
        function deleteAcc(email) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "func-adminDeleteUser.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    showAlert("Deleting Account, Please Wait.", "rgb(221, 187, 36)");
                    setTimeout(() => {
                        showAlert("Account Successfully Deleted!", "rgb(36, 221, 67)");
                        loadAccountTable();
                        loadAccountTable();
                    }, 3000);
                } else {
                    alert("Failed to delete user.");
                }
            };
            xhr.send("email=" + encodeURIComponent(email));
        }
// generate report
        async function generateReport() {
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF('landscape', 'pt', 'a4');
            const pdfWidth = pdf.internal.pageSize.getWidth();
            // ===== 1. Add CHART IMAGE =====
            const chartDiv = document.getElementById("reportDiv");
            if (chartDiv) {
                // Ensure visibility
                const originalDisplay = chartDiv.style.display;
                if (getComputedStyle(chartDiv).display === 'none') {
                    chartDiv.style.display = 'block';
                }
                await new Promise(resolve => setTimeout(resolve, 200));
                const canvas = await html2canvas(chartDiv, {
                    scale: 2,
                    willReadFrequently: true
                });
                chartDiv.style.display = originalDisplay;
                const imgData = canvas.toDataURL("image/png");
                const imgWidth = canvas.width;
                const imgHeight = canvas.height;
                const scale = Math.min((pdfWidth * 0.9) / imgWidth, 400 / imgHeight);
                const scaledWidth = imgWidth * scale;
                const scaledHeight = imgHeight * scale;
                const x = (pdfWidth - scaledWidth) / 2;
                const y = 60;
                pdf.setFontSize(20);
                pdf.setFont("helvetica", "bold");
                pdf.text("Charts Report", pdfWidth / 2, 40, { align: "center" });
                pdf.addImage(imgData, 'PNG', x, y, scaledWidth, scaledHeight);
            }
            // ===== 2. Add TABLES from Arrays =====
            const tables = [
                { title: "Sales Report", data: salesDatas },
                { title: "Inventory Report", data: prodDatas },
                { title: "Account Report", data: userDatas }
            ];
            for (let i = 0; i < tables.length; i++) {
                const { title, data } = tables[i];
                if (!Array.isArray(data) || data.length === 0) {
                    console.warn(`${title} has no data.`);
                    continue;
                }
                const headers = Object.keys(data[0]);
                const rows = data.map(item => headers.map(h => item[h]));
                if (i > 0 || chartDiv) pdf.addPage(); // add page unless it's the first after charts
                pdf.setFontSize(20);
                pdf.setFont("helvetica", "bold");
                pdf.text(title, pdfWidth / 2, 40, { align: "center" });
                pdf.autoTable({
                    startY: 60,
                    head: [headers],
                    body: rows,
                    theme: 'grid',
                    styles: { fontSize: 10 },
                    headStyles: { fillColor: [153, 112, 23] }
                });
            }
            // ===== 3. Save PDF =====
            const padZero = (num) => num.toString().padStart(2, '0');
            const today = `${padZero(new Date().getMonth() + 1)}/${padZero(new Date().getDate())}/${new Date().getFullYear()}`;
            pdf.save("kapeShop_report_" + today + ".pdf");
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