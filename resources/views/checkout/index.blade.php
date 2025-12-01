<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pagamento</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #06080c;
            color: #fff;
        }
        .container {
            max-width: 500px;
            background: #0b0e14;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
        }
        h2 {
            color: #52aaff;
            font-weight: 700;
        }
        .StripeElement {
            padding: 10px;
            border: 1px solid #2d3748;
            border-radius: 4px;
            background: #1a202c;
            color: #fff;
            margin-bottom: 20px;
        }
        .StripeElement--focus {
            box-shadow: 0 0 0 0.2rem rgba(82, 170, 255, 0.25);
        }
        .btn-success {
            background-color: #2b5df5;
            border-color: #2b5df5;
            font-weight: bold;
        }
        .btn-success:hover {
            background-color: #1e4bd4;
            border-color: #1e4bd4;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Finalizar Pagamento</h2>

    <form id="payment-form" action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div id="card-element"></div>
        <div id="card-errors" class="text-danger mb-3"></div>
        {{-- MUDANÇA AQUI: type="button" para evitar submissão padrão --}}
        <button id="submit" type="button" class="btn btn-success w-100">Pagar</button>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const submitButton = document.getElementById('submit');
    const form = document.getElementById('payment-form');
    const cardErrorsElement = document.getElementById('card-errors');
    
    // VARIÁVEIS DO PHP
    const stripeKey = '{{ $stripeKey }}';
    const clientSecret = '{{ $clientSecret }}';

    // ==========================================================
    // DIAGNÓSTICO DE CHAVES (PASSOS 1 e 2)
    // ==========================================================
    if (!stripeKey || stripeKey.length < 10) {
        // Se a chave Stripe for inválida ou vazia, alertar e parar.
        cardErrorsElement.textContent = "ERRO FATAL: Chave pública do Stripe (stripeKey) não carregada. Verifique .env e config/services.php.";
        console.error("ERRO FATAL DE CHAVE: stripeKey está vazia ou incorreta.");
        return; 
    }
    
    if (!clientSecret || clientSecret.length < 10) {
        // Se o clientSecret falhar, geralmente é erro do Controller/Stripe
        cardErrorsElement.textContent = "ERRO FATAL: clientSecret do Stripe não carregado. Verifique a configuração do seu CheckoutController.";
        console.error("ERRO FATAL DE CLIENT SECRET: clientSecret está vazia ou incorreta.");
        return; 
    }
    
    // Verifica se o formulário e o botão existem (prevenindo o erro 'null')
    if (!submitButton || !form) {
        cardErrorsElement.textContent = "ERRO FATAL DE JS: Elementos do formulário não encontrados.";
        console.error("ERRO FATAL DE JS: O formulário ou o botão 'submit' não foram encontrados na página.");
        return;
    }
    
    // Inicialização do Stripe
    const stripe = Stripe(stripeKey);
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');
    
    // Tratamento de Erro do Card
    card.on('change', function(event) {
        cardErrorsElement.textContent = event.error ? event.error.message : '';
    });

    // Função de Submissão que agora é chamada diretamente pelo clique
    function handleFormSubmission(ev) {
        submitButton.disabled = true;
        cardErrorsElement.textContent = 'Processando pagamento...';

        stripe.confirmCardPayment(clientSecret, {
            payment_method: {
                card: card,
                billing_details: {
                    name: 'Cliente Teste'
                }
            }
        }).then(function(result) {
            
            if (result.error) {
                // Erro no pagamento Stripe
                console.error('Erro no Stripe PaymentIntent:', result.error);
                cardErrorsElement.textContent = result.error.message;
                submitButton.disabled = false;

            } else if (result.paymentIntent.status === 'succeeded') {
                
                // Pagamento bem-sucedido, finalize o pedido no Laravel
                console.log('Stripe Payment Succeeded. Finalizando pedido no servidor...');
                cardErrorsElement.textContent = 'Pagamento aprovado. Finalizando pedido...';
                
                // Envia requisição para a rota checkout.store
                fetch("{{ route('checkout.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({})
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.error || `Erro do Servidor (Status ${response.status})`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Usa a URL de redirect enviada pelo Controller no JSON
                    if (data.redirect) {
                        console.log('Pedido finalizado com sucesso. Redirecionando para:', data.redirect);
                        window.location.href = data.redirect;
                    } else {
                        cardErrorsElement.textContent = "Erro: Pedido salvo, mas sem URL de redirecionamento.";
                        submitButton.disabled = false;
                    }
                })
                .catch(error => {
                    // Captura erros de rede ou a exceção lançada
                    console.error('Erro ao finalizar o pedido:', error);
                    cardErrorsElement.textContent = `Falha ao salvar o pedido: ${error.message}`;
                    submitButton.disabled = false;
                });

            } else {
                // Outro status do PaymentIntent
                console.log('PaymentIntent Status:', result.paymentIntent.status);
                cardErrorsElement.textContent = `Status de pagamento inesperado: ${result.paymentIntent.status}`;
                submitButton.disabled = false;
            }
        });
    }

    // Anexar o evento diretamente ao botão de clique
    submitButton.addEventListener('click', handleFormSubmission);
});
</script>
</body>
</html>