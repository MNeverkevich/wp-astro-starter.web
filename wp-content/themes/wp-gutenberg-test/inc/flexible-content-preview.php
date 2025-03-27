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
    document.addEventListener('DOMContentLoaded', function() {
      if (document.querySelector('.acf-field-67dc050979630')) {
        const addLayoutButtons = document.querySelectorAll('a[data-name=add-layout]');

        addLayoutButtons.forEach(button => {
          button.addEventListener('click', function() {
            showACFTooltipWait('.acf-tooltip li', function() {
              const moduleFromList = document.querySelectorAll('.acf-tooltip li');

              moduleFromList.forEach(function(module) {
                const moduleEl = module.querySelector('a');
                const moduleName = moduleEl.getAttribute('data-layout');
                const img = new Image();
                const imagePath = '<?php echo get_site_url(); ?>/wp-content/themes/wp-gutenberg-test/inc/previews/' + moduleName + '.png';
                const defaultImagePath = '<?php echo get_site_url(); ?>/wp-content/themes/wp-gutenberg-test/inc/previews/no-preview-image.png';

                const previewDiv = document.createElement('div');
                previewDiv.className = 'imagePreview';

                const previewImg = document.createElement('img');
                previewImg.src = imagePath;
                previewImg.alt = moduleName;
                previewImg.width = 300;
                previewImg.height = 200;
                previewImg.loading = 'eager';
                previewImg.onerror = function() {
                  this.onerror = null;
                  this.src = defaultImagePath;
                };

                previewDiv.appendChild(previewImg);
                moduleEl.appendChild(previewDiv);
              });
            });
          });
        });

        var showACFTooltipWait = function(selector, callback) {
          if (document.querySelectorAll(selector).length) {
            callback();
          } else {
            setTimeout(function() {
              showACFTooltipWait(selector, callback);
            }, 100);
          }
        };
      }
    });
  </script>
<?php
}

add_action('acf/input/admin_head', 'acf_flexible_preview');
?>
