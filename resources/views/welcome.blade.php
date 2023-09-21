<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>

        
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
        
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet" crossorigin="anonymous">

        

        <!-- Styles -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

      
    </head>
    <body>
        <div class="container">

                <div class="card maincard">
                    <div class="card-header">
                        <h2>Task List</h2>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>New Task</h3>
                    </div>
                    <div class="card-body">
                        <form id="taskform">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Task</label>
                                <input type="task" class="form-control" id="tasktext" name="task">
                            </div>
                            <button type="submit" class="btn btn-task"><i class="fa fa-plus" aria-hidden="true"></i> Add Task</button>           
                        </form>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        <h3>Current Task</h3>
                    </div>
                    <div class="card-body">

                            <div class="box-body table-responsive">
                            <table id="example" class="table table-bordered table-striped">

                                <thead>
                                    <tr>
                                        <th> Task </th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                        @php $i=0;  @endphp
                                    @foreach ($tasks as $task)
                                        @php  $i+=1; @endphp
                                    
                                    <tr>                                         
                                            <td>{{ $task->task }}</td>                                                
                                            <td class="center">
                                                <div class="btn-mini btn-danger btn-flat btn">                                          
                                                <a href="javascript:;" class="delete" uid="{{ $task->id }}"><i class="fa fa-fw fa-trash-o"></i>Delete Record</a>                                                                                                     
                                                </div>			
                                            </td> 
                                    </tr>
                                  
                                    @endforeach 
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->

                    </div>  
                </div>          
            


              

        </div>


        <!-- ajax for form submition -->

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
 
        $(document).ready(function() {

            $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
            $('#taskform').submit(function(e) {
            e.preventDefault();
            //submit the form
            $.ajax({
                type: 'POST',
                url: '/save',
                data: $(this).serialize(),
                // headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                success: function(response) {
                    $('#example tbody tr:eq(0)').before('<tr role="row" style="text-align:center;"><td>' + response.data.task + '</td>' + '<td><div class="btn-mini btn-danger btn-flat btn"><a href="javascript:;" class="delete" uid="' + response.data.id + '"><i class="fa fa-fw fa-trash-o"></i> Delete Record</a></div>' + '</td></tr>');
                //success response
                $("#tasktext").val('');
                },
                error: function(xhr, status, error) {
                    alert(erro);
                //error
                }
            });
            });

            $('#example').on('click', 'a.delete', function(e) {
                e.preventDefault();
                if (!confirm("Are you sure to delete?")) return false;
                    var oTable = $('#example');
                        var tr = $(this).closest('tr')[0];
                        var uid = $(this).attr('uid');
                        $.ajax({
                            type: "DELETE",
                            url: "/tasks/" + uid,
                            success: function () {
                                tr.parentNode.removeChild(tr);
                                // $('#example').DataTable().row(tr).remove().draw(false);
                            },
                            error: function (error) {
alert(error);
                            }
                        });
                    
            })

        });
        </script>
    </body>
</html>
