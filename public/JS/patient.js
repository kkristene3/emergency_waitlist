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