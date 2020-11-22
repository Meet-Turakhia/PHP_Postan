function openFeedback() {
    document.getElementById("feedback_form").style.display = "block";
    // When the user clicks anywhere outside of the modal, close it
    var modal = document.getElementById("feedback_form");
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

function closeFeedback() {
    document.getElementById("feedback_form").style.display = "none";
}
