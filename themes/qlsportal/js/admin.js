
function addInputFile()
{
    var newinput = document.createElement('input');    
    $(newinput).attr('type', 'file');
    $(newinput).attr('name', 'files[]');
    $(newinput).change(addInputFile);

    $('#form-edit-news-files').append(document.createElement('br'));
    $('#form-edit-news-files').append($(newinput));
}

$(document).ready(function() {
    
    $('a.confirm-link').click(function() {
        return confirm('Вы уверены?');
    });
    
    $('#form-edit-editor').submit(function() {
        if($('#form-edit-editor :password').val()) {
            return confirm('Пароль был изменен. Хотите продолжить?');
        }
    });
    
    $('#form-edit-news-files :file').change(addInputFile);
});
