(function ($) {
  Drupal.behaviors.hardwoods_help = {
    attach: function (settings, context) {
      var _that = this;
      $(document).on('click', '[data-toggle="tab"]', function (e) {
        var tab = $(this).attr('href');

        _that.pushToHistory(tab.substring(1));
      });

      this.setActive();
    },

    pushToHistory: function (tab_id) {
      if (!window.history) {
        return;
      }

      var state = window.history.state;
      var params = this.params();
      params.help_pane = tab_id;

      var url = [];
      Object.keys(params).map(function (key) {
        url.push(key + '=' + params[key]);
      });

      window.history.replaceState(state, document.title, '?' + url.join('&'));
    },

    setActive: function () {
      var params = this.params();

      if (typeof params.help_pane !== 'undefined') {
        $('[href="#' + params.help_pane + '"]').tab('show');
      }
    },

    params: function () {
      // Check browser href for a pane to open
      var params = window.location.search;
      if (params.length > 0) {
        // remove the "?" char
        var qIndex = params.indexOf('?');
        if (qIndex !== -1) {
          params = params.slice(qIndex + 1, params.length);
        }

        var indexed = {};

        // split it into array
        params.split('&').map(function (param) {
          var broken = param.split('=');
          if (broken.length === 2) {
            indexed[broken[0]] = broken[1];
          }
          else if (broken.length === 1) {
            indexed[broken[0]] = null;
          }
        });

        return indexed;
      }

      return [];
    }
  };
})(jQuery);
