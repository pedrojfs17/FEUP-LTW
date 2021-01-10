// Adds notification
function pushNotification(receiver, text) {
    let notif_request = new XMLHttpRequest()
    notif_request.open('GET', '../api/api_add_notification.php?receiver=' + receiver + '&text=' + text, true)
    notif_request.send()
}