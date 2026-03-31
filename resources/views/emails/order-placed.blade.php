<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="font-family: sans-serif; color: #333; padding: 20px;">
    <h2>Order Confirmed</h2>
    <p>Hi {{ $order->user->name }},</p>
    <p>Your order <strong>{{ $order->order_number }}</strong> has been placed successfully.</p>
    <table style="width:100%; border-collapse: collapse; margin: 16px 0;">
        <thead>
            <tr style="background:#f4f4f4;">
                <th style="text-align:left; padding:8px; border:1px solid #ddd;">Product</th>
                <th style="text-align:right; padding:8px; border:1px solid #ddd;">Qty</th>
                <th style="text-align:right; padding:8px; border:1px solid #ddd;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td style="padding:8px; border:1px solid #ddd;">{{ $item->product_name }}</td>
                <td style="text-align:right; padding:8px; border:1px solid #ddd;">{{ $item->quantity }}</td>
                <td style="text-align:right; padding:8px; border:1px solid #ddd;">₱{{ number_format($item->line_total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="text-align:right; padding:8px; font-weight:bold;">Order Total</td>
                <td style="text-align:right; padding:8px; font-weight:bold; border:1px solid #ddd;">₱{{ number_format($order->total, 2) }}</td>
            </tr>
        </tfoot>
    </table>
    <p><strong>Flight:</strong> {{ $order->flight_number }} &mdash; {{ $order->departure_date->format('d M Y') }}</p>
    <p style="color:#888; font-size:12px;">This is a simulated email — logged via MAIL_MAILER=log.</p>
</body>
</html>
