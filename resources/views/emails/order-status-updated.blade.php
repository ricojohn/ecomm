<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="font-family: sans-serif; color: #333; padding: 20px;">
    <h2>Order Status Updated</h2>
    <p>Hi {{ $order->user->name }},</p>
    <p>Your order <strong>{{ $order->order_number }}</strong> has been updated.</p>
    <p>
        New status:
        <strong>{{ ucfirst(str_replace('_', ' ', $order->status)) }}</strong>
    </p>
    <p style="color:#888; font-size:12px;">This is a simulated email — logged via MAIL_MAILER=log.</p>
</body>
</html>
