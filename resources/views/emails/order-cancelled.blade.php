<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="font-family: sans-serif; color: #333; padding: 20px;">
    <h2>Order Cancelled</h2>
    <p>Hi {{ $order->user->name }},</p>
    <p>Your order <strong>{{ $order->order_number }}</strong> has been cancelled.</p>
    <p>Stock for all items has been restored.</p>
    <p style="color:#888; font-size:12px;">This is a simulated email — logged via MAIL_MAILER=log.</p>
</body>
</html>
