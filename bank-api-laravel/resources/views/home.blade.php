<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        h1 {
            color: #007bff;
            font-size: 2.5rem;
        }
        footer {
            text-align: center;
            padding: 15px;
            background-color: #f8f9fa;
            margin-top: 40px;
            border-top: 1px solid #e1e1e1;
        }
        footer p {
            margin: 0;
            font-size: 1rem;
            color: #6c757d;
        }
        main p {
            font-size: 1.2rem;
            color: #333;
            line-height: 1.6;
        }
        .btn-create {
            display: inline-block;
            padding: 12px 30px;
            font-size: 1.2rem;
            color: white;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }
        .btn-create:hover {
            background-color: #218838;
        }
        .form-container {
            margin-top: 30px;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container h3 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome</h1>
            <a href="transfer">
                <h4>Make a transfer</h4>
            </a>
        </header>
        <main>
            <p>This is the home page of the bank application. Here you can find various banking services and information.</p>

            <div class="form-container">
                <h3>Create New Bank Account</h3>
                <form id="createAccountForm">
                    <div class="mb-3">
                        <label for="currency" class="form-label">Currency</label>
                        <select class="form-select" id="currency" required>
                            <option value="">Select Currency</option>
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                            <option value="GBP">GBP</option>
                            <option value="UAH">UAH</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-create">Create Account</button>
                </form>
            </div>

            <div class="mt-4">
                <h3>Your Accounts</h3>
                <ul id="accountsList" class="list-group">
                </ul>
            </div>
        </main>
    </div>
    <script>
        const authToken = @json(session('auth_token'));
        if (authToken) {
            localStorage.setItem('auth_token', authToken);
        }
        const createAccountForm = document.getElementById('createAccountForm');
        const accountsList = document.getElementById('accountsList');

        createAccountForm.addEventListener('submit', async (event) => {
    event.preventDefault();

    const currency = document.getElementById('currency').value;

    if (currency) {
        try {
            const url = `/api/account/${currency}`;
            const token = localStorage.getItem('auth_token');

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`,
                }
            });

            if (response.status === 200) {
                const data = await response.json();
                const newToken = data.new_token;  

                localStorage.setItem('auth_token', newToken);

                fetchAccounts();
                document.getElementById('currency').value = ''; 
            } else {
                console.error('Error creating account:', response.status);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
});


        async function fetchAccounts() {
            try {
                const url = '/api/accounts';
                const token = localStorage.getItem('auth_token');

                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`,
                    }
                });

                if (response.status === 200) {
                    const data = await response.json();
                    displayAccounts(data.accounts); 
                } else {
                    console.error('Error fetching accounts:', response.status);
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        function displayAccounts(accounts) {
            accountsList.innerHTML = ''; 

            if (accounts && accounts.length > 0) {
                accounts.forEach(account => {
                    const listItem = document.createElement('li');
                    listItem.classList.add('list-group-item');
                    listItem.textContent = `Account Number: ${account.account_number}, Currency: ${account.currency}, Balance: ${account.balance}`;
                    accountsList.appendChild(listItem);
                });
            } else {
                const listItem = document.createElement('li');
                listItem.classList.add('list-group-item');
                listItem.textContent = 'No accounts found.';
                accountsList.appendChild(listItem);
            }
        }

        window.onload = fetchAccounts;
    </script>
</body>
</html>