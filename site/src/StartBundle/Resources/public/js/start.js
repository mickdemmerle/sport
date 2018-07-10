$(document).ready(function(){

    setIntervalTimeout = null;
    nextTrainingElem = null;

    $('.btn-start-next').click(function(){
        nextTrainingElem = $(this);

        var timeout = $(this).parent().data('timeout');
        var timeoutHtml = $(this).parent().data('timeout');

        $(nextTrainingElem).parent().fadeOut();

        $('.start-training-timeout').html(timeoutHtml);

        setTimeout(function(){
            clearInterval(setIntervalTimeout);
            setIntervalTimeout = setInterval(function(){

                if (timeoutHtml == timeout){
                    $('.start-training-timeout').fadeIn();
                }

                if ((timeoutHtml+1) == 0){
                    clearInterval(setIntervalTimeout);
                    $('.start-training-timeout').hide();
                    $(nextTrainingElem).parent().next().fadeIn();
                } else {
                    $('.start-training-timeout').html(timeoutHtml);
                }

                timeoutHtml--;
            }
            , 1000);
        }, timeout);

    });

    $('.start-training-timeout').click(function(){
        clearInterval(setIntervalTimeout);
        $('.start-training-timeout').hide();
        $(nextTrainingElem).parent().next().fadeIn();
    });
});