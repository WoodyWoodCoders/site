function checkIfNoError(response, callback) {
    if(typeof response === "object") {
        if(response.success === true) {
            return true;
        } else if(response.success === false) {
            if (typeof callback === "function") {
                callback(response);
            } else {
                closeModal();
                // showAlert("#page-body", "alert-danger display-none" , response.error);
            }
            return false;
        }
    }  else {
        closeModal();
        // showAlert("#page-body", "alert-danger display-none" , "Le serveur n'est pas joignable");

        return false;
    }
}

function setContentModal(html) {
    $("#modal-body").html(html);
}

function openModal() {
    $("#modal").modal("show");
}

function closeModal() {
    if($('#modal').css('display') !== "none"){
        $("#modal").modal("toggle");
    }
}

$(function() {

});
