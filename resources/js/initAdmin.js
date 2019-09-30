var ShelfShop = {};

+function ($, undefined) {
    'use strict';

    ShelfShop = {

        init : function()
        {
            //Initializing the shelf
            ShelfShop.initShelf();

            //If it's not mobile, initializing the pan and zoom feature
            // if(!Utils.isMobile())
            // ShelfShop.initPanZoom();

            if(!Utils.isMobile()){
                $(document).on('mouseover', '.shelf__product', function() {
                    $(this).addClass('shelf-product-hover-big')
                }).on('mouseleave', '.shelf__product', function() {
                    $(this).removeClass('shelf-product-hover-big')
                });
            }

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
                    top : product.coordinates.top + '%',
                    left : product.coordinates.left + '%',
                    height : product.coordinates.height + '%',
                    width : product.coordinates.width + '%'
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
                        trigger: 'custom',
                        triggerOpen: {
                            mouseenter: true,
                            touchstart: true
                        },
                        triggerClose: {
                            click: true,
                            scroll: true,
                            tap: true
                        },
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
                        trigger: 'custom',
                        triggerOpen: {
                            click: true,
                            mouseenter: true
                        },
                        triggerClose: {
                            mouseleave: true,
                        },
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
    $('img#board').one('load',function() {

        let shelfElement = $('img#board');
        let shelfWidth = shelfElement.width();
        let shelfHeight = shelfElement.height();

        let shelf = $('img#board').imgAreaSelect({
            instance: true,
            handles: true,
            onSelectEnd: function (img, selection) {

                const shelfTopPercent =  selection.y1 * 100 / shelfHeight;
                const shelfLeftPercent =  selection.x1 * 100 / shelfWidth;

                const shelfWidthPercent =  selection.width * 100 / shelfWidth;
                const shelfHeightPercent =  selection.height * 100 / shelfHeight;

                const modal = $('#product-modal');
                const form = $('.product-form');
                const board_id = $('.shelf').data('board-id');

                form.trigger("reset");
                modal.find('.modal-title').text(formActions.add.formTitle);
                modal.find('.product-save').text(formActions.add.actionButtonTitle);
                modal.find('.board-id').val(board_id);
                form.data('action', 'add');

                modal.find('.top').val(shelfTopPercent);
                modal.find('.left').val(shelfLeftPercent);
                modal.find('.width').val(shelfWidthPercent);
                modal.find('.height').val(shelfHeightPercent);
                modal.modal('show');
            }
        });

        $('#product-modal').on('hide.bs.modal', function (e) {
            shelf.cancelSelection();
        });
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

    $(document).on('click', 'button.product-upload', function (event) {
        $('input.product-upload').click();
    });

    $('input.product-upload').change(function (event) {

        let file_data =  $('input.product-upload').prop('files')[0];
        let form_data = new FormData();
        let form = $('form.product-upload');
        form_data.append('file', file_data);
        $.ajax({
            url: '/product/upload', // point to server-side PHP script
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
        }).done((response) => {
            console.log(response);
            form.trigger("reset");
        });
    });

    $(document).on('click', 'button.board-upload', function (event) {
        $('input.board-upload').click();
    });

    $('input.board-upload').change(function (event) {

        let file_data =  $('input.board-upload').prop('files')[0];
        let form_data = new FormData();
        form_data.append('board', file_data);

        $.ajax({
            url: '/board/upload', // point to server-side PHP script
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
        }).done((response) => {
            location.reload();
        });
    });

    //save product
    $(document).on('click', '.product-save', function (e) {
        const form = $('.product-form');
        const productId = form.data('product-id');
        const serializedData = form.serialize();
        const route = (form.data('action') === 'edit')
            ? `${formActions.edit.route}${productId}`
            : formActions.add.route;
            $.post(route, serializedData)
                .done(function(response){
                    $('#product-modal').modal('hide');

                    location.reload();
                });
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
            .then((response) => {
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

            $(`.shelf__product.product-${productId}`).trigger(e.type)
                .addClass('shelf-product-hover');
        },
        function(e){
            let productId = $(this).data('product-id');

            $(`.shelf__product.product-${productId}`).trigger(e.type)
                .removeClass('shelf-product-hover');
        });

    $("form.product-form").validate({
        rules: {
            'title': {
                required: true,
                minlength: 3
            },
            'description': {
                required: true,
                minlength: 1
            },
            'price': {
                required: true,
                minlength: 1
            },
        },
        messages: {
            'title': {
                required: "Please enter some data",
                minlength: "Your data must be at least 8 characters"
            },
            'description': {
                required: "Please enter some data",
                minlength: "Your data must be at least 8 characters"
            },
            'price': {
                required: "Please enter some data",
                minlength: "Your data must be at least 8 characters"
            },
        }
    });

    ShelfShop.init();
});
