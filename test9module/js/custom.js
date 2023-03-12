(function ($, Drupal) {
  'use strict';

  Drupal.behaviors.test9module = {
    attach: function (context, settings) {
      // Limit on textarea.
      $('textarea').keyup(function() {
        $("#characters-remaining").html("Characters Remaining : " + (100 - this.value.length));
      })

      // Display 'P' Element Count.
      var count_p = $('.count-p').find('p').length;
      $('.count-p').find('span').html('Count P is ' + count_p);

      // Make first word bold.
     // $(".make-bold-p").ready(function () {
        $(".make-bold-p").find("p").each(function () {
          var pdata = $(this);
          pdata.html(pdata.text().replace(/(^\w+)/, '<strong>$1</strong>'));
        });
     // });

     // Delete All Child except the first one .
      $("#exercises").find('p').not(':first').remove();

      // Javascript function to find the unique Elements.
      function difference(array1, array2) {

        var a1 = flatten(array1, true);
        var a2 = flatten(array2, true);

        var a = [], diff = [];
        for (var i = 0; i < a1.length; i++)
          a[a1[i]] = false;
        for (i = 0; i < a2.length; i++)
          if (a[a2[i]] === true) { delete a[a2[i]]; }
          else a[a2[i]] = true;
        for (var k in a)
          diff.push(k);
        return diff;
      }

      var flatten = function (a, shallow, r) {
        if (!r) { r = []; }
        if (shallow) {
          return r.concat.apply(r, a);
        }
        for (i = 0; i < a.length; i++) {
          if (a[i].constructor == Array) {
            flatten(a[i], shallow, r);
          } else {
            r.push(a[i]);
          }
        }
        return r;
      };
      console.log(difference([1, 2, 3], [100, 2, 1, 10]));
      console.log(difference([1, 2, 3, 4, 5], [1, [2], [3, [[4]]], [5, 6]]));
      console.log(difference([1, 2, 3], [100, 2, 1, 10]));

      // Union of 2 arrays.
      function union(array1, array2) {
        if ((array1 == null) || (array2 == null))
          return void 0;

        var obj = {};

        for (var i = array1.length - 1; i >= 0; --i)
          obj[array1[i]] = array1[i];

        for (var i = array2.length - 1; i >= 0; --i)
          obj[array2[i]] = array2[i];

        var res = [];

        for (var n in obj) {

          if (obj.hasOwnProperty(n))
            res.push(obj[n]);
        }

        return res;
      }
      console.log(union([1, 2, 3], [100, 2, 1, 10]));

    }
  };
})(jQuery, Drupal);
