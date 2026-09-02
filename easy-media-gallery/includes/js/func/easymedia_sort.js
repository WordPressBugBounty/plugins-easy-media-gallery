jQuery(document).ready(function($) {
    var easymediaList = $('#easymedia_list');
    
    easymediaList.sortable({
        update: function(event, ui) {
            
            var nonceValue = (typeof easymedia_sort_vars !== 'undefined' && easymedia_sort_vars.nonce) ? easymedia_sort_vars.nonce : '';
            var errorText  = (typeof easymedia_sort_vars !== 'undefined' && easymedia_sort_vars.error_msg) ? easymedia_sort_vars.error_msg : 'There was an error saving the update.';

            opts = {
                url: ajaxurl,
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                data:{
                    action: 'easymedia_sort',
                    security: nonceValue,
                    order: easymediaList.sortable('toArray').toString() 
                },
                success: function(response) {
                    return;
                },
                error: function(xhr,textStatus,e) {
                    alert(errorText);
                    return;
                }
            };
            $.ajax(opts);
        }
    });
});