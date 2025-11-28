@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">Finalizar Pagamento</h2>

    @if(Cart::getContent()->count() === 0)
        <div class="alert alert-warning">
            Seu carrinho está vazio. <a href="{{ route('filmes.index') }}">Ver filmes</a>
        </div>
    @else
        <form id="payment-form">
            <div id="card-element" class="StripeElement"></div>
            <div id="card-errors" role="alert" class="text-danger mt-2"></div>
            <button id="submit" class="btn btn-primary mt-3 w-100">Pagar R$ {{ number_format(Cart::getTotal(), 2, ',', '.') }}</button>
        </form>
    @endif
</div>

<style>
.StripeElement {
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background: white;
}
#card-errors {
    margin-top: 10px;
}
</style>

<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stripe = Stripe('{{ $stripeKey }}');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit');
    const clientSecret = "{{ $clientSecret }}";

    card.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        displayError.textContent = event.error ? event.error.message : '';
    });

    form?.addEventListener('submit', function(ev) {
        ev.preventDefault();
        submitButton.disabled = true;

        stripe.confirmCardPayment(clientSecret, {
            payment_method: {
                card: card,
                billing_details: { name: '{{ auth()->user()->name ?? "Cliente" }}' }
            }
        }).then(function(result) {
            if (result.error) {
                // Erro no pagamento
                document.getElementById('card-errors').textContent = result.error.message;
                submitButton.disabled = false;
            } else if (result.paymentIntent && result.paymentIntent.status === 'succeeded') {
                // Pagamento aprovado → envia para backend
                fetch('{{ route('checkout.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Pedido finalizado com sucesso!');
                        window.location.href = '{{ route("orders.index") }}';
                    } else {
                        alert(data.message || 'Erro ao salvar pedido. Tente novamente.');
                        submitButton.disabled = false;
                    }
                })
                .catch(() => {
                    alert('Erro ao salvar pedido. Tente novamente.');
                    submitButton.disabled = false;
                });
            }
        });
    });
});
</script>
@endsection
