document.addEventListener('DOMContentLoaded', function() {
    const nopunksForm = document.getElementById('lookup-nobased');
    const nopunksUrl = document.body.getAttribute('data-url');

    if (nopunksForm) {
        // Prevent default form submission
        nopunksForm.addEventListener('submit', function(event) {
            event.preventDefault();
            seekNoPunks();
        });

        const seekNoPunks = async () => {
            try {

                const successDiv = document.getElementById('success-response-nobased');
                successDiv.innerHTML = '';


                const idValue = document.getElementById('nobasedid').value;

                // Create JSON payload
                const payload = { 'id': idValue };

                // Log payload for debugging
                console.log("Payload:", payload);

                const response = await fetch(nopunksUrl + '/lookup-nobased', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                if (!response.ok) {
                    throw new Error(`Network response was not ok: ${response.statusText}`);
                }

                const json = await response.json();
                if (json.success) {
                    handleSuccess(json);
                } else {
                    const successDiv = document.getElementById('success-response-nobased');
                    successDiv.innerHTML = 'Enter a valid ID between 0 and 9999';
                }
            } finally {
                toggleFormState(false);
            }
        };

        const handleSuccess = (json) => {
            const successDiv = document.getElementById('success-response-nobased');
            successDiv.innerHTML = '';

            const createImageElement = (url) => {
                const colDiv = document.createElement('div');
                colDiv.classList.add('col-12', 'col-md-10', 'col-lg-4', 'py-2');

                const imageTag = document.createElement('img');
                imageTag.src = url;
                imageTag.classList.add('img-fluid');

                colDiv.appendChild(imageTag);
                return colDiv;
            };

            if (json.url) {
                const image1 = createImageElement(json.url);
                successDiv.appendChild(image1);
            }

            if (json.url_cryptopunk_compare) {
                const image2 = createImageElement(json.url_cryptopunk_compare);
                successDiv.appendChild(image2);
            }
        };

        const toggleFormState = (isDisabled) => {
            const formElements = nopunksForm.querySelectorAll('button, input');
            formElements.forEach(element => {
                element.disabled = isDisabled;
            });
        };
    }
});