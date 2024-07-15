// custom-script.js

document.addEventListener('DOMContentLoaded', function() {
    var playNowButton = document.getElementById('play-now-button');
    var iframeGameDesktop = document.getElementById('iframeGameDesktop');

    playNowButton.addEventListener('click', function() {
        iframeGameDesktop.classList.add('active');
        playNowButton.style.display = 'none';
    });
});
