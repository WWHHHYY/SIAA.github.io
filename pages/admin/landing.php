<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="../../css/style.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <title>CM Narido Frozen Trading</title>
  </head>
  <body>
    <header>
      <div class="container">
        <div class="navbar">
          <div class="logo">
            <a style=display:block href="../../pages/admin/landing.php">
			<label>
			<img id=logo src="../../images/lg.png">
			</label></a>
          </div>
          <nav>
            <div class="btn">
              <i class="fa fa-times close-btn"></i>
            </div>
            <li><a href="../../pages/admin/landing.php">Home</a></li>
            <li><a href="../../pages/admin/about.php">About</a></li>
            <li><a href="../../pages/admin/hdpurefoods.php">Products</a></li>
            <li><a href="../../pages/admin/login.php">Log-in</a></li>
          </nav>
          <div class="btn">
            <i class="fa fa-bars menu-btn"></i>
          </div>
        </div>
      </div>
	</header>
	<style>
body {
	font-family: Arial;
	margin: 0;
}

* {
  box-sizing: border-box;
}

img {
  vertical-align: middle;
}

/* Position the image container (needed to position the left and right arrows) */
.container {
  position: relative;
}

/* Hide the images by default */
.mySlides {
  display: none;
}

/* Add a pointer when hovering over the thumbnail images */
.cursor {
  cursor: pointer;
}

/* Next & previous buttons */
.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 40%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: green;
  font-weight: bold;
  font-size: 20px;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: rgba(0, 0, 0, 0.8);
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* Container for image text */
.caption-container {
  text-align: center;
  background-color: #222;
  padding: 5px 20px;
  color: white;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Six columns side by side */
.column {
  float: left;
  width: 16.66%;
}

/* Add a transparency effect for thumnbail images */
.demo {
  opacity: 0.6;
}

.active,
.demo:hover {
  opacity: 1;
}
</style>
	<!-- Container for the image gallery -->
<div class="container">

  <!-- Full-width images with number text -->
  <div class="mySlides">
    <div class="numbertext">2 / 8</div>
      <img src="../../images/1.png" style="width:100%">
  </div>

  <div class="mySlides">
    <div class="numbertext">3 / 8</div>
      <img src="../../images/2.png" style="width:100%">
  </div>

  <div class="mySlides">
    <div class="numbertext">4 / 8</div>
      <img src="../../images/3.png" style="width:100%">
  </div>

  <div class="mySlides">
    <div class="numbertext">5 / 8</div>
      <img src="../../images/4.png" style="width:100%">
  </div>

  <div class="mySlides">
    <div class="numbertext">6 / 8</div>
      <img src="../../images/5.png" style="width:100%">
  </div>
  
   <div class="mySlides">
    <div class="numbertext">7 / 8</div>
      <img src="../../images/6.png" style="width:100%">
  </div>

  <!-- Next and previous buttons -->
  <a class="prev" onclick="plusSlides(1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>

  <!-- Image text -->
  <div class="caption-container">
    <p id="caption"></p>
  </div>

  <!-- Thumbnail images -->
  <div class="row">
    <div class="column">
      <img class="demo cursor" src="../../images/1.png" style="width:100%" onclick="currentSlide(1)" alt="TJ HOTDOGS">
    </div>
    <div class="column">
      <img class="demo cursor" src="../../images/2.png" style="width:100%" onclick="currentSlide(2)" alt="CDO HOTDOGS">
    </div>
    <div class="column">
      <img class="demo cursor" src="../../images/3.png" style="width:100%" onclick="currentSlide(3)" alt="CDO HAMON">
    </div>
    <div class="column">
      <img class="demo cursor" src="../../images/4.png" style="width:100%" onclick="currentSlide(4)" alt="CDO SLICED HAM">
    </div>
    <div class="column">
      <img class="demo cursor" src="../../images/5.png" style="width:100%" onclick="currentSlide(5)" alt="PAMPANGA'S BEST TOCINO">
    </div>
	<div class="column">
      <img class="demo cursor" src="../../images/6.png" style="width:100%" onclick="currentSlide(6)" alt="PAMPANGA'S BEST LONGANIZA">
    </div>
  </div>
</div>

<script>
let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("demo");
  let captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}
</script>
  
  <footer>
    <p>&copy; CM Narido Frozen Trading</p>
  </footer>
</html>