tinyMCE.init({
    entity_encoding : "raw",
    selector: "textarea.text",
    theme: "modern",
    language : "pt_BR",
    width: '100%',
    plugins: [
        "advlist autolink lists link charmap print preview anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "nonbreaking save table contextmenu directionality",
        "emoticons paste textcolor colorpicker textpattern"
    ],
    toolbar1: "insertfile undo redo | styleselect | forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media ",
    //toolbar2: "print preview media | forecolor backcolor",
    image_advtab: true,
    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ]
    
});//te