<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    var options = {
        "key": "{{ env('RAZORPAY_KEY_ID') }}",
        "amount": "{{ $amount }}",
        "currency": "INR",
        "name": "{{ $user->name }}",
        "description": "Monthly Fee for {{ \Carbon\Carbon::create()->month($month)->format('F') }}",
        "order_id": "{{ $order_id }}",
        "handler": function (response){

            fetch('{{ route('student.payment.success') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    razorpay_payment_id: response.razorpay_payment_id,
                    razorpay_order_id: response.razorpay_order_id
                })
            }).then(res => window.location.href = "/student/fee/month");
        },
        "theme": {
            "color": "#6777ef"
        }
    };

    var rzp = new Razorpay(options);
    rzp.open();
</script>
