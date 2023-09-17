@include('laravel-common::mail.header')
    <div style="font-size: 28px;line-height: 40px;margin-bottom: 10px;">
        Order Shipped
    </div>
    <div style="margin-bottom: 10px;">Dear {{$order->email}}</div>
    <div>
        <div>We are happy to tell you we have dispatched your order! You can track its progress with the following tracking number:xxxxxx.</div>
        <div>You can also track the delivery of your order yourself here: www.xxxxx.com.
            It usually takes about 30 days for your order arrive, but as this is the shopping season,
            the logistics companies are very busy and some orders may takes lightly longer to arrive.</div>
    </div>

Thank you for your order, [customer name]!

This is to confirm that we shipped your order [order number] on [shipping date]. It should arrive between [earliest arrival date] and [latest delivery date]. If you have any questions, please send us an email at [customer service email address] or call us at [customer service telephone number]. Please include your order number in all communication with us.

Thank you again for your order!

@include('laravel-common::mail.footer')
