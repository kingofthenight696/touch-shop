var ShelfShop = {};

+function ($, undefined) {
    'use strict';

    ShelfShop = {

        init : function()
        {
            //Initializing the shelf
            ShelfShop.initShelf();

            //If it's not mobile, initializing the pan and zoom feature
            if(!Utils.isMobile()) ShelfShop.initPanZoom();

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
                // console.log(product);
                const productText = product.title + ', $' + product.price;

                //Creating the product markup
                const productMarkup = $('<div/>');
                productMarkup.addClass('shelf__product tooltip');
                //productMarkup.text(productText);
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
                const tooltipLink = tooltip.find('.button');
                tooltip.attr('data-tooltip-base', 'false');
                tooltipText.text(productText);
                tooltipLink.attr('href', cartBaseUrl);
                tooltipLink.data('product_id', product.id);

                //Async functionality to add to cart
                const cart = $('.user-cart');
                const cartItems = cart.find('span');
                tooltipLink.on('click', function(){
                    tooltipLink.addClass('button--ajax-loading');
                    $.post(tooltipLink.attr('href'), {'product_id': product.id, 'quantity': 1} )
                        .done(function(response){
                            cartItems.text(cartItems.text() * 1 + 1);
                        })
                        .always(function(){
                            tooltipLink.removeClass('button--ajax-loading');
                        });
                    return false;
                });

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

        /*
            Initializes the pan-zoom plug-in.
         */
        initPanZoom : function()
        {
            const shelf = $('.shelf');
            const shelfElement = shelf[0];
            const shelfImage = $('.shelf__image');
            const shelfImageElement = shelfImage[0];
            const shelfZoom = $('.shelf__zoom');

            const handleDoubleClick = function(e)
            {
                const shelfZoomOffset = shelfZoom.offset();
                const insideVertically = e.pageY >= shelfZoomOffset.top && e.pageY <= shelfZoomOffset.top + shelfZoom.height();
                const insideHorizontally = e.pageX >= shelfZoomOffset.left && e.pageX <= shelfZoomOffset.left + shelfZoom.width();

                return insideVertically && insideHorizontally;
            };

            //Initiating the Panzoom
            const instance = panzoom(shelfImageElement, {
                maxZoom: 5,
                minZoom: 1,
                boundBox: shelfElement,
                onDoubleClick: handleDoubleClick,
                zoomWithoutPan : false
            });

            let removeMovingClassPointer = null;
            const removeMovingClassDelay = 3000;
            shelf.on('mousemove', function(){
                shelfZoom.addClass('shelf__zoom--visible');
                if(removeMovingClassPointer){
                    clearTimeout(removeMovingClassPointer);
                }
                removeMovingClassPointer = setTimeout(function(){
                    shelfZoom.removeClass('shelf__zoom--visible');
                }, removeMovingClassDelay);
            });

            const shelfZoomMinus = $('.shelf__zoom-minus');
            const shelfZoomPlus = $('.shelf__zoom-plus');
            const zoom = function(e, direction){
                const shelfHeightHalf = shelf.height() / 2;
                const shelfWidthHalf = shelf.width() / 2;
                if(direction == 'plus'){
                    instance.smoothZoom(shelfWidthHalf, shelfHeightHalf, 1.5);
                }else{
                    instance.smoothZoom(shelfWidthHalf, shelfHeightHalf, 0.5);
                }
            };
            shelfZoomMinus.on('click', function(e){
                zoom(e, 'minus');
                return false;
            });
            shelfZoomPlus.on('click', function(e){
                zoom(e, 'plus');
                return false;
            });

            //Resize support. Without this code if the image is zoomed out when resizing could end up out of boundaries.
            $( window ).resize(function() {
                instance.moveBy(0, 0);
            });
        }

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
