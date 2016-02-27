(function() {
    var actionbar = {
        init: function() {
            var $container = $('.project-actions');
            if ( !$container.length ) return;

            // rAF polyfill
            if ( !Date.now ) Date.now = function() { return new Date().getTime(); };

            (function() {
                var vendors = ['webkit', 'moz'];
                for ( var i = 0; i < vendors.length && !window.requestAnimationFrame; ++i ) {
                    var vp = vendors[i];
                    window.requestAnimationFrame = window[vp + 'RequestAnimationFrame'];
                    window.cancelAnimationFrame = (window[vp + 'CancelAnimationFrame']
                    || window[vp + 'CancelRequestAnimationFrame']);
                }

                if ( /iP(ad|hone|od).*OS 6/.test(window.navigator.userAgent) || !window.requestAnimationFrame || !window.cancelAnimationFrame ) {
                    var lastTime = 0;
                    window.requestAnimationFrame = function(callback) {
                        var now = Date.now();
                        var nextTime = Math.max(lastTime + 16, now);
                        return setTimeout(function() { callback(lastTime = nextTime); }, nextTime - now);
                    };

                    window.cancelAnimationFrame = clearTimeout;
                }
            }());

            // rAF loop
            var self = this;
            (function animloop(){
                requestAnimationFrame(animloop);
                self.update();
            })();
        },
        update: function() {
            var y = $(document).scrollTop(),
                offset = $('.project-content').offset().top;

            $('.project-actions').toggleClass('is-sticky', y > offset);
        }
    }
    var filter = {
        init: function() {
            $('.projects-list').clone().addClass('projects-list--clone').removeClass('projects-list').insertAfter('.projects-list');
            $('.projects-filter-category').on('change', $.proxy(function() {
                this.filter();
            }, this));

            // Make sure the order and filter is correct
            this.filter();
        },
        reset: function() {
            $('.projects-list').remove();
            $('.projects-list--clone').clone().removeClass('projects-list--clone').addClass('projects-list').insertBefore('.projects-list--clone');

            $('.projects-list-empty').hide();
        },

        filter: function() {
            var categories = [];

            // Reset
            this.reset();

            // Retrieve all selected options
            $('.projects-filter-list input:checkbox').each(function() {
                var $this = $(this);
                if ( $this.is(':checked') ) categories.push($this.val());
            });

            // Show all categories if no selection was made
            if ( !categories.length ) {
                $('.projects-list [data-categories]').show();
                return;
            }

            $('.projects-list [data-categories]').each(function() {
                var arr = $(this).data('categories').split(',');

                var show = false;
                for ( var i in arr ) {
                    if ( categories.indexOf(arr[i]) >= 0 ) {
                        show = true;
                        break;
                    }
                }

                if ( !show ) $(this).remove();
            });

            // Show message if theres
            if ( !$('.projects-list [data-categories]').length ) {
                $('.projects-list-empty').show();
                return;
            }

            // Sort the items
            // TODO
        }
    }

    $(function() {
        filter.init();
        actionbar.init();
    });
})();