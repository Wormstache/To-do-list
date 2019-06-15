<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <!-- font link -->
    <link href="https://fonts.googleapis.com/css?family=Cookie|Covered+By+Your+Grace|Caveat|Patua+One" rel="stylesheet">
    <!-- css link -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- fontAwesome link -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <title>To-Do List</title>
  </head>
  <body>
    <!-- navigation bar -->
    <nav class="navbar navbar-dark bg-dark justify-content-center">
        <a class="navbar-brand navFont" href="#">To-do List</a>
    </nav>
    <!-- form -->
    <div class="container">
        <div class="card bg-dark text-white border-0">
            <img class="card-img image" src={{ asset('image/img.jpg') }} alt="Card image">
            <div class="card-img-overlay">
                <p class="card-text cardFont">Do you have any tasks today?</p>
                <!-- error message -->
                @if($errors->any())
                @foreach($errors->all() as $error)
                    <p class="text-center text-danger">{{ $error }}</p>
                @endforeach
                @endif
                @if (session()->has('success'))
                    <p class="text-center text-success">{{ session('success') }}</p>
                @endif
                <div class="text-center">
                    <button type="submit" class="btn btn-dark mt-3 buttonFont" data-toggle="modal" data-target="#task"><i class="fa fa-pencil-square-o"></i> Add Tasks</button>
                </div>
                
            </div>
        </div>
    </div>
    
    <!-- listTable -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th  class="col-md-6" scope="col">Tasks</th>
                            <th class="col-md-3" scope="col"></th>
                            <th class="col-md-3" scope="col"></th>
                        </tr>
                    </thead>
                    @foreach ($posts as $post)
                    <tbody>
                        <tr class="warning">
                            <td class="taskFont col-md-6">{{ $post->task }}</td>
                            <td class="text-right col-md-3">
                                <button class="btn btn-info" data-toggle="modal" data-target="#taskEdit{{ $post->id }}" href="{{ route('task.update',$post->id) }}"><i class="fa fa-pencil"></i></button>
                            </td>
                            <td class="text-right col-md-3">
                                <form action="{{ route('task.destroy', $post->id) }}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token()}}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger" onclick=" return confirm('Are you sure?')";><i class="fa fa-trash-o"></i></button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
  </body>
  <!-- Modal for posting -->
    <div class="modal fade" id="task" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form name="task" action="{{ route('task.store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Task for today</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input class="form-control" type="text" placeholder="Task" name="task">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal for editing -->
    @foreach ($posts as $post)
    <div class="modal fade" id="taskEdit{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('task.update',$post->id) }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PATCH">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Edit the task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input class="form-control" type="text" placeholder="Task" name="task" value="{{ $post->task }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</html>

