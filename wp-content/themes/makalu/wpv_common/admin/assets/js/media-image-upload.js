/* jshint -W098 */

function wpv_media_add(id){
	var win = window.dialogArguments || opener || parent || top;

	win.wpv_upload.get(id);
	win.tb_remove();
}