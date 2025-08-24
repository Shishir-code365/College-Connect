<?php
// Handle AJAX submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['feedback'])) {
    session_start(); // make sure session is started
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['feedback'])) {
        include "../connection.php"; // adjust path if needed

        $user_id  = $_SESSION['user_id']; // get logged-in user
        $feedback = trim($_POST['feedback']);
        $rating   = $_POST['rating'];
        $category = $_POST['category'];

        if (!empty($feedback)) {
            $stmt = $con->prepare("INSERT INTO chat_feedback (user_id, feedback, rating, category) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isis", $user_id, $feedback, $rating, $category); // note the "i" for user_id and rating, "s" for text
            if ($stmt->execute()) {
                $stmt->close();
                echo "success";
            } else {
                echo "error";
            }
        } else {
            echo "empty";
        }
        exit();
    }
}
?>

<form id="feedbackForm">
    <textarea name="feedback" required placeholder="Write your feedback..."></textarea><br><br>
    <select name="rating" required>
        <option value="5">⭐⭐⭐⭐⭐ (Excellent)</option>
        <option value="4">⭐⭐⭐⭐ (Good)</option>
        <option value="3">⭐⭐⭐ (Average)</option>
        <option value="2">⭐⭐ (Poor)</option>
        <option value="1">⭐ (Very Bad)</option>
    </select><br><br>
    <select name="category">
        <option value="Bug Report">🐞 Bug Report</option>
        <option value="Feature Request">💡 Feature Request</option>
        <option value="General Comment">💬 General Comment</option>
        <option value="Query">❓ Query</option>
    </select><br><br>
    <button type="submit">Submit Feedback</button>
</form>

<script>
    document.getElementById('feedbackForm').addEventListener('submit', function(e) {
        e.preventDefault(); // prevent page reload

        let formData = new FormData(this);

        fetch('feedback_form.php', { // send AJAX to same file
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                data = data.trim();
                if (data === 'success') {
                    alert('✅ Feedback submitted successfully!');
                    this.reset(); // clear form
                } else if (data === 'empty') {
                    alert('⚠ Please enter your feedback!');
                } else {
                    alert('❌ Error submitting feedback. Please try again.');
                }
            })
            .catch(err => {
                alert('❌ Network error. Please try again.');
            });
    });
</script>