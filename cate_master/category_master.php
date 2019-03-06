<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>category managing page</title>
    <script src='jquery-3.3.1.js'></script>
    <script src='cate_master.js'></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="haiyun/admin.css">
</head>
<body>
<div id='wrap'>
    <div id='btn'>
    <p>Hello Master <strong>John Doe</strong></p>
    <button id='add' class = "btn btn-primary">Add a new category</button>
    <button id="all" class = 'btn btn-primary'>See All </button>
    </div>

    <div id= "div_add" style="display:none" class = 'jumbotron'>
    <form id= 'cate_add' action="haiyun/add.php" method="post">
    <table id='tbl_add'>
    <tr><td><label>Category Name</label></td><td><input type="text" name="name" id="name" class = 'form-control'></td></tr>
    <tr><td><label>Description</label></td><td><textarea rows="5" cols="10" wrap="soft" class = 'form-control' name="description" id="description"> </textarea></td></tr>
    <tr><td><label>Created by</label></td><td><input type="text" name="created_by" class = 'form-control' id="created_by"></td></tr>
    </table> 
    
    <input type="submit" id="submit" class = 'btn btn-secondary'>
    </form>
    </div>

    <div id= "div_showAll" style="display:none">
    <table style="text-align:left" class="table table-hover" id='showAll'></table>
    </div>
</div>

   <script>
   $('form').submit(function () {

// Get the Login Name value and trim it
var name = $.trim($('#name').val());
var des = $.trim($('#description').val());
var admin = $.trim($('#created_by').val());

// Check if empty of not
if (name  === '') {
    alert('name field is empty.');
    return false;
}
if (des  === '') {
    alert('descreiption field is empty.');
    return false;
}
if (admin  === '') {
    alert('admin number field is empty.');
    return false;
}
});

$('#add').click(function(){
    $( "#div_add" ).toggle(300);
})

$('#all').click(function(){
    $( "#div_showAll" ).toggle(300);
})


$("#all").click(function(){
    
    $.ajax({
        url: 'haiyun/all.php',
        type: 'get',
        dataType: 'JSON',
        success: function(response){

            $("#showAll").empty();

            var tr_str="<tr><th>Category ID</th><th>Category Name</th><th>Description</th><th>Created By</th><th>Added Time</th></tr>";
            var len = response.length;
            for(var i=0; i<len; i++){
                var id = response[i].cate_id;
                var cate_name = response[i].cate_name;
                var cate_des = response[i].cate_des;
                var created_by = response[i].created_by;
                var cate_datetime = response[i].cate_datetime;

                tr_str += "<tr>" +
                    
                    "<td>" + id + "</td>" +
                    "<td>" + cate_name + "</td>" +
                    "<td>" + cate_des +"</td>" +
                    "<td>" + created_by + "</td>" +
                    "<td>" + cate_datetime + "</td>" +
                    "</tr>";
            }

            $("#showAll").append(tr_str);
        }
    });
})

$("#name").blur(function(){

    var cate_name = $('#name').val();

      $.ajax({

        type : 'POST',
        url  : 'haiyun/add.php',
        data : { name: cate_name},
        success : function(data)
              {
                   $("#result").html(data);
                }
        });
        return false;

})

  
   </script>
</body>
</html>
