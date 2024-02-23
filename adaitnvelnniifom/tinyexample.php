<?php 
  $pageType = '';
  include('header.php'); 
  $pageHead = 'Edit HTML File';
  $addText =  ''; 
  $primaryKey = $_GET['primarykey'];
  $tableName = $_GET['table'];
  $title = $_GET['title'];
  $name = $_GET['name'];
  $tableType = 'a';
?>
<style>
	p{
		margin: 0px;
		padding: 0px;
	}
</style>
<div class="wrapper">

<?php include('titlebar.php'); ?>

<?php include('sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
 
    <!-- Main content -->

    <section class="content-header">
      <input type="hidden" id="dataType" value="<?php echo "$pageHead"; ?>" />
      <input type="hidden" id="pageType" value="<?php echo "$pageType"; ?>" />
      <h1><?php echo "$pageHead $addText"; ?> <small> <?php echo "$pageHead $addText"; ?> data here</small></h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
        <li class="active"><?php echo "$pageHead $addText"; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="alert alert-error alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <div><i class="icon fa fa-warning"></i><span>You have entered wrong security. Please enter correct code.</span> </div>
      </div>
      <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <div>  <i class="icon fa fa-check"></i> HTML Data File updated successfully !</div>
      </div>

    <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
         <h3 class="box-title"><?php echo "$title". " [<b>".$row[$name] ." - #".$row[$primaryKey] ."</b> ]"; ?></h3>
          <div class="box-tools pull-right">
          	<a href="mediaLibrary.php" target="_blank">Media Library</a> &nbsp; &nbsp; 
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
          </div>
        </div> 
        <div class="box-body" >

    		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="editHTML" name="editHTML" method="post" >
          <input id="file_path" name="file_path" type="hidden" value="<?php echo $row['file_path']; ?>" />
          <input id="cir_no" name="cir_no" type="hidden" value="<?php echo $row[$name]; ?>" />
          <input id="field_name" name="field_name" type="hidden" value="<?php echo $primaryKey; ?>" />
          <input id="table_name" name="table_name" type="hidden" value="<?php echo $tableName; ?>" />
          <input id="data_id" name="data_id" type="hidden" value="<?php echo $row[$primaryKey]; ?>" />
          <input id="dataTypeText"  name="dataTypeText" type="hidden" value="<?php echo "$pageHead"; ?>" />
			   	<textarea id="editor" name="editor"></textarea>
				<div class="box-footer">
			      	<label class="col-sm-5 control-label"></label>
			    	<div class="col-sm-7">
			      		<button type="submit" class="btn btn-lg btn-primary" name="save-html" id="save-html">Save HTML</button>
			      	</div>
			    </div>
			</form>

        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->




<?php include('copyright.php'); ?>

</div><!-- ./wrapper -->

<?php include('footer.php'); ?>
<!-- <script src='//tinymce.cachefly.net/4.3/tinymce.min.js'></script> -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.0.6/jquery.tinymce.min.js"></script>
 
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
					    "insertdatetime media nonbreaking save table directionality",
					    "emoticons template paste textpattern imagetools",
					],
					toolbar1: "fontsizeselect fontselect | bold italic underline | alignleft aligncenter alignright alignjustify	 mybutton | bullist numlist outdent indent | forecolor backcolor | media link image ",
 					content_css: [
						// // '//www.tinymce.com/css/codepen.min.css'
						'tiny.css'
						
					],

					fontsize_formats: '8pt 10pt 10.5pt 11pt 11.5pt 12pt 14pt 18pt 24pt 36pt',
 					extended_valid_elements: valid_elms,
 					force_br_newlines : false,
  					force_p_newlines : true,
  					//forced_root_block : '',// Needed for 3.x
          			forced_root_block : '',
					entity_encoding: "raw",
 			        valid_children : "+body[style|meta|head|base], +style[type], +div[h2|span|meta|object],+object[param|embed]",
			       // apply_source_formatting : false,                //added option
			        verify_html : false,
			        relative_urls: false,
			        setup : function(ed)
						    {
						    	debugger;
						        ed.on('init', function() 
						        {
						        	debugger;
						            this.getDoc().body.style.fontSize = '10.5pt';
						            this.getDoc().body.style.fontFamily = 'Verdana';
						            this.getDoc().body.style.menuitem = '1.5';

						            ed.ui.registry.addMenuButton('mybutton', {
							      	text: 'Line Spacing',
								    fetch: function (callback) {
								        var items = [
								        {
								            type: 'menuitem',
								            text: '1.0',
								            onAction: function () {
								              // ed.insertContent('&nbsp;<em>You clicked menu item 1!</em>');
								              tinymce.activeEditor.dom.setStyle(tinymce.activeEditor.dom.select('p'), 'line-height', 'normal');
								            }
								        },
								        {
								            type: 'menuitem',
								            text: '1.15',
								            onAction: function () {
								              tinymce.activeEditor.dom.setStyle(tinymce.activeEditor.dom.select('p'), 'line-height', '115%');
								            }
								        },
								        {
								            type: 'menuitem',
								            text: '1.5',
								            onAction: function () {
								              tinymce.activeEditor.dom.setStyle(tinymce.activeEditor.dom.select('p'), 'line-height', '150%');
								            }
								        },
								        {
								            type: 'menuitem',
								            text: '2.0',
								            onAction: function () {
								              tinymce.activeEditor.dom.setStyle(tinymce.activeEditor.dom.select('p'), 'line-height', '200%');
								            }
								        },
								        {
								            type: 'menuitem',
								            text: '2.5',
								            onAction: function () {
								              tinymce.activeEditor.dom.setStyle(tinymce.activeEditor.dom.select('p'), 'line-height', '250%');
								            }
								        },
								        {
								            type: 'menuitem',
								            text: '3.0',
								            onAction: function () {
								              tinymce.activeEditor.dom.setStyle(tinymce.activeEditor.dom.select('p'), 'line-height', '300%');
								            }
								        },
								        // {
								        //     type: 'nestedmenuitem',
								        //     text: 'Menu item 2',
								        //     icon: 'user',
								        //     getSubmenuItems: function () {
								        //     return [
								        //         {
								        //           type: 'menuitem',
								        //           text: 'Sub menu item 1',
								        //           icon: 'unlock',
								        //           onAction: function () {
								        //             ed.insertContent('&nbsp;<em>You clicked Sub menu item 1!</em>');
								        //           }
								        //         },
								        //         {
								        //           type: 'menuitem',
								        //           text: 'Sub menu item 2',
								        //           icon: 'lock',
								        //           onAction: function () {
								        //             ed.insertContent('&nbsp;<em>You clicked Sub menu item 2!</em>');
								        //           }
								        //         }
								        //       ];
								        //     }
								        //   }
								        ];
								        callback(items);
								    }
    });
						        });

						         /* example, adding a toolbar menu button */
							    
						    }

				});
			// 	var myListItems = ['Item1','Item2'];
			// 	tinymce.PluginManager.add('myNewPluginName', function(editor) {
	  //   		var menuItems = [];
	  //   		tinymce.each(myListItems, function(myListItemName) {
		 //        	menuItems.push({
			//             text: myListItemName,
			//             onclick: function() {
			//                 editor.insertContent(myListItemName);
			//             }
			//         });
		 //    	});

			//     editor.addMenuItem('insertValueOfMyNewDropdown', {
			//         icon: 'date',
			//         text: 'Do something with this new dropdown',
			//         menu: menuItems,
			//         context: 'insert'
			//     });
			// });


// tinymce.init({
//   selector: 'textarea#custom-toolbar-menu-button',
//   height: 500,
//   toolbar: 'mybutton',

//   content_css: [
//     '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
//     '//www.tiny.cloud/css/codepen.min.css'
//   ],

//   setup: function (editor) {

   

//   }
// });


        	});


        </script>


