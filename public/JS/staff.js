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


/**
 * This function will check the form for adding a patient
 */
function checkPatientForm() {
    const patientForm = document.getElementById('add-patient-form');
    const patientName = document.getElementById('patient-name').value;
    const patientUsername = document.getElementById('patient-username').value;
    const patientLoginCode = document.getElementById('patient-login-code').value;
    const patientSeverity = document.getElementById('patient-severity').value;

    // if login code is over 3 characters, return false
    if (patientLoginCode.length > 3) {
        alert('Login code must be 3 characters or less');
    } else {
        // send form data to server through PHP class
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../app/models/TableInsertion.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                alert(xhr.responseText);
            }
        };
        xhr.send('addPatient=true&name=' + patientName + '&username=' + patientUsername + '&loginCode=' + patientLoginCode + '&severity=' + patientSeverity);
        // clear form
        patientForm.reset();
    }
}

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