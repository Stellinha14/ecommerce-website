@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Finalizar Pagamento</h2>

    <form id="payment-form">
        @csrf
        <div id="card-element" class="StripeElement"></div>
        <div id="card-errors" role="alert" style="color:red; margin-top:10px;"></div>
        <button type="submit" id="submit" class="btn btn-primary mt-3">Pagar R$ {{ number_format(Cart::getTotal(), 2, ',', '.') }}</button>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
const stripe = Stripe('{{ $stripeKey }}');
const elements = stripe.elements();
const card = elements.create('card');
card.mount('#card-element');

card.on('change', function(event) {
    document.getElementById('card-errors').textContent = event.error ? event.error.message : '';
});

const form = document.getElementById('payment-form');
form.addEventListener('submit', async function(ev) {
    ev.preventDefault();
    document.getElementById('submit').disabled = true;

    const { paymentIntent, error } = await stripe.confirmCardPayment(
        "{{ $clientSecret }}",
        {
            payment_method: {
                card: card,
                billing_details: { name: "{{ auth()->user()->name }}" }
            }
        }
    );

    if (error) {
        document.getElementById('card-errors').textContent = error.message;
        document.getElementById('submit').disabled = false;
    } else if (paymentIntent.status === 'succeeded') {
        // Chama backend para salvar pedido
        fetch('{{ route('checkout.store') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                alert('Pedido finalizado com sucesso!');
                window.location.href = '{{ route("orders.index") }}';
            } else {
                alert('Erro ao salvar pedido.');
                document.getElementById('submit').disabled = false;
            }
        })
        .catch(() => {
            alert('Erro na comunicação com o servidor.');
            document.getElementById('submit').disabled = false;
        });
    }
});
</script>
@endsection
