<?php
// Initialize variables and error messages
$name = $email = $dob = $phone = $website = $contact_method = $message = '';
$country_code = '+1';
$subscribe = false;
$errors = [];

// Function to calculate age from date of birth
function calculateAge($dob) {
    $birthDate = new DateTime($dob);
    $today = new DateTime('today');
    return $birthDate->diff($today)->y;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Name
    if (empty(trim($_POST["name"]))) {
        $errors['name'] = "Name is required.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate Email
    if (empty(trim($_POST["email"]))) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate Date of Birth
    if (empty(trim($_POST["dob"]))) {
        $errors['dob'] = "Date of birth is required.";
    } else {
        $dob = trim($_POST["dob"]);
        if (!DateTime::createFromFormat('Y-m-d', $dob)) {
            $errors['dob'] = "Invalid date format.";
        } else {
            $age = calculateAge($dob);
        }
    }

    // Validate Phone
    if (empty(trim($_POST["phone"]))) {
        $errors['phone'] = "Phone number is required.";
    } elseif (!preg_match("/^[0-9]{10}$/", trim($_POST["phone"]))) {
        $errors['phone'] = "Phone number must be 10 digits.";
    } else {
        $phone = trim($_POST["phone"]);
        $country_code = $_POST["country_code"];
    }

    // Validate Website
    if (!empty(trim($_POST["website"])) && !filter_var(trim($_POST["website"]), FILTER_VALIDATE_URL)) {
        $errors['website'] = "Invalid website URL.";
    } else {
        $website = trim($_POST["website"]);
    }

    // Validate Contact Method
    if (empty(trim($_POST["contact_method"]))) {
        $errors['contact_method'] = "Preferred contact method is required.";
    } else {
        $contact_method = trim($_POST["contact_method"]);
    }

    // Validate Message
    if (!empty(trim($_POST["message"])) && strlen(trim($_POST["message"])) > 500) {
        $errors['message'] = "Message must not exceed 500 characters.";
    } else {
        $message = trim($_POST["message"]);
    }

    // Check if there are no errors
    if (empty($errors)) {
        $subscribe = isset($_POST["subscribe"]);

        // Display success message
        echo "<h2>Submission Successful!</h2>";
        echo "<p>Name: " . htmlspecialchars($name) . "</p>";
        echo "<p>Email: " . htmlspecialchars($email) . "</p>";
        echo "<p>Age: " . htmlspecialchars($age) . "</p>";
        echo "<p>Phone: " . htmlspecialchars($country_code . ' ' . $phone) . "</p>";
        echo "<p>Website: " . htmlspecialchars($website) . "</p>";
        echo "<p>Preferred Contact Method: " . htmlspecialchars($contact_method) . "</p>";
        echo "<p>Newsletter Subscription: " . ($subscribe ? "Yes" : "No") . "</p>";
        echo "<p>Message: " . nl2br(htmlspecialchars($message)) . "</p>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Contact Us</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
                <span class="error"><?php echo isset($errors['name']) ? $errors['name'] : ''; ?></span>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <span class="error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" name="dob" value="<?php echo htmlspecialchars($dob); ?>">
                <span class="error"><?php echo isset($errors['dob']) ? $errors['dob'] : ''; ?></span>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <div class="phone-input">
                    <select name="country_code">
                        <option value="+880" <?php echo ($country_code == '+880') ? 'selected' : ''; ?>>+880 (BD)</option>
                        <option value="+1" <?php echo ($country_code == '+1') ? 'selected' : ''; ?>>+1 (US)</option>
                        <option value="+44" <?php echo ($country_code == '+44') ? 'selected' : ''; ?>>+44 (UK)</option>
                        <option value="+91" <?php echo ($country_code == '+91') ? 'selected' : ''; ?>>+91 (India)</option>
                        <option value="+61" <?php echo ($country_code == '+61') ? 'selected' : ''; ?>>+61 (Australia)</option>
                        <option value="+81" <?php echo ($country_code == '+81') ? 'selected' : ''; ?>>+81 (Japan)</option>
                        <option value="+49" <?php echo ($country_code == '+49') ? 'selected' : ''; ?>>+49 (Germany)</option>
                        <option value="+33" <?php echo ($country_code == '+33') ? 'selected' : ''; ?>>+33 (France)</option>
                        <option value="+34" <?php echo ($country_code == '+34') ? 'selected' : ''; ?>>+34 (Spain)</option>
                        <option value="+55" <?php echo ($country_code == '+55') ? 'selected' : ''; ?>>+55 (Brazil)</option>
                        <option value="+86" <?php echo ($country_code == '+86') ? 'selected' : ''; ?>>+86 (China)</option>
                        <option value="+7" <?php echo ($country_code == '+7') ? 'selected' : ''; ?>>+7 (Russia)</option>
                        <option value="+39" <?php echo ($country_code == '+39') ? 'selected' : ''; ?>>+39 (Italy)</option>
                        <option value="+27" <?php echo ($country_code == '+27') ? 'selected' : ''; ?>>+27 (South Africa)</option>
                        <option value="+82" <?php echo ($country_code == '+82') ? 'selected' : ''; ?>>+82 (South Korea)</option>
                        <option value="+90" <?php echo ($country_code == '+90') ? 'selected' : ''; ?>>+90 (Turkey)</option>
                        <option value="+62" <?php echo ($country_code == '+62') ? 'selected' : ''; ?>>+62 (Indonesia)</option>
                        <option value="+52" <?php echo ($country_code == '+52') ? 'selected' : ''; ?>>+52 (Mexico)</option>
                    </select>
                    <input type="text" name="phone" placeholder="1234567890" value="<?php echo htmlspecialchars($phone); ?>">
                </div>
                <span class="error"><?php echo isset($errors['phone']) ? $errors['phone'] : ''; ?></span>
            </div>
            <div class="form-group">
                <label for="website">Website:</label>
                <input type="url" name="website" value="<?php echo htmlspecialchars($website); ?>">
                <span class="error"><?php echo isset($errors['website']) ? $errors['website'] : ''; ?></span>
            </div>
            <div class="form-group">
                <label for="contact_method">Preferred Contact Method:</label>
                <select name="contact_method">
                    <option value="" <?php echo ($contact_method == '') ? 'selected' : ''; ?>>Select</option>
                    <option value="email" <?php echo ($contact_method == 'email') ? 'selected' : ''; ?>>Email</option>
                    <option value="phone" <?php echo ($contact_method == 'phone') ? 'selected' : ''; ?>>Phone</option>
                </select>
                <span class="error"><?php echo isset($errors['contact_method']) ? $errors['contact_method'] : ''; ?></span>
            </div>
            <div class="form-group">
                <label for="subscribe">
                    <input type="checkbox" name="subscribe" <?php echo $subscribe ? 'checked' : ''; ?>> Subscribe to our newsletter
                </label>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea name="message"><?php echo htmlspecialchars($message); ?></textarea>
                <span class="error"><?php echo isset($errors['message']) ? $errors['message'] : ''; ?></span>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector("form");

            form.addEventListener("input", function(e) {
                const target = e.target;

                if (target.name === "email") {
                    const emailError = document.querySelector(".error.email");
                    if (!target.value.match(/^\S+@\S+\.\S+$/)) {
                        emailError.textContent = "Invalid email format.";
                    } else {
                        emailError.textContent = "";
                    }
                }

                if (target.name === "phone") {
                    const phoneError = document.querySelector(".error.phone");
                    if (!target.value.match(/^[0-9]{10}$/)) {
                        phoneError.textContent = "Phone number must be 10 digits.";
                    } else {
                        phoneError.textContent = "";
                    }
                }
            });
        });
    </script>
</body>
</html>
