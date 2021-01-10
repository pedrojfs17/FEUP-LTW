const current_page = window.location.pathname.split("/").pop()

// True if current page is the owner_favorite page
const favs_page = current_page.startsWith('owner_favorite.php')

//
// Page variables for favorite pets and helper functions
//
var fav_pets = [] // Current favorite pets
var removed_favs = [] // Favorite pets removed in last update

/**
 * Checks if the new favorite pets list is different from the current one
 * @param {Array} new_favs 
 */
function favs_changed(new_favs) {
    let removed = false

    // Find removed elements
    for (let fav of fav_pets) {
        if (new_favs.filter(e => e.pet_id === fav.pet_id).length == 0) {
            removed_favs.push(fav)
            removed = true
        }
    }

    return removed || fav_pets.length != new_favs.length // Changed if elements were removed or added
}

/**
 * Adds a favorite pet with specified id to the fav_pets array
 * @param {String} id 
 */
function favs_add(id) {
    let fav = new Object()
    fav.pet_id = id
    fav_pets.push(fav)
}

/**
 * Removes a favorite pet with specified id from the fav_pets array
 * @param {String} id 
 */
function favs_remove(id) {
    fav_pets = fav_pets.filter(e => e.pet_id != id)
}


//
// Change favorite icons
//
function setFavIcon(icon, val) {
    if (val) {
        icon.innerText = "favorite"
    } else {
        icon.innerText = "favorite_border"
    }
    icon.parentNode.classList.toggle("liked")
}

function setFavIconByID(id, val) {
    let card = document.querySelector(".pet-card[data-id='" + id + "']")
    if (card != null) {
        let icon = card.querySelector(".fav-icon i")
        if (icon != null)
            setFavIcon(icon, val)
    }
}


//
// Register click event listeners on favorite buttons
//
for (let button of document.getElementsByClassName('fav-icon')) {
    button.addEventListener('click', favClickHandler)
}

/**
 * Event listener for favorite button clicks
 * @param event 
 */
function favClickHandler(event) {
    let pet_card = event.target.closest('.pet-card')
    let pet_id = pet_card.dataset.id

    let fav_request = new XMLHttpRequest()
    fav_request.open('GET', '../api/api_toggle_fav.php?' + encodeForAjax({ pet_id: pet_id }), true)
    fav_request.onload = toggleFavReqHandler
    fav_request.send()

}

/**
 * XML request handler for updating favorite pets in database
 */
function toggleFavReqHandler() {
    let response = JSON.parse(this.responseText)
    let card = document.querySelector(".pet-card[data-id='" + response.pet_id + "']")

    // Minimizes number of requests, locally updating info
    if (response.fav) {
        favs_add(response.pet_id)
        let owner = card.dataset.owner
        pushNotification(owner, "favorited your pet")
    } else favs_remove(response.pet_id)

    if (favs_page) {
        card.remove()
        return
    }
    let icon = card.querySelector(".fav-icon i")
    setFavIcon(icon, response.fav)
}


//
// Listen for Server Sent Events updating favorite pets
//
const evtSource = new EventSource("../events/event_fav_changes.php")
evtSource.onmessage = function(event) {
    let data = JSON.parse(event.data)
    if (favs_changed(data.favs)) {
        fav_pets = data.favs
        onFavsChanged()
    }
}

/**
 * Updates page info when favorite pets change
 */
function onFavsChanged() {
    if (favs_page) {
        let getFavs_request = new XMLHttpRequest()
        getFavs_request.open('GET', '../api/api_get_favs.php', true)
        getFavs_request.onload = getFavsReqHandler
        getFavs_request.send()
    } else {
        for (let fav of fav_pets) {
            setFavIconByID(fav.pet_id, true)
        }
        for (let rem of removed_favs) {
            setFavIconByID(rem.pet_id, false)
        }
        removed_favs = []
    }
}

/**
 * XML request handler for getting favorite pets card for owner_favorite page
 */
function getFavsReqHandler() {
    let doc = new DOMParser().parseFromString(this.responseText, 'text/html')
    document.getElementById("pet-cards").replaceWith(doc.getElementById("pet-cards"))
    for (let fav of fav_pets) {
        setFavIconByID(fav.pet_id, true)
    }
    let like_buttons = document.getElementsByClassName('fav-icon')
    for (let button of like_buttons) {
        button.addEventListener('click', favClickHandler)
    }
}