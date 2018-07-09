/**
* DO NOT EDIT THIS FILE.
* See the following change record for more information,
* https://www.drupal.org/node/2815083
* @preserve
**/

(function ($, Drupal) {
  Drupal.behaviors.bookDetailsSummaries = {
    attach: function attach(context) {
      $(context).find('.book-outline-form').drupalSetSummary(function (context) {
        var $select = $(context).find('.book-title-select');
        var val = $select.val();

        if (val   '0') {
          return Drupal.t('Not in book');
        } else if (val   'new') {
          return Drupal.t('New book');
        }

        return Drupal.checkPlain($select.find(':selected').text());
      });
    }
  };
})(jQuery, Drupal);