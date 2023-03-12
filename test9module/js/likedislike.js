(function ($, Drupal) {
  'use strict';

  Drupal.behaviors.articleLikeDislike = {
    attach: function (context, settings) {
      var like_dislike_wrapper = $('.article-like-dislike', context).once();
      like_dislike_wrapper.on('click', '.article-like-dislike-wrapper a', function () {
        // Get Article Id.
        var nid = $(this).attr('data-nid');
        var data_type = $(this).attr('data-type');

        var url = '/article-like-dislike/' + nid + '/' + data_type;
        jQuery.ajax({
          url: url,
          type: "POST",
          dataType: 'json',
          success: function (response) {
            $(".article-like span").html(' ' + response.like_count);
            $(".article-like-dislike-wrapper a").removeClass('active');
            if (response.like_count) {
              $('.article-like').addClass('active');
            }
            else {
              $('.article-dislike').addClass('active');
            }
          }
        });
      });
    }
};
})(jQuery, Drupal);
