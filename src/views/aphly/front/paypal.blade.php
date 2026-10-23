<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PayPal JS SDK Standard Integration</title>
</head>
<body>
<div id="paypal-button-container" class="paypal-button-container"></div>

<script src="https://www.paypal.com/sdk/js?client-id={{$res['ClientID']}}&buyer-country=US&currency=USD&components=buttons&enable-funding=venmo"></script>
<script >
    window.paypal
        .Buttons({
            style: {
                shape: "pill",
                layout: "vertical",
                color: "gold",
                label: "paypal",
            },
            async createOrder() {
                try {
                    const response = await fetch("/paypal/order", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        // use the "body" param to optionally pass additional order information
                        // like product ids and quantities
                        body: JSON.stringify({
                            cart: [
                                {
                                    id: "YOUR_PRODUCT_ID",
                                    quantity: "YOUR_PRODUCT_QUANTITY",
                                },
                            ],
                        }),
                    });
                    const res = await response.json();
                    console.log(res)
                    //
                    if (!res.code) {
                        return res.data.paypal_id;
                    }
                    throw new Error(res.msg);
                } catch (error) {
                    console.error(error);
                }
            },

            async onApprove(data, actions) {
                console.log('onApprove',data, actions)
                try {
                    const response = await fetch(`/paypal/capture`, {
                        method: "POST",
                        body: JSON.stringify({
                            paypal_id: data.orderID,
                        }),
                        headers: {
                            "Content-Type": "application/json",
                        },
                    });
                    const res = await response.json();
                    if(!res.code){
                        throw new Error(`${res.msg}`);
                    }
                    console.log(res)
                    const errorDetail = res.data?.details?.[0];

                    if (errorDetail?.issue === "INSTRUMENT_DECLINED") {
                        // (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                        // recoverable state, per
                        // https://developer.paypal.com/docs/checkout/standard/customize/handle-funding-failures/
                        return actions.restart();
                    } else if (errorDetail) {
                        // (2) Other non-recoverable errors -> Show a failure message
                        throw new Error(`${errorDetail.description} (${res.data.debug_id})`);
                    } else if (!res.data.purchase_units) {
                        throw new Error(JSON.stringify(res.data));
                    } else {
                        // (3) Successful transaction -> Show confirmation or thank you message
                        // Or go to another URL:  actions.redirect('thank_you.html');
                        const transaction =
                            res.data?.purchase_units?.[0]?.payments?.captures?.[0] ||
                            res.data?.purchase_units?.[0]?.payments?.authorizations?.[0];
                        console.log(
                            "Capture result",
                            res.data,
                            JSON.stringify(res.data, null, 2)
                        );
                    }
                } catch (error) {
                    console.error(error);
                }
            },
        })
        .render("#paypal-button-container");
</script>
</body>
</html>
