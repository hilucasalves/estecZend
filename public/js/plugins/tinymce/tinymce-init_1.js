tinymce.init({
    selector: "textarea.text",
    theme: "modern",
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak code",
         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
         "table contextmenu directionality emoticons paste textcolor responsivefilemanager"
   ],
   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
   toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
   image_advtab: true ,
   image_dimensions: false,
         image_class_list: [
            {title: 'Responsive', value: 'img-responsive'}
        ],
   external_filemanager_path:"/js/filemanager/",
   filemanager_title:"Responsive Filemanager" ,
   external_plugins: { "filemanager" : "/js/filemanager/plugin.min.js"}
 });