$('.delete').click(function () {
   var res = confirm('Подтверждение удаления')
    if (!res) return false;
});

$('.redact').click(function () {
    var res = confirm('Вы можете изменить только комментарий');
    return false;
});

$('.deletedb').click(function () {
    var res = confirm('Подтвердите удаление из БД');
    if (!res)
        return false;
});