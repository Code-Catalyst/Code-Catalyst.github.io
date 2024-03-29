function emptiness() {
    

}

const buttons = document.querySelectorAll('.archive_btn');
buttons.forEach((button) => {
  button.addEventListener("click", (e) => {
    var parentElement = button.parentElement;
    var id = parentElement.id;
    var competitionName = id;


    //New popups
    var gotoarchiveBtn = document.getElementById('gotoarchiveBtn');
    var confirmBtn = document.getElementById('confirmBtn');
    // Confirm
    popupMarkAsDone = document.getElementById('markAsDoneWrapper');
  
    var showMarkAsDone = function() {
        popupMarkAsDone.style.display ='flex';
    }
    var hideMarkAsDone = function() {
        popupMarkAsDone.style.display ='none';
    }

    // Cancel
    popupCancel = document.getElementById('cancelWrapper');

    var showCancel = function() {
        popupCancel.style.display ='flex';
    }
    var hideCancel = function() {
        popupCancel.style.display ='none';
    }

    showCancel();
    confirmBtn.addEventListener("click", function(e){
        hideCancel();
        var post = document.getElementById(competitionName).parentElement;
        var remaining_posts = document.querySelectorAll('.result_container');
        console.log(remaining_posts);
            if (post != null){
                console.log("competitionName is "+competitionName);
                $.ajax({
                    type: "POST",
                    url: "./php/COM-archive_result.php",
                    data: { competitionName: competitionName },
                      success: function(response) {
                        post.remove();
                        showMarkAsDone();
                        remaining_posts = document.querySelectorAll('.result_container');
                      }
                    });
                    if (remaining_posts.length-1 <= 0 || remaining_posts == null || remaining_posts == undefined){
                        var empty = document.getElementById('empty');
                        var searchbar = document.querySelector('.inputAndDeleteDiv');
                        var pagini = document.querySelector('.pagination');
                        empty.style.display = 'flex';
                        searchbar.style.display = 'none';
                        pagini.style.display = 'none';
                    }
            }
            
            if (remaining_posts.length <= 0){
                var empty = document.getElementById('empty');
                var searchbar = document.querySelector('.inputAndDeleteDiv');
                var pagini = document.querySelector('.pagination');
                empty.style.display = 'flex';
                searchbar.style.display = 'none';
                pagini.style.display = 'none';
            }
        e.stopPropagation();
    })
    gotoarchiveBtn.addEventListener("click", function(e) {
        hideMarkAsDone();
        window.location.href = "COM-archive_page.php";
        e.stopPropagation();
    })
  });
});
// Confirm
popupMarkAsDone = document.getElementById('markAsDoneWrapper');
  
var showMarkAsDone = function() {
    popupMarkAsDone.style.display ='flex';
}
var hideMarkAsDone = function() {
    popupMarkAsDone.style.display ='none';
}

// Cancel
popupCancel = document.getElementById('cancelWrapper');

var showCancel = function() {
    popupCancel.style.display ='flex';
}
var hideCancel = function() {
    popupCancel.style.display ='none';
}
