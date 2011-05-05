
function trim(str)
{
    s = str.replace(/^(\s)*/, '');
    s = s.replace(/(\s)*$/, '');
    return s;
}

$(document).ready(function() {
    $('#addcomment-form-author').click(function() {
        if($('#addcomment-form-author').val() === 'Введите ваше имя')
            $('#addcomment-form-author').val('');
    });

    $('#addcomment-form-author').blur(function() {
        if($('#addcomment-form-author').val() === '')
            $('#addcomment-form-author').val('Введите ваше имя');
    });
    
    $('#addcomment-form').submit(function() {
        if($('#addcomment-form-author').val() === 'Введите ваше имя') {
            alert('Пожалуйста введите другое имя.');
            return false;
        }
        return true;
    });
    
    $('.deletecomment-link').click(function() {
        return confirm('Вы уверены?');
    });

    $('.reply-to').click(function() {
        hrefarr = $(this).attr('href').split('-');
        id = hrefarr[2];
        text = $('#addcomment-text-' + id).html();
        text = trim(text);
        text = text.replace('&gt;', '>');
        text = text.replace(/<br>/g, "\r\n");
        author = $('#addcomment-author-' + id).text();
        text = 'Ответ на комментарий от "' + author + '":' + "\r\n" + '> ' + text + "\r\n\r\n";
        $('#addcomment-form-text').val(text);
        $('#addcomment-form-text').focus();
    });

    $('.services-unfold').click(function() {
        unfold = $(this).attr('href');
        $('.services-fold').hide();
        $(unfold).show();
    });
    
    /*
    $('#addcomment-form-text').click(function() {
        if($('#addcomment-form-text').val() === 'Комментарий...')
            $('#addcomment-form-text').val('');
    });
    
    $('#addcomment-form-text').blur(function() {
        if($('#addcomment-form-text').val() === '')
            $('#addcomment-form-text').val('Комментарий...');
    });
    */
});