let form = document.getElementsByTagName('form')[0]
console.log(form.outerHTML);
form.addEventListener('submit', function(event) {
    event.preventDefault();
    console.log(event)
    const description = event.target[0].value;
    const quantity = event.target[1].value;

    let tr = document.createElement('tr');

    let td1 = document.createElement('td');
    td1.innerHTML = description;

    let td2 = document.createElement('td');
    let inputQuantity = document.createElement('input');
    inputQuantity.setAttribute('type', 'number');
    inputQuantity.setAttribute('value', quantity);
    td2.append(inputQuantity);

    let td3 = document.createElement('td');
    let inputRemove = document.createElement('input');
    inputRemove.setAttribute('type', 'submit');
    inputRemove.setAttribute('value', 'Remove');
    td3.append(inputRemove);

    inputRemove.onclick = (event) => {
        event.preventDefault()
        tr.remove()
      }

    tr.append(td1);
    tr.append(td2);
    tr.append(td3);

    document.querySelector('#products tbody').append(tr);

    alert('Submitted!');
})

let secondInput = document.querySelector('form label:nth-child(2) input');
console.log(secondInput.outerHTML);

let allInputs = document.querySelectorAll('form label input');
for (let input of allInputs)
    console.log(input.outerHTML);
