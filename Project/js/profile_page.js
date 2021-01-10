// Changes Tab in Profile Page
function changeTab(tabId) {
    var i;
    var x = document.getElementsByClassName("tab");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    document.getElementById(tabId).style.display = "grid";
}

const prof_nav = document.getElementById("profile-nav")

if(prof_nav){
    const tabButtons =prof_nav.querySelectorAll("button");

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            changeTab(button.dataset.tab);
        })
    })
}
