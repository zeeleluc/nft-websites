document.getElementById('copyButton').addEventListener('click', function() {
    var copyText = document.getElementById('contractAddress');
    navigator.clipboard.writeText(copyText.value).then(function() {
        copyText.style.fontWeight = 'bold'; // Make the text bold
    });
});
