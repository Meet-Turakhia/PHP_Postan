$(document).ready(function () {
  $(".login").hide();
  $(".register_li").addClass("active");

  $(".login_li").click(function () {
    $(this).addClass("active");
    $(".register_li").removeClass("active");
    $(".login").show();
    $(".register").hide();
  })

  $(".register_li").click(function () {
    $(this).addClass("active");
    $(".login_li").removeClass("active");
    $(".register").show();
    $(".login").hide();
  })
});
var state = false;
function toggle() {
  if (state) {
    document.getElementById('pwd').setAttribute("type", "password");
    document.getElementById("eye").style.color = '#000';
    state = false;

  }
  else {
    document.getElementById('pwd').setAttribute("type", "text");
    document.getElementById("eye").style.color = '#ffcc00';
    state = true;
  }
}
var state = false;
function toggle1() {
  if (state) {
    document.getElementById('pwd1').setAttribute("type", "password");
    document.getElementById("eye1").style.color = '#000';
    state = false;

  }
  else {
    document.getElementById('pwd1').setAttribute("type", "text");
    document.getElementById("eye1").style.color = '#ffcc00';
    state = true;
  }
}
var state = false;
function toggle3() {
  if (state) {
    document.getElementById('pwd2').setAttribute("type", "password");
    document.getElementById("eye3").style.color = '#000';
    state = false;

  }
  else {
    document.getElementById('pwd2').setAttribute("type", "text");
    document.getElementById("eye3").style.color = '#ffcc00';
    state = true;
  }
}
function adminkey() {
  var adminkey = prompt("Please Enter Key to Create Admin Account", "");
  if (adminkey == 'postanadmin') {
    alert("✔ Admin verification process is completed successfully!");
  }
  else {
    alert("🚫 Invalid Key! \n Can't create your Admin account.");
    document.getElementById('inlineRadio1').checked = false;
  }
}

