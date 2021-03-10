@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 style="float: left">All Links</h2>
                        <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#linkEditorModal">Open Modal</button>
                    </div>

                    <div class="card-body">
                        <table class="table table-inverse">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Link</th>
                                <th>Description</th>
                                <th>Edit or Delete</th>
                            </tr>
                            </thead>
                            <tbody id="links-list" name="links-list">
                            @foreach ($links as $link)
                                <tr id="link{{$link->id}}">
                                    <td>{{$link->id}}</td>
                                    <td>{{$link->url}}</td>
                                    <td>{{$link->description}}</td>
                                    <td>
                                        <button class="btn btn-info open-modal" value="{{$link->id}}">Edit
                                        </button>
                                        <button class="btn btn-danger delete-link" value="{{$link->id}}">Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>




        <!-- Modal -->
        <div class="modal fade" id="linkEditorModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="linkEditorModalLabel">Link Editor</h4>
                    </div>
                    <div class="modal-body">
                        <form id="modalFormData" name="modalFormData" class="form-horizontal" novalidate="">

                            <div class="form-group">
                                <label for="inputLink" class="col-sm-2 control-label">Link</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="link" name="link"
                                           placeholder="Enter URL" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="description" name="description"
                                           placeholder="Enter Link Description" value="">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes
                        </button>
                        <input type="hidden" id="link_id" name="link_id" value="0">
                    </div>
                </div>
            </div>
        </div>


    </div>
        @endsection

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
          <script>
              jQuery(document).ready(function($){
                  ////----- Open the modal to CREATE a link -----////
                  jQuery('#btn-add').click(function () {
                      jQuery('#btn-save').val("add");
                      jQuery('#modalFormData').trigger("reset");
                      jQuery('#linkEditorModal').modal('show');
                  });

                  ////----- Open the modal to UPDATE a link -----////
                  jQuery('body').on('click', '.open-modal', function () {
                      var link_id = $(this).val();
                      $.get('links/' + link_id, function (data) {
                          jQuery('#link_id').val(data.id);
                          jQuery('#link').val(data.url);
                          jQuery('#description').val(data.description);
                          jQuery('#btn-save').val("update");
                          jQuery('#linkEditorModal').modal('show');
                      })
                  });

                  // Clicking the save button on the open modal for both CREATE and UPDATE
                  $("#btn-save").click(function (e) {
                      $.ajaxSetup({
                          headers: {
                              'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                          }
                      });
                      e.preventDefault();
                      var formData = {
                          url: jQuery('#link').val(),
                          description: jQuery('#description').val(),
                      };
                      var state = jQuery('#btn-save').val();
                      var type = "POST";
                      var link_id = jQuery('#link_id').val();
                      var ajaxurl = 'links';
                      if (state == "update") {
                          type = "PUT";
                          ajaxurl = 'links/' + link_id;
                      }
                      $.ajax({
                          type: type,
                          url: ajaxurl,
                          data: formData,
                          dataType: 'json',
                          success: function (data) {
                              var link = '<tr id="link' + data.id + '"><td>' + data.id + '</td><td>' + data.url + '</td><td>' + data.description + '</td>';
                              link += '<td><button class="btn btn-info open-modal" value="' + data.id + '">Edit</button>&nbsp;';
                              link += '<button class="btn btn-danger delete-link" value="' + data.id + '">Delete</button></td></tr>';
                              if (state == "add") {
                                  jQuery('#links-list').append(link);
                              } else {
                                  $("#link" + link_id).replaceWith(link);
                              }
                              jQuery('#modalFormData').trigger("reset");
                              jQuery('#linkEditorModal').modal('hide')
                          },
                          error: function (data) {
                              console.log('Error:', data);
                          }
                      });
                  });

                  ////----- DELETE a link and remove from the page -----////
                  jQuery('.delete-link').click(function () {
                      var link_id = $(this).val();
                      $.ajaxSetup({
                          headers: {
                              'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                          }
                      });
                      $.ajax({
                          type: "DELETE",
                          url: 'links/' + link_id,
                          success: function (data) {
                              console.log(data);
                              $("#link" + link_id).remove();
                          },
                          error: function (data) {
                              console.log('Error:', data);
                          }
                      });
                  });
              });

          </script>

    @endpush
