$(document).ready(function () {
    $("#image").on("change", function () {
        var extension = $("#image").val().split(".").pop().toLowerCase();
        if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
            alert("Invalid Image File");
            $("#image").val("");
        }
    });
});

$(document).ready(function () {
    var status = document.getElementById("status").value;
    if (status == "Dispatched" || status == "Delivered") {
        $("#title").prop("disabled", true);
        $("#description").prop("disabled", true);
        $("#address").prop("disabled", true);
        $("#image").prop("disabled", true);
        $("#delboy").prop("disabled", true);
    } else {
        $("#title").prop("disabled", false);
        $("#description").prop("disabled", false);
        $("#address").prop("disabled", false);
        $("#image").prop("disabled", false);
        $("#delboy").prop("disabled", false);
    }
});

$(document).ready(function () {
    $("#status").on("change", function () {
        var status = document.getElementById("status").value;
        if (status != "Processing") {
            $("#title").prop("disabled", true);
            $("#description").prop("disabled", true);
            $("#address").prop("disabled", true);
            $("#image").prop("disabled", true);
            $("#delboy").prop("disabled", true);
        } else {
            $("#title").prop("disabled", false);
            $("#description").prop("disabled", false);
            $("#address").prop("disabled", false);
            $("#image").prop("disabled", false);
            $("#delboy").prop("disabled", false);
        }
    });
});

$(document).ready(function () {
    $("#status").on("change", function () {
        var status = this.value;

        if (status != "Delivered") {
            $("#delimage").prop("required", false);
            $("#delimage").prop("hidden", true);
            $("#delimage").prop("disabled", true);
            $("#delimage_label").prop("hidden", true);
            $("#cost").prop("required", false);
            $("#cost").prop("hidden", true);
            $("#cost").prop("disabled", true);
            $("#cost_label").prop("hidden", true);
        } else {
            $("#delimage").prop("required", true);
            $("#delimage").prop("hidden", false);
            $("#delimage").prop("disabled", false);
            $("#delimage_label").prop("hidden", false);
            $("#cost").prop("required", true);
            $("#cost").prop("hidden", false);
            $("#cost").prop("disabled", false);
            $("#cost_label").prop("hidden", false);
        }

    });
});

$(document).ready(function () {
    $("#status").on("change", function () {
        var status = this.value;
        var delboy = document.getElementById("delboy").value;
        if (status != "Processing") {
            if (delboy == "NULL") {
                alert("Please select a delivery boy, before going to dispatched or delivered status!");
                $("#updatebtn").prop("disabled", true);
            }
        } else {
            $("#updatebtn").prop("disabled", false);
        }
    });
});

$(document).ready(function () {
    $("#delboy").on("change", function () {
        var delboy = this.value;
        var status = document.getElementById("status").value;
        if (status != "Processing") {
            if (delboy != "NULL") {
                $("#updatebtn").prop("disabled", false);
            } else {
                alert("Please select a delivery boy, before going to dispatched or delivered status!");
                $("#updatebtn").prop("disabled", true);
            }
        }
    });
});

$(document).ready(function () {
    $("#delimage").on("change", function () {
        var extension = $("#delimage").val().split(".").pop().toLowerCase();
        if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
            alert("Invalid Image File");
            $("#delimage").val("");
        }
    });
});

$(document).ready(function () {
    $("#updatebtn").on("click", function () {
        $("#title").prop("disabled", false);
        $("#description").prop("disabled", false);
        $("#address").prop("disabled", false);
        $("#image").prop("disabled", false);
        $("#delboy").prop("disabled", false);
    });
});