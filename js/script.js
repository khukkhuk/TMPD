$(document).ready(function() {
  loaddata();
  $("#btnSend").click(function() {
      $.ajax({
      type: "POST",
      url: "process.php",
      data: $("#frmMain").serialize(),
    success: function(result) {
      if(result.status == 1) { alert(result.message); } // Success
      else { alert(result.message); }
    }
    });
  }) ;

  function loaddata(){


    $("#page_id").change(function(){
      page_id=$("#page_id").val();
      console.log(page_id)
    })
     
    $.getJSON('../pagination/selectData.php',function(result){
      console.log("data"+result);
      text = "<table class='table table-hover' border='1'>";
      text += "<thead class='thead-dark'><tr><th>id</th><th>name</th><th>price</th><th>email</th><th>status</th></tr></thead><tbody>";
      for (i = 0;i<result.total_page; i++) {
        text +="<tr>"+
        "<td>"+result[i].id+"</td>"+
        "<td>"+result[i].name+"</td>"+
        "<td>"+result[i].price+"</td>"+
        "<td>"+result[i].status+"</td>"+ 
        "<td><button>edit</button><button>show</button><button>del</button></td>"+ 
        "</tr>";
      }

      text += "</tbody></table>";


    text += "<nav><ul class='pagination'><li><a href='index.php?page=1' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
  for(j=1;j<=result.total_page;j++){

  text += "<li><a href='index.php?page="+j+"'>"+j+"</a></li>";

  }
  text+="<li><a href='index.php?page="+result.total_page+"' aria-label='Next'>";
  text +="<span aria-hidden='true'>&raquo;</span></a></li></ul></nav>";
      


      $("#showData").html(text);
    });
  }

});