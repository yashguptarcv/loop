@extends('checkout::components.layout')

@section('page_title','Checkout')
@section('content')
<div id="notification-container" class="fixed top-1 right-5 z-50 space-y-3"></div>

<div class="max-w-5xl w-full checkout-card rounded-2xl overflow-hidden" id="checkout-container">
    <!-- Header with progress -->
    <!-- @include('checkout::checkout.components.steps') -->

    <!-- Main Content -->
    <div class="p-6 md:p-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Left Column - Form -->
        @include('checkout::checkout.components.billing')

        <!-- Right Column - Order Summary -->
        @include('checkout::checkout.components.items')
    </div>

    <!-- Navigation -->
    <div class="px-6 py-5 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center">
        <a href="{{session('redirect_back', route('customer.dashboard'))}}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition duration-200 flex items-center mb-3 sm:mb-0">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
        <div class="flex items-center text-sm text-gray-500 mr-4">
            <i class="fas fa-lock text-primary mr-1"></i> Secure payment encryption
        </div>

        <div id="payment-detail-action">

        </div>

    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="https://sandbox.web.squarecdn.com/v1/square.js"></script>
<script>
  // Replace with your actual Square Application ID
  const appId = "sandbox-sq0idb-PciqOCN-HwYxO16C7SNG1A"; 
  const locationId = "LRW37RQ8D6FZF"; 

  async function initializeSquare() {
    if (!window.Square) {
      alert("Square.js failed to load");
      return;
    }

    const payments = Square.payments(appId, locationId);

    try {
      const card = await payments.card();
      await card.attach('#card-container');

      const cardButton = document.getElementById('card-button');
      cardButton.addEventListener('click', async function () {
        
        try {
          const result = await card.tokenize();
          if (result.status === 'OK') {
            console.log("Nonce:", result.token);

            const select = document.querySelector("#payment_method");
            const payment = select?.options[select.selectedIndex]?.value;
            
            // send nonce to your backend
            fetch("{{route('api.cart.payment.charge', $order['order_id'])}}", {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
              },
              body: JSON.stringify({
                payment:payment,
                nonce: result.token
              })
            })
            .then(res => res.json())
            .then(data => {
              if (data.success) {
                alert("Payment successful!");
              } else {
                alert("Payment failed: " + data.message);
              }
            });
          } else {
            document.getElementById("card-errors").innerText = result.errors?.[0]?.message || "Payment error";
          }
        } catch (err) {
          console.error(err);
          document.getElementById("card-errors").innerText = "Payment failed. Try again.";
        }
      });
    } catch (e) {
      console.error("Initializing card failed", e);
    }
  }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");
        
        const mutations = {
            applyCoupon() {
                const code = document.querySelector("#coupon-code")?.value;
                if (!code) return notify("Please enter a coupon code", "error");

                if (typeof ceAjax !== "function") return console.error("ceAjax is not defined");

                ceAjax("PUT", "{{ route('api.cart.discount.add', $order['order_id']) }}", {
                    loader: true,
                    data: {
                        coupon_code: code,
                        _token: csrfToken,
                    },
                    callback: function(response) {
                        if (response.success) {
                            notify("Coupon applied successfully", "success")
                            loadCheckout();
                        } else {
                            notify(response.message || "Invalid coupon", "error")
                        }
                    },
                    errorCallback: function() {
                        notify("Error applying coupon", "error")
                    }
                });
            },

            removeCoupon() {
                if (typeof ceAjax !== "function") return console.error("ceAjax is not defined");

                ceAjax("PUT", "{{ route('api.cart.discount.remove') }}", {
                    loader: true,
                    data: {
                        _token: csrfToken,
                    },
                    callback: function(response) {
                        if (response.success) {
                            notify("Coupon removed successfully", "success");
                            loadCheckout();
                        } else {
                            notify(response.message || "Unable to remove coupon", "error");
                        }
                    },
                    errorCallback: function() {
                        notify("Error removing coupon", "error");
                    }
                });
            },

            updateBilling() {
                const payload = {
                    email: document.querySelector("#email")?.value,
                    name: document.querySelector("#first-name")?.value,
                    phone: document.querySelector("#phone")?.value,
                    address_1: document.querySelector("#address")?.value,
                    city: document.querySelector("#city")?.value,
                    postcode: document.querySelector("#zip")?.value,
                    country: document.querySelector('select[name="country"]')?.value,
                    state: document.querySelector('select[name="state"]')?.value,
                    type: 'both',
                    _token: csrfToken,
                };

                if (typeof ceAjax !== "function") return console.error("ceAjax is not defined");

                ceAjax("POST", "{{ route('api.cart.customer.billing_address', Auth::guard('customer')->id()) }}", {
                    loader: true,
                    data: payload,
                    callback: function(response) {
                        if (response.success) {
                            notify("Billing address updated successfully", "success");
                            loadCheckout();
                        } else {
                            notify(response.message || "Failed to update billing address", "error");
                        }
                    },
                    errorCallback: function() {
                        notify("Error updating billing address", "error");
                    }
                });
            },

            payment() {
                const select = document.querySelector("#payment_method");
                const payment = select?.options[select.selectedIndex]?.value;
                if (!payment) return notify("Payment method not selected", "error");

                if (typeof ceAjax !== "function") return console.error("ceAjax is not defined");

                ceAjax('GET', '{{ route("api.cart.payment.payment_form") }}', {
                    loader: true,
                    result_ids: 'payment-detail-action',
                    data: {                        
                        payment_method_id: payment,
                    },
                    callback: function(response) {

                        initializeSquare();
                    },
                    errorCallback: function() {
                        notify('Error removing coupon', 'error');
                    }
                });
            }
        };

        function notify(message, type = "info", duration = 4000) {
            const container = document.getElementById("notification-container");
            if (!container) return;

            // Create wrapper
            const el = document.createElement("div");
            el.className =
                "flex items-start justify-between w-80 max-w-sm px-4 py-3 rounded-xl shadow-lg border transition-all transform opacity-0 translate-x-5";

            // Style based on type
            let colors = {
                success: "bg-green-50 text-green-700 border-green-200",
                error: "bg-red-50 text-red-700 border-red-200",
                warning: "bg-yellow-50 text-yellow-700 border-yellow-200",
                info: "bg-blue-50 text-blue-700 border-blue-200",
            };
            el.className += " " + (colors[type] || colors.info);

            // Message
            const msg = document.createElement("span");
            msg.className = "text-sm font-medium";
            msg.textContent = message;

            // Close button
            const btn = document.createElement("button");
            btn.innerHTML = "&times;";
            btn.className =
                "ml-3 text-lg font-bold leading-none focus:outline-none hover:opacity-70";
            btn.onclick = () => removeNotification(el);

            // Build notification
            el.appendChild(msg);
            el.appendChild(btn);
            container.appendChild(el);

            // Animate in
            setTimeout(() => {
                el.classList.remove("opacity-0", "translate-x-5");
                el.classList.add("opacity-100", "translate-x-0");
            }, 50);

            // Auto remove
            if (duration > 0) {
                setTimeout(() => removeNotification(el), duration);
            }
        }

        // Helper: Remove with animation
        function removeNotification(el) {
            el.classList.remove("opacity-100", "translate-x-0");
            el.classList.add("opacity-0", "translate-x-5");
            setTimeout(() => el.remove(), 300);
        }

        window.loadCheckout = function() {
            const container = document.getElementById("checkout-container");
            if (!container) return;

            if (typeof ceAjax !== "function") return console.error("ceAjax is not defined");

            ceAjax("GET", "{{ route('checkout.confirm') }}", {
                loader: true,
                result_ids: 'checkout-container',
                callback: function(response) {},
                errorCallback: function() {
                    notify("Error applying coupon", "error")
                }
            });

        };

       
        function attachEvents(container) {
            if (!container) return;

            // Apply coupon
            container.querySelector("#apply-coupon-btn")?.addEventListener("click", mutations.applyCoupon);

            // Remove coupon
            container.querySelector("#remove-coupon-btn")?.addEventListener("click", mutations.removeCoupon);

            // Update billing
            container.querySelector("#update-billing-btn")?.addEventListener("click", mutations.updateBilling);

            container.querySelector("#payment_method")?.addEventListener("change", mutations.payment);
        }

        const observer = new MutationObserver(() => {
            const container = document.getElementById("checkout-container");
            attachEvents(container);
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });

        // Initial attach
        attachEvents(document.getElementById("checkout-container"));
    });
</script>


@endsection