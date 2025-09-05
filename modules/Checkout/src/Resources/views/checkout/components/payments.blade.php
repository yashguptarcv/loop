<select name="payment_method" id="payment_method" class="mt-6 w-full px-4 py-3 border border-gray-200 rounded-lg input-focus focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200">
    <option value="">Select Payment</option>
    @foreach(fn_get_payments() as $payment)
    @if((!empty($order['total']) && $order['total']) >= $payment->amount)
    <option value="{{$payment->payment_method_id}}" data-payment-code="{{$payment->payment_method_id}}">{{$payment->merchant_name}}</option>
    @endif
    @endforeach
</select>