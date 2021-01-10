let passwordElement = document.getElementsByName("password")[0]
let usernameElement = document.getElementsByName("username")[0]
usernameElement.addEventListener("focus", validateField)
usernameElement.addEventListener("changes", validateField)

let nameElement = document.getElementsByName("name")[0]
nameElement.addEventListener("focus", validateField)
nameElement.addEventListener("changes", validateField)

let zipcodeElement = document.getElementsByName("zipcode")[0]
zipcodeElement.addEventListener("focus", validateField)
zipcodeElement.addEventListener("changes", validateField)

let ipv4Element = document.getElementsByName("ipv4")[0]
ipv4Element.addEventListener("focus", validateField)
ipv4Element.addEventListener("changes", validateField)

let macElement = document.getElementsByName("mac")[0]
macElement.addEventListener("focus", validateField)
macElement.addEventListener("changes", validateField)

let submit = document.querySelector("form input[type='submit']")

passwordElement.addEventListener("input", function(event) {
    const password = event.target.value
    const username = usernameElement.value

    if (password.includes(username)) {
        submit.disabled = true;
        passwordElement.classList.add("error");
    }
    else {
        validateField(event);
        submit.disabled = false;
        passwordElement.classList.remove("error")
    }
})

function validateField(e) {
    const element = e.target
    const value = e.target.value

    // Check if it is empty
    var invalid = element.getAttribute("required") && !value

    if (invalid) {
        submit.disabled = true;
        element.classList.add("error");
    }
    else {
        submit.disabled = false;
        element.classList.remove("error")
    }
  }