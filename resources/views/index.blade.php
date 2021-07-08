<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dckap Test</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="jquery.treeview.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" />

    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body style="padding:10px;">
    <div class="row">
        <div class="col-md-4">
            <div class="bg-primary text-center" style="padding:10px;">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="text-light">Sections</h4>
                    </div>
                    <div class="col-md-6">
                        <a id="addSection" class="btn btn-success"><i class="fa fa-plus"></i> Add Section</a>
                    </div>
                </div>
            </div>
            <div id="successMessage" style="font-size:20px;color:white;font-weight:bold;background-color:green;text-align:center;"></div>
            <div class="container">      
                {!! $tree !!}
            </div> 
        </div>
        <div class="col-md-8">
            <div class=" bg-success text-center" style="padding:10px;">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="text-light">Test Cases</h4>
                    </div>
                    <div class="col-md-6">
                        <a id="addTestCase" class="btn btn-success"><i class="fa fa-plus"></i> Add test Case</a>
                    </div>
                </div>
            </div>
            <div class="container">   
            <br>
            <div id="successMessageTestCase" style="font-size:20px;color:white;font-weight:bold;background-color:green;text-align:center;"></div>
            <br>
            <table class="table table-bordered table-responsive" id="testCAse">
                <thead class="text-center">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Section Name</th>
                        <th class="text-center">Summary</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">File</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                </tbody>
            </table>  
            </div> 
        </div>
    </div>
    

    <!-- addsection modal -->
    <div class="modal fade" id="addSectionModal" tabindex="-1" role="dialog" aria-labelledby="addSectionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="addSectionForm">
            @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSectionModalLabel">Add Section</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <div class="modal-body">

                <span>Parent Section</span>
                @if(count($all) == 0)
                    <select name="parent_id" class="form-control" >
                        <option value="">Creating Root Section</option>
                    </select>
                @else
                    <select name="parent_id" class="form-control" required>
                        <option value="">Select a Section</option>
                        @foreach($all as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                @endif
                <br>
                <span>Section Name</span>
                <input type="text" name="name" class="form-control" required/>
                <br>
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!----modal starts here--->
    <div id="deleteModal" class="modal fade" role='dialog'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Delete </h4>
                </div>
                <div class="modal-body">
                    <p>Do You Really Want to Delete This ?</p>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <span id= 'deleteButton'></span>
                </div>
                
            </div>
        </div>
    </div>
    <!--Modal ends here--->

    <!----modal starts here--->
    <div id="deleteTestCaseModal" class="modal fade" role='dialog'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Delete </h4>
                </div>
                <div class="modal-body">
                    <p>Do You Really Want to Delete This Test Case ?</p>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <span id= 'deleteButtonTestCase'></span>
                </div>
                
            </div>
        </div>
    </div>
    <!--Modal ends here--->


    <div class="modal fade" id="addTestCaseModal" tabindex="-1" role="dialog" aria-labelledby="addTestCaseModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="addTestCaseForm" enctype='multipart/form-data'>
            @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTestCaseModalLabel">Add TestCase</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <div class="modal-body">

                    <span>Parent Module</span>
                    <select name="section_id" class="form-control" required>
                        <option value="">Select a Section</option>
                        @foreach($all as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                    <br>
                    <span>TestCase Summary</span>
                    <textarea  name="summary" class="form-control" required></textarea>
                    <br>
                    <span>TestCase Description</span>
                    <textarea  name="description" class="form-control" ></textarea>
                    <br>
                    <span>TestCase File</span>
                    <input type="file"  name="file" class="form-control" />
                    <br>
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="jquery.treeview.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function(){
            $("#tree").treeview();
            var table = $('#testCAse').DataTable();
 

            $('.deleteNode').click(function(e){
                e.preventDefault();
                let deleteId = $(this).attr('nodeId');
                $('#deleteModal').modal();
                $('#deleteButton').html('<a class="btn btn-danger" onclick="deleteData('+deleteId+')">Delete</a>');

            });

            $('.viewNode').click(function(e){ 
                let viewId = $(this).attr('nodeId');
                $.ajax({
                    url: '/getTestCase/'+viewId, 
                    type: 'GET', 
                    success: function(data){
                        console.log(data);
                        table.clear().draw();
                        for(let i = 0; i<data.test_cases.length;i++){
                            let file = '';
                            if(data.test_cases[i].file){
                                file+='<a href="/uploads/'+data.test_cases[i].file+'" target="_new" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> View File</a>';
                            }
                            else{
                                file+='N/A';
                            }
                            table.row.add([(i+1),data.name, data.test_cases[i].summary, data.test_cases[i].description,file,'<a class="btn btn-danger" onclick="getTCDeleteModal('+data.test_cases[i].id+')"><i class="fa fa-trash"></i></a>']).draw();
                        }
                    }
                });
            });


            $('#addSection').click(function(e){
                $("#addSectionModal").modal('show');
            });
            $('#addTestCase').click(function(e){
                $("#addTestCaseModal").modal('show');
            })

            $('form#addTestCaseForm').on('submit', function(e){
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: '/addTestCase', 
                    type: 'POST', 
                    data: formData,
                    success: function(data){
                        console.log(data)
                        $("#successMessageTestCase").html(data.message);
                        $('#addTestCaseModal').modal('hide'); 
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            })

            $('#addSectionForm').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url: '/addSection', 
                    type: 'POST', 
                    data: $('#addSectionForm').serialize(),
                    success: function(data){
                        $("#successMessage").html(data.message);
                        $('#addSectionModal').modal('hide'); 
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    }
                });
            });
        });

        function getTCDeleteModal(deleteId){
            $(document).ready(function(){
                $('#deleteTestCaseModal').modal();
                $('#deleteButtonTestCase').html('<a class="btn btn-danger" onclick="deleteDataTC('+deleteId+')">Delete</a>');
            });
        }

        function deleteDataTC(deleteId){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(document).ready(function(){
                $.ajax({
                    type:'POST',
                    url:'/destroyTestCase',
                    data:{_token: CSRF_TOKEN,testcase_id:deleteId},
                    success:function(data){
                        //alert(data.message);
                        $("#successMessageTestCase").html(data.message);
                        $('#deleteTestCaseModal').modal('hide'); 
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    }
                });
            });
        }
        function deleteData(deleteId){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(document).ready(function(){
                $.ajax({
                    type:'POST',
                    url:'/destroySection',
                    data:{_token: CSRF_TOKEN,section_id:deleteId},
                    success:function(data){
                        //alert(data.message);
                        $("#successMessage").html(data.message);
                        $('#deleteModal').modal('hide'); 
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    }
                });
            });
        }  
    </script>
</body>
</html>