// Proposal Response
let proposal_headers = document.getElementsByClassName('user-proposal-header')
let withdraw_buttons = document.querySelectorAll('.button.withdraw')
let confirm_buttons = document.querySelectorAll('.button.confirm')
let accept_buttons = document.querySelectorAll('.button.accept')
let reject_buttons = document.querySelectorAll('.button.reject')
let action_buttons = []
action_buttons.push(...withdraw_buttons, ...confirm_buttons, ...accept_buttons, ...reject_buttons)

function proposalClickHandler(event) {
    let proposal = event.target.closest('.user-proposal-header')
    let details = proposal.nextElementSibling
    details.classList.toggle('active')
    proposal.children[2].classList.toggle('fa-plus')
    proposal.children[2].classList.toggle('fa-minus')
}

function actionClickHandler(event) {
    let proposal = event.target.closest('.user-proposal')
    let proposal_id = proposal.dataset.proposal_id
    let decision, new_state

    if (event.target.classList.contains('accept')) {
        decision = 1
        new_state = 'approved'
    } else if (event.target.classList.contains('reject')) {
        decision = -1
        new_state = 'rejected'
    } else if (event.target.classList.contains('confirm')) {
        decision = 2
        new_state = 'complete'
    } else if (event.target.classList.contains('withdraw')) {
        decision = -2
        new_state = 'withdrawn'
    }

    let request = new XMLHttpRequest()
    request.open('GET', '../api/api_proposal_response.php?' + encodeForAjax({proposal_id:proposal_id, decision:decision}))
    request.onreadystatechange = () => {
        if (request.readyState === XMLHttpRequest.DONE) {
            let status = request.status
            if (status === 0 || (status >= 200 && status < 400)) {
                proposal.dataset.decision = new_state
                proposal.querySelector('.proposal-state').textContent = new_state
                if (decision == 1) {
                    let reject_button = document.createElement('span')
                    reject_button.className = 'button reject'
                    reject_button.textContent = 'Reject'
                    reject_button.addEventListener('click', actionClickHandler)
                    let proposal_actions = event.target.parentNode
                    proposal_actions.textContent = ''
                    proposal_actions.appendChild(reject_button)
                } else {
                    event.target.parentNode.remove()
                }
            } else {
                alert('Unable to change proposal. Try again!')
            }
        }
    }
    request.send()
}

for (let proposal of proposal_headers) {
    proposal.addEventListener('click', proposalClickHandler)
}

for (let button of action_buttons) {
    button.addEventListener('click', actionClickHandler)
}


// Question Reply
function replyReqSuccess(e) {
    reply_form[e.target.Index].textContent = 'Reply submitted successfully!'
    reply_form[e.target.Index].classList.toggle('success')
}

function replyReqError(e) {
    reply_form[e.target.Index].textContent = 'An error occurred, please try again!'
    reply_form[e.target.Index].classList.toggle('error')
}

function sendReply(e) {
    e.preventDefault()
    if (reply_area[e.target.Index].value.trim() == "") return
    let reply = new XMLHttpRequest()
    reply.open('GET', '../api/api_new_reply.php?' + encodeForAjax({question_id:asker[e.target.Index].dataset.question_id, reply:reply_area[e.target.Index].value.trim()}))
    reply.onreadystatechange = () => {
        if (reply.readyState === XMLHttpRequest.DONE) {
            let status = reply.status
            if (status === 0 || (status >= 200 && status < 400)) {
                pushNotification(asker[e.target.Index].dataset.asker, "replied to your question")
                replyReqSuccess(e)
            } else {
                replyReqError(e)
            }
        }
    }
    reply.send()
}

let reply_form = document.querySelectorAll('.reply-form')
let send_reply = document.querySelectorAll('.reply-form .reply-button')
let reply_area = document.querySelectorAll('.reply-form textarea')
let asker = document.querySelectorAll('.question')
if (send_reply != null) {
    for(let i=0;i<send_reply.length;i++){
        send_reply[i].Index = i
        send_reply[i].addEventListener('click',sendReply)
        
    }
}

