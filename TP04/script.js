let form = document.getElementsByTagName('form')
console.log(form[0].outerHTML);

let secondInput = document.querySelector('form label:nth-child(2) input');
console.log(secondInput.outerHTML);

let allInputs = document.querySelectorAll('form label input');
for (let input of allInputs)
    console.log(input.outerHTML);
