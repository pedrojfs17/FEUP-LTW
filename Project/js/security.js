let csrf_token = document.querySelector("meta[name='csrf-token']").getAttribute("content")

function csrfSafeMethod(method) {
    // these HTTP methods do not require CSRF protection
    return (/^(GET|HEAD|OPTIONS)$/.test(method))
}
let o = XMLHttpRequest.prototype.open;
XMLHttpRequest.prototype.open = function () {
    let res = o.apply(this, arguments)
    let err = new Error()
    if (!csrfSafeMethod(arguments[0])) {
        this.setRequestHeader('anti-csrf-token', csrf_token)
    }
    return res
}

// Enabling/Disabling Signup based on User Input
let password = document.querySelectorAll("#signup #password")[0]
let username = document.querySelectorAll("#signup #username")[0]
let submit = document.querySelectorAll(".sensitive input[type='submit']")
if(username) {
    username.addEventListener('input',function(event){
        if (!event.target.checkValidity()) {
            submit[0].disabled = true
            submit[0].style.setProperty('background-color','brown')
            event.target.classList.add("error")
        }
        else {
            submit[0].disabled = false
            submit[0].style.setProperty('background-color','#4F8A10')
            event.target.classList.remove("error")
        }
    })
}
if(password) {
    password.addEventListener('input',function(event){
        if (!event.target.checkValidity()) {
            submit[0].disabled = true
            submit[0].style.setProperty('background-color','brown')
            event.target.classList.add("error")
        }
        else {
            submit[0].disabled = false
            submit[0].style.setProperty('background-color','#4F8A10')
            event.target.classList.remove("error")
        }
    })
}

