(function() {
    function $(selector) {
        return document.querySelector(selector);
    }

    function $$(selector) {
        var elements = document.querySelectorAll(selector);
        return [].slice.call(elements);
    }

    function fiximages() {
        // WP automatically adds width/height attributes to images, which
        // pretty much sucks for responsive scaling
        $$("img").forEach(function(img) {
            if (!!img.getAttribute('height')) {
                img.removeAttribute('height');
            }
        });

        // And all those nonsense attachment divs with fixed widths
        $$('.wp-caption').forEach(function(caption) {
            caption.removeAttribute('style');
        });
    }

    function main() {
        fiximages();
        window.addEventListener('load', function() {
            $('body').setAttribute('data-loaded', 'loaded');
        });
    }

    main();
})();