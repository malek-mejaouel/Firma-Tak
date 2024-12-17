<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Agropro</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
   </head>
   <!-- body -->
   <body class="main-layout inner_page about_page">
      <!-- loader  -->
      <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="#"/></div>
      </div>
      <!-- end loader -->
      <div class="full_bg">
         <!-- header -->
         <header class="header-area">
            <div class="container-fluid">
               <div class="row d_flex">
                  <div class=" col-md-2 col-sm-3">
                     <div class="logo">
                        <a href="index.html">Firma<span>Tak</span></a>
                     </div>
                  </div>
                  <div class="col-md-8 col-sm-9">
                     <div class="navbar-area">
                        <nav class="site-navbar">
                           <ul>
                           <li><a  href="index.php">Home</a></li>
                              <li><a href="about.php">feedback</a></li>
                              <li><a href="chat.php">Chatbot</a></li>
                               <li><a href="listEvents.php">Projects</a></li>
                               <li><a  href="template/news/map.html">Map</a></li>
                               
                                <li><a href="rating.php">rating</a></li>
                                <li><a href="showcaseLands.php">land</a></li>

                              <li><a href="prodi.php">product</a></li>
                              <li><a href="contact.php">Contact</a></li>
                           </ul>
                           <button class="nav-toggler">
                           <span></span>
                           </button>
                        </nav>
                     </div>
                  </div>
                  <div class="col-md-2 padd_0 d_none">
                     <ul class="email text_align_right">
                        <li><a href="Javascript:void(0)">Login</a>
                        </li>
                        <li><a href="Javascript:void(0)"><i class="fa fa-search" aria-hidden="true"></i>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </header>
         <!-- end header inner -->
      </div>
      <!-- end banner -->
     
       <!-- Chatbot Section -->
      <div id="chatbot-container" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 350px; border: 1px solid #ccc; border-radius: 5px; background-color: #b0b68a; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
         <div id="chatbot-header" style="background-color: #6f7b20; color: #fff; padding: 10px; text-align: center; border-top-left-radius: 5px; border-top-right-radius: 5px;">
            Chatbot
         </div>
         <div id="chatbot-body" style="padding: 10px; height: 400px; overflow-y: auto; background-color: #b0b68a;">
            <div id="chatbot-messages"></div>
         </div>
         <div id="chatbot-footer" style="padding: 10px; border-top: 1px solid #ccc; background-color: #b0b68a;">
            <input type="text" id="chatbot-input" placeholder="Type a message..." style="width: 80%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <button onclick="sendMessage()" style="padding: 10px; border: none; background-color: #6f7b20; color: #fff; border-radius: 5px;">Send</button>
         </div>
      </div>

      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/owl.carousel.min.js"></script>
      <script src="js/bootstrap-datepicker.min.js"></script>
      <script src="js/custom.js"></script>

      <!-- Chatbot Script -->
      <script>
         function sendMessage() {
            var userInput = document.getElementById('chatbot-input').value;
            if (userInput.trim() === '') return;

            var messagesContainer = document.getElementById('chatbot-messages');
            var userMessage = document.createElement('div');
            userMessage.style.textAlign = 'right';
            userMessage.style.marginBottom = '10px';
            userMessage.innerHTML = '<strong>You:</strong> ' + userInput;
            messagesContainer.appendChild(userMessage);

            document.getElementById('chatbot-input').value = '';

            // Simulate bot response
            setTimeout(function() {
                var botMessage = document.createElement('div');
                botMessage.style.textAlign = 'left';
                botMessage.style.marginBottom = '20px';
                botMessage.innerHTML = '<strong style="font-size: 1.7em;">👩‍🌾</strong> : ' + getBotResponse(userInput);
                messagesContainer.appendChild(botMessage);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }, 1000);
         }

         function getBotResponse(userInput) {
            var responses = {
               'hello': 'Hi there! How can I help you?',
               'how are you': 'I am just a bot, but thank you for asking!',
               'what is your name': 'I am the Agropro Chatbot.',
               'most famous animals in kebili': 'Kebili is known for its camels and sheep.',
               'most famous animals in mahdia': 'Mahdia is known for its marine life, including various fish species.',
               'most famous animals in tunis': 'Tunis is known for its diverse wildlife, including birds and small mammals.',
               'most famous animals in sfax': 'Sfax is known for its livestock, including cattle and goats.',
               'most famous animals in sousse': 'Sousse is known for its marine life and various bird species.',
               'most famous animals in gabes': 'Gabes is known for its camels and livestock.',
               'most famous animals in kairouan': 'Kairouan is known for its livestock, including sheep and cattle.',
               'most famous animals in monastir': 'Monastir is known for its marine life and various bird species.',
               'most famous animals in gafsa': 'Gafsa is known for its livestock, including sheep and goats.',
               'most famous animals in jendouba': 'Jendouba is known for its livestock, including cattle and sheep.',
               'most famous animals in medenine': 'Medenine is known for its camels and livestock.',
               'most famous animals in nabeul': 'Nabeul is known for its marine life and various bird species.',
               'most famous animals in tataouine': 'Tataouine is known for its camels and livestock.',
               'most famous animals in tozeur': 'Tozeur is known for its camels and livestock.',
               'most famous animals in zaghouan': 'Zaghouan is known for its livestock, including sheep and goats.',
               'most famous animals in ariana': 'Ariana is known for its diverse wildlife, including birds and small mammals.',
               'most famous animals in ben arous': 'Ben Arous is known for its livestock, including cattle and goats.',
               'most famous animals in manouba': 'Manouba is known for its livestock, including sheep and cattle.',
               'most famous food in mahdia': 'Mahdia is famous for its seafood, especially grilled fish and couscous.',
               'most famous food in tunis': 'Tunis is famous for its traditional dishes like couscous, tajine, and brik.',
               'most famous food in sfax': 'Sfax is known for its seafood dishes, especially squid and octopus.',
               'most famous food in gabes': 'Gabes is known for its seafood dishes and couscous.',
               'most famous food in kairouan': 'Kairouan is famous for its traditional dishes like couscous and tajine.',
               'most famous food in monastir': 'Monastir is known for its seafood dishes, especially grilled fish.',
               'most famous food in gafsa': 'Gafsa is known for its couscous dishes and stews.',
               'most famous food in jendouba': 'Jendouba is famous for its traditional Tunisian dishes, including couscous and tajine.',
               'most famous food in medenine': 'Medenine is known for its couscous dishes and seafood.',
               'most famous food in nabeul': 'Nabeul is famous for its seafood dishes and couscous.',
               'most famous food in tataouine': 'Tataouine is known for its traditional Tunisian dishes, including couscous and tagine.',
               'most famous food in tozeur': 'Tozeur is known for its couscous dishes and stews.',
               'most famous food in zaghouan': 'Zaghouan is famous for its couscous and traditional stews.',
               'most famous food in ariana': 'Ariana is known for its couscous and traditional stews.',
               'most famous food in ben arous': 'Ben Arous is known for its seafood dishes and couscous.',
               'most famous food in manouba': 'Manouba is known for its couscous and stews.'
            };

            return responses[userInput.toLowerCase()] || "Sorry, I don't understand that.";
         }
      </script>
   </body>
</html>
