const body = document.querySelector("body"),
      modeToggle = body.querySelector(".mode-toggle");
      sidebar = body.querySelector("nav");
      sidebarToggle = body.querySelector(".sidebar-toggle");

let getMode = localStorage.getItem("mode");
if(getMode && getMode ==="dark"){
    body.classList.toggle("dark");
}

let getStatus = localStorage.getItem("status");
if(getStatus && getStatus ==="close"){
    sidebar.classList.toggle("close");
}

modeToggle.addEventListener("click", () =>{
    body.classList.toggle("dark");
    if(body.classList.contains("dark")){
        localStorage.setItem("mode", "dark");
    }else{
        localStorage.setItem("mode", "light");
    }
});

sidebarToggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
    if(sidebar.classList.contains("close")){
        localStorage.setItem("status", "close");
    }else{
        localStorage.setItem("status", "open");
    }
})


function deleteCaregiver(caregiverId) {
    if (confirm('Are you sure you want to delete this caregiver?')) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'deleteCaregiver.php', true); // Path to your delete PHP script
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = xhr.responseText;
                if (response === 'success') {
                    alert('Caregiver deleted successfully.');
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert('Error deleting caregiver.');
                }
            } else {
                alert('Request failed. Please try again.');
            }
        };
        xhr.send('caregiver_id=' + caregiverId);
    }
}



function updateCaregiver(caregiverId) {
    window.location.href = 'updateCaregiver.php?caregiver_id=' + caregiverId; // Redirect to the update form
}



function updateChild(child_id) {
    // Redirect to update page with child_id in the query string
    window.location.href = 'update_child.php?child_id=' + child_id;
    
}


function deleteChild(child_id) {
    if (confirm('Are you sure you want to delete this child?')) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_child.php', true); // Path to your delete PHP script
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = xhr.responseText;
                if (response === 'success') {
                    alert('Child deleted successfully.');
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert('Error deleting child.');
                }
            } else {
                alert('Request failed. Please try again.');
            }
        };
        xhr.send('child_id=' + child_id);
    }
}



