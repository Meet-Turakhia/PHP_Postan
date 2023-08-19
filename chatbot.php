<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="data/css/style.css">
  <link rel="icon" href="data/img/minilogo.png" type="image/x-icon">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/22d43b373b.js" crossorigin="anonymous"></script>
  <style>
    * {
      box-sizing: border-box;
    }

    #cb {
      color: #ffcc00;
      font-size: 40px;
    }

    #cb:hover {
      color: #ffd632;
      font-size: 50px;
      transition: 0.3s;
    }

    /* The popup form - hidden by default */
    .form-popup-chatbot {
      display: none;
      overflow-x: hidden;
      position: fixed;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      z-index: 10;
      background-color: rgba(255, 204, 0, 0.5);
      backdrop-filter: blur(6px);
      transition: 0.3s;
    }

    /* Add styles to the form container */
    .form-container-chatbot {
      box-shadow: 0px 10px 18px 0px rgba(0, 0, 0, 1);
      width: 300px;
      margin: 25% 2% 2% auto;
      -ms-overflow-style: none;
      scrollbar-width: none;
      padding: 15px;
      color: #ffcc00;
      background-color: black;
      border-radius: 10px;
    }

    .botmsg {
      margin: 10px;
      width: 250px;
      text-align: left;
      display: inline-block;
      background-color: #ffcc00;
      border-radius: 10px;
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    #bot {
      margin: 5px;
      text-align: justify;
      word-wrap: break-word;
      font-weight: bold;
      overflow: auto;
    }

    input[type="checkbox"] {
      visibility: hidden;
    }

    .animate {
      -webkit-animation: animate 0.3s;
      animation: animate 0.3s
    }

    @-webkit-keyframes animate {
      from {
        -webkit-transform: translate(1em, 0em)
      }

      to {
        -webkit-transform: translate(0em, 0em)
      }
    }

    @keyframes animate {
      from {
        transform: translate(3em, 0em)
      }

      to {
        transform: translate(0em, 0em)
      }
    }

    .animate2 {
      -webkit-animation: animate2 1s;
      animation: animate2 1s
    }

    @-webkit-keyframes animate2 {
      from {
        -webkit-transform: translate(1em, 0em)
      }

      to {
        -webkit-transform: translate(0em, 0em)
      }
    }

    @keyframes animate2 {
      from {
        transform: translate(3em, 0em)
      }

      to {
        transform: translate(0em, 0em)
      }
    }

    .animate3 {
      -webkit-animation: animate3 2s;
      animation: animate3 2s
    }

    @-webkit-keyframes animate3 {
      from {
        -webkit-transform: translate(0em, 1em)
      }

      to {
        -webkit-transform: translate(0em, 0em)
      }
    }

    @keyframes animate3 {
      from {
        transform: translate(0em, 3em)
      }

      to {
        transform: translate(0em, 0em)
      }
    }
  </style>
</head>

<body>
  <div>
    <a href="#" onclick="openForm()" style="box-shadow: 0px 8px 16px 0px rgba(0,0,0,1); overflow: hidden; position:fixed; bottom: 20px; right: 20px; background-color: black; border-radius: 10px;" class="animate3" id="cb"><i class='fas fa-user-astronaut p-2 animate3' id="cb"></i></a>
    <div class="form-group form-popup-chatbot" id="chatbot">
      <form name="botform" method="post" class="form-container-chatbot animate">
        <center><label for="exampleFormControlFile1">
            <h5 style='font-size:24px; color: #ffcc00;'><i class='fas fa-user-astronaut' style='font-size:25px; color: #ffcc00;'></i> STANBOT</h5><small id="emailHelp" class="form-text text-muted">Encryption by Team Postan</small>
            <div class='dropdown-divider'></div>
            <h6 style="color: white;">Hello, how can i help you ?</h6>
          </label></center>
        <div class="botmsg animate2">
          <p style="color:black;" id="bot"></p>
        </div>
        <input class="form-control mb-2" type="text" name="mytext" id="u_msg" placeholder="Type a message" onfocus="this.value=''" autocomplete="off" required>
        <div class="form-inline">
          <button class="btn btn-success mx-2" id="send" onclick="window.onclick(reply())" onclick="document.botform.mytext.focus();">Send</button></br>
          <input type="button" class="btn btn-sm btn-danger mb-2" value="Cancel" onclick="closeForm()">
          <input type="checkbox" oninvalid="this.setCustomValidity('IGNORE THIS')" required>
        </div>
      </form>
    </div>
  </div>


  <script>
    function openForm() {
      document.getElementById("chatbot").style.display = "block";
      document.botform.mytext.focus();
      // When the user clicks anywhere outside of the modal, close it
      var modal = document.getElementById("chatbot");
      window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      }
    }

    function closeForm() {
      document.getElementById("chatbot").style.display = "none";
    }

    function reply() {
      document.getElementById("chatbot").style.display = "block";
      a = document.getElementById("u_msg").value
      if (a.indexOf("home") != -1 || a.indexOf("Home") != -1 || a.indexOf("postan") != -1 || a.indexOf("Postan") != -1 || a.indexOf("index") != -1 || a.indexOf("Index") != -1) {
        var str = "Postan";
        document.getElementById("bot").innerHTML += "<div class='dropdown-divider'></div>Here You Go > " + str.link("index.php");
      } else if (a.indexOf("dashboard") != -1 || a.indexOf("Dashboard") != -1 || a.indexOf("db") != -1 || a.indexOf("Db") != -1) {
        var str = "Dashboard";
        document.getElementById("bot").innerHTML += "<div class='dropdown-divider'></div>Here You Go > " + str.link("dashboard.php");
      } else if (a.indexOf("courier") != -1 || a.indexOf("Courier") != -1 || a.indexOf("post") != -1 || a.indexOf("Post") != -1 || a.indexOf("deliver") != -1 || a.indexOf("Deliver") != -1) {
        var str = "Courier";
        document.getElementById("bot").innerHTML += "<div class='dropdown-divider'></div>Here You Go > " + str.link("courier.php");
      } else if (a.indexOf("profile") != -1 || a.indexOf("Profile") != -1 || a.indexOf("acc") != -1 || a.indexOf("Acc") != -1) {
        var str = "Profile";
        document.getElementById("bot").innerHTML += "<div class='dropdown-divider'></div>Check Out Here > " + str.link("profile.php");
      } else if (a.indexOf("price") != -1 || a.indexOf("Price") != -1 || a.indexOf("cost") != -1 || a.indexOf("Cost") != -1 || a.indexOf("amount") != -1 || a.indexOf("Amount") != -1 || a.indexOf("rupee") != -1 || a.indexOf("Rupee") != -1) {
        document.getElementById("bot").innerHTML += "<div class='dropdown-divider'></div>How we calculate,<br>Per km = ₹18 +<br>Per kg = ₹5 × km +<br>5% GST.";
      } else if (a.indexOf("proc") != -1 || a.indexOf("Proc") != -1 || a.indexOf("desc") != -1 || a.indexOf("Desc") != -1 || a.indexOf("order") != -1 && a.indexOf("detail") != -1) {
        var str = "Place Courier";
        document.getElementById("bot").innerHTML += "<div class='dropdown-divider'></div>Our Procedure,<br>•" + str.link("courier.php") + "<br>•Confirmation<br>•Pick Up<br>•Delivery & Receipt";
      } else if (a.indexOf("service") != -1 || a.indexOf("Service") != -1 || a.indexOf("system") != -1 || a.indexOf("System") != -1 || a.indexOf("feature") != -1 && a.indexOf("Feature") != -1) {
        document.getElementById("bot").innerHTML += "<div class='dropdown-divider'></div>Services provided by Postan,<br>•Fast<br>•Reliable<br>•Secure";
      } else if (a.indexOf("hist") != -1 || a.indexOf("Hist") != -1 || a.indexOf("record") != -1 || a.indexOf("Record") != -1 || a.indexOf("order") != -1 || a.indexOf("Order") != -1) {
        var str = "History";
        document.getElementById("bot").innerHTML += "<div class='dropdown-divider'></div>Check Out Here > " + str.link("history.php");
      } else if (a.indexOf("about") != -1 || a.indexOf("About") != -1 || a.indexOf("contact") != -1 || a.indexOf("Contact") != -1) {
        var str = "About Us";
        document.getElementById("bot").innerHTML += "<div class='dropdown-divider'></div>Here You Go > " + str.link("aboutus.php");
      } else if (a.indexOf("Comp") != -1 || a.indexOf("comp") != -1 || a.indexOf("past") != -1 || a.indexOf("Past") != -1 || a.indexOf("story") != -1 || a.indexOf("Story") != -1) {
        var str = "Postan";
        document.getElementById("bot").innerHTML += "<div class='dropdown-divider'></div>Postan is a courier management service used by multiple courier companies, we provide secure and reliable online services, so that company can operate smoothly. Simply place your courier by filling out a form, after which our admins will reach you through phone, once the confirmation is done, your courier will be assigned to a delivery boy. You can check the status of your courier in your dashboard. Haven't tried yet?<br>So what are you wating for!<br>Let's " + str.link("index.php");
      } else if (a.indexOf("log") != -1 || a.indexOf("Log") != -1 || a.indexOf("Sign") != -1 || a.indexOf("sign") != -1 || a.indexOf("regi") != -1 || a.indexOf("Regi") != -1) {
        var str = "SignUp/Login ";
        document.getElementById("bot").innerHTML += "<div class='dropdown-divider'></div>Here You Go > " + str.link("login.php");
      } else if (a.indexOf("hi") != -1 || a.indexOf("hello") != -1 || a.indexOf("hey") != -1 || a.indexOf("Hi") != -1 || a.indexOf("Hello") != -1 || a.indexOf("Hey") != -1 || a.indexOf("help") != -1 || a.indexOf("Help") != -1) {
        document.getElementById("bot").innerHTML += "<div class='dropdown-divider'></div>Hey, what's up!<br>how can i help you 🙂";
      } else if (a.indexOf("team") != -1 || a.indexOf("Team") != -1 || a.indexOf("info") != -1 || a.indexOf("Info") != -1 || a.indexOf("born") != -1 || a.indexOf("create") != -1 || a.indexOf("you") != -1 || a.indexOf("name") != -1 || a.indexOf("founder") != -1 || a.indexOf("develop") != -1 || a.indexOf("maker") != -1) {
        var str = "Team Postan";
        document.getElementById("bot").innerHTML += "<div class='dropdown-divider'></div>I am <i class='fas fa-user-astronaut'></i> STANBOT<br> Created By Team Postan <br> Founders : Parth and Meet<br> For More Info > " + str.link("aboutus.php") + "<br><br>How can i help you ?";
      } else if (a.indexOf("joke") != -1 || a.indexOf("Joke") != -1 || a.indexOf("fun") != -1 || a.indexOf("Fun") != -1) {
        document.getElementById("bot").innerHTML += "<div class='dropdown-divider'></div>Let's have some fun! <br>Here you go... <br><br>I just read a list of '100 Things To Do Before You Die'...<br><br>I was quite surprised that 'Yell for help' wasn't one of them.<br>😂";
      } else if (a == "") {
        document.getElementById("bot").innerHTML += "<div class='dropdown-divider'></div>Type Something 😑";
      } else if (a.indexOf("joke") != -1 || a.indexOf("Joke") != -1 || a.indexOf("fun") != -1 || a.indexOf("Fun") != -1) {
        document.getElementById("bot").innerHTML += "<div class='dropdown-divider'></div>Let's have some fun! <br>Here you go... <br><br>I just read a list of '100 Things To Do Before You Die'...<br><br>I was quite surprised that 'Yell for help' wasn't one of them.<br>😂";
      } else {
        document.getElementById("bot").innerHTML += "<div class='dropdown-divider'></div>😵 Sorry, didn't get that. <br> Can you rephrase?";
      }
    }
  </script>

</body>

</html>