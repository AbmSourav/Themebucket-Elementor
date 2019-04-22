;(function($) {
    $(document).ready(function() {
            
        $("#horizontal").twentytwenty({
            default_offset_pct   : 0.6,
            orientation          : 'horizontal',
            before_label         : 'Before',
            after_label          : 'After',
            move_slider_on_hover : false,
            move_with_handle_only: true,
            click_to_move        : false
        });

        $("#vertical").twentytwenty({
            default_offset_pct   : 0.6,
            orientation          : 'vertical',
            before_label         : 'Before',
            after_label          : 'After',
            move_slider_on_hover : false,
            move_with_handle_only: true,
            click_to_move        : false
        });

    })
})(jQuery);