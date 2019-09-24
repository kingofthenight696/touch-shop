$(function(){

    $('img#board').imgAreaSelect({
        handles: true,
        onSelectEnd: function (img, selection) {
            $('#myModal .top').val(selection.top);
            $('#myModal .left').val(selection.left);
            $('#myModal .width').val(selection.width);
            $('#myModal .height').val(selection.height);
            $('#myModal').modal('show');

            // alert('width: ' + selection.width + '; height: ' + selection.height);
        }
    });

    $(document).on('click', '#add-product', function (event) {
        let formData = new FormData($('#add-product').closest('form'));
        $.post('/product/add', formData)
            .done(function(response){
                $('#product-row-template').tmpl(response).appendTo('#product-table');
            })
            .error(function(error){
                alert(error.message);
            });
    });
    ShelfShop.init();
    // $(function(){

    // });
});
