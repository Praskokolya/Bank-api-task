<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 500px;
            margin-top: 100px;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 10px;
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .text-center {
            margin-top: 20px;
        }
        .form-text {
            font-size: 14px;
            color: #6c757d;
        }
        .error {
            color: red;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create Account</h2>
        <form id="registerForm" method="POST" action="{{ route('auth.register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
                <div class="form-text">Password should be at least 8 characters.</div>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                <div class="error" id="password-error"></div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create Account</button>
            </div>
        </form>
        <div class="text-center">
            <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
        </div>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            const errorElement = document.getElementById('password-error');
            
            if (password !== passwordConfirmation) {
                event.preventDefault();
                errorElement.textContent = 'Passwords do not match.';
            } else {
                errorElement.textContent = '';
            }
        });
    </script>
</body>
</html>
