<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $my_payment_url = "https://raksmeypay.com/payment/request/b3a7fbbc2b97c3f120a536ed7453613e";
    $transaction_id = time(); // Using timestamp as transaction ID for uniqueness
    $amount = floatval($_POST['amount']); // Get amount from user input
    $success_url = urlencode("https://raksmeypay.com/payment/sample-success-page?payment=$transaction_id&token=1720886855");
    $pushback_url = urlencode("https://raksmeypay.com/payment/sample-pushback-page?payment=$transaction_id&token=1720886855");
    $remark = "Payment from user";
    $profile_key = "c133b998d2b87f957ec7144f4065f07b6eb90ae6b7806145011e54d1692e905d33e3994e13031a93";
    $hash = sha1($profile_key . $transaction_id . $amount . $success_url . $pushback_url . $remark);
    $parameters = [
        "transaction_id" => $transaction_id,
        "amount" => $amount,
        "success_url" => $success_url,
        "pushback_url" => $pushback_url,
        "remark" => $remark,
        "hash" => $hash
    ];
    $queryString = http_build_query($parameters);
    $payment_link_url = $my_payment_url."?".$queryString;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
        .payment-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .payment-frame {
            border: none;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        form {
            margin-bottom: 20px;
        }
        input[type="number"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <h1>Secure Payment</h1>
        <?php if (!isset($payment_link_url)): ?>
            <form method="post">
                <input type="number" name="amount" step="0.01" min="0.01" placeholder="Enter amount" required>
                <button type="submit">Proceed to Payment</button>
            </form>
        <?php else: ?>
            <iframe src="<?php echo $payment_link_url; ?>" width="300" height="509" class="payment-frame"></iframe>
        <?php endif; ?>
    </div>
</body>
</html>