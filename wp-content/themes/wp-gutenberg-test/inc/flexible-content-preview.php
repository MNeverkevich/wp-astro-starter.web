<?php
function acf_flexible_preview() {
?>
  <style type="text/css">
    .acf-tooltip.acf-fc-popup ul li a:hover .imagePreview {
      display: block;
    }
    .imagePreview {
      position: absolute;
      right: calc(100% + 5px);
      top: 0;
      z-index: 999999;
      border: 1px solid #c3c4c7;
      background-color: #fff;
      padding: 10px 15px;
      color: #1d2327;
      display: none;
    }

    .imagePreview img {
      width: 300px;
      display: block;
      max-height: 300px;
      height: auto;
    }
  </style>
  <script>
    var appliedModules = [
      'hero',
      'cta',
    ];
    jQuery(document).ready(function($) {
      if ($('.acf-field-67dc050979630').length > 0) {
        $('a[data-name=add-layout]').click(function() {
          showACFTooltipWait('.acf-tooltip li', function() {
            Array.from(appliedModules).forEach(function(module) {
              var moduleFromList = $('.acf-tooltip li a[data-layout=' + module + ']');
              var img = new Image();
              var imagePath = '<?php echo get_site_url(); ?>/wp-content/themes/wp-gutenberg-test/inc/previews/' + module + '.png';
              var defaultImagePath = '<?php echo get_site_url(); ?>/wp-content/themes/wp-gutenberg-test/inc/previews/no-preview-image.png';

              moduleFromList.append(
                '<div class="imagePreview">' +
                '<img src="' + imagePath + '" onerror="this.onerror=null;this.src=\'' + defaultImagePath + '\'" alt="' + module + '" width="300" height="200" loading="eager" />' +
                '</div>'
              );
            })
          });
        })
        var showACFTooltipWait = function(selector, callback) {
          if (jQuery(selector).length) {
            callback();
          } else {
            setTimeout(function() {
              showACFTooltipWait(selector, callback);
            }, 100);
          }
        };
      }
    })
  </script>
<?php
}

add_action('acf/input/admin_head', 'acf_flexible_preview');
?>