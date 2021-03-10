<!DOCTYPE html>
<html lang="en">
<head>
    <title>Laravel Ajax</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <div class="col-md-2"></div>
    <div class="col-md-8" style="margin-top: 200px">
        <div class="panel panel-default" style="height: 200px">
            <div class="panel-heading">Laravel Ajax</div>
            <div class="panel-body">
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="image">Upload Image</label>
                        <input type="file" class="form-control" id="file"  name="file">
                    </div>

                    <input type="submit" class="form-control btn btn-success" id="ajax-submit">
                </form>

            </div>
            <div class="alert alert-success" style="display: none"></div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
      $(document).ready(function(){
          $("#ajax-submit").click(function (e){
               e.preventDefault();
               $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                    }
               });

               $.ajax({

                      url: "{{ url('/ajax') }}",
                      method: 'POST',
                      data: { file: $("#file").val()},
                      success: function(result){
                          $(".alert").show();
                          $(".alert").html(result.success+result.data);
                      }
               });
          });
      });
</script>

</body>
</html>
