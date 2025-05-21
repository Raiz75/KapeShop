<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="images\kapeShop-logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <style>
/**css */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .fontStyle2{
            font-family:"Georgia", serif
        }
        .fontColor{color: white;}
    /**logo */
        .logo{
            width: 10vw;
            height: 10vw;
            position: absolute;
            top: 3vw;
            left: 13vw;
        }
    /**middle */
        .middle{
            position: relative;
            background-image: url("images/bgg.webp");
            background-size: 100vw;
            background-repeat: no-repeat;
            background-blend-mode: darken;
            background-color: rgba(0, 0, 0, 0.3);
            width: 100%;
            height: 45vw;
            background-attachment: fixed;
        }
    /**registration n login */
        .sp1{
            position: absolute;
            top: 10vw;
            left: 7vw;
            font-size: 5.5em;
        }
        .q{
            color: rgba(202, 164, 81, 0.75);
        }
        .sp2{
            position: absolute;
            top: 20vw;
            left: 7vw;
            font-size: 1.2em;
        }
        .reglog{
            position: absolute;
            top: 25vw;
            left: 7vw;
        }
        .reglog button{
            background-color: rgba(153, 112, 23, 0.75);
            color: rgb(255, 255, 255);
            border:none;
            border-radius: 5px;
            width: 7vw;
            height: 2vw;
            font-size: 1em;
            transition: transform 1s ease;
        }
        .reglog button:hover{
            background-color: rgb(255, 255, 255);
            color: rgba(153, 112, 23, 0.75);
            border: 1px solid rgba(153, 112, 23, 0.75);
        }
    /**contents */
        .content{
            margin: 0vw 20vw 0vw 20vw;
            font-size: 1.2em;
        }
        .content hr{margin: 1.5vw 0vw 1.5vw 0vw;}
        .intro{text-align:center;}
        .cont{display:flex;}
        .contText{
            width: 50%;
            text-align:center;
        }
        .contTitle{
            text-align:center;
            margin-bottom: 1.5vw;
            font-size: 1.5em;
            color: rgba(153, 112, 23, 0.75);
        }
        .contImg{width: 50%;}
    /**carousel */
        .carousel-container {
            width: 50%;
            margin: auto;
            overflow: hidden;
            position: relative;
            border-radius: 15px;
            border: 1px solid grey;
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
            padding: 1vw;
            cursor: pointer;
            font-size: 1vw;
            opacity: 25%;
        }
        .prev { left: 1vw; }
        .next { right: 1vw; }
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
    <!--reglog--> 
        <div class="middle">
            <img class="logo move-up" src="images/kapeShop-logo.png">
            <p class="fontColor sp1 move-up">KAPE<span class="q">SHOP</span></p>
            <p class="fontColor sp2 move-up">Pour the PASSION, Taste the ART, A PERFECT START!</p>
            <div class="reglog move-up">
                <button class="fontColor" onclick="window.location.href='signinPage.php'">LOGIN</button>
                <button class="fontColor" onclick="window.location.href='signupPage.php'">REGISTER</button>
            </div>
        </div>
    <!--main-->
        <div class="content">
            <hr>
            <p class="contTitle move-up"><b>KAPE SHOP</b></p>
            <div class="intro move-up">
                <p>Your Ultimate Coffee Haven!</p><br>
                At Kape Shop, we believe that every cup tells a story. Whether you're craving a bold espresso,
                a refreshing frappé, or a delightful dessert to pair with your drink, we've got something special just for you.
                Our carefully crafted menu is designed to bring warmth and flavor to every sip and bite. From rich, aromatic
                coffee blends to indulgent sweet treats, we serve only the finest ingredients to elevate your café experience.</p>
            </div>
            <hr>
        <!--coffee hot-->
            <div class="cont">
                <div class="contText">
                    <p class="contTitle move-up"><b>HOT COFFEE</b></p> 
                    <p class="move-up">Nothing beats the comforting embrace of a hot coffee, brewed to perfection to awaken your senses. Whether you prefer a bold espresso, a smooth latte, or a rich cappuccino, each cup is crafted with high-quality beans to deliver deep flavors and a satisfying aroma.</p>
                </div>
                <div class="contImg move-up">
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
            </div>
            <hr>
        <!--coffee cold-->
            <div class="cont">
                <div class="contImg move-up">
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
                <div class="contText">
                    <p class="contTitle move-up"><b>ICED COFFEE</b></p> 
                    <p class="move-up">Beat the heat and energize your day with our cold coffee, a perfect blend of bold flavors and icy refreshment. Whether you love a creamy iced latte, or a strong cold brew, each sip delivers a smooth, invigorating taste that cools you down while keeping you energized.</p>
                </div>
            </div>
            <hr>
        <!--frappe-->
            <div class="cont">
                <div class="contText">
                    <p class="contTitle move-up"><b>FRAPPE</b></p> 
                    <p class="move-up">Cool, creamy, and irresistibly smooth—our frappé is the ultimate treat for coffee lovers who crave a refreshing twist. Blended with rich espresso, velvety milk, and just the right amount of sweetness, every sip is a delightful balance of bold flavor and icy indulgence.</p>
                </div>
                <div class="contImg move-up">
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
            </div>
            <hr>
        <!--dessert-->
            <div class="cont">
                <div class="contImg move-up">
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
                <div class="contText">
                    <p class="contTitle move-up"><b>DESSERT</b></p> 
                    <p class="move-up">Indulge in a world of sweetness with our delicious desserts, perfectly crafted to satisfy your cravings. From rich, sweet breads to yummy pastries and decadent chocolate treats, each bite is a delightful experience of flavor and texture.</p>
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