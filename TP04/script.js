let form = document.getElementsByTagName('form')[0]
console.log(form.outerHTML);
form.addEventListener('submit', function(event) {
    event.preventDefault();
    alert('Submitted!');
})

let secondInput = document.querySelector('form label:nth-child(2) input');
console.log(secondInput.outerHTML);

let allInputs = document.querySelectorAll('form label input');
for (let input of allInputs)
    console.log(input.outerHTML);
