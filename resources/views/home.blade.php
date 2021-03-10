@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 style="float: left">All studnets</h2>
                    <a style="float: right" href="" class="btn btn-success" id="createstudent" onclick="create()">add studnet</a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th width="10%">Sl</th>
                            <th width="20%">Title</th>
                            <th width="25%">Description</th>
                            <th width="20%">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- The Modal -->
    <div class="modal" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="mymodal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <form name="userForm" class="form-horizontal">
                    <input type="hidden" name="post_id" id="post_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2">title</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
                            <span id="titleError" class="alert-message"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2">Description</label>
                        <div class="col-sm-12">
                        <textarea class="form-control" id="description" name="description" placeholder="Enter description" rows="4" cols="50">
                        </textarea>
                            <span id="descriptionError" class="alert-message"></span>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-save" onclick="createPost()">Save</button>
                    <button type="button" class="btn btn-primary btn-update" onclick="updatePost()">Update</button>
                </div>
            </div>

    </div>

</div>
@endsection



@push('js')

   <script>

       var studenturl = '{{ url('student') }}';


       $(document).ready(function(){
           $('#createstudent').click(function(event){
                event.preventDefault();
           });

       });

       function get_records(){
           $.ajax({
               type: 'GET',
               url: '{{ url('posts') }}',
               success: function (data) {
                   //console.log(data);
                   var html = '';
                   data.forEach(function (row){
                       html +='<tr>'
                       html +='<td>'+row.id+'</td>'
                       html +='<td>'+row.title+'</td>'
                       html +='<td>'+row.description+'</td>'
                       html +='<td>'
                       html += '<button class="btn btn-primary btn-xs" onclick="Editdata(' +row.id+ ');"><span class="material-icons">edit</span></button>'
                       html += '<button class="btn btn-success btn-xs" onclick="Showdata(' +row.id+ ');"><span class="material-icons">visibility</span></button>'
                       html += '<button class="btn btn-danger btn-xs"><span class="material-icons" onclick="Deletedata(' +row.id+ ');">delete</span></button>'
                       html +='</td></tr>'
                   })
                   $('table tbody').html(html)

               },
               error: function() {
                   console.log('data not load');
               }
           });
       }

       get_records();

       function getinputs(){
             var name  = $("#name").val()
             var email = $("#email").val()
             var phone = $("#phone").val()
             return {name: name, email: email, phone: phone}
       }

       function createPost(){

           var title = $('#title').val();
           var description = $('#description').val();
           var id = $('#post_id').val();

           let _url     = '{{ url('posts') }}';
           let _token   = $('meta[name="csrf-token"]').attr('content');
           console.log(_url)

           $.ajax({
               url: _url,
               type: "POST",
               data: {
                   id: id,
                   title: title,
                   description: description,
                   _token: _token
               },
               success: function(response) {
                   get_records();
                   $('#title').val('');
                   $('#description').val('');
                   $('#mymodal').modal('hide');
               }
           });



       }


       function Editdata(id){

           $(".modal-title").text('Update post');
           $("#mymodal").modal('show');
           var id = id;
           var url = `posts/${id}/edit`;

           $.ajax({
               type: 'GET',
               url: url,

               success: function (data) {

                     $("#title").val(data.title).attr('readonly', false);;
                     $("#description").val(data.description).attr('readonly', false);;
                     $("#post_id").val(data.id);
                     $(".btn-save").hide();
                     $(".btn-update").show();
               }
           });
       }

       function Showdata(id){

           $(".modal-title").text('View post');
           $("#mymodal").modal('show');
           $(".btn-save").hide();
           $(".btn-update").hide();
           var id = id;
           var url = `posts/${id}/edit`;

           $.ajax({
               type: 'GET',
               url: url,

               success: function (data) {

                   $("#title").val(data.title).attr('readonly', true);
                   $("#description").val(data.description).attr('readonly', true);
                   $("#post_id").val(data.id).attr('readonly', true);

               }
           });
       }



       function updatePost(){

           var title = $('#title').val();
           var description = $('#description').val();
           var id = $('#post_id').val();

           let _url     = '{{ url('posts') }}';
           let _token   = $('meta[name="csrf-token"]').attr('content');
           // console.log(_url)

           var url = `posts/${id}`;

           $.ajax({
               url: url,
               type: "PUT",
               data: {
                   id: id,
                   title: title,
                   description: description,
                   _token: _token
               },
               success: function(response) {
                   get_records();
                   $("#mymodal").modal('hide');
               }
           });



       }


       function Deletedata(id){

           var url = `posts/${id}`;
           var title = $('#title').val();
           var description = $('#description').val();
           var id = $('#post_id').val();
           let _token   = $('meta[name="csrf-token"]').attr('content');

           $.ajax({
               url: url,
               type: "DELETE",
               data: {
                   id: id,
                   title: title,
                   description: description,
                   _token: _token
               },
               success: function(response) {
                   console.log("data deleted successfully");
                   get_records();
               }
           });
       }












       function create(){

           $(".modal-title").text('Add new post');
           $("#mymodal").modal('show');
           $(".btn-save").show();
           $(".btn-update").hide();
       }



   </script>
@endpush
