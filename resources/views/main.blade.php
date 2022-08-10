<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Ajax</title>

    <style>
        .wrapper{
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <div class="modal fade" id="studentform" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="studentForm">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control" id="name" placeholder="Enter Name">
                      <small id="nameError" class="form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" class="form-control" id="email" placeholder="Enter Email">
                      <small id="emailError" class="form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="contact">Contact</label>
                        <input type="number" class="form-control" id="contact" placeholder="Enter Contact">
                        <small id="contactError" class="form-text text-danger"></small>
                    </div>
                    
                    <input id="id_value" hidden type="text">
                    <button type="submit" id="btn" class="btn btn-primary">Submit</button>
                    <button type="submit" id="updateBtn" class="btn btn-primary">Update</button>
                  </form>
            </div>
          </div>
        </div>
      </div>
    
    <div class="wrapper">
        <div class="container">
            <table class="table border">

                <button type="button" id="createbtn" class="btn btn-primary" data-toggle="modal" data-target="#studentform">Create New</button>

                <thead class="thead-dark text-center">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody id="tbody" class="text-center">

                </tbody>
              </table>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script>
      
        $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                });

            $("#updateBtn").hide();
            $("#btn").show();

            function inputClear(){
                  $("#name").val('');
                  $("#email").val('');
                  $("#contact").val('');
                };

            function errorClear(){
                    $("#nameError").text('');
                    $("#emailError").text('');
                    $("#contactError").text('');
            };

            //Data show function start here
            function showData(){
                $.ajax({
                    url : "{{route('data.show')}}",
                  type: 'Get',
                  dataType : 'json',
                  success : function(response){
                  var data = '';
                  var id = 1;
                  if (response == '') {
                      data = data+"<tr>"
                        data = data+"<td colspan='5' class='text-center'>"+'<h6>Sorry No Data Found :(</h6>'+"</td>"
                      data = data+"</tr>"
                      $("#tbody").html(data);
                    }else{
                      $.each(response,function(key,value){
                        data = data+"<tr>"
                          data = data+"<td>"+id+++"</td>"
                          data = data+"<td>"+value.name+"</td>"
                          data = data+"<td>"+value.email+"</td>"
                          data = data+"<td>"+value.contact+"</td>"
                          data = data+"<td>"
                          data = data+"<button class='btn btn-sm btn-primary m-1' data-toggle='modal' data-target='#studentform' onclick='editData("+value.id+")'>Edit</button>"
                          data = data+"<button class='btn btn-sm btn-danger m-1'>Delete</button>"
                          data = data+"</td>"
                        data = data+"</tr>"

                        $("#tbody").html(data);
                    });
                    }
                  },
                });
            }
            showData();
            errorClear();
            //  Data show end function end here

            //data store start here
            $("#btn").on('click',function(e){
              e.preventDefault();

                var name = $("#name").val();
                var email = $("#email").val();
                var contact = $("#contact").val();
                $("#tbody").html('');

              $.ajax({
                  url   : "{{route('data.store')}}",
                  type  : 'POST',
                  dataType : 'json',
                  data   : {
                      name : name,
                      email : email,
                      contact:contact
                  },
                  success : function(response){
                    inputClear();
                    showData();
                  },
                  error : function(error){
                    $("#nameError").text(error.responseJSON.errors.name);
                    $("#emailError").text(error.responseJSON.errors.email);
                    $("#contactError").text(error.responseJSON.errors.contact);
                    showData();
                  },
              });
            });
          //data store ends here

          //data edit start here
          function editData(id){
            $.ajax({
              url       : '/edit/'+id,
              type      : "GET",
              dataType  : 'json',
              success   : function(response){
                  $("#name").val(response.name);
                  $("#email").val(response.email);
                  $("#contact").val(response.contact);
                  $("#id_value").val(response.id);

                  $("#updateBtn").show();
                  $("#btn").hide();
              },
            });
          }
          //data edit end here here

          //data update store start
          $("#updateBtn").on('click',function(e){
            e.preventDefault();

            var name = $("#name").val();
            var email = $("#email").val();
            var contact = $("#contact").val();
            var id = $("#id_value").val()
          
            $.ajax({
              url       : '/update/'+id,
              type      : "POST",
              dataType  : 'json',
              data      : {
                name : name,
                email : email,
                contact:contact
              },
              success   : function(response){
                showData();
                inputClear();
                $("#updateBtn").hide();
                $("#btn").show();

              },
              error : function(error){
                  $("#nameError").text(error.responseJSON.errors.name);
                  $("#emailError").text(error.responseJSON.errors.email);
                  $("#contactError").text(error.responseJSON.errors.contact);
              }
            });
          });
          
          
    </script>

</body>
</html>