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

            // Responsive
            $(window).on('resize load', $.proxy(function() {
                this.resize();
            }, this));
        },
        update: function() {
            var y = $(document).scrollTop(),
                offset = $('.project-content').offset().top;

            $('.project-actions').toggleClass('is-sticky', y > offset);
        },
        resize: function() {
            var width = 0,
                $container = $('.project-actions-container');

            $container.children().each(function() {
                width += $(this).outerWidth(true);
            });

            $container.css('min-width', width + 20);
        }
    }
    var filter = {
        init: function() {
            $('.projects-list').clone().addClass('projects-list--clone').removeClass('projects-list').insertAfter('.projects-list');
            $('.projects-filter-category, input[name="projects-sort"]').on('change', $.proxy(function() {
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
            } else {
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
            }

            // Show message if theres
            if ( !$('.projects-list [data-categories]').length ) {
                $('.projects-list-empty').show();
                return;
            }

            // Sort the items
            var $wrapper = $('.projects-list'),
                sort = $('input[name="projects-sort"]:checked', '.projects-filter').val();
            $wrapper.children('li').sort(function(a, b) {
                var $a = $(a),
                    $b = $(b);

                switch ( sort ) {
                    case 'most-votes':
                        return (($b.attr('data-potentional-votes') + $b.attr('data-experiment-votes')) > ($a.attr('data-potentional-votes') + $a.attr('data-experiment-votes'))) ? 1 : -1;
                    case 'best-experiment':
                        return ($b.attr('data-experiment-votes') > $a.attr('data-experiment-votes')) ? 1 : -1;
                    case 'most-potential':
                        return ($b.attr('data-potentional-votes') > $a.attr('data-potentional-votes')) ? 1 : -1;
                    case 'recent':
                        return ($b.attr('data-timestamp') > $a.attr('data-timestamp')) ? 1 : -1;
                }
            }).appendTo($wrapper);
        }
    }
    var votes = {
        init: function() {
            var self = this;

            // Add .is-active classes to votes
            var ce = Cookies.get('vote-experimental');
            if ( ce ) $('.project-vote-experimental[data-postid="' + ce + '"]').addClass('is-active');
            var cp = Cookies.get('vote-potential');
            if ( cp ) $('.project-vote-potential[data-postid="' + cp + '"]').addClass('is-active');

            $('.project-vote').on('click', function() {
                var $this = $(this);
                var type  = $this.attr('class').match(/project-vote-(.*)\b/)[1],
                    votes = 1;

                if ( $this.hasClass('is-active') ) return;

                // Check for cookies
                var c = Cookies.get('vote-' + type);
                if ( c ) {
                    if ( !confirm('You already voted for another project in this category. Do you want to remove your previous vote and vote on this project instead?') ) return;

                    // Update old votes on curent page
                    var $old = $('.project-vote-' + type + '[data-postid="' + c + '"]').first();
                    $old.text(parseInt($old.text(), 10) - votes).removeClass('is-active');
                    self.vote($old.data('postid'), type, -votes);
                }

                // Update text and save vote to WP
                $this.text(parseInt($this.text(), 10) + votes).addClass('is-active');
                self.vote($this.data('postid'), type, votes);
            });
        },
        vote: function(post_id, type, votes) {
            $.post(ajaxurl, {
                action: 'hackastory_votes',
                post_id: post_id,
                type: type,
                votes: votes
            }, function() {
                if ( votes > 0 ) Cookies.set('vote-' + type, post_id);
            });
        }
    }
    var links = {
        init: function() {
            $('.js-new-window').on('click', function(e) {
                e.preventDefault();
                window.open($(this).attr('href'), null, 'height=400,width=700');
            });
        }
    }

    $(function() {
        links.init();
        filter.init();
        actionbar.init();
        votes.init();
    });
})();