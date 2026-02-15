async function confirmSalesOrder(event) {
    event.preventDefault();
    const form = event.target;
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;

    // Validation
    const productSelect = document.getElementById('newItemProduct');
    const qtyInput = document.getElementById('newItemQty');
    const deliveryDate = form.querySelector('[name="delivery_date"]');
    const customerSelect = form.querySelector('[name="customer_id"]');

    if (!customerSelect.value) {
        showErrorNotification('Please select a customer.');
        return false;
    }
    if (!deliveryDate.value) {
        showErrorNotification('Please select a delivery date.');
        return false;
    }
    if (!productSelect.value) {
        showErrorNotification('Please select a product.');
        return false;
    }
    if (!qtyInput.value || qtyInput.value < 1) {
        showErrorNotification('Quantity must be at least 1.');
        return false;
    }

    // Show loading
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Creating...';

    try {
        const formData = new FormData(form);
        // Check header meta for csrf token
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showSuccessNotification(data.message);
            closeModal('newOrderModal');
            form.reset();

            // Reset dynamic fields
            if (document.getElementById('newItemUnitPrice')) document.getElementById('newItemUnitPrice').value = '';
            if (document.getElementById('newItemLineTotal')) document.getElementById('newItemLineTotal').textContent = '₱0.00';

            // Insert new row
            const tbody = document.getElementById('salesTbody');
            // Insert at the top
            const noMatch = document.getElementById('salesNoMatch');
            if (noMatch) noMatch.classList.add('hidden');

            // If empty row exists (when no orders), remove it or hide it
            const firstRow = tbody.querySelector('tr');
            if (firstRow && firstRow.children.length === 1 && firstRow.innerText.includes('No orders yet')) {
                firstRow.remove();
            }

            tbody.insertAdjacentHTML('afterbegin', data.html);

        } else {
            showErrorNotification(data.message || 'Error creating order');
        }
    } catch (error) {
        console.error(error);
        showErrorNotification('An error occurred. Please try again.');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    }

    return false;
}
