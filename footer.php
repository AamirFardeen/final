<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>EasyFitness</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- bootstrap cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">

   <!-- custom css file link  -->
   <style>

      
.footer {
    background: url(../images/footer-bg.jpg) no-repeat;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
  }
  
  .footer .box-container {
    display: -ms-grid;
    display: grid;
    -ms-grid-columns: (minmax(25rem, 1fr))[auto-fit];
        grid-template-columns: repeat(auto-fit, minmax(25rem, 1fr));
    gap: 2rem;
  }
  
  .footer .box-container .box h3 {
    font-size: 2rem;
    text-transform: capitalize;
    color: #fff;
    padding: 1rem 0;
  }
  
  .footer .box-container .box a {
    font-size: 1rem;
    line-height: 2;
    color: #ccc;
    padding: .5rem 0;
    display: block;
  }
  
  .footer .box-container .box a i {
    padding-right: .5rem;
    color: #ff5421;
  }
  
  .footer .box-container .box a:hover {
    color: #ff5421;
  }
  
  .footer .box-container .box p {
    font-size: 1.8rem;
    line-height: 2;
    color: #ccc;
  }
  
  .footer .box-container .box .email {
    width: 100%;
    padding: 1.2rem;
    font-size: 1.6rem;
    border: 0.1rem solid rgba(255, 255, 255, 0.2);
    margin: 1rem 0;
  }
  
  .footer .credit {
    text-align: center;
    font-size: 2rem;
    text-transform: capitalize;
    color: #fff;
    padding: 0 1rem;
    margin-top: 3rem;
    padding-top: 3rem;
    border-top: 0.1rem solid rgba(255, 255, 255, 0.2);
  }
  
  .footer .credit span {
    color: #ff5421;
  }
  


      </style>
</head>
<body>

<section class="footer">

   <div class="box-container container">

      <div class="box">
         <h3>quick links</h3>
         <a href="#home"> <i class="fas fa-angle-right"></i> home</a>
         <a href="#about"> <i class="fas fa-angle-right"></i> about</a>
         <a href="#courses"> <i class="fas fa-angle-right"></i> nutrition</a>
         <a href="#pricing"> <i class="fas fa-angle-right"></i> training</a>
         <a href="#team"> <i class="fas fa-angle-right"></i> tracker</a>
         <a href="#blogs"> <i class="fas fa-angle-right"></i> muslce</a>
      </div>

      <div class="box">
         <h3>contact info</h3>
         <a href="#"> <i class="fas fa-phone"></i> 07882079389 </a>
         <a href="#"> <i class="fas fa-envelope"></i> aamiraziz@gmail.com </a>
         <a href="#"> <i class="fas fa-map"></i> Nottingham, United Kingdom</a>
      </div>

      <div class="box">
         <h3>follow us</h3>
         <a href="#"> <i class="fab fa-facebook-f"></i> facebook </a>
         <a href="#"> <i class="fab fa-instagram"></i> instagram </a>
      </div>

   </div>

   <p class="credit"> Created by <span>Aamir Aziz</span> | Copyright:EasyFit </p>

</section>
</body>
</html>