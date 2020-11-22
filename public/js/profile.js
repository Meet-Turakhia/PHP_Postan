$(document).ready(function () {
    $("#dp").on("change", function () {
        var image_name = $("#dp").val();
        if (image_name == "") {
            alert("Please Select Image");
            return false;
        }
        else {
            var extension = $("#dp").val().split(".").pop().toLowerCase();
            if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                alert("Invalid Image File");
                $("#dp").val("");
            }
        }
    });
});

$(document).ready(function () {
    $(pic).hover(function () {
        $(edit).css("display", "none");
    }, function () {
        $(edit).css("display", "block");
    });
});


function openForm1() {
    document.getElementById("updatedp").style.display = "block";
    // When the user clicks anywhere outside of the modal, close it
    var modal = document.getElementById("updatedp");
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

function closeForm1() {
    document.getElementById("updatedp").style.display = "none";
}

function openForm2() {
    document.getElementById("updateinfo").style.display = "block";
    // When the user clicks anywhere outside of the modal, close it
    var modal2 = document.getElementById("updateinfo");
    window.onclick = function (event) {
        if (event.target == modal2) {
            modal2.style.display = "none";
        }
    }
}

function closeForm2() {
    document.getElementById("updateinfo").style.display = "none";
}