<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <title>{{$title}}</title>
    
    <style>
      body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background-color: #f8f9fa;
      }

      h1 {
        margin-bottom: 20px;
        color: #333;
      }

      #numero {
        font-size: 4rem;
        font-weight: bold;
        color: #007bff; /* Mismo color que el borde */
        margin-top: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100px;
        width: 100px;
        border-radius: 50%;
        border: 3px solid #007bff; /* Borde de color */
      }

      .btn-sorteo {
        width: 200px;
        font-size: 1.2rem;
        margin-top: 20px;
      }

      #enviarMail {
      margin-top: 20px;
    }

    #resultado {
        display: none;
        margin-top: 20px;
        padding: 10px;
        border: 2px solid #28a745;
      }

    </style>
  </head>
  <body>
    <h1>{{$title}}</h1>

    <input type="hidden" id="_token" value="{{csrf_token()}}">

    <button type="button" class="btn btn-primary btn-sorteo" id="sorteo">
        <i class="fas fa-info-circle"></i> SORTEO
    </button>

    <div id="numero">--</div>
    <div id="mail"></div>
    <div id="resultado" class="alert alert-success rounded border border-success">aaaaaaaa</div>


  </body>
</html>


<script>
    $(document).ready(function () {


        $(document).on("click", "#mail", function(e) {
            var _token = $('#_token').val();
            var mail = $('#enviarMail').data('mail');
            var cliente = $('#enviarMail').data('cliente');
            console.log(cliente)

            var formData = new FormData();
            formData.append('_token', _token);
            formData.append('mail', mail);
            formData.append('cliente', cliente);

            $.ajax({
                type: "Post",
                url: "{{route('sendMail')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response)
                    $('#resultado').show();
                    $('#resultado').html(`Se ha enviado un mail al ganador.`)
                    

                }
            });



        });


        $('#sorteo').click(function (e) { 
            e.preventDefault();
            var _token = $('#_token').val();
            var formData = new FormData();
            formData.append('_token', _token);
            
            $.ajax({
                type: "Post",
                url: "{{route('sorteoNumero')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response)
                    $('#numero').html(` ${response.id} `);
                    $('#mail').html(`
                    <button type="button" class="btn btn-primary" id="enviarMail" data-cliente="${response.nombre_cliente}" data-mail="${response.email_cliente}">
                        <i class="fas fa-info-circle"></i> Enviar Mail
                    </button>`
                    );
                }
            });

            
        });
    });
    
</script>