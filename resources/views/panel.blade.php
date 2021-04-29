<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$panel->title}}</title>

    <style>
        body {
            margin: 0;
            overflow:hidden;
        }
        .xyzfrm{
            border: 0;
            width: 100%;
            height: 100vw;
        }
    </style>
    <script src="/assets/js/vendors/jquery-3.2.1.min.js"></script>
    <script>
        var count = 0;
        $(function() {
            $.ajax({
            url: "{{route('pti.panel.show')}}",
            type: 'POST',
            data: {
                hash: "{{$panel->hash}}"
            },
            success: function (data) {
                //Monta a tela inicial
                //console.log(data.screens);
                $.each( data.screens, function( key, value ) {
                    $('body').append('<iframe id="' + key + '" src="' + value +'" class="xyzfrm" style="display: ' + (key == 0 ? 'block' : 'none')+ '"></iframe>');
                })

                setTimeout(() => {
                    $("#" + count).hide();

                    setInterval(() => {

                    $('.xyzfrm').each(function(i, obj) {console.log(i);
                        if(i !== count){
                            $("#" + count).hide();
                        }else{
                            $("#" + count).show();
                        }
                    });
                    count = (count == data.screens.length -1) ? 0 : (count + 1);
                    }, 5000);

                }, 10000);


            },
            error: function (data) {
                // handle error response
            }
        });
        })
    </script>
</head>
<body>

</body>
</html>
