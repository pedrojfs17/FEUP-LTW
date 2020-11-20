let commentForm = document.querySelector('#comments form')

commentForm.addEventListener('submit', submitComment)

function submitComment(event) {
    event.preventDefault()

    const newsId = event.target[2].value
    const commentId = document.querySelector('#comments article:last-of-type').getAttribute('data-id')
    const username = event.target[0].value
    const commentText = event.target[1].value

    console.log(newsId, commentId, username, commentText)
    
}