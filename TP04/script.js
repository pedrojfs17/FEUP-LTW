function updateTotal() {
    let tr = document.querySelectorAll('#products tbody tr');
    let total = 0;

    tr.forEach((line) => {
        if (line.children[0].tagName != 'TH') {
            inputValue = line.children[1].children[0].attributes['value'].value;
            total += parseInt(inputValue);
        }
    })

    document.getElementById('total').innerHTML = total;
}

let form = document.getElementsByTagName('form')[0]

form.addEventListener('submit', function(event) {
    event.preventDefault();

    const description = event.target[0].value;
    const quantity = event.target[1].value;

    let tr = document.createElement('tr');

    let td1 = document.createElement('td');
    td1.innerHTML = description;
    tr.append(td1);

    let td2 = document.createElement('td');
    let inputQuantity = document.createElement('input');
    inputQuantity.setAttribute('type', 'number');
    inputQuantity.setAttribute('value', quantity);
    td2.append(inputQuantity);
    tr.append(td2);

    inputQuantity.addEventListener('change', function(event) {
        updateTotal();
    });

    let td3 = document.createElement('td');
    let inputRemove = document.createElement('input');
    inputRemove.setAttribute('type', 'submit');
    inputRemove.setAttribute('value', 'Remove');
    td3.append(inputRemove);
    tr.append(td3);

    inputRemove.addEventListener('click', function(event) {
        event.preventDefault();
        tr.remove();
        updateTotal();
    });

    document.querySelector('#products tbody').append(tr);

    updateTotal();

    alert('Submitted!');
})

