@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 style="float: left">All Teacher</h2>
                        <a style="float: right" href="" class="btn btn-success" id="addteacher" onclick="create()">add studnet</a>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th width="15%">Sl</th>
                                <th width="20%">Name</th>
                                <th width="20%">Phone</th>
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
                    <form action="" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="col-sm-2">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                                <span id="nameError" class="alert-message"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2">Phone</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone">
                                <span id="phoneError" class="alert-message"></span>
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
                        <button type="button" class="btn btn-primary" id="addnewteacher">Save</button>
                    </div>
                </div>

            </div>

        </div>
        @endsection



        @push('js')

            <script>

                $(document).ready(function(){
                    $('#addteacher').click(function(event){
                        event.preventDefault();
                    });
                });
                $(document).ready(function(){
                    $("#addnewteacher").click(function (e){
                        e.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                            }
                        });

                        $.ajax({

                            url: "{{ url('/teacher-store') }}",
                            method: 'POST',
                            data: {
                                name: $("#name").val(),
                                phone: $("#phone").val(),
                                description: $("#description").val(),
                            },
                            success: function(result){
                                $("#mymodal").modal('hide');
                            }
                        });
                    });
                });
                function create(){
                    $(".modal-title").text('Add new teacher');
                    $("#mymodal").modal('show');
                }



            </script>
    @endpush
