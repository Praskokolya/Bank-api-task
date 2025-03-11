<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Money</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
        }

        input[type="text"]:focus, input[type="number"]:focus, select:focus {
            border-color: #007BFF;
            outline: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .form-footer {
            text-align: center;
            margin-top: 20px;
        }

        .form-footer a {
            color: #007BFF;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Transfer Money</h1>
    <form id="transferForm">
        <div class="form-group">
            <label for="from_account">From Account:</label>
            <select id="from_account" name="from_account" required>
            </select>
        </div>

        <div class="form-group">
            <label for="to_account">To Account:</label>
            <select id="to_account" name="to_account" required>
            </select>
        </div>

        <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" required>
        </div>

        <button type="submit">Transfer</button>
    </form>
    <form action="{{ route('home') }}" method="GET">
        <button type="submit" class="home-button">Home</button>
    </form>
</div>

<script>
    const token = localStorage.getItem('auth_token');

    if (!token) {
        window.location.href = '/login';
    }

    const transferForm = document.getElementById('transferForm');
    const fromAccountSelect = document.getElementById('from_account');
    const toAccountSelect = document.getElementById('to_account');

    async function loadAccounts() {
        try {
            const response = await fetch('/api/accounts', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                }
            });

            if (!response.ok) {
                throw new Error('Failed to fetch accounts');
            }

            const accounts = await response.json();

            fromAccountSelect.innerHTML = '';
            toAccountSelect.innerHTML = '';

            accounts.accounts.forEach(account => { 
                const optionFrom = document.createElement('option');
                optionFrom.value = account.account_number;
                optionFrom.textContent = `Account: ${account.account_number} - Balance: ${account.balance} ${account.currency}`;
                fromAccountSelect.appendChild(optionFrom);

                const optionTo = document.createElement('option');
                optionTo.value = account.account_number;
                optionTo.textContent = `Account: ${account.account_number} - Balance: ${account.balance} ${account.currency}`;
                toAccountSelect.appendChild(optionTo);
            });
        } catch (error) {
            console.error('Error loading accounts:', error);
        }
    }

    window.onload = loadAccounts;

    transferForm.addEventListener('submit', async function (event) {
        event.preventDefault();

        const fromAccount = fromAccountSelect.value;
        const toAccount = toAccountSelect.value;
        const amount = parseFloat(document.getElementById('amount').value);
        const fromAccountBalance = Array.from(fromAccountSelect.options)
            .find(option => option.value === fromAccount)
            .textContent.split("Balance: ")[1]
            .split(" ")[0];

        const fromAccountCurrency = Array.from(fromAccountSelect.options)
            .find(option => option.value === fromAccount)
            .textContent.split("Balance: ")[1]
            .split(" ")[1];

        if (parseFloat(fromAccountBalance) < amount) {
            alert('Insufficient balance for this transfer.');
            return;
        }

        const data = {
            from_account: fromAccount,
            to_account: toAccount,
            amount: amount,
            from_currency: fromAccountCurrency,
        };

        try {
            const response = await fetch(`/api/transfer/${fromAccount}/${toAccount}`, {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });
            location.reload();

            if (response.ok) {
                const result = await response.json();
            } else {
                const error = await response.json();
        }
        } catch (error) {
        }
    });
</script>

</body>
</html>
