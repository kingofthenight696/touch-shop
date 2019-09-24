$(function(){

    $('img#board').imgAreaSelect({
        handles: true,
        onSelectEnd: function (img, selection) {
            $('#myModal').modal('show');

            // alert('width: ' + selection.width + '; height: ' + selection.height);
        }
    });

    $(document).on('click', '#add-product', function () {
        $.post('/product/add', {'product_id': product.id, 'quantity': 1} )
            .done(function(response){
                //TODO append product to table
            })
            .error(function(error){
                alert(error.message);
            });
    });
    ShelfShop.init();
    // $(function(){

    // });
});
