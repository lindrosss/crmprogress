
$(document).ready(function() 
{	
	tinymce.init({
		selector: "textarea#elm1",
		theme: "modern",
		//width: 300,
		height: 500,
		plugins: "fullpage, fullscreen, code",
		fullpage_default_encoding: "UTF-8",		
		toolbar: "insertfile undo redo |  bold italic underline | alignleft aligncenter alignright alignjustify |   fullscreen   " 
	}); 
 
 //-----------tinymce------------------
		
	$('#btn_save').click(function()
		{
			update_trening();				
		});
});	

