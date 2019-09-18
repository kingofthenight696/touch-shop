var Utils = {};

+function ($, undefined) {
    'use strict';

    Utils = {
        isMobile : function(){
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        }
    }

}(jQuery);
