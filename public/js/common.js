
function addToCart(productId, isSizeRequired = 0) {
    var size_id = $('#product-size').val();
    var qty = parseInt($('#quantity').val(), 10);
    var inventoryQty = parseInt($('#inventory-qty').val(), 10);

    $('#size-err').text('');
    if(inventoryQty <= 0){
        $('#size-err').text('Sold Out');

        return false;
    }

    if(inventoryQty < qty){
        var errText = 'Only ' + inventoryQty + ' quantity left for this size.';
        $('#size-err').text(errText);

        return false;
    }
    
    if(isSizeRequired == 1){
        if(size_id == ''){
            $('#size-err').text('Please select a size');
    
            return false;
        }
    }

    $.ajax({
        url: addToCartUrl,
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            product_id: productId,
            size_id: size_id,
            quantity: qty, // Example: Adding 1 quantity
        },
        success: function (response) {
            if (response.status === "success") {
                alert(response.message);
                location.reload();
                // Optionally update cart icon or UI
            } else {
                alert(response.message);
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            alert("Something went wrong! Please try again.");
        },
    });
}

function getProductInventory(invId){
    $('#size-err').text('');
    $.ajax({
        url: getProductInventoryUrl,
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            invId: invId
        },
        success: function (response) {
            $('#inventory-qty').val(response.inventory);
            if(response.inventory <= 0){
                $('#size-err').text('Sold Out');
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            alert("Something went wrong! Please try again.");
        },
    });
}

function updateCart(itemId, quantity) {
    $.ajax({
        url: updateCartUrl,
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            itemId: itemId,
            quantity: quantity, // Example: Adding 1 quantity
        },
        success: function (response) {
            if (response.status === "success") {
                // alert(response.message);
                location.reload();
                // Optionally update cart icon or UI
            } else {
                alert(response.message);

                location.reload();
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            alert("Something went wrong! Please try again.");
        },
    });
}

function changeQty(action) {
    var quantity = parseInt($('#quantity').val());

    if (action === 'plus') {
        // Increase the quantity by 1
        quantity++;
    } else if (action === 'minus' && quantity > 1) {
        // Decrease the quantity by 1 (but not below 1)
        quantity--;
    }

    // Set the updated quantity back to the input field
    $('#quantity').val(quantity);
}

// Ensure quantity cannot be manually set to less than 1
$('#quantity').on('input', function () {
    var value = parseInt($(this).val());
    if (isNaN(value) || value < 1) {
        $(this).val(1);
    }
});

function copyAddress() {
    const isChecked = document.getElementById('address_same').checked;

    if (isChecked) {
        // Copy values from Shipping to Billing
        document.getElementById('billing_street_address').value = document.getElementById('shipping_street_address').value;
        document.getElementById('billing_postal_code').value = document.getElementById('shipping_postal_code').value;
		let billingStateId = $('#shipping_state_id').val();
		let billingCityId = $('#shipping_city_id').val();
		
		$('#billing_state_id').val(billingStateId).trigger('change');
		
		setTimeout(() => {
        	$('#billing_city_id').val(billingCityId);
        }, 700);
		
		
    } else {
        // Clear Billing fields if checkbox is unchecked
        document.getElementById('billing_street_address').value = '';
		$('#billing_state_id').val('');
		$('#billing_city_id').val('');
        //document.getElementById('billing_city').value = '';
        //document.getElementById('billing_state').value = '';
        document.getElementById('billing_postal_code').value = '';
    }
}


function changeImg(obj){
    let imageUrl = $(obj).data('image');
    $('#main-image').attr('src', imageUrl);
}

function applyPromocode(){
    var errField = $('#promo-error');
    var successField = $('#promo-success');
    var promocode = $('#promocode').val();
    var subTotal = $('#subtotal').val();
    var shippingCharge = $('#shipping_charge').val();
    var taxAmount = $('#tax_amount').val();

    errField.text('');
    successField.text('');
    if(promocode == ''){
        errField.text('Enter Promocode');

        return false;
    }

    $.ajax({
        url: applyPromocodeUrl,
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            subTotal: subTotal,
            promocode: promocode
        },
        success: function (response) {
            if (response.status === "success") {
                var discount = parseFloat(response.discount);
                var subTotalWithDiscount = parseFloat(response.final_amount);
                var totalAmount = parseFloat(subTotalWithDiscount) + parseFloat(shippingCharge) + parseFloat(taxAmount);

                $('#promocode_id').val(response.promocode_id);
                $('#discount_amount').val(discount.toFixed(2));
                $('#discount_amount_text').text(discount.toFixed(2));
                $('#total_amount').val(totalAmount.toFixed(2));
                $('#total_amount_text').text(totalAmount.toFixed(2));

                successField.text(response.message);
            } else {
                var totalAmount = parseFloat(subTotal) + parseFloat(shippingCharge) + parseFloat(taxAmount);

                $('#promocode_id').val('');
                $('#discount_amount').val(0);
                $('#discount_amount_text').text("0.00");
                $('#total_amount').val(totalAmount.toFixed(2));
                $('#total_amount_text').text(totalAmount.toFixed(2));

                errField.text(response.message);
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            alert("Something went wrong! Please try again.");
        },
    });
}
