document.addEventListener("DOMContentLoaded", function () {
    loadTasks();

    // Delegate event handling for dynamically loaded buttons
    const tasksDiv = document.getElementById("tasks");
    if (tasksDiv) {
        tasksDiv.addEventListener("click", async function (event) {
            // Check if the clicked element is a button with the class `async-action-btn`
            if (event.target.classList.contains("async-action-btn")) {
                const button = event.target;

                // Extract data attributes
                const project = button.getAttribute("data-project");
                const action = button.getAttribute("data-action");

                try {
                    // Perform an async call to your controller
                    const response = await fetch("/do-shill", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({ project, action }),
                    });

                    if (!response.ok) {
                        throw new Error("Failed to perform action.");
                    }

                    const result = await response.json();
                    loadTasks();
                    console.log("Action performed successfully:", result);

                    // Optionally update the UI or show a message
                    // alert("Action completed!");
                } catch (error) {
                    loadTasks();
                    console.error("Error:", error);
                    // alert("Failed to complete the action.");
                }
            }
        });
    }
});

async function loadTasks() {
    const tasksDiv = document.getElementById("tasks");
    if (tasksDiv) {
        try {
            // Make the GET request to "get-tasks"
            const response = await fetch("/get-tasks", {
                method: "GET",
                headers: {
                    "Content-Type": "text/html", // Specify content type for response
                },
            });

            // Check if the response is successful
            if (!response.ok) {
                throw new Error(`Failed to fetch tasks: ${response.statusText}`);
            }

            // Get the HTML response as text
            const html = await response.text();

            // Find the div with id "tasks" and inject the HTML
            const tasksDiv = document.getElementById("tasks");
            if (tasksDiv) {
                tasksDiv.innerHTML = html;
            } else {
                console.error("Element with id 'tasks' not found.");
            }
        } catch (error) {
            // Handle any errors that occur during the fetch
            console.error("Error loading tasks:", error);
            alert("Failed to load tasks. Please try again later.");
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Event delegation to handle dynamically added elements
    const container = document.body; // Change to a specific container if needed

    // Listen for clicks on .progress elements to toggle related project examples
    container.addEventListener('click', (event) => {
        const progress = event.target.closest('.progress');
        if (!progress) return;

        // Get the related project identifier
        const project = progress.getAttribute('data-project');

        // Hide all example cards
        document.querySelectorAll('.examples-project').forEach(card => {
            card.style.display = 'none';
        });

        // Show the related example card
        const relatedExample = document.querySelector(`[data-example="${project}"]`);
        if (relatedExample) {
            relatedExample.style.display = 'block';
        }
    });

    // Listen for clicks on example buttons to copy text
    container.addEventListener('click', (event) => {
        const exampleButton = event.target.closest('button[id="example"]');
        if (!exampleButton) return;

        // Copy the data-text value to the clipboard
        const textToCopy = exampleButton.getAttribute('data-text');
        if (textToCopy) {
            navigator.clipboard.writeText(textToCopy).then(() => {

            }).catch(err => {
                console.error('Failed to copy text: ', err);
            });
        }
    });


    // sports
    const buttons = document.querySelectorAll('.async-sport-type-action-btn');

    buttons.forEach(button => {
        button.addEventListener('click', async (event) => {
            const sportType = event.currentTarget.getAttribute('data-sport-type');
            const multiple = event.currentTarget.getAttribute('data-multiple');
            const originalText = button.innerHTML; // Save the original text
            button.disabled = true; // Disable the button

            try {
                const response = await fetch('do-sport', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ sportType, multiple }) // Send sportType in the POST body
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const result = await response.json();
                console.log('Success:', result);
                loadSports();

            } catch (error) {
                console.error('Error:', error);
                button.innerHTML = 'Failed!';
                setTimeout(() => (button.innerHTML = originalText), 2000); // Restore original text after 2 seconds
            } finally {
                button.disabled = false; // Re-enable the button
            }
        });
    });
});

loadSports();

async function loadSports() {
    const sportsDiv = document.getElementById("sports");
    if (sportsDiv) {
        try {
            // Make the GET request to "get-tasks"
            const response = await fetch("/get-sports", {
                method: "GET",
                headers: {
                    "Content-Type": "text/html", // Specify content type for response
                },
            });

            // Check if the response is successful
            if (!response.ok) {
                throw new Error(`Failed to fetch sports: ${response.statusText}`);
            }

            // Get the HTML response as text
            const html = await response.text();

            // Find the div with id "tasks" and inject the HTML
            const sportsDiv = document.getElementById("sports");
            if (sportsDiv) {
                sportsDiv.innerHTML = html;
            } else {
                console.error("Element with id 'sports' not found.");
            }
        } catch (error) {
            // Handle any errors that occur during the fetch
            console.error("Error loading sports:", error);
            alert("Failed to load sports. Please try again later.");
        }
    }
}
