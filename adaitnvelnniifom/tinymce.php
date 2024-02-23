<a href="#" class="close-upload_options">Hide <i class="fa fa-close"></i></a>
        <input type="text" id="pageType" value="<?php echo "$pageType"; ?>" />
         <textarea id="editor" name="editor"></textarea>
<script src='//tinymce.cachefly.net/4.3/tinymce.min.js'></script>
 
        <script>
            $(document).ready(function() {
                var valid_elms = "hr[class|width|size|noshade]";
                    valid_elms    += "span[class|align|style],";
                    valid_elms    += "font[face|size|color|style],";
                    valid_elms    += "img[href|src|name|title|onclick|align|alt|title|";
                    valid_elms    += "width|height|vspace|hspace],";
                    valid_elms    += "iframe[id|class|width|size|noshade|src|height|";
                    valid_elms    += "frameborder|border|marginwidth|marginheight|";
                    valid_elms    += "target|scrolling|allowtransparency],style";
                    valid_elms    += "em[class|name|id]";
                tinymce.init({
                    selector: 'textarea',
                    height: 500,
                     plugins: [
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace wordcount visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "emoticons template paste textcolor colorpicker textpattern imagetools"
                    ],
                    toolbar1: "fontsizeselect fontselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor | media link image",
                    content_css: [
                        '//www.tinymce.com/css/codepen.min.css'
                    ],
                    fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                    extended_valid_elements: valid_elms,
          forced_root_block : false,
                    entity_encoding: "raw",
                    valid_children : "+body[style|meta|head|base], +style[type], +div[h2|span|meta|object],+object[param|embed]",
                   // apply_source_formatting : false,                //added option
                    verify_html : false,
                    relative_urls: false,
                    setup : function(ed)
                            {
                                ed.on('init', function() 
                                {
                                    this.getDoc().body.style.fontSize = '10pt';
                                    this.getDoc().body.style.fontFamily = 'Verdana';
                                });
                            }

                });

            });

        </script>
        