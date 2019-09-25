var ShelfShop = {};

+function ($, undefined) {
    'use strict';

    ShelfShop = {

        init : function()
        {
            //Initializing the shelf
            ShelfShop.initShelf();

            //If it's not mobile, initializing the pan and zoom feature
            // if(!Utils.isMobile()) ShelfShop.initPanZoom();

            //Initializing the products markup and tooltips
            ShelfShop.initProductsTooltips();
        },

        /*
            Lazy loading of a high-res version of the shelf image, whilst a low-res version is displayed.
        */
        initShelf : function()
        {
            const shelfImage = $('.shelf__image');
            const shelfImageImg = shelfImage.find('img');
            const shelfImageFullUrl = shelfImageImg.attr('data-full-src');
            const imageTemp = $('<img/>');

            //After the low-res image has loaded, start loading the high-res
            shelfImageImg.one('load', function(){
                imageTemp.attr('src', shelfImageFullUrl);
            }).each(function(){
                if(this.complete) $(this).trigger('load');
            });

            //After the high-res image has loaded, show it (instead of the low-res)
            imageTemp.on('load', function(){
                shelfImageImg.attr('src', shelfImageFullUrl);
            });

        },

        /*
            Requesting for products and assigning the callback to product creation.
         */
        initProductsTooltips : function()
        {
            if(board == undefined){
                console.log('Empty response when trying to fetch the products.');
            }
            else if(board.products.length == 0){
                console.log('No products found for this shelf.');
            }
            else{
                ShelfShop.createProductsTooltips(board.products);
            }

        },

        /*
            Based on a list of products creates the HTML markup and initializes the tooltips.
         */
        createProductsTooltips : function(products)
        {
            const shelf = $('.shelf');
            const shelfImage = $('.shelf__image');
            const cartBaseUrl = 'cart/add';

            products.forEach(function(product)
            {
                const productText = product.title + ', $' + product.price;

                //Creating the product markup
                const productMarkup = $('<div/>');
                productMarkup.addClass(`shelf__product tooltip product-${product.id}`);
                productMarkup.css({
                    top : product.coordinates.top + 'px',
                    left : product.coordinates.left + 'px',
                    height : product.coordinates.height + 'px',
                    width : product.coordinates.width + 'px'
                });
                shelfImage.append(productMarkup);

                //Creating the tooltip markup
                const tooltipTemplates = $('.tooltip_templates');
                const tooltipTemplate = tooltipTemplates.find('[data-tooltip-base=true]');
                const tooltip = tooltipTemplate.clone();
                const tooltipText = tooltip.find('.shelf__tooltip__text');
                const tooltipEditBtn = tooltip.find('.product-edit');
                const tooltipDeleteBtn = tooltip.find('.product-remove');
                tooltip.attr('data-tooltip-base', 'false');
                tooltipText.text(productText);
                tooltipEditBtn.data('product-id', product.id);
                tooltipDeleteBtn.data('product-id', product.id);

                if(Utils.isMobile())
                {
                    productMarkup.tooltipster({
                        trigger: 'click',
                        interactive: true,
                        contentAsHTML : true,
                        functionBefore: function(instance, helper){
                            instance.content(tooltip);
                            $(helper.origin).addClass('shelf__product--active');
                        },
                        functionReady : function(instance, helper){
                            $(helper.tooltip).addClass('shelf__tooltip');
                        },
                        functionAfter: function(instance, helper){
                            $(helper.origin).removeClass('shelf__product--active');
                        }
                    });
                }
                else
                {
                    productMarkup.tooltipster({
                        trigger: 'hover',
                        interactive: true,
                        contentAsHTML : true,
                        functionBefore: function(instance, helper){
                            instance.content(tooltip);
                        },
                        functionReady : function(instance, helper){
                            $(helper.tooltip).addClass('shelf__tooltip');
                        }
                    });
                }
            });
        },
    };

    $('.count').prop('disabled', true);
    $(document).on('click', '.qty .plus', function(){
        let counter = $(this).parent().find('input');
        let count  =  parseInt(counter.val()) ;
        count++;
        let product_id  =  $(this).parent().find('input').data('product_id');
        $.post('/cart/add', {'product_id': product_id, 'quantity': count})
            .done(function(response){
                counter.val(count);
                updateCart(response);
            });
    });
    $(document).on('click','.minus', function(){
        let counter = $(this).parent().find('input');
        let count  =  parseInt(counter.val()) ;
        count--;
        let product_id  =  $(this).parent().find('input').data('product_id');
        $.post('/cart/add', {'product_id': product_id, 'quantity': count})
            .done(function(response){
                counter.val(count);
                updateCart(response);
            });
    });

    function updateCart(cart) {
        $('.total_price').text(cart.total_price);
        $('.user-cart span').text(cart.total_quantity);
    }

}(jQuery);


$(function(){

    let shelf = $('img#board').imgAreaSelect({
        instance: true,
        handles: true,
        onSelectEnd: function (img, selection) {

            const modal = $('#product-modal');
            const form = $('.product-form');
            const board_id = $('.shelf').data('board-id');

            form.trigger("reset");
            modal.find('.modal-title').text(formActions.add.formTitle);
            modal.find('.product-save').text(formActions.add.actionButtonTitle);
            modal.find('.board-id').val(board_id);
            form.data('action', 'add');

            modal.find('.top').val(selection.y1);
            modal.find('.left').val(selection.x1);
            modal.find('.width').val(selection.width);
            modal.find('.height').val(selection.height);
            modal.modal('show');
        }
    });

    const formActions = {
        "edit": {
            "formTitle": "Edit product",
            "actionButtonTitle": "Save",
            "route": "/product/edit/",
        },
        "add": {
            "formTitle": "Add product ",
            "actionButtonTitle": "Add",
            "route": "/product/add",
        },
    };
    $('#product-modal').on('hide.bs.modal', function (e) {
        shelf.cancelSelection();
    });

    $(document).on('click', '.product-edit', function (event) {
        let productId = $(this).data('product-id');

        $.get(`/product/${productId}`)
            .then((response) => {

                let data = response.data;
                const modal = $('#product-modal');

                modal.find('.modal-title').text(formActions.edit.formTitle);
                modal.find('.product-save').text(formActions.edit.actionButtonTitle);
                modal.find('.product-form').data('action', 'edit');

                modal.find('.product-form').data('product-id', productId);
                modal.find('.top').val(data.coordinates.top);
                modal.find('.left').val(data.coordinates.left);
                modal.find('.width').val(data.coordinates.width);
                modal.find('.height').val(data.coordinates.height);

                modal.find('.board-id').val(data.board_id);
                modal.find('.product-title').val(data.title);
                modal.find('.product-description').val(data.description);
                modal.find('.product-price').val(data.price);

                modal.modal('show');
            });
    });

    //save product
    $(document).on('click', '.product-save', function (e) {
        const form = $('.product-form');
        const productId = form.data('product-id');

        const route = (form.data('action') === 'edit')
            ? `${formActions.edit.route}${productId}`
            : formActions.add.route;

        $.post(route, form.serialize())
            .done(function(response){
                $('#product-modal').modal('hide');
            });
        location.reload();

    });

    //ask product remove
    $(document).on('click', '.product-remove', function (event) {
        const productId = $(this).data('product-id');
        const modal = $('#product-remove-modal');

        modal.find('.product-remove-yes').data('product-id', productId);
        modal.modal('show');
    });

    //confirm product remove
    $(document).on('click', '.product-remove-yes', function (e) {
        let productId = $(this).data('product-id');

        $.post(`/product/delete/${productId}`)
            .then((response) =>{
                $('#product-remove-modal').modal('hide');
        });
        location.reload();
    });

    $( "#showToast" ).click(function() {
        $('.toast').toast('show');
    });

    //Hover shelf product
    $('.product-search').hover(function(e) {

            let productId = $(this).data('product-id');

            $(`.shelf__product.product-${productId}`).trigger(e.type).addClass('shelf-product-hover');
        },
        function(e){
            let productId = $(this).data('product-id');

            $(`.shelf__product.product-${productId}`).trigger(e.type).removeClass('shelf-product-hover');
        });

    ShelfShop.init();
});
