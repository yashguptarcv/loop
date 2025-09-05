<script src="https://js.stripe.com/v3/"></script>
<script>
async function pay() {
    const response = await fetch('/stripe/payment-intent', {
        method: 'POST',
        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
        body: JSON.stringify({ amount: 100, order_id: 123 })
    });
    const data = await response.json();

    const stripe = Stripe("{{ config('services.stripe.key') }}");
    const result = await stripe.confirmCardPayment(data.clientSecret, {
        payment_method: {
            card: {
                // mount a card element or pass card token here
            }
        }
    });

    if (result.error) {
        alert(result.error.message);
    } else if (result.paymentIntent.status === 'succeeded') {
        alert("Payment successful!");
    }
}
</script>
