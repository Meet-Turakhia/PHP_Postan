// $(document).ready(function () {
//     $(pic).hover(function () {
//         $(edit).css("display", "none");
//     }, function () {
//         $(edit).css("display", "block");
//     });
// });

function openForm() {
    document.getElementById("courier_settings").style.display = "block";
    // When the user clicks anywhere outside of the modal, close it
    var modal = document.getElementById("courier_settings");
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}