@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="fw-bold mb-4 text-center">Checkout</h1>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif
                    <form id="payment-form" action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="users" class="form-label">Number of Users</label>
                            <input type="number" class="form-control" id="users" name="users" min="1" value="1" required>
                            <div class="form-text">First user is free. Each additional user is £10/month.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Card Details</label>
                            <div id="card-element" class="form-control p-0"></div>
                        </div>
                        <input type="hidden" name="payment_method_id" id="payment_method_id">
                        <div class="mb-3">
                            <label for="cardholder_name" class="form-label">Cardholder Name</label>
                            <input type="text" class="form-control" id="cardholder_name" name="cardholder_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="billing_email" class="form-label">Billing Email</label>
                            <input type="email" class="form-control" id="billing_email" name="billing_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="billing_address" class="form-label">Billing Address</label>
                            <input type="text" class="form-control" id="billing_address" name="billing_address" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total</label>
                            <div id="total" class="fw-bold">£0/month</div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" id="pay-btn">Complete Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://js.stripe.com/v3/"></script>
<script>
const stripe = Stripe("{{ $stripeKey }}");
const elements = stripe.elements();
const card = elements.create('card');
card.mount('#card-element');
const form = document.getElementById('payment-form');
const payBtn = document.getElementById('pay-btn');
form.addEventListener('submit', async function(e) {
    e.preventDefault();
    payBtn.disabled = true;
    const {paymentMethod, error} = await stripe.createPaymentMethod({
        type: 'card',
        card: card,
        billing_details: {
            name: document.getElementById('cardholder_name').value,
            email: document.getElementById('billing_email').value,
            address: { line1: document.getElementById('billing_address').value }
        }
    });
    if (error) {
        alert(error.message);
        payBtn.disabled = false;
        return;
    }
    document.getElementById('payment_method_id').value = paymentMethod.id;
    form.submit();
});
const usersInput = document.getElementById('users');
const totalDiv = document.getElementById('total');
function updateTotal() {
  const users = parseInt(usersInput.value) || 1;
  const total = users > 1 ? '£' + ((users-1)*10) + '/month' : '£0/month';
  totalDiv.textContent = total;
}
usersInput && usersInput.addEventListener('input', updateTotal);
updateTotal();
</script>
@endsection
