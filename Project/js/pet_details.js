// Toggles Proposal Motivation Visibility
function toggleFormVisible() {
    adopt_button.classList.toggle('open')
    adopt_form.classList.toggle('show')
}
// Updates Motivation Char count
function updateProposalChars() {
    let new_count = motivation_box.value.length
    char_counter.textContent = new_count
}
// Updates Question Char count
function updateQuestionChars() {
    let new_count = question_area.value.length
    char_counter_question.textContent = new_count
}
// Send Proposal Request
function proposalReqSuccess() {
    adopt_form.textContent = 'Adoption proposal submitted successfully!'
    adopt_form.classList.toggle('success')
}
function proposalReqError() {
    adopt_form.textContent = 'An error occurred, please try again!'
    adopt_form.classList.toggle('error')
}

function sendForm() {
    let proposal_request = new XMLHttpRequest()
    proposal_request.open('GET', '../api/api_new_proposal.php?' + encodeForAjax({pet_id:pet_id, motivation:motivation_box.value.trim()}))
    proposal_request.onreadystatechange = () => {
        if (proposal_request.readyState === XMLHttpRequest.DONE) {
            let status = proposal_request.status
            if (status === 0 || (status >= 200 && status < 400)) {
                pushNotification(owner.slice(owner.lastIndexOf(':')+1).trim(), "sent you a proposal")
                proposalReqSuccess()
            } else {
                proposalReqError()
            }
        }
    }
    proposal_request.send()
}

// Send Question Request
function questionReqSuccess() {
    question_form.textContent = 'Question submitted successfully!'
    question_form.classList.toggle('success')
}

function questionReqError() {
    question_form.textContent = 'An error occurred, please try again!'
    question_form.classList.toggle('error')
}

function sendQuestion() {
    if (question_area.value.trim() === "") return
    let question = new XMLHttpRequest()
    question.open('GET', '../api/api_new_question.php?' + encodeForAjax({pet_id:pet_id, question:question_area.value.trim()}))
    question.onreadystatechange = () => {
        if (question.readyState === XMLHttpRequest.DONE) {
            let status = question.status
            if (status === 0 || (status >= 200 && status < 400)) {
                pushNotification(owner.slice(owner.lastIndexOf(':')+1).trim(), "sent you a question")
                questionReqSuccess()
            } else {
                questionReqError()
            }
        }
    }
    question.send()
}

// Event Listener additions
let adopt_form = document.getElementById('adopt-form')
let adopt_button = document.getElementById('adopt-button')
let send_button = document.querySelector('.adoption-form .send')
let pet_id
if(document.getElementById('pet-page'))
    pet_id = document.getElementById('pet-page').dataset.pet_id
let motivation_box = document.querySelector('.adoption-form textarea')
let char_counter = document.getElementById('char-count')
let char_counter_question = document.getElementById('char-count-question')
let question_form = document.getElementById('question-form')
let question_area = document.querySelector('.question-form textarea')
let send_question_button = document.querySelector('.question-form .send')
let owner_li = document.querySelector('#details li[name="owner"]')
let owner=null
if(owner_li){
    owner = owner_li.innerText
}
if (adopt_button != null) {
    adopt_button.addEventListener('click', toggleFormVisible)
    
    if (motivation_box != null) {
        motivation_box.addEventListener('keydown', updateProposalChars)
        motivation_box.addEventListener('keyup', updateProposalChars)
        send_button.addEventListener('click', sendForm)
    }
}

if(question_area!=null){
    question_area.addEventListener('keydown',updateQuestionChars)
    question_area.addEventListener('keyup',updateQuestionChars)
    send_question_button.addEventListener('click',sendQuestion)
}


const fakeUploadBtn = document.querySelector('.upload-image #replace-file-button')
if(fakeUploadBtn){
    const realUploadBtn = document.querySelector('.upload-image #upload-file-button')
    const selectedFiles = document.querySelector('#selected-files')
    
    fakeUploadBtn.addEventListener('click', ()=>{
       realUploadBtn.click()
    })
    realUploadBtn.addEventListener('change',()=>{
        const currFiles = realUploadBtn.files
        if(currFiles.length>0){
            selectedFiles.innerText = "Files chosen:"
            const list = document.createElement("ol")
            selectedFiles.append(list)

            for(const file of currFiles){
                const li = document.createElement("li")
                li.innerText = file.name
                list.appendChild(li)
            }
            
        }
        else
        selectedFiles.innerText = "No files chosen, yet"
    })
}