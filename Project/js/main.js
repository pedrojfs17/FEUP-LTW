'use strict'

// Get all done checkboxes and add an event listener
let doneCBs = document.querySelectorAll('article.list input[type=checkbox]')
doneCBs.forEach((doneCB) => doneCB.addEventListener('change', doneClicked))

// What happens when a done checkbox changes value
function doneClicked(event) {
    let doneCB = event.target
    let id = doneCB.getAttribute('data-id')

    // Ajax request
    let request = new XMLHttpRequest()
    request.open("post", "../api/api_item_done.php", true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.addEventListener("load", function() {
        let item = JSON.parse(this.responseText)
        doneCB.checked = (item.item_done == 1) // closure
    })
    request.send(encodeForAjax({ item_id: id }))
}

// Helper function
function encodeForAjax(data) {
    return Object.keys(data).map(function(k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}


// Search Filter
let filterCheckboxes = document.getElementById('search-filters')
if (filterCheckboxes) {
    filterCheckboxes.addEventListener('input', function() {
        let selectedFilters = {};

        let checked = filterCheckboxes.querySelectorAll('input[type=checkbox]:checked')
        for (let i = 0; i < checked.length; i++) {
            selectedFilters[checked[i].name] = selectedFilters[checked[i].name] || [];
            selectedFilters[checked[i].name].push(checked[i].value);
        }
        // create a collection containing all of the filterable elements
        let petCards = document.querySelectorAll('div.pet-card')
        let filteredResults = [...petCards]
            // loop over the selected filter name -> (array) values pairs
        Object.values(selectedFilters).forEach((filterValues) => {
            // filter each .pet-card element
            filteredResults = filteredResults.filter(petCard => {
                let matched = false;
                filterValues.forEach(value => {
                    if (petCard.dataset.category.includes(value)) {
                        matched = true;
                        return true;
                    }
                })

                return matched;
            });
        });

        petCards.forEach((element) => {
            element.style.display = "none"
        })
        filteredResults.forEach((element) => {
            element.style.display = "grid"
        })
    })

  let typesStr = location.href.split('types=')[1]

  if (typesStr) {
    let currentTypes = typesStr.split(',')

    currentTypes.forEach(type => {
      filterCheckboxes.querySelector("#" + type).toggleAttribute('checked')
    })

    filterCheckboxes.dispatchEvent(new Event('input'))
  }
}

/* Register Switch User Shelter */

let toggleBtnRegister = document.querySelector('#signup form .button-box #btn');
let btnUser = document.querySelector('#signup form .button-box button:first-of-type');
let btnShelter = document.querySelector('#signup form .button-box button:last-of-type');
let userColab = document.querySelector('#signup form #user-colaborator');
let accountType = document.querySelector('#signup form #accountType');

if(btnUser){
  btnUser.addEventListener('click', ()=>{
    
    accountType.setAttribute('value', 0);
    userColab.style.display = "grid";

    toggleBtnRegister.style.left = "0%";

    btnUser.style.color = "White";
    btnUser.style["font-size"] = "1em";
    
    btnShelter.style.color = "Black";
    btnShelter.style["font-size"] = "0.8em";
    })
}
if(btnShelter){
  btnShelter.addEventListener('click', ()=>{
    accountType.setAttribute('value', 1);
    userColab.style.display = "none";

    toggleBtnRegister.style.left = "50%";
    
    btnShelter.style.color = "White";
    btnShelter.style["font-size"] = "1em";
    
    btnUser.style.color = "Black";
    btnUser.style["font-size"] = "0.8em";
  })
}


const colaboratorCheckbox = document.querySelector("#signup .toggle-colaborator input");
if (colaboratorCheckbox != null) {
    colaboratorCheckbox.addEventListener('change', function() {
        let searchShelter = document.querySelector('#shelterSearch');
        if (this.checked) {
            searchShelter.style.display = "grid";
        } else {
            searchShelter.style.display = "none";
        }
    })
}

/* Check for empty uplaod Image */

const uploadButton = document.querySelector('#pet-page #upload-file-button');
if(uploadButton){
  if(uploadButton.files.length==0){
    console.warn("No File Selected");
  }
}

/* Main Page Search Pet */

const typeButtons = document.querySelectorAll('.type-wrapper')

typeButtons.forEach(button => {
  button.addEventListener('click', event => {
    event.target.closest(".type-wrapper").classList.toggle('selected-type')
  })
})

const searchButton = document.querySelector("#search-by-type")
if(searchButton) {
  searchButton.addEventListener('click', event => {
    event.preventDefault()
    let url = "search.php"
    let selectedTypes = document.querySelectorAll('.selected-type')

    for (let i = 0; i < selectedTypes.length; i++) {
      if (i == 0)
        url += "?types="
      else
        url += ","
      
      url += selectedTypes[i].id.split('type-')[1]
    }

    location.href = url;
  })
}

/* Main page image slider */

const sliderCards = document.querySelector('#pet-cards');
const sliderButtons = document.querySelectorAll('.pet-card-rotate-button');
const nCards = document.querySelectorAll('#pet-cards .pet-card').length - 1;

let imageIndex = 1;
let translateX = 10;

sliderButtons.forEach(button => {
    button.addEventListener('click', event => {
        if (event.target.id === 'rotate-left') {
            if (imageIndex !== 1) {
                imageIndex--;
                translateX += 20
            }
        } else {
            if (imageIndex !== nCards) {
                imageIndex++;
                translateX -= 20
            }
        }

        sliderCards.style.transform = `translateX(${translateX}vw)`;
    })
})

// Pet Image SlideShow
let slideIndex = 1;
const slideshowBtnL = document.querySelector(".display-left");
const slideshowBtnR = document.querySelector(".display-right");
if(slideshowBtnL){
    slideshowBtnL.addEventListener('click',function(){
        plusDivs(-1)
    });
}
if(slideshowBtnR){
    slideshowBtnR.addEventListener('click',function(){
        plusDivs(+1)
    });
}

function plusDivs(n) {
    showDivs(slideIndex += n);
}


function showDivs(n) {
    var i;
    var x = document.getElementsByClassName("pet-images-slideshow");
    if (x != null) {
        if (n > x.length) { slideIndex = 1 }
        if (n < 1) { slideIndex = x.length };
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        x[slideIndex - 1].style.display = "block";
    }
}

//Upload Pet Image

let uploadImageBtn = document.querySelectorAll('.edit-details .profile-image');
if(uploadImageBtn){
    uploadImageBtn.forEach(btn => {
        btn.addEventListener('click',function(){
            let fileUploadBtn = document.querySelectorAll('#upload-profile-button')[0];
            fileUploadBtn.click();
        })
    });
}



// Confirmation Forms

const confirmationForms = document.querySelectorAll('.confirmationForm')

confirmationForms.forEach(confirmationForm => {
    let confirmButton = confirmationForm.querySelector('.confirmbtn')
    let cancelButton = confirmationForm.querySelector('.cancelbtn')
    let closeButton = confirmationForm.querySelector('.close-confirmation')
    let submitForm = confirmationForm.parentElement
    let submitButton = submitForm.querySelector('input[type="submit"]')
    let valid = true
    submitButton.addEventListener('click', function(e) {
        e.preventDefault()
        let inputs = submitForm.querySelectorAll('input')
        
        inputs.forEach(element => {
            valid = valid && element.checkValidity()
        });
        if(valid)
            confirmationForm.style.display = "block"
    })

    confirmButton.addEventListener('click', function(e) {
        e.preventDefault()
        submitForm.submit()
    })

    cancelButton.addEventListener('click', function(e) {
        e.preventDefault()
        confirmationForm.style.display = "none";
    })

    closeButton.addEventListener('click', function(e) {
        e.preventDefault()
        confirmationForm.style.display = "none";
    })
})

window.onclick = function(event) {
    if (event.target.classList.contains('confirmationForm')) {
        event.target.style.display = "none";
    }
}



// Notifications Button for Small Screens

const notificationsToggle = document.querySelector('#notificationButton')

if (notificationsToggle) {
    notificationsToggle.addEventListener('click', function(e) {
        e.preventDefault()
        document.querySelector("#notifications").classList.toggle('active')
    })
}

// Search Dropdown
const searchDropdowns = document.querySelectorAll('.searchDropdown')

searchDropdowns.forEach(searchDropdown => {
    searchDropdown.isOpen = false

    const label = searchDropdown.querySelector('.dropdown-label')
    const inputs = searchDropdown.querySelectorAll('input[type="checkbox"]')

    label.addEventListener('click', function(e) {
        e.preventDefault();
        searchDropdown.classList.toggle('openDropdown')
    })
    
    inputs.forEach(input => {
        input.addEventListener('change', function(e) {
            updateDropdownStatus(searchDropdown)
        })
    })
})

function updateDropdownStatus(dropDown) {
    let inputs = dropDown.querySelectorAll('input[type="checkbox"]')
    let checked = dropDown.querySelectorAll('input[type="checkbox"]:checked');
    let label = dropDown.querySelector('.dropdown-label')
      
    if(checked.length <= 0) {
        label.innerText = 'Search';
    }
    else if(checked.length === 1) {
        label.innerText = checked[0].parentElement.innerText;
    }
    else if(checked.length === inputs.length) {
        label.innerText = 'All Selected';
    }
    else {
        label.innerText = checked.length + ' Selected'
    }
}