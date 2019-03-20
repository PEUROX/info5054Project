$('#add').click(function(){
    $( "#div_add" ).toggle(300);
    $( "#div_showAll" ).hide();
    $( "#div_member" ).hide();
})

$('#all').click(function(){
    $( "#div_showAll" ).toggle(300);
    $( "#div_add" ).hide();
    $( "#div_member" ).hide();
})

$('#btn_member').click(function(){
    $( "#div_add" ).hide();
    $( "#div_showAll" ).hide();
    $( "#div_member" ).toggle(300);
})


$("#all").click(function(){
    
    $.ajax({
        url: 'admin_php/all.php',
        type: 'get',
        dataType: 'JSON',
        success: function(response){

            $("#showAll").empty();


var tbl = '';
	tbl +='<table class="table table-hover">'

		//--->create table header > start
		tbl +='<thead>';
			tbl +='<tr>';
			tbl +='<th>Category Name</th>';
			tbl +='<th>Description</th>';
			tbl +='<th>Created By</th>';
			tbl +='<th>Date&Time</th>';
			tbl +='</tr>';
		tbl +='</thead>';
		//--->create table header > end

		
		//--->create table body > start
		tbl +='<tbody>';

        //--->create table body rows > start
			$.each(response, function(index, val) 
			{
				//you can replace with your database row id
				var row_id = val['cate_id'];
                console.log(row_id);

				//loop through ajax row data
				tbl +='<tr row_id="'+row_id+'">';
					tbl +='<td ><div class="row_data" edit_type="click" col_name="cate_name">'+val['cate_name']+'</div></td>';
					tbl +='<td ><div class="row_data" edit_type="click" col_name="cate_des">'+val['cate_des']+'</div></td>';
					tbl +='<td ><div  edit_type="click" col_name="created_by">'+val['created_by']+'</div></td>';
                    tbl +='<td ><div  edit_type="click" col_name="cate_datetime">'+val['cate_datetime']+'</div></td>';

					//--->edit options > start
					tbl +='<td>';
					 
						tbl +='<span class="btn_edit" > <a href="#" class="btn btn-link " row_id="'+row_id+'" > Edit</a> </span>';

						//only show this button if edit button is clicked
						tbl +='<span class="btn_save"> <a href="#" class="btn btn-link"  row_id="'+row_id+'"> Save</a> | </span>';
						tbl +='<span class="btn_cancel"> <a href="#" class="btn btn-link" row_id="'+row_id+'"> Cancel</a> | </span>';
                        tbl +="&#x20;<button class='text-danger btn_del' onclick='cate_delete("+row_id+")'>Delete</button>";

					tbl +='</td>';
					//--->edit options > end
					
				tbl +='</tr>';
			});

			//--->create table body rows > end

		tbl +='</tbody>';
		//--->create table body > end

	tbl +='</table>'	
	//--->create data table > end

    $(document).find('#showAll').html(tbl);

$(document).find('.btn_save').hide();
$(document).find('.btn_cancel').hide(); 
        }
    });
})

$(document).on('click', '.btn_edit', function(event) 
{
	event.preventDefault();
	var tbl_row = $(this).closest('tr');

	var row_id = tbl_row.attr('row_id');

	tbl_row.find('.btn_save').show();
	tbl_row.find('.btn_cancel').show();

	//hide edit button
	tbl_row.find('.btn_edit').hide(); 

	//make the whole row editable
	tbl_row.find('.row_data')
	.attr('contenteditable', 'true')
	.attr('edit_type', 'button')
	.addClass('bg-warning')
	.css('padding','3px')

	//--->add the original entry > start
	tbl_row.find('.row_data').each(function(index, val) 
	{  
		//this will help in case user decided to click on cancel button
		$(this).attr('original_entry', $(this).html());
	}); 		
	//--->add the original entry > end

});
//--->button > edit > end

$(document).on('click', '.btn_cancel', function(event) 
{
	event.preventDefault();

	var tbl_row = $(this).closest('tr');

	var row_id = tbl_row.attr('row_id');

	//hide save and cacel buttons
	tbl_row.find('.btn_save').hide();
	tbl_row.find('.btn_cancel').hide();

	//show edit button
	tbl_row.find('.btn_edit').show();

	//make the whole row editable
	tbl_row.find('.row_data')
    .attr('contenteditable', 'false')
	.removeAttr('edit_type', 'click')	 
	.removeClass('bg-warning')
	.css('padding','') 

	tbl_row.find('.row_data').each(function(index, val) 
	{   
		$(this).html( $(this).attr('original_entry') ); 
	});  
});
//--->button > cancel > end

//--->save whole row entery > start	
$(document).on('click', '.btn_save', function(event) 
{
	event.preventDefault();
	var tbl_row = $(this).closest('tr');

	var row_id = tbl_row.attr('row_id');

	
	//hide save and cacel buttons
	tbl_row.find('.btn_save').hide();
	tbl_row.find('.btn_cancel').hide();

	//show edit button
	tbl_row.find('.btn_edit').show();


	//make the whole row editable
    tbl_row.find('.row_data')
    .attr('contenteditable', 'false')
	.attr('edit_type', 'click')	
	.removeClass('bg-warning')
	.css('padding','') 

	//--->get row data > start
	var obj = {}; 
	tbl_row.find('.row_data').each(function(index, val) 
	{   
		var col_name = $(this).attr('col_name');  
		var col_val  =  $(this).html();
		obj[col_name] = col_val;
	});
	//--->get row data > end

	//use the "arr"	object for your ajax call
	$.extend(obj, {row_id:row_id});

	//out put to show
	//$('.post_msg').html( '<pre class="bg-success">'+JSON.stringify(arr, null, 2) +'</pre>')
    console.log(obj);

    $.post( 
        "admin_php/cate_update.php", 
        obj,
        function( data ) {
            console.log(data);
    });
});
//--->save whole row entery > end

$("#cate_add").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

var form = $("#cate_add");

$.ajax({
       type: "POST",
       url: "admin_php/add.php",
       data: form.serialize(), // serializes the form's elements.
       success: function(data)
       {
           res = JSON.parse(data);

           if (res.status=="error"){
               $("#err").css('color','red').html(res.status_msg);
           }else{
            $("#err").css('color','green').html(res.status_msg);
            $(".cate_addd").val("");
           }
       }
     });
});

function cate_delete(id){

    var con = confirm("are you sure you want to delete this category and all its related posts content?");
    
    if(con){

        $.post( 
        "admin_php/delete.php", 
        {id:id},
        function( data ) {
          if (data=='1'){
            alert("category deleted successfully!")
            
            $(".btn_del").focus(function(){
                $(this).closest( "tr" ).remove();
            })
          }
         })
    }
}

$("#cate_sel").change(function(){
    $.post('admin_php/cate_sort.php',
    {'cate_sel':$(this).val()},
    function(res){

        console.log(data);

    })
})

