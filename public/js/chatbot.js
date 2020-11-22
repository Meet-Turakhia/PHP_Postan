function openForm() {
    document.getElementById("chatbot").style.display = "block";
    document.botform.mytext.focus();
    // When the user clicks anywhere outside of the modal, close it
    var modal = document.getElementById("chatbot");
    window.onclick = function (event) {
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
    } else if (a.indexOf("price") != -1 || a.indexOf("Price") != -1 || a.indexOf("cost") != -1 || a.indexOf("Cost") != -1 || a.indexOf("amount") != -1 || a.indexOf("Amount") != -1 || a.indexOf("rupee") != -1 || a.indexOf("Rupee") != -1 || a.indexOf("fee") != -1 || a.indexOf("Fee") != -1) {
        document.getElementById("bot").innerHTML += "<div class='dropdown-divider'></div>How we calculate,<br>Per km = ₹18 +<br>Per kg = ₹5 × km +<br>5% GST.";
    } else if (a.indexOf("proc") != -1 || a.indexOf("Proc") != -1 || a.indexOf("step") != -1 || a.indexOf("Step") != -1 || a.indexOf("desc") != -1 || a.indexOf("Desc") != -1 || a.indexOf("order") != -1 && a.indexOf("detail") != -1) {
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