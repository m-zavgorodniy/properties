// ImageGallery FCKeditor plugin
// (c) 2009 Eclipse Interactive, http://eclipse-interactive.ru

var ImageGalleryCommand=function() {
//create our own command, we dont want to use the FCKDialogCommand because it uses the default fck layout and not our own
};
ImageGalleryCommand.GetState=function() {
return FCK_TRISTATE_OFF; //we dont want the button to be toggled
}
ImageGalleryCommand.Execute=function() {
//open a popup window when the button is clicked
window.open('/admin/html_editor_plugin.php?type=imagegallery', 'ImageGallery', 'width=800,height=700,scrollbars=yes,resizable=yes,location=no,toolbar=no,top='+Math.floor(screen.height/2-700/2-50)+',left='+Math.floor(screen.width/2-800/2));
}

// Register the related commands.
FCKCommands.RegisterCommand( 'ImageGallery' , ImageGalleryCommand ) ;

// Create toolbar button.
var oImageGallery = new FCKToolbarButton( 'ImageGallery', 'ImageGallery' ) ;
oImageGallery.IconPath = FCKConfig.PluginsPath + 'imagegallery/imagegallery.gif' ;

FCKToolbarItems.RegisterItem( 'ImageGallery', oImageGallery ) ;