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

// Add click event listener to all code elements
document.querySelectorAll('code').forEach((codeElement) => {
    codeElement.addEventListener('click', function () {
        // Copy the content of the clicked code element to the clipboard
        navigator.clipboard.writeText(this.textContent).then(() => {
            // Provide feedback to the user
        }).catch((err) => {
            console.error('Failed to copy text: ', err);
        });
    });
});

