function validateLoginForm() {
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();

    if (email === "" || password === "") {
        alert("Please fill in all fields.");
        return false;
    }

    localStorage.setItem("currentUser", email);
    window.location.href = "dashboard.html";
    return false;
}

function validateRegisterForm() {
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();

    if (name === "" || email === "" || password === "") {
        alert("Please fill in all fields.");
        return false;
    }

    alert("Registration successful!");
    window.location.href = "login.html";
    return false;
}

function validateFeedbackForm() {
    let title = document.getElementById("title").value.trim();
    let category = document.getElementById("category").value;
    let description = document.getElementById("description").value.trim();

    if (title === "" || category === "" || description === "") {
        alert("Please complete all fields.");
        return false;
    }

    let currentUser = localStorage.getItem("currentUser");

    if (!currentUser) {
        currentUser = "guest";
    }

    let feedbackList = JSON.parse(localStorage.getItem("feedbackList")) || [];

    let newFeedback = {
        user: currentUser,
        title: title,
        category: category,
        description: description,
        status: "Pending"
    };

    feedbackList.push(newFeedback);

    localStorage.setItem("feedbackList", JSON.stringify(feedbackList));

    alert("Feedback submitted successfully!");
    window.location.href = "feedbacks.html";
    return false;
}

function displayMyFeedback() {
    let currentUser = localStorage.getItem("currentUser");
    let feedbackList = JSON.parse(localStorage.getItem("feedbackList")) || [];
    let container = document.getElementById("feedbackContainer");

    let myFeedback = feedbackList.filter(function(feedback) {
        return feedback.user === currentUser;
    });

    if (myFeedback.length === 0) {
        container.innerHTML = "<p>No feedback submitted yet.</p>";
        return;
    }

    let output = "";

    myFeedback.forEach(function(feedback) {
        output += `
            <div class="feedback-card">
                <h3>${feedback.title}</h3>
                <p><strong>Category:</strong> ${feedback.category}</p>
                <p><strong>Description:</strong> ${feedback.description}</p>
                <span class="status pending">${feedback.status}</span>
            </div>
        `;
    });

    container.innerHTML = output;
}