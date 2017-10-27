/* global CoursePress */

(function() {
    'use strict';
    CoursePress.Define( 'PopUp', function() {
        return CoursePress.View.extend({
            template_id: 'coursepress-popup-tpl',
            className: 'coursepress-popup',
            events: {
                'click .btn-ok': 'Ok',
                'click .cp-btn-cancel': 'remove'
            },
            render: function() {
                if ( typeof this.model.attributes.type !== 'undefined' && 'info' === this.model.attributes.type ) {
                    this.template_id = 'coursepress-popup-info-tpl';
                }
                CoursePress.View.prototype.render.apply( this );
                this.$el.appendTo( 'body' );
            },
            Ok: function() {
                /**
                 * Trigger whenever OK button is click
                 */
                this.trigger( 'coursepress:popup_ok', this );
                this.remove();
            }
        });
    });
})();
