'use-strict';

function deleteProductAttribute(productAttrId) {
    let apiUrl = '/api/deleteProductAttribute';

    $.ajax({
        url: apiUrl,
        type: 'POST',
        data: {
            'product_attribute_id': productAttrId
        },
        success: function (data) {
            console.log('Risposta API:', data);
        },
        error: function (xhr, status, error) {
            console.error('Errore API:', status, error);
        }
    });
}


function editFieldValue() {

}