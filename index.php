<?php
session_start(); // Start the session

if (isset($_SESSION['user_email'])) {
    echo "Welcome, " . $_SESSION['user_name'] . "!"; // Access user name
} else {
    echo "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jama Lagbe</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="container">

         <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="#">
            <img src="logo3.png" alt="">
          </a>
             <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                 <span class="navbar-toggler-icon"></span>
             </button>
             <div class="collapse navbar-collapse" id="navbarNav">
                 <ul class="navbar-nav">
                     <li class="nav-item active">
                     <a class="nav-link" href="buy.php">Buy <span class="sr-only">(current)</span></a>
                     </li>
                     <li class="nav-item">
                     <a class="nav-link" href="#">Borrow</a>
                     </li>
                     <li class="nav-item">
                     
                     <a class="nav-link" href="Donation.php">Donation <span class="sr-only">(current)</span></a>
                     </li>
                     <li class="nav-item">
    <a class="nav-link" href="add_product.php">Add Product</a>
</li>

               </ul>
             </div>
         </nav>
      
    
    </div> 
    <div class="container">
         <div id="carouselExampleControls" class="carousel slide orange-bg" data-ride="carousel">
             <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="row d-flex align-items-center"> 
                    <div class="col-md-7">
                        <h1>Floral Shirt For Men </h1>
                        <p>Floral shirts are stylish and versatile for men. They add personality and can be dressed up or down.</p>
                         <h1 class="price">1500tk</h1> <button class="buy-now-button">Buy now</button>
                        

                    </div>
                    <div class="col-medium-5">
                        <img src="jama/images/r.shirt.png" class="d-block w-100" alt="...">
                    </div>
                </div>


      
    </div>
    <div class="carousel-item">
    <div class="row d-flex align-items-center">
                        <div class="col-md-7"> 
                             <h1>Hoodies</h1>
                             <p>A hoody is a comfortable, hooded sweatshirt perfect for casual wear, offering warmth and easy style.</p>
                             <h1 class="price">3000tk</h1>
                             <button class="buy-now-button">Buy now</button>
                        </div>
                        
                        <div class="col-medium-5">
                        <img src="jama/images/r.jumper.jpg" class="d-block w-100" alt="...">
                        </div>
                    </div>
      
    </div>
    <div class="carousel-item">
         <div class="row d-flex align-items-center">
                        <div class="col-md-7">
                             <h1>OverCoat For Women</h1>
                              <p>An overcoat for women is a long, warm coat designed for cold weather, adding both elegance and protection from the elements.</p>
                             <h1 class="price">3000tk</h1>
                              <button class="buy-now-button">Buy now</button>

                        </div>
                        <div class="col-medium-5">
                             <img src="jama/images/r.scart.jpg" class="d-block w-100" alt="...">
                        </div>
         </div>
      
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
</div>

<div class="container categories">
    
    <div class="row">
    
        <div class="col-md-4">
            <div class="d-flex justify-content-between align-items-center cat1">
            <H1 >Buy</H1>
            <img src="jama/images/buy.png" alt="">   

            </div>
                     
        </div>
    
    
        <div class="col-md-4 ">
            <div class="d-flex justify-content-between align-items-center cat2">
            <H1>Borrow</H1>
            <img src="jama/images/borrow.png" alt="">

            </div>
             
        </div>
      
    
        <div class="col-md-4">
            <div class="d-flex justify-content-between align-items-center cat3">
            <H1>Donate</H1>
            <img src="jama/images/donate.png" alt="">

            </div>
             
        </div>
      
    </div>
    
</div>
<div class="container buy" id="buy">
    <h3>Buy</h3>
    <div class="card-deck">
        <div class="card">
    <img src="jama/images/buy10.jpg" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Gingham Check Shirt</h5>
      <p class="card-text">Fabric: Cotton
      Lightweight and breathable, cotton is perfect for gingham shirts, offering comfort and a crisp look suitable for casual or semi-formal wear.</p>
      <p class="card-text"><small class="text-muted"></small></p>
      <h5>1600tk</h5>
      <button class="buy-now-button">Buy now >></button>
    </div>
        </div>
  <div class="card">
    <img src="jama/images/buy2.jpg" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Tartan Plaid Shirt</h5>
      <p class="card-text">Fabric: Flannel
      Tartan plaid shirts made from flannel provide warmth and softness, making them ideal for colder weather and more relaxed, rugged styles.</p>
      <p class="card-text"><small class="text-muted"></small></p>
      <h5>1599tk</h5>
      <button class="buy-now-button">Buy now >></button>
    </div>
  </div>
  <div class="card">
    <img src="jama/images/buy3.jpg" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Windowpane Check Shirt</h5>
      <p class="card-text">Fabric: Linen
      Linen fabric is breathable and lightweight, giving windowpane check shirts a sophisticated, breezy feel, perfect for warmer climates and formal settings.</p>
      <p class="card-text"><small class="text-muted"></small></p>
      <h5>1500tk</h5>
      <button class="buy-now-button">Buy now >></button>
    </div>
  </div>
</div>
</div>
<div class="container" id="borrow">
    <h3>Borrow</h3>
    <div class="card-deck">
  <div class="card">
    <img src="jama/images/borrow99.png" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Red Panjabi</h5>
      <p class="card-text">A cotton fabric Panjabi is a lightweight, breathable traditional attire for men, featuring a knee-length tunic and loose trousers. It combines comfort and style, making it perfect for casual and festive occasions.</p>
      <h5>200Tk for a day </h5>
      
    </div>
    <div class="card-footer">
        <button class="buy-now-button">Borrow now >></button>
    </div>
  </div>
  <div class="card">
    <img src="jama/images/borrow2.png" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Lehenga</h5>
      <p class="card-text">A lehenga is a traditional Indian garment consisting of a long skirt paired with a blouse (choli) and a dupatta (scarf). Often richly embroidered and adorned with vibrant colors, lehengas are popular for weddings and festive celebrations.</p>
      <h5>1000Tk for a day </h5>
     
      
    </div>
    <div class="card-footer">
         <button class="buy-now-button">Borrow now >></button>
    </div>
  </div>
  <div class="card">
    <img src="jama/images/borrow3.png" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Navy Blue Suit</h5>
      <p class="card-text">A suit typically consists of a tailored jacket and trousers, often made from matching fabric, and is worn for formal occasions or professional settings. Suits come in various styles, colors, and patterns, allowing for both classic and modern looks.</p>
      <h5>700Tk for a day </h5>
      
    </div>
    <div class="card-footer">
         <button class="buy-now-button">Borrow now >></button>
    </div>
  </div>
</div>


</div>
<div class="container d-flex align-items-center orange-bg" id="donate">
    <div>
    <H3>"Let’s help the unprivileged people."</H3>
    <h6>Together, we can create opportunities and empower lives for a brighter future.</h6>
    <form action="Add_donation.php">
    <button type="submit" class="buy-now-button">Donate Now >></button>
</form>
    </div>

</div>

<footer>
    <small>© 2024 Jama Lagbe Co. All Rights Reserved. Dhaka, Bangladesh </small>
</footer>

        
        
    
    



    



























<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
</body>
</html>