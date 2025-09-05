<!-- Include Square Payments SDK -->
<script type="text/javascript" src="https://sandbox.web.squarecdn.com/v1/square.js"></script>

<form id="payment-form" method="post">
  <!-- Card input container -->
  <div id="card-container" class="mb-4"></div>

  <!-- Error message container -->
  <div id="card-errors" class="text-red-600 text-sm mb-2"></div>

  <!-- Pay button -->
  <button 
    id="card-button"
    type="button"
    class="px-5 py-2.5 text-sm font-medium text-white gradient-bg rounded-lg hover:opacity-90 transition duration-200 flex items-center shadow-md hover:shadow-lg">
    Pay
  </button>
</form>



