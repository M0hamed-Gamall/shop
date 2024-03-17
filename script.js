
document.addEventListener('DOMContentLoaded', (event) => {
    setTimeout(function() {
        var alertMessage = document.getElementById('alertMessage');
        if (alertMessage) {
            alertMessage.style.display = 'none';
        }
    }, 1000);
});

