document.addEventListener('DOMContentLoaded', function() {

    const form = document.getElementById('lookup-wallet');
    const url = document.body.getAttribute('data-url');

    if (form) {

        const seekWallet = async () => {
            try {

                const formData = new FormData(form);
                const formValues = {};
                formData.forEach((value, key) => {
                    formValues[key] = value;
                });

                const response = await fetch(url + '/lookup-whitelist', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formValues),
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }

                const json = await response.json();
                if (json.success) {
                    const checkDiv = document.getElementById('check');
                    checkDiv.classList.remove('hide');

                    const successDiv = document.getElementById('success-response');

                    successDiv.innerHTML = '';

                    const messageDiv = document.createElement('div');
                    messageDiv.innerHTML = json.message;
                    messageDiv.classList.add('py-2');

                    const walletDiv = document.createElement('div');
                    walletDiv.innerHTML = json.wallet;
                    walletDiv.classList.add('py-2');
                    walletDiv.classList.add('px-3');
                    walletDiv.classList.add('rounded');
                    walletDiv.classList.add('success-bg');

                    successDiv.appendChild(messageDiv);
                    successDiv.appendChild(walletDiv);
                } else {
                    form.querySelector('input[name="wallet"]').value = '';

                    const failureDiv = document.getElementById('failure-response');
                    failureDiv.classList.remove('hide');

                    const messageDiv = document.createElement('div');
                    messageDiv.innerHTML = json.message;

                    failureDiv.appendChild(messageDiv);

                    form.querySelector('button[type="submit"]').disabled = false;
                    form.querySelector('input[name="wallet"]').disabled = false;
                }
                console.log(json);
            } catch (error) {
                console.error('Fetch error: ', error);
            }
        };


        form.addEventListener('submit', function(event) {
            seekWallet();

            const failureDiv = document.getElementById('failure-response');
            failureDiv.classList.add('hide');
            failureDiv.innerHTML = '';

            form.querySelector('button[type="submit"]').disabled = true;
            form.querySelector('input[name="wallet"]').disabled = true;

            return event.preventDefault();
        });
    }
});
