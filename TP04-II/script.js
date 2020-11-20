function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}

let commentForm = document.querySelector('#comments form')

commentForm.addEventListener('submit', submitComment)

function submitComment(event) {
    event.preventDefault()

    const newsId = event.target[2].value
    const commentId = document.querySelector('#comments article:last-of-type').getAttribute('data-id')
    const username = event.target[0].value
    const commentText = event.target[1].value

    let request = new XMLHttpRequest()
    request.addEventListener("load", receiveComments)

    request.open("post", "api_add_comment.php", true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.send(encodeForAjax({id: newsId, comment_id: commentId, username:username, text:commentText}))
}

function receiveComments() {
    response = JSON.parse(this.responseText)
    comments = document.querySelector('#comments')

    response.forEach( function(comment) {
        const comment_id = comment['id'];
        const username = comment['username']
        const text = comment['text']
        const date = comment['published']

        let newComment = document.createElement('article')
        newComment.setAttribute('class', 'comment')
        newComment.setAttribute('data-id', comment_id)

        let userSpan = document.createElement('span')
        userSpan.setAttribute('class', 'user')
        userSpan.innerText = username

        let dateSpan = document.createElement('span')
        dateSpan.setAttribute('class', 'date')
        dateSpan.innerText = date

        let textP = document.createElement('p')
        textP.innerText = text

        userSpan.append(dateSpan)
        newComment.append(userSpan)
        newComment.append(textP)

        comments.insertBefore(newComment, commentForm)
    })
}