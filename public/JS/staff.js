// event listeners for staff page
document.addEventListener('DOMContentLoaded', function () {
    const addPatientBtn = document.getElementById('add-patient-btn');
    const removePatientBtn = document.getElementById('remove-patient-btn');
    const addPatientDiv = document.getElementById('add-patient');
    const removePatientDiv = document.getElementById('remove-patient');

    // show add patient form, hide remove patient form
    addPatientBtn.addEventListener('click', function () {
        addPatientDiv.style.display = 'flex';
        removePatientDiv.style.display = 'none';
    });
    // show remove patient form, hide add patient form
    removePatientBtn.addEventListener('click', function () {
        removePatientDiv.style.display = 'flex';
        addPatientDiv.style.display = 'none';
    });
});

// function to sign out
document.addEventListener('DOMContentLoaded', function() {
    const signOutBtn = document.getElementById('signout-btn');
    signOutBtn.addEventListener('click', function() {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'signOut', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                window.location.href = 'index.php';
            }
        };
        xhr.send('signOut=true');
    });
});