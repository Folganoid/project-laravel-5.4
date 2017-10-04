jQuery(document).ready(function($) {

    $('.commentlist li').each(function(i) {

        $(this).find('div.commentNumber').text('#' + (i + 1));

    });

    $('#commentform').on('click', '#submit', function(e) {

        e.preventDefault();

        var comParent = $(this);

        $('.wrap_result').
            css('color', 'grey').
            text('Сохранение комментария').
            fadeIn(500, function() {

                var data = $('#commentform').serializeArray();

                $.ajax({

                    url: $('#commentform').attr('action'),
                    data: data,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    datatype: 'JSON',
                    success: function(html) {
                        if(html.error) {
                            $('.wrap_result').css('color', 'red').append('<br><strong>Ошибка: </strong>' + html.error.join('<br>'));
                            $('.wrap_result').delay(2000).fadeOut(500);
                        }
                        else if(html.success) {
                            $('.wrap_result')
                                .append('<br /><strong>Сохранено!</strong>')
                                .delay(2000)
                                .fadeOut(500, function() {

                                    console.log(html);

                                    if(html.data.parent_id > 0) {
                                        comParent.parents('div#respond').prev().after('<ul class="children">' + html.comments + '</ul>>');
                                    }
                                    else {
                                        if($('#comments').find('span') == 0) {
                                            $('ol.commentlist').append(html.comments);
                                        }
                                        else {

                                            $('#respond').before('<ol class="commentlist group">' + html.comments + '</ol>');
                                        }
                                    }

                                    $('#cancel-comment-reply-link').click();

                                });
                        }
                    },
                    error: function() {
                        $('.wrap_result').css('color', 'red').append('<br><strong>Ошибка: </strong>');
                        $('.wrap_result').delay(2000).fadeOut(500, function() {
                            $('#cancel-comment-reply-link').click();
                        });
                    }

                });

            });

    });

});