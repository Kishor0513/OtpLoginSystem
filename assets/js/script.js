
function validateForm(event) {
	// Get form elements
	var name = document.getElementById('name').value;
	var email = document.getElementById('email').value;
	var pass = document.getElementById('pass').value;
	var cpass = document.getElementById('cpass').value;

	// Validate username (required and at least 3 characters)
	if (name.length < 3) {
		alert('Username must be at least 3 characters long.');
		event.preventDefault(); // Prevent form submission
		return false;
	}

	// Validate email (basic email pattern check)
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
	if (!emailPattern.test(email)) {
		alert('Please enter a valid email address.');
		event.preventDefault(); // Prevent form submission
		return false;
	}

	// Validate password (required and at least 6 characters)
	if (pass.length < 6) {
		alert('Password must be at least 6 characters long.');
		event.preventDefault(); // Prevent form submission
		return false;
	}

	// Validate confirm password (must match the password)
	if (pass !== cpass) {
		alert('Passwords do not match.');
		event.preventDefault(); // Prevent form submission
		return false;
	}

	// If all validations pass, allow form submission
	return true;
}

